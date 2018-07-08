<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2018 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

        
$package = $oPage->getRequestValue('package');

$oPage->addItem(new ui\PageTop(sprintf(_('Package %s details'), $package)));

$oPage->head->addItem( '<meta property="og:image" content="http://v.s.cz/'. (file_exists('img/deb/'.$package.'.png') ?  'img/deb/'.$package.'.png' : 'img/deb-package.png') .'"/>');
$oPage->head->addItem( '<meta property="og:title" content="Debian Package '. $package . '"/>' );

$oPage->addItem(new \Ease\TWB\Container(new ui\PackageInfo(urlencode($package))));

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

