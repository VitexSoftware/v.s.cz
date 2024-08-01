<?php

/**
 * Init aplikace
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright Vitex@hippy.cz (G) 2010-2019
 */

namespace VSCZ;

require_once 'includes/Configure.php';
require_once '/var/lib/vitexsoftware.cz/autoload.php';

if (!defined('EASE_APPNAME')) {
    define('EASE_APPNAME', 'VitexSoftwareWEB');
}

\Ease\Locale::singleton(null, './i18n', 'vscz');

session_start();

if (php_sapi_name() == 'cli') {
    if (!defined('EASE_LOGGER')) {
        define('EASE_LOGGER', 'syslog|console|email');
    }
} else {
    /* @var $oPage ui\WebPage */
    $oPage = new ui\WebPage();
}

/**
 * Objekt uživatele User nebo Anonym
 * @global \Ease\User
 */
$oUser = \Ease\User::singleton();


/* @var $oPage VSWebPage */
$oPage = new ui\WebPage();
$oPage->includeJavaScript('js/matomo.js');

