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
 * @copyright  2012 Vitex@hippy.cz (G)
 */

// if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
//    header('Location: https://www.vitexsoftware.cz/');
//    exit;
// }

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Articles')));

try {
    $oPage->container->addItem(new \Ease\TWB5\Card(new ui\NewsListing(new News())));
} catch (\Throwable $e) {
    $oPage->container->addItem(new \Ease\TWB5\Alert(
        _('Articles temporarily unavailable.'),
        'warning',
    ));
}

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
