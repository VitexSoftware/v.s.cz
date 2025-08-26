# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is the VitexSoftware company homepage (https://vitexsoftware.cz/) built with PHP using the EaseFramework. It showcases various PHP libraries, applications, and utilities developed by VitexSoftware, with a focus on AbraFlexi integrations and business tools.

## Architecture

- **Framework**: Custom EaseFramework with Bootstrap 5 UI components
- **Pattern**: MVC-style with separate UI classes in `classes/ui/` namespace
- **Namespace Structure**:
  - `VSCZ\` - Main application classes
  - `VSCZ\ui\` - User interface components
- **Dependencies**: Uses local Debian packages from `/usr/share/php/` and custom vendor directory `/var/lib/vitexsoftware.cz/`

### Key Components

- **VSInit.php**: Application initialization, configuration loading from `/etc/vscz.env`
- **MainPageMenu.php**: Dynamic menu generation with GitHub integration and Packagist badges
- **User.php**: Extended user management with database ORM
- **WebPage classes**: UI components extending EaseFramework's TWB5 (Twitter Bootstrap 5) widgets

## Development Commands

### Setup
```bash
# Install dependencies
composer install
make vendor
```

### Code Quality
```bash
# Run static analysis
make static-code-analysis

# Generate PHPStan baseline
make static-code-analysis-baseline

# Fix coding standards (uses custom PHP CS Fixer config)
make cs
```

### Testing
```bash
# Run tests
make tests
```

### Build & Development
```bash
# View available make targets
make help
```

## Configuration

- **Main config**: `/etc/vscz.env` (loaded via Ease\Shared::init())
- **Composer**: Uses custom vendor directory and local package repositories
- **Database**: Uses FluentPDO for database operations
- **Localization**: `i18n/` directory with 'vscz' domain
- **Session**: PHP sessions initialized in VSInit.php

## Key Files Structure

- `index.php` - Main homepage with dynamic menu generation
- `includes/VSInit.php` - Application bootstrap
- `classes/` - Application classes
  - `User.php` - Extended user management
  - `ui/` - UI components and widgets
- `composer.json` - Dependencies with local Debian package paths
- `Makefile` - Build automation
- `.php-cs-fixer.dist.php` - Code style configuration

## Development Notes

- The application heavily integrates with GitHub API for repository information
- Uses Packagist badges for library version display
- Implements custom authentication with password hashing
- Designed to work with Debian package ecosystem
- Features RSS feed integration and Mastodon social feed
- Includes GitHub activity widgets and WakaTime coding statistics

## Production Deployment

- **Production Server**: `v.s.cz`
- **Document Root**: `/var/www/html/vitexsoftware`
- **Access**: SSH connection available via `ssh v.s.cz`
- **Verification**: Check deployment with `ssh v.s.cz 'ls /var/www/html/vitexsoftware'`
- **Repository**: Connected to https://github.com/VitexSoftware/v.s.cz

### Deployment Process
```bash
# SSH into production server
ssh v.s.cz

# Navigate to web directory
cd /var/www/html/vitexsoftware

# Pull latest changes from GitHub
git pull
```

## External Integrations

- GitHub API for repository stars/forks
- Packagist for version badges
- WakaTime for coding activity
- Mastodon social feed
- Custom RSS feed for package updates
- Matomo analytics
