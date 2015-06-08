<?php

/**
 * Init aplikace
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright Vitex@hippy.cz (G) 2010
 */
require_once 'includes/Configure.php';
set_include_path('classes' . PATH_SEPARATOR . get_include_path());

function __autoload($class_name)
{
    $class_file = 'classes/' . $class_name . '.php';
    if (file_exists($class_file)) {
        include $class_file;
        return TRUE;
    }
    return FALSE;
}

$language = "cs_CZ";
$codeset = "cs_CZ.UTF-8";
$domain = "messages";
putenv("LANGUAGE=" . $language);
putenv("LANG=" . $language);
bind_textdomain_codeset($domain, "UTF8");
setlocale(LC_ALL, $codeset);
bindtextdomain($domain, realpath("./locale"));
textdomain($domain);

require_once 'Ease/EaseUser.php';

session_start();

if (!isset($_SESSION['User']) || !is_object($_SESSION['User'])) {
    EaseShared::user(new EaseAnonym());
}


/**
 * Objekt uživatele VSUser nebo VSAnonym
 * @global VSUser
 */
$OUser = & EaseShared::user();

require_once 'VSWebPage.php';

/* @var $oPage VSWebPage */
$oPage = new \VSWebPage( );

