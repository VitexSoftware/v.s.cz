<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2018 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';


$oPage->addItem(new ui\PageTop(_('Debian Repository')));


$repodir = '/home/vitex/WWW/repo.vitexsoftware.cz';

$oPage->addItem(new ui\Repositor($repodir));


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();
