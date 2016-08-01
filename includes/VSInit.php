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

function __autoload($class_name)
{
    $class_file = 'classes/'.$class_name.'.php';
    if (file_exists($class_file)) {
        include $class_file;
        return TRUE;
    }
    return FALSE;
}

$language = "cs_CZ";
$codeset  = "cs_CZ.UTF-8";
$domain   = "messages";
putenv("LANGUAGE=".$language);
putenv("LANG=".$language);
bind_textdomain_codeset($domain, "UTF8");
setlocale(LC_ALL, $codeset);
bindtextdomain($domain, realpath("./locale"));
textdomain($domain);

session_start();

if (!isset($_SESSION['User']) || !is_object($_SESSION['User'])) {
    \Ease\Shared::user(new \Ease\Anonym());
}


/**
 * Objekt uživatele VSUser nebo VSAnonym
 * @global VSUser
 */
$OUser = & \Ease\Shared::user();

/* @var $oPage VSWebPage */
$oPage = new \VSCZ\ui\WebPage( );
