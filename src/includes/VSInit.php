<?php

declare(strict_types=1);

/**
 * This file is part of the VitexSoftware package
 *
 * https://vitexsoftware.com/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VSCZ;

require_once '../vendor/autoload.php';

// The vhost's Apache "php_value include_path" narrows include_path to the
// app's own directories, which hides the system PEAR packages (php-mail,
// php-mail-mime) that Ease\HtmlMailer loads via a bare require_once
// 'Mail.php'. Restore access to them without touching server config.
set_include_path(get_include_path().\PATH_SEPARATOR.'/usr/share/php');

if (!\defined('EASE_APPNAME')) {
    \define('EASE_APPNAME', 'VitexSoftwareWEB');
}

date_default_timezone_set('Europe/Prague');

\Ease\Shared::init([], '/etc/vscz.env');

if (\PHP_SAPI === 'cli') {
    if (!\defined('EASE_LOGGER')) {
        \define('EASE_LOGGER', 'syslog|console|email');
    }

    \Ease\Locale::singleton(null, '../i18n', 'vscz');
} else {
    // Session first, so the language chosen via ?locale= survives to the next page.
    session_start();
    \Ease\Locale::singleton(ui\WebPage::preferredLocale('../i18n'), '../i18n', 'vscz');
}

/**
 * Objekt uživatele User nebo Anonym.
 *
 * @global \Ease\User
 */
\Ease\Shared::user(null, '\Ease\Anonym');
$oUser = \Ease\User::singleton();

/** @var VSWebPage $oPage */
$oPage = new ui\WebPage();
$oPage->includeJavaScript('js/matomo.js');
