"""Sign the deployment request with the existing Actions SSH credential."""
import base64
import json
import os
from pathlib import Path
import subprocess
import tempfile
import time
import urllib.error
import urllib.request


def verify_shopero_case_study(sha):
    """Allow the public route a short propagation window after atomic deploy."""
    expected = '<link rel="canonical" href="https://flowsee.ir/projects/shopero">'
    last_error = None
    for attempt in range(6):
        url = 'https://flowsee.ir/projects/shopero?deploy-check=' + sha + '-' + str(attempt)
        request = urllib.request.Request(url, headers={'Cache-Control': 'no-cache'})
        try:
            with urllib.request.urlopen(request, timeout=30) as response:
                page = response.read().decode()
            if expected in page:
                return
            last_error = RuntimeError('response did not contain the expected canonical URL')
        except urllib.error.HTTPError as error:
            if error.code not in (404, 502, 503, 504):
                raise
            last_error = error
        if attempt < 5:
            time.sleep(5)
    raise RuntimeError('Shopero case study was not available after deployment: ' + str(last_error))


def main():
    sha = os.environ['GITHUB_SHA']
    payload = json.dumps({
        'repository': os.environ['GITHUB_REPOSITORY'],
        'ref': os.environ['GITHUB_REF'],
        'sha': sha,
        'issued_at': int(time.time()),
    }, sort_keys=True).encode()
    with tempfile.TemporaryDirectory() as directory:
        key = Path(directory) / 'key'
        key.write_text(os.environ.pop('SSH_PRIVATE_KEY').replace('\r', '').strip() + '\n')
        key.chmod(0o600)
        message = Path(directory) / 'request'
        message.write_bytes(payload)
        signing = subprocess.run(['ssh-keygen', '-Y', 'sign', '-f', str(key), '-n',
                                  'flowsee-deploy', str(message)], capture_output=True, text=True)
        if signing.returncode:
            # ssh-keygen diagnostics are safe to expose here: they contain key paths and
            # parser errors, never private-key material. Without stderr the Action only
            # reports a generic CalledProcessError and cannot distinguish a bad secret
            # from a changed OpenSSH environment.
            raise RuntimeError('ssh-keygen could not sign the deployment request: '
                               + signing.stderr.strip())
        signature = base64.b64encode(Path(str(message) + '.sig').read_bytes()).decode()
        request = urllib.request.Request('https://flowsee.ir/github-webhook', data=payload,
            headers={'Content-Type': 'application/json', 'X-Flowsee-Signature': signature})
        with urllib.request.urlopen(request, timeout=660) as response:
            result = json.load(response)
        if result.get('sha') != sha:
            raise RuntimeError('Server did not publish the requested commit')
    with urllib.request.urlopen('https://flowsee.ir/deployment.txt?sha=' + sha, timeout=30) as response:
        if response.read().decode().strip() != sha:
            raise RuntimeError('Public site does not match the requested commit')
    verify_shopero_case_study(sha)
    print('Verified deployment: ' + sha + ' https://flowsee.ir')
    with open(os.environ['GITHUB_STEP_SUMMARY'], 'a') as summary:
        summary.write('### Published successfully\n\nhttps://flowsee.ir\n\nCommit: ' + sha + '\n')


if __name__ == '__main__':
    main()
