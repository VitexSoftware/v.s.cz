# Migration Notes - December 25, 2025

## Database Migration from vsnew to magnymph

Successfully migrated vscz database from compromised server (10.11.56.222) to new production server (magnymph.vitexsoftware.com).

### Steps performed:
1. Dumped vscz database from old server (14MB compressed)
2. Transferred to magnymph.vitexsoftware.com
3. Scanned with ClamAV antivirus (clean - 0 infections)
4. Loaded into MySQL on magnymph

### Site Setup Fixes:

**Issue:** HTTP 500 errors on vitexsoftware.com

**Root causes:**
1. Missing composer dependencies in `/var/lib/vitexsoftware.cz/`
2. Missing i18n directory symlink

**Solutions:**
1. Created `/var/lib/vitexsoftware.cz/` directory
2. Ran `composer install --no-dev --optimize-autoloader` in `/var/www/vitexsoftware.cz/`
3. Created symlink: `/usr/share/vitexsoftware.cz/i18n -> /var/www/vitexsoftware.cz/i18n`

### Server Configuration Notes:
- Document root: `/usr/share/vitexsoftware.cz/` (from Debian package)
- Source repository: `/var/www/vitexsoftware.cz/`
- Vendor directory: `/var/lib/vitexsoftware.cz/` (configured in composer.json)
- Database: vscz (5 tables: files, news, packages, phinxlog, user)

### Important:
The i18n symlink is required because:
- The package installs code to `/usr/share/vitexsoftware.cz/`
- VSInit.php uses relative path `'./i18n'` for locale initialization
- The actual i18n directory is in the source repository at `/var/www/vitexsoftware.cz/i18n/`
