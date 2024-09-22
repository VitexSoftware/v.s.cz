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

/**
 * VitexSoftware - titulní strana.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2019 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';

$package = $oPage->getRequestValue('package');

$oPage->addItem(new ui\PageTop(sprintf(_('Package %s details'), $package)));

$oPage->head->addItem('<meta property="og:image" content="http://vitexsoftware.cz/'.(file_exists('img/deb/'.$package.'.png') ? 'img/deb/'.$package.'.png' : 'img/deb-package.png').'"/>');
$oPage->head->addItem('<meta property="og:title" content="Debian Package '.$package.'"/>');

$oPage->addItem(new \Ease\TWB4\Container(new ui\PackageInfo(urlencode($package))));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
