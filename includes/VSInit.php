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

require_once 'includes/Configure.php';

require_once '/var/lib/vitexsoftware.cz/autoload.php';

if (!\defined('EASE_APPNAME')) {
    \define('EASE_APPNAME', 'VitexSoftwareWEB');
}

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
