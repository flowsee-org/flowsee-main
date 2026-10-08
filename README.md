# Flowsee

The live static site is https://flowsee.ir. The homepage source is
`felosi-home-before-about-v2.html`; deployment publishes it as `index.html`.

## Publishing

Edit this repository, commit your changes, and push to `main`. GitHub Actions
validates the deployment code, sends a signed HTTPS request, and checks that the
public site serves the exact pushed commit. You can also use **Run workflow**.

The existing organization secret `SSH_PRIVATE_KEY` signs requests. Its matching
public key is installed in `/opt/flowsee-deploy/allowed_signers` on the server.
No private key is included in this repository or sent in the HTTPS request.

The server fetches this repository, creates a release in `/var/www/flowsee-releases`,
and atomically changes `/var/www/flowsee-live`. A failed local health check restores
the previous release. `/deployment.txt` identifies the currently published commit.
Old releases are retained for manual rollback. The old direct-push webhook does
not deploy independently of Actions.

Server deployment code is installed separately in `/opt/flowsee-deploy`; changes
to `ops/deploy.py` or `ops/webhook.py` need a deliberate server update.

This repository currently publishes static files. Form storage requires a separate
backend and is not provided by this deployment workflow.
