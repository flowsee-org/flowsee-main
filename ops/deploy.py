"""Release Laravel with shared runtime data and atomic, health-checked activation."""
import fcntl
import os
from pathlib import Path
import re
import shutil
import subprocess
import sys
import tarfile
import tempfile

REPO = Path('/var/www/flowsee-main')
RELEASES = Path('/var/www/flowsee-releases')
SHARED = Path('/var/www/flowsee-shared')
LIVE = Path('/var/www/flowsee-live')
PHP = '/usr/bin/php8.4'


def run(*args, cwd=REPO, timeout=300):
    return subprocess.check_output(args, cwd=cwd, timeout=timeout,
        env=dict(os.environ, COMPOSER_ALLOW_SUPERUSER='1'))


def switch(target):
    temporary = LIVE.with_name('flowsee-live.next')
    temporary.unlink(missing_ok=True)
    temporary.symlink_to(target, target_is_directory=True)
    os.replace(temporary, LIVE)


def main(sha):
    if re.fullmatch('[0-9a-f]{40}', sha) is None:
        raise ValueError('Invalid commit')
    with open('/run/lock/flowsee-deploy.lock', 'w') as lock:
        fcntl.flock(lock, fcntl.LOCK_EX)
        run('git', 'fetch', 'origin', 'main', timeout=90)
        if run('git', 'rev-parse', 'origin/main').decode().strip() != sha:
            raise ValueError('Commit is no longer the tip of main')
        RELEASES.mkdir(exist_ok=True)
        release = RELEASES / (sha + '-laravel')
        if not release.exists():
            with tempfile.TemporaryDirectory(prefix='prepare-', dir=RELEASES) as directory:
                staging = Path(directory)
                archive = staging / 'source.tar'
                run('git', 'archive', '--format=tar', '--output=' + str(archive), sha)
                with tarfile.open(archive) as source:
                    members = [m for m in source.getmembers() if (m.isfile() or m.isdir())
                        and m.name.split('/')[0] in {'app','bootstrap','config','database','public','resources','routes','storage','artisan','composer.json','composer.lock'}]
                    source.extractall(staging, members=members, filter='data')
                archive.unlink()
                if not (staging / 'public/index.php').is_file():
                    raise ValueError('Missing Laravel entrypoint')
                # Prepare in the final location so cached Laravel paths remain valid.
                staging.chmod(0o755)
                shutil.copytree(staging, release)
            try:
                shutil.rmtree(release / 'storage')
                (release / 'storage').symlink_to(SHARED / 'storage', target_is_directory=True)
                (release / '.env').symlink_to(SHARED / '.env')
                run(PHP, '/usr/bin/composer', 'install', '--no-dev', '--prefer-dist',
                    '--no-interaction', '--optimize-autoloader', cwd=release)
                run(PHP, 'artisan', 'migrate', '--force', cwd=release)
                run(PHP, 'artisan', 'db:seed', '--class=LegacyPortfolioSeeder', '--force', cwd=release)
                run(PHP, 'artisan', 'config:cache', cwd=release)
                run(PHP, 'artisan', 'route:cache', cwd=release)
                run(PHP, 'artisan', 'view:cache', cwd=release)
                run('chown', '-R', 'www-data:www-data', str(release / 'bootstrap/cache'), str(SHARED / 'storage'))
                (release / 'public/deployment.txt').write_text(sha + '\n')
                (release / '.ready').touch()
            except Exception:
                # Never reuse a partially installed release; preserve it for diagnosis.
                release.rename(RELEASES / (sha + '-failed-' + str(os.getpid())))
                raise
        if not (release / '.ready').is_file():
            raise ValueError('Release was not completely prepared')
        previous = LIVE.resolve(strict=True)
        switch(release / 'public')
        try:
            for path in ['/up', '/', '/robots.txt', '/sitemap.xml', '/assets/css/mobile.css', '/vendor/livewire/livewire.min.js']:
                run('curl', '--fail', '--silent', '--show-error', '--max-time', '30',
                    '--resolve', 'flowsee.ir:443:127.0.0.1', 'https://flowsee.ir' + path)
            revision = run('curl', '--fail', '--silent', '--max-time', '20',
                '--resolve', 'flowsee.ir:443:127.0.0.1', 'https://flowsee.ir/deployment.txt')
            if revision.decode().strip() != sha:
                raise ValueError('Live revision mismatch')
        except Exception:
            switch(previous)
            raise
        print('Published Laravel ' + sha, flush=True)


if __name__ == '__main__':
    main(sys.argv[1])
