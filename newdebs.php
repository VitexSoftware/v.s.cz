<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2021 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new ui\NewPackages());
$oPage->draw();
