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

$oPage->addItem(new \VSCZ\ui\PageTop(_('Imap2MX for Roundcube and Squirrelmail')));
$oPage->addPageColumns();

$prehled = $oPage->column2->addItem(new \Ease\Html\DivTag());
$prehled->addItem('Plugin <strong>Imap2mx</strong> allow IMAP login to user\'s email address MX ip. This is special configuration for multiplete dedicated (ISPConfig) mailservers.');

$oPage->column2->addItem('<hr>');

$oPage->column1->addItem(new \Ease\Html\H3Tag(_('Download')));

$oPage->column1->addItem('<div style="background-color: #CAAAAA; margin: 2px; padding: 5px;">imap2mx package<br>');

$dwDir = '/var/www/html/download/';
$d = dir($dwDir);
$downloads = [];

while (false !== ($entry = $d->read())) {
    if ($entry[0] === '.') {
        continue;
    }

    $downloads[$entry] = \VSCZ\ui\WebPage::_format_bytes(filesize($dwDir.$entry));
}

$d->close();
ksort($downloads);
$SquirelPackage = [];
$RoundcubePackage = [];

foreach ($downloads as $file => $size) {
    if (strstr($file, 'squirrelmail-imap2mx_')) {
        $SquirelPackage = [$file => $size];
    }
}

// echo '<pre>'; print_r($Downloads); echo '</pre>';

$oPage->column1->addItem(new \Ease\Html\ATag(
    'download/'.key($SquirelPackage),
    '<img style="width: 42px;" src="img/deb-package.png">&nbsp;'.key($SquirelPackage).' '.current($SquirelPackage),
    ['class' => 'btn btn-success'],
));

$oPage->column1->addItem('</div>');

$oPage->column3->addItem(new \Ease\Html\H3Tag(_('Download')));

$oPage->column3->addItem('<div style="background-color: #CAAAAA; margin: 2px; padding: 5px;">imap2mx package<br>');

$dwDir = '/var/www/html/download/';
$d = dir($dwDir);
$downloads = [];

while (false !== ($entry = $d->read())) {
    if ($entry[0] === '.') {
        continue;
    }

    $downloads[$entry] = VSCZ\ui\WebPage::_format_bytes(filesize($dwDir.$entry));
}

$d->close();
ksort($downloads);
$SquirelPackage = [];
$RoundcubePackage = [];

foreach ($downloads as $file => $size) {
    if (strstr($file, 'roundcube-plugin-imap2mx')) {
        $SquirelPackage = [$file => $size];
    }
}

// echo '<pre>'; print_r($Downloads); echo '</pre>';

$oPage->column3->addItem(new \Ease\Html\ATag(
    'download/'.key($SquirelPackage),
    '<img style="width: 42px;" src="img/deb-package.png">&nbsp;'.key($SquirelPackage).' '.current($SquirelPackage),
    ['class' => 'btn btn-success'],
));

$oPage->column3->addItem('</div>');

$oPage->column2->addItem('<h4>Debian installation</h4>');
$oPage->column2->addItem('<li><code>wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -</code></li>');
$oPage->column2->addItem('<li><code>echo deb http://v.s.cz/ stable main &gt; /etc/apt/sources.list.d/ease.list </code></li>');
$oPage->column2->addItem('<li><code>aptitude update</code></li>');
$oPage->column2->addItem('<strong><li><code>aptitude install squirrelmail-imap2mx</code></li></strong>');
$oPage->column2->addItem('<strong><li><code>aptitude install roundcube-plugin-imap2mx</code></li></strong>');

$oPage->column2->addItem('<h5>Compatible with</h5>');
$oPage->column2->addItem('<a href="http://debian.org/"><img style="width: 60px;" title="Debian Linux" src="img/debian.png"></a>');
$oPage->column2->addItem('<a href="http://ubuntu.com/"><img style="width: 60px;" title="Ubuntu Linux" src="img/ubuntulogo.png"></a>');

$oPage->column1->addItem(new \Ease\Html\ATag(
    'http://squirrelmail.org/',
    '<img style="height: 32px;" src="img/sm_logo.png">&nbsp; Official project homepage',
    ['class' => 'btn btn-info'],
));
$oPage->column3->addItem(new \Ease\Html\ATag(
    'http://www.roundcube.net/',
    '<img style="height: 32px;" src="img/rc_logo.png">&nbsp; Official project homepage',
    ['class' => 'btn btn-info'],
));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
