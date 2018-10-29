<?php
/**
 * Init aplikace
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright Vitex@hippy.cz (G) 2010
 */

namespace VSCZ;

require_once 'includes/Configure.php';
require_once '/var/lib/v.s.cz/autoload.php';

if (!defined('EASE_APPNAME')) {
    define('EASE_APPNAME', 'VitexSoftwareWEB');
}

session_start();

$locale = \Ease\Shared::locale(new \Ease\Locale(null,'./i18n','vscz'));

if (\Ease\Shared::isCli()) {
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
$oUser = \Ease\Shared::user();


/* @var $oPage VSWebPage */
$oPage = new \VSCZ\ui\WebPage( );

