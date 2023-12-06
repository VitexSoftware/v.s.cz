<?php

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */

namespace VSCZ;

use League\CommonMark\CommonMarkConverter;

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('FlexiPeeHP')));
$container = $oPage->addItem(new \Ease\TWB4\Container());


$oPage->AddItem('<a href="https://github.com/Spoje-NET/FlexiPeeHP" class="ribbon bg-teal">Forkni na GitHubu</a>');


$prehled = new \Ease\TWB4\Well();
$prehled->addItem(new \Ease\Html\DivTag('<strong>FlexiPeeHP</strong> je aktívně vyvíjen od roku 2015. '));


$buttons = new \Ease\Container();

$buttons->addItem(new \Ease\TWB4\LinkButton(
    '/flexipeehp/',
    '<img src="img/apigen.png" width="20">' . ' ' . _('Apigen documentation'),
    'info btn-lg'
));
$buttons->addItem(new \Ease\TWB4\LinkButton(
    'https://github.com/Spoje-NET/FlexiPeeHP',
    '<i class = "fa fa-github"></i>&nbsp;GitHub',
    'info btn-lg'
));
$buttons->addItem(new \Ease\TWB4\LinkButton(
    'https://github.com/Spoje-NET/FlexiPeeHP/commits/master.atom',
    '<i class = "fa fa-rss-square"></i>&nbsp;' . _('RSS Feed'),
    'info btn-lg'
));

$prehled->addItem($buttons);


if (file_exists('easelastmsg.txt')) {
    $prehled->addItem('<hr>');
    $prehled->addItem(new \Ease\Html\H4Tag(_('Latest change')));
    $prehled->addItem(file('flexipeehplastlog'));
}

$efRow = new \Ease\TWB4\Row();
$efRow->addColumn(8, $prehled);



$download = new \Ease\Html\DivTag();


$efRow->addColumn(4, '<img src="img/flexipeehp-1.8.png" class="img-responsive">');

$container->addItem($efRow);


$readme = '/usr/share/doc/FlexiPeeHP/README.md';

if (file_exists($readme)) {
    $converter = new CommonMarkConverter();
    $container->addItem(new \Ease\Html\DivTag(
        $converter->convertToHtml(file_get_contents($readme)),
        ['class' => 'jumbotron']
    ));
}


$oPage->addItem(new ui\PageBottom());

$oPage->draw();
