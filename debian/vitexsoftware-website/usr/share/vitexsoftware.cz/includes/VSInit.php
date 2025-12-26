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



// Try to load autoload from different locations
if (file_exists('/var/lib/vitexsoftware.cz/autoload.php')) {
    require_once '/var/lib/vitexsoftware.cz/autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
} else {
    // For development - try to include basic EaseFramework if available
    if (file_exists('/usr/share/php/EaseCore/autoload.php')) {
        require_once '/usr/share/php/EaseCore/autoload.php';
    }
    if (file_exists('/usr/share/php/EaseTWB5/autoload.php')) {
        require_once '/usr/share/php/EaseTWB5/autoload.php';
    }
    // Create a simple fallback autoloader
    spl_autoload_register(function ($class) {
        $file = str_replace('\\', '/', $class) . '.php';
        if (strpos($class, 'VSCZ\\') === 0) {
            $file = __DIR__ . '/../classes/' . substr($file, 5);
            if (file_exists($file)) {
                include $file;
            }
        }
    });
}

if (!\defined('EASE_APPNAME')) {
    \define('EASE_APPNAME', 'VitexSoftwareWEB');
}


date_default_timezone_set('Europe/Prague');


\Ease\Shared::init([],'/etc/vscz.env');


\Ease\Locale::singleton(null, './i18n', 'vscz');

session_start();

if (\PHP_SAPI === 'cli') {
    if (!\defined('EASE_LOGGER')) {
        \define('EASE_LOGGER', 'syslog|console|email');
    }
} else {
    /** @var ui\WebPage $oPage */
    $oPage = new ui\WebPage();
}

/**
 * Objekt uživatele User nebo Anonym.
 *
 * @global \Ease\User
 */
$oUser = \Ease\User::singleton();

/** @var VSWebPage $oPage */
$oPage = new ui\WebPage();
$oPage->includeJavaScript('js/matomo.js');
