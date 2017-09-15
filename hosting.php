<?php

namespace VSCZ;

/**
 * VitexSoftware - hosting
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2017 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Hosting - Vitex Software')));

$oPage->addItem(new \Ease\TWB\Container(_('Nabízíme hosting na těchto platformách:')));
$oPage->addPageColumns();

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('NodeJS')));
$oPage->column1->addItem(_('Javascript on backend and frontend'));
$oPage->column1->addItem(new \Ease\Html\ATag('https://nodejs.org',
    new \Ease\Html\ImgTag('img/node_js.png', 'nodejs', ['width' => '50%'])));


$oPage->column2->addItem(new \Ease\Html\H2Tag(_('Ruby on Rails')));
$oPage->column2->addItem(_('Most poplular Ruby WebAPPs framework'));
$oPage->column2->addItem(new \Ease\Html\ATag('http://rubyonrails.org/',
    new \Ease\Html\ImgTag('img/ruby-on-rails.png', 'RoR', ['width' => '50%'])));

$oPage->column3->addItem(new \Ease\Html\H2Tag(_('Python Django')));
$oPage->column3->addItem(_('Most Popular Python WebAPPs framework'));
$oPage->column3->addItem(new \Ease\Html\ATag('https://www.djangoproject.com/',
    new \Ease\Html\ImgTag('img/PythonDjango.jpg', 'Django', ['width' => '50%'])));

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

