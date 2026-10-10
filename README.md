[فارسی](README.fa.md)

# Flowsee Studio

The Persian, right-to-left website for Flowsee Studio, built with Laravel and PHP to showcase the studio's services, portfolio, and a standalone case study.

[Read the full project documentation in the GitHub Wiki](https://github.com/flowsee-org/flowsee-main/wiki).

## Features

- Responsive homepage introducing the studio, its services, portfolio, and contact options
- Project previews and the Ebrahimi case study, including an image gallery and lightbox
- Project-brief form with browser-side validation and a downloadable text summary
- Self-hosted fonts, images, and frontend scripts
- Laravel health endpoint at `/up` and permanent redirects from legacy URLs

> The project-brief form does not submit data to a server. The browser stores entered values locally and downloads a text file when the form is completed.

## Tech stack

- PHP 8.3 or later (CI and production deployment use PHP 8.4)
- Laravel 13
- Blade, CSS, and JavaScript; no frontend build step
- Composer for PHP dependencies; Node.js and npm are not required to run the site

## Local development

Prerequisites: PHP 8.3+ with Laravel's required extensions, Composer, and Git.

From the repository root:

```sh
composer install
test -f .env || cp .env.example .env
php artisan key:generate
php artisan serve
```

The site is available at `http://127.0.0.1:8000`. Run the test suite with:

```sh
composer test
```

If `.env` already exists, do not replace it. Keep local settings in `.env` and never commit that file. For development, architecture, content, deployment, and troubleshooting guides, see the [project Wiki](https://github.com/flowsee-org/flowsee-main/wiki).

## Routes

| URL | Description |
| --- | --- |
| `/` | Homepage |
| `/projects/ebrahimi` | Ebrahimi case study |
| `/up` | Laravel health check |
| Legacy HTML URLs | Permanent redirects to the homepage or case study |

## Project structure

```text
app/                         Laravel application code
routes/web.php               Web routes and legacy redirects
resources/views/             Homepage and case-study templates
public/assets/css/           Main and responsive stylesheets
public/assets/js/site.js     Page interactions, gallery, and brief form
public/assets/               Images, fonts, and frontend libraries
tests/Feature/               Route, content, and local-asset tests
ops/                         Deployment tools and webhook tests
.github/workflows/deploy.yml CI and deployment workflow
wiki/                        Source files for project documentation
reference/                   Design references and archived resources
```

The Wiki source pages are also kept in `wiki/`. Read the published guides on the [GitHub Wiki](https://github.com/flowsee-org/flowsee-main/wiki).
