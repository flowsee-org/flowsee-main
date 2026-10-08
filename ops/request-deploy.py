"""Sign the deployment request with the existing Actions SSH credential."""
import base64
import json
import os
from pathlib import Path
import subprocess
import tempfile
import time
import urllib.request


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
        subprocess.run(['ssh-keygen', '-Y', 'sign', '-f', str(key), '-n',
                        'flowsee-deploy', str(message)], check=True, capture_output=True)
        signature = base64.b64encode(Path(str(message) + '.sig').read_bytes()).decode()
        request = urllib.request.Request('https://flowsee.ir/github-webhook', data=payload,
            headers={'Content-Type': 'application/json', 'X-Flowsee-Signature': signature})
        with urllib.request.urlopen(request, timeout=240) as response:
            result = json.load(response)
        if result.get('sha') != sha:
            raise RuntimeError('Server did not publish the requested commit')
    with urllib.request.urlopen('https://flowsee.ir/deployment.txt?sha=' + sha, timeout=30) as response:
        if response.read().decode().strip() != sha:
            raise RuntimeError('Public site does not match the requested commit')
    print('Verified deployment: ' + sha + ' https://flowsee.ir')
    with open(os.environ['GITHUB_STEP_SUMMARY'], 'a') as summary:
        summary.write('### Published successfully\n\nhttps://flowsee.ir\n\nCommit: `' + sha + '`\n')


if __name__ == '__main__':
    main()
