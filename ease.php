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

$oPage->addItem(new ui\PageTop(_('Ease Framework')));
$container = $oPage->addItem(new \Ease\TWB\Container());


$oPage->AddItem('<a href="https://github.com/Vitexus/EaseFramework" class="ribbon bg-teal">Forkni na GitHubu</a>');


$prehled = new \Ease\TWB\Well();
$prehled->addItem('<strong>Ease Framework</strong> je aktívně vyvíjen od roku 2008. ');
$prehled->addItem('Podporuje <a href="http://html5.org">HTML5</a> či <a href="http://getbootstrap.com/">Twitter Bootstrap</a>');
$prehled->addItem(' a <a href="http://www.phpunit.de/manual/current/en/index.html">PHPUnit</a> testy. ');
$prehled->addItem('Snaží se o přehledně psaný kod s <a href="http://pear.php.net/">PEAR</a> upravou. ');
$prehled->addItem('Jazykově závislé řetězce mají <a href="http://php.net/manual/en/book.gettext.php">gettext</a> překlad do Anglického jazyka.<hr>');


$buttons = new \Ease\Container();

$buttons->addItem(new \Ease\TWB\LinkButton('/ease-framework/',
        '<img src="img/apigen.png" width="20">'.' '._('Apigen documentation'),
        'info btn-lg'));
$buttons->addItem(new \Ease\TWB\LinkButton('https://github.com/Vitexus/EaseFramework',
        '<i class = "fa fa-github"></i>&nbsp;GitHub', 'info btn-lg'));
$buttons->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/EaseFramework/commits/master.atom',
        '<i class = "fa fa-rss-square"></i>&nbsp;'._('RSS Feed'), 'info btn-lg'));

$prehled->addItem($buttons);


if (file_exists('easelastmsg.txt')) {
    $prehled->addItem('<hr>');
    $prehled->addItem(new \Ease\Html\H4Tag(_('Latest change')));
    $prehled->addItem(file('easelastmsg.txt'));
}

$efRow = new \Ease\TWB\Row();
$efRow->addColumn(8, $prehled);



$download = new \Ease\Html\DivTag();


$efRow->addColumn(4, '<img src="img/graf-timecost.png" class="img-responsive">');

$container->addItem($efRow);


$readme = '/usr/share/doc/ease-framework/README.md';

if (file_exists($readme)) {
    $converter = new CommonMarkConverter();
    $container->addItem(new \Ease\Html\Div($converter->convertToHtml(file_get_contents($readme)),
            ['class' => 'jumbotron']));
}


$oPage->addItem(new ui\PageBottom());

$oPage->draw();
