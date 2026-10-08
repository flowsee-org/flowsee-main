# Flowsee — Laravel

Laravel 13 / PHP 8.4+. The existing Flowsee design, portfolio, dialogs, and Instagram
link are preserved, with a dedicated mobile layout layer.

- `resources/views/home.blade.php`: homepage content
- `resources/views/layouts/site.blade.php`: document layout and asset loading
- `resources/views/case-study.blade.php`: standalone case study
- `public/assets/css/site.css`: original design styles
- `public/assets/css/mobile.css`: responsive layout and touch controls
- `public/assets/js/site.js`: dialog, gallery, and brief-download behavior
- `routes/web.php`: public routes and legacy URL redirects
- `reference/legacy`: archived HTML source, never exposed by the web server

## Local development

```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
php vendor/bin/phpunit
```

Use the web root `public/`. Do not serve the repository root. Node/npm is not
required for these existing CSS and JavaScript assets.

## Deployment

Push to `main` to run PHP tests and send the existing signed HTTPS deployment
request. The server creates a Laravel release, installs production dependencies,
runs migrations, caches configuration/routes/views, then atomically activates
the release. Failed HTTP health checks restore the previous release.

Runtime configuration and data live outside releases in `/var/www/flowsee-shared`.
Never commit `.env`, vendor packages, or the SQLite database. Back up this shared
directory separately. Schema migrations must remain backward compatible with the
previous release; code rollback does not undo a database migration.

The form currently downloads a project brief, as before. It does not yet store
submissions or notify the owner. Laravel is ready for implementing that separately.
