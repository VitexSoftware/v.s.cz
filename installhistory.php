<?php
/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */

namespace VSCZ;

require_once 'includes/VSInit.php';



$stDB = new \Ease\SQL\PDO([
    'dbType' => constant('STATS_TYPE'),
    'server' => constant('STATS_SERVER'),
    'username' => constant('STATS_USERNAME'),
    'password' => constant('STATS_PASSWORD'),
    'database' => constant('STATS_DATABASE'),
    'port' => constant('STATS_PORT')
    ]);


    $installs = $stDB->queryToValue(sprintf(
            "SELECT * FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' AND agent LIKE 'Debian APT%%'  ",
            $pName));

    $downloads = $stDB->queryToValue(sprintf(
            "SELECT * FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' AND agent NOT LIKE 'Debian APT%%' "
            , $pName));

$oPage->addItem(new ui\PageTop(_('Install History')));


$packages = ui\PackageInfo::getPackagesInfo();


$oPage->addItem(new \Ease\TWB\Container(  new \Ease\Html\TableTag($installs)  ));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
