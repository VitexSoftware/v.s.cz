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
 * @copyright  2012-2020 Vitex@hippy.cz (G)
 */

// if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
//    header('Location: https://www.vitexsoftware.cz/');
//    exit;
// }

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Articles')));

$oPage->container->addItem(new \Ease\TWB5\Card([new ui\NewsShow(new News(), $oPage->getRequestValue('id', 'int')),
    new \Ease\TWB5\LinkButton(
        'articles.php',
        '<img src="img/news.svg" style="height: 20px"> '._('More articles').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>',
        'info',
    )]));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
