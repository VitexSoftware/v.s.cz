<?php

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */

namespace VSCZ;

require_once 'includes/VSInit.php';

$repostats = new AccessLog();


$oPage->includeJavaScript('js/jquery.tablesorter.min.js');
$oPage->addJavaScript('$("#packs").tablesorter();');

$oPage->addItem(new ui\PageTop(_('Deb Repository')));


$packTabs = new \Ease\TWB4\Tabs('PackTabs');


$reposinfo = new \Ease\TWB4\Well(new \Ease\Html\H3Tag(_('How to use repository')));
$reposinfo->addItem(new \Ease\Html\EmTag(_('On current debian or ubuntu')));
$steps     = $reposinfo->addItem(new \Ease\Html\UlTag(
    null,
    ['class' => 'list-group']
));

$steps->addItemSmart(
    'wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key | sudo apt-key add - ',
    ['class' => 'list-group-item']
);
$steps->addItemSmart(
    'echo deb http://v.s.cz/ stable main | sudo tee /etc/apt/sources.list.d/vitexsoftware.list ',
    ['class' => 'list-group-item']
);
$steps->addItemSmart('sudo apt update', ['class' => 'list-group-item']);
$steps->addItemSmart(
    'sudo apt install <em>package(s)</em>',
    ['class' => 'list-group-item']
);

$reposinfo->addItem(sprintf(
    _('apt-get update feeded %d times'),
    $repostats->getUpdatedCount()
));


$packages = ui\PackageInfo::getPackagesInfo();

$ptable = new \Ease\Html\TableTag(null, ['class' => 'table', 'id' => 'packs']);
$ptable->setHeader([_('Package name'), _('Version'), _('Age'), _('Release date'),
    _('Size'),
    _('Package'), _('Installs'), _('Downloads')]);

$oPage->addJavascript('$(".hinter").popover();', null, true);
$oPage->addCss('.hinter { font-weight: bold; font-size: large; }');

foreach ($packages as $pName => $pProps) {
    $packFile = trim($pProps['Filename']);
    $icon     = 'img/deb/' . $pName . '.png';
    if (!file_exists($icon)) {
        $icon = 'img/deb-package.png';
    }
    if (!file_exists($packFile)) {
        continue;
    }

    $installs = $repostats->getPackageInstalls($pName);

    $downloads = $repostats->getPackageDownloads($pName);

    $fileMtime = filemtime($packFile);
    $incTime   = date("Y m. d.", $fileMtime);
    $packAge   = ui\WebPage::secondsToTime(doubleval(time() - $fileMtime));

    $package = new \Ease\Html\ATag(
        $pProps['Filename'],
        '<img style="width: 18px;" src="img/deb-package.png">&nbsp;' . $pProps['Architecture'],
        ['class' => 'btn btn-xs btn-success']
    );
    $pInfo   = new \Ease\Html\ATag(
        'package.php?package=' . $pName . '#',
        $pName,
        ['tabindex' => 0, 'class' => 'hinter', 'data-toggle' => 'popover', 'data-trigger' => 'hover',
        'data-content' => $pProps['Description']]
    );
    $ptable->addRowColumns(['<img class="debicon" src="' . $icon . '"> ' . $pInfo, $pProps['Version'],
        $packAge, $incTime, ui\WebPage::_format_bytes($pProps['Size']),
        $package, $installs, $downloads]);
}

$packTabs->addTab(_('Packages'), $ptable);
$packTabs->addTab(_('Instructions'), $reposinfo);

$oPage->addItem(new \Ease\TWB4\Container($packTabs));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
