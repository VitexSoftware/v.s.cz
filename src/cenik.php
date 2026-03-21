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

require_once 'includes/VSInit.php';

$oPage->addItem(new \VSCZ\ui\PageTop(_('Vitex Software')));

$pageCols = $oPage->container->addItem(new \Ease\TWB5\Row());

$oPage->column1 = $pageCols->addColumn(4);
$oPage->column2 = $pageCols->addColumn(4);
$oPage->column3 = $pageCols->addColumn(4);

$oPage->column2->addItem(new \Ease\Html\ImgTag('img/terminal.png'));

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Remote programming / administration work')));
$serverSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart('Small work: 400 CZK per hour');
$serverSkills->addItemSmart('Medium work: CZK 2,000 per day');
$serverSkills->addItemSmart('Flat fee 30000 CZK per month');

$oPage->column3->addItem(new \Ease\Html\H2Tag(_('On-site programming / administration work')));
$serverSkills = $oPage->column3->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart('Small scale work: CZK 500 per hour');
$serverSkills->addItemSmart('Medium work: CZK 3,000 per day');
$serverSkills->addItemSmart('Flat fee 45000 CZK per month');

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
