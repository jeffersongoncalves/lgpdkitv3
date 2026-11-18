<div class="filament-hidden">

![LgpdKit](https://raw.githubusercontent.com/jeffersongoncalves/lgpdkitv3/main/art/jeffersongoncalves-lgpdkitv3.png)

</div>

# LgpdKit Start Kit Filament 3.x and Laravel 12.x

[![Buy Me A Coffee](https://img.shields.io/badge/Buy%20Me%20A%20Coffee-support-FFDD00?style=flat-square&logo=buy-me-a-coffee&logoColor=black)](https://buymeacoffee.com/jeffersongoncalves)

## About LgpdKit

LgpdKit is a robust starter kit built on Laravel 12.x and Filament 3.x, designed to accelerate the development of modern
web applications with a ready-to-use multi-panel structure and the LGPD privacy suite already installed: the tooling for
Brazil's LGPD (Lei 13.709/2018), managed from the Admin panel.

## Features

- **Laravel 12.x** - The latest version of the most elegant PHP framework
- **Filament 3.x** - Powerful and flexible admin framework
- **Multi-Panel Structure** - Includes three pre-configured panels:
    - Admin Panel (`/admin`) - For system administrators
    - App Panel (`/app`) - For authenticated application users
    - Public Panel (frontend interface) - For visitors
- **LGPD privacy suite** - every `laravel-lgpd*` package and its `filament-lgpd*` plugin (1.x), wired into the Admin panel
- **Environment Configuration** - Centralized configuration through the `config/lgpdkit.php` file

## System Requirements

- PHP 8.2 or higher
- Composer
- Node.js and PNPM

## Installation

Clone the repository
``` bash
laravel new my-app --using=jeffersongoncalves/lgpdkitv3 --database=mysql
```

### Using FilaKit CLI

Or use [FilaKit CLI](https://github.com/jeffersongoncalves/filakit-cli) for a simplified setup:

```bash
filakit new my-app --kit=jeffersongoncalves/lgpdkitv3
```

> Install FilaKit CLI: `composer global require jeffersongoncalves/filakit-cli`

###  Easy Installation

LgpdKit can be easily installed using the following command:

```bash
php install.php
```

This command automates the installation process by:
- Installing Composer dependencies
- Setting up the environment file
- Generating application key
- Setting up the database
- Running migrations
- Installing Node.js dependencies
- Building assets
- Configuring Herd (if used)

### Manual Installation

Install JavaScript dependencies
``` bash
pnpm install
```
Install Composer dependencies
``` bash
composer install
```
Set up environment
``` bash
cp .env.example .env
php artisan key:generate
```

Configure your database in the .env file

Run migrations
``` bash
php artisan migrate
```
Build frontend assets
``` bash
pnpm run build
```
Run the server
``` bash
php artisan serve
```

## Installation with Docker

Clone the repository
```bash
laravel new my-app --using=jeffersongoncalves/lgpdkitv3 --database=mysql
```

Move into the project directory
```bash
cd my-app
```

Install Composer dependencies
```bash
composer install
```

Set up environment
```bash
cp .env.example .env
```

Configuring custom ports may be necessary if you have other services running on the same ports.

```bash
# Application Port (ex: 8080)
APP_PORT=8080

# MySQL Port (ex: 3306)
FORWARD_DB_PORT=3306

# Redis Port (ex: 6379)
FORWARD_REDIS_PORT=6379

# Mailpit Port (ex: 1025)
FORWARD_MAILPIT_PORT=1025
```

Start the Sail containers
```bash
./vendor/bin/sail up -d
```
You won’t need to run `php artisan serve`, as Laravel Sail automatically handles the development server within the container.

Attach to the application container
```bash
./vendor/bin/sail shell
```

Generate the application key
```bash
php artisan key:generate
```

Install JavaScript dependencies
```bash
pnpm install
```

## LGPD privacy suite

The kit ships the whole LGPD suite for Brazil's LGPD (Lei 13.709/2018):

| Package | Filament plugin |
|---|---|
| [laravel-lgpd](https://github.com/jeffersongoncalves/laravel-lgpd) | [filament-lgpd](https://github.com/jeffersongoncalves/filament-lgpd) |
| [laravel-lgpd-consent](https://github.com/jeffersongoncalves/laravel-lgpd-consent) | [filament-lgpd-consent](https://github.com/jeffersongoncalves/filament-lgpd-consent) |
| [laravel-lgpd-dsar](https://github.com/jeffersongoncalves/laravel-lgpd-dsar) | [filament-lgpd-dsar](https://github.com/jeffersongoncalves/filament-lgpd-dsar) |
| [laravel-lgpd-retention](https://github.com/jeffersongoncalves/laravel-lgpd-retention) | [filament-lgpd-retention](https://github.com/jeffersongoncalves/filament-lgpd-retention) |
| [laravel-lgpd-audit-log](https://github.com/jeffersongoncalves/laravel-lgpd-audit-log) | [filament-lgpd-audit-log](https://github.com/jeffersongoncalves/filament-lgpd-audit-log) |
| [laravel-lgpd-incidents](https://github.com/jeffersongoncalves/laravel-lgpd-incidents) | [filament-lgpd-incidents](https://github.com/jeffersongoncalves/filament-lgpd-incidents) |
| [laravel-lgpd-records](https://github.com/jeffersongoncalves/laravel-lgpd-records) | [filament-lgpd-records](https://github.com/jeffersongoncalves/filament-lgpd-records) |
| [laravel-lgpd-vendors](https://github.com/jeffersongoncalves/laravel-lgpd-vendors) | [filament-lgpd-vendors](https://github.com/jeffersongoncalves/filament-lgpd-vendors) |
| [laravel-lgpd-ripd](https://github.com/jeffersongoncalves/laravel-lgpd-ripd) | [filament-lgpd-ripd](https://github.com/jeffersongoncalves/filament-lgpd-ripd) |
| [laravel-lgpd-minors](https://github.com/jeffersongoncalves/laravel-lgpd-minors) | [filament-lgpd-minors](https://github.com/jeffersongoncalves/filament-lgpd-minors) |
| [laravel-lgpd-takedown](https://github.com/jeffersongoncalves/laravel-lgpd-takedown) | [filament-lgpd-takedown](https://github.com/jeffersongoncalves/filament-lgpd-takedown) |

- `App\Models\User` is the data subject: it implements `HasPersonalData` and declares its `name` and `email` with `#[PersonalData]`.
  Declare every personal column you add, on this model and on your own models, and list those models in `config/lgpd.php`.
- The migrations are already in `database/migrations`: `php artisan migrate` creates every table of the suite.
- Every plugin is registered in `app/Providers/Filament/AdminPanelProvider.php`, under the **LGPD** navigation group.
- `tests/Feature/LgpdSuiteTest.php` checks the declarations and opens every page of the suite.

Each package's README explains its configuration, events and scheduled commands. The suite gives you tooling: it does not make
you compliant on its own, you still need legal review.

## Authentication Structure

LgpdKit comes pre-configured with a custom authentication system that supports different types of users:

- `Admin` - For administrative panel access
- `User` - For application panel access

## Development

``` bash
# Run the development server with logs, queues and asset compilation
composer dev

# Or run each component separately
php artisan serve
php artisan queue:listen --tries=1
pnpm run dev
```

## Customization

### Panel Configuration

Panels can be customized through their respective providers:

- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Providers/Filament/AppPanelProvider.php`
- `app/Providers/Filament/PublicPanelProvider.php`

Alternatively, these settings are also consolidated in the `config/lgpdkit.php` file for easier management.

### Themes and Colors

Each panel can have its own color scheme, which can be easily modified in the corresponding Provider files or in the
`lgpdkit.php` configuration file.

### Configuration File

The `config/lgpdkit.php` file centralizes the configuration of the starter kit, including:

- Panel routes
- Middleware for each panel
- Branding options (logo, colors)
- Authentication guards

## Resources

LgpdKit includes support for:

- User and admin management
- Multi-guard authentication system
- Tailwind CSS integration
- Database queue configuration
- Customizable panel routing and branding

## License

This project is licensed under the [MIT License](LICENSE).

## Security headers

Every panel response carries baseline security headers from [laravel-security-headers](https://github.com/jeffersongoncalves/laravel-security-headers) (the `SecurityHeaders` middleware is the first entry in each panel's `->middleware([...])`):

- `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy`, `Cross-Origin-Opener-Policy`
- `Strict-Transport-Security` over HTTPS outside the `local` environment (configure `trustProxies` behind a TLS-terminating proxy)
- a `Content-Security-Policy` that keeps scripts, styles, fonts, frames and form posts first-party. Filament needs `'unsafe-inline'` and `'unsafe-eval'` in `script-src`, so it is **not** an XSS defence — escape and sanitize anything user-supplied. The CSP is disabled in `local` so the Vite dev server works.

Defaults live in `config/security-headers.php`. Admins can change them at runtime in **Settings → Security headers** ([filament-security-headers](https://github.com/jeffersongoncalves/filament-security-headers)); saved values override the config, and **Reset to config** goes back. Allow any third-party origin you add (analytics, chat widgets, CDNs) in the matching directive, and try a stricter policy with report-only first.

## Credits

Developed by [Jefferson Gonçalves](https://github.com/jeffersongoncalves).
