"""Prepare a static release, switch it atomically, and roll back on health failure."""
import fcntl
import hashlib
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
LIVE = Path('/var/www/flowsee-live')
HOME = 'felosi-home-before-about-v2.html'


def run(*args):
    return subprocess.check_output(args, cwd=REPO, timeout=90)


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
        run('git', 'fetch', 'origin', 'main')
        if run('git', 'rev-parse', 'origin/main').decode().strip() != sha:
            raise ValueError('Commit is no longer the tip of main')
        RELEASES.mkdir(exist_ok=True)
        with tempfile.TemporaryDirectory(prefix=sha + '-', dir=RELEASES) as directory:
            staging = Path(directory)
            archive = staging / 'source.tar'
            run('git', 'archive', '--format=tar', '--output=' + str(archive), sha)
            with tarfile.open(archive) as source:
                members = [member for member in source.getmembers()
                    if (member.isfile() or member.isdir()) and
                    (member.name.startswith('assets/') or
                     ('/' not in member.name and Path(member.name).suffix.lower()
                      in {'.html', '.jpg', '.jpeg', '.png', '.webp', '.ico', '.svg', '.css', '.js'}))]
                source.extractall(staging, members=members, filter='data')
            archive.unlink()
            if not (staging / HOME).is_file() or not (staging / 'assets').is_dir():
                raise ValueError('Missing site files')
            shutil.copyfile(staging / HOME, staging / 'index.html')
            (staging / 'deployment.txt').write_text(sha + '\n')
            expected = hashlib.sha256((staging / 'index.html').read_bytes()).hexdigest()
            staging.chmod(0o755)
            release = RELEASES / sha
            if release.exists():
                if hashlib.sha256((release / 'index.html').read_bytes()).hexdigest() != expected:
                    raise ValueError('Existing release does not match')
            else:
                shutil.copytree(staging, release)
        previous = LIVE.resolve(strict=True)
        switch(release)
        try:
            body = run('curl', '--fail', '--silent', '--show-error', '--max-time', '20',
                '--resolve', 'flowsee.ir:443:127.0.0.1', 'https://flowsee.ir/')
            if hashlib.sha256(body).hexdigest() != expected:
                raise ValueError('Live page verification failed')
        except Exception:
            switch(previous)
            raise
        print('Published ' + sha, flush=True)


if __name__ == '__main__':
    main(sys.argv[1])
