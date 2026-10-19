# Flowsee blog listing

Next.js App Router renders `/blog` on the server and uses `next/link` for category and pagination transitions without document reloads. Existing `/blog/{slug}` article routes, homepage and Studio publishing remain in Laravel. The public `/api/blog` endpoint includes published, due posts only. No Studio credentials are sent to Next.js.

Use Node 20.9+ and run `npm ci`, `npm test`, `npm run build`. For development, run `FLOWSEE_CONTENT_ORIGIN=http://127.0.0.1:8000 npm run dev` alongside Laravel. The existing `/assets/css` and `/assets/fonts` URLs must be served by Laravel or the local reverse proxy.

Production requires `ops/flowsee-blog.service` installed and enabled, plus `ops/blog-nginx.conf` included inside the `flowsee.ir` HTTPS server. Node listens only on `127.0.0.1:4180`. The installed `/opt/flowsee-deploy/deploy.py` must match the repository version. Deployments build a standalone app and switch the Laravel and Next.js release links together, rolling both back on failed health checks.

Content is fetched per server request, so Studio publications do not need a Next.js rebuild. Category URLs, canonical metadata and structured data remain available on direct requests and with JavaScript disabled. On the server, `flowsee.ir` must resolve to its own Nginx server for the internal content request.
