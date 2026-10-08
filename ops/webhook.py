"""Only signed Actions requests can initiate a deployment."""
import base64
from http.server import BaseHTTPRequestHandler, HTTPServer
import json
from pathlib import Path
import re
import subprocess
import tempfile
import time

ALLOWED_SIGNERS = '/opt/flowsee-deploy/allowed_signers'


def valid_payload(payload, now):
    return (isinstance(payload, dict)
        and payload.get('repository') == 'flowsee-org/flowsee-main'
        and payload.get('ref') == 'refs/heads/main'
        and isinstance(payload.get('sha'), str)
        and re.fullmatch('[0-9a-f]{40}', payload['sha']) is not None
        and type(payload.get('issued_at')) is int
        and abs(now - payload['issued_at']) <= 300)


def verify(body, signature):
    with tempfile.TemporaryDirectory() as directory:
        path = Path(directory) / 'signature'
        path.write_bytes(base64.b64decode(signature, validate=True))
        result = subprocess.run(['ssh-keygen', '-Y', 'verify', '-f', ALLOWED_SIGNERS,
            '-I', 'github-actions', '-n', 'flowsee-deploy', '-s', str(path)],
            input=body, capture_output=True, timeout=10)
        return result.returncode == 0


class Handler(BaseHTTPRequestHandler):
    def reply(self, status, payload):
        body = json.dumps(payload).encode()
        self.send_response(status)
        self.send_header('Content-Type', 'application/json')
        self.send_header('Content-Length', str(len(body)))
        self.end_headers()
        self.wfile.write(body)

    def do_POST(self):
        if self.path != '/github-webhook':
            return self.reply(404, {'error': 'Not found'})
        signature = self.headers.get('X-Flowsee-Signature', '')
        if not signature:
            return self.reply(403, {'error': 'Signed Actions request required'})
        try:
            length = int(self.headers.get('Content-Length', '0'))
            if not 0 < length <= 4096 or len(signature) > 4096:
                return self.reply(400, {'error': 'Invalid request size'})
            self.connection.settimeout(15)
            body = self.rfile.read(length)
            payload = json.loads(body)
            if not valid_payload(payload, time.time()) or not verify(body, signature):
                return self.reply(403, {'error': 'Invalid or expired signature'})
            result = subprocess.run(['python3', '/opt/flowsee-deploy/deploy.py', payload['sha']],
                                    capture_output=True, text=True, timeout=600)
            if result.returncode:
                print(result.stderr, flush=True)
                return self.reply(500, {'error': 'Deployment failed; see server journal'})
            return self.reply(200, {'sha': payload['sha']})
        except (ValueError, TypeError):
            return self.reply(400, {'error': 'Malformed request'})
        except Exception as error:
            print(type(error).__name__, flush=True)
            return self.reply(500, {'error': 'Deployment failed'})


if __name__ == '__main__':
    HTTPServer(('127.0.0.1', 9001), Handler).serve_forever()
