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
 * @copyright  2012-2022 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';
$oPage->addItem(new ui\PageTop(_('Debian Repository')));
$repodir = 'repo';
$reposinfo = new \Ease\TWB5\Card(new \Ease\Html\H3Tag(_('How to use repository')));
$reposinfo->addItem(new \Ease\Html\EmTag(_('On current debian or ubuntu')));
$steps = $reposinfo->addItem(new \Ease\Html\UlTag(
    null,
    ['class' => 'list-group'],
));
$steps->addItemSmart(
    'echo "deb http://repo.vitexsoftware.com $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart(
    'sudo wget -O /etc/apt/trusted.gpg.d/vitexsoftware.gpg http://repo.vitexsoftware.cz/keyring.gpg',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart('sudo apt update', ['class' => 'list-group-item']);
$steps->addItemSmart(
    'sudo apt install <em>package(s)</em>',
    ['class' => 'list-group-item'],
);
$pTabs = new \Ease\TWB5\Tabs([_('Packages') => new ui\Repositor($repodir), _('How to use') => $reposinfo]);
$oPage->container->addItem($pTabs);
$oPage->addItem(new \VSCZ\ui\PageBottom());
$oPage->draw();
