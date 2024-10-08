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

$oPage->includeJavaScript('js/jquery.tablesorter.min.js');
$oPage->addJavaScript('$("#packs").tablesorter();');

$oPage->addItem(new \VSCZ\ui\PageTop(_('Deb Repository')));

$packTabs = new Ease\TWB5\Tabs('PackTabs');

$reposinfo = new \Ease\TWB5\Card(new \Ease\Html\H3Tag(_('How to use repository')));

$steps = $reposinfo->addItem(new \Ease\Html\UlTag(
    null,
    ['class' => 'list-group'],
));

$steps->addItemSmart(
    'wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key | sudo apt-key add -',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart(
    'echo deb http://v.s.cz/ stable main | sudo tee /etc/apt/sources.list.d/vitexsoftware.list ',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart('sudo aptitude update', ['class' => 'list-group-item']);
$steps->addItemSmart(
    'sudo aptitude install <em>package(s)</em>',
    ['class' => 'list-group-item'],
);

$updated = \Ease\Shared::db()->queryToValue('SELECT count(*) FROM `vs_access_log` WHERE `request_uri` = \'/dists/stable/InRelease\'');
$reposinfo->addItem(sprintf(_('apt-get update feeded %d times'), $updated));

$packages = [];
$pName = null;
$handle = @fopen(
    '/var/lib/apt/lists/v.s.cz_dists_stable_main_binary-amd64_Packages',
    'rb',
);

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        if (!strstr($buffer, ':')) {
            continue;
        }

        [$key, $value] = explode(':', $buffer);

        switch ($key) {
            case 'Package':
                $pName = trim($value);

                break;
            case 'Description':
                $packages[$pName][$key] = $value;

                while (($buffer = fgets($handle, 4096)) !== false) {
                    if (\strlen(trim($buffer))) {
                        if (trim($buffer) === '.') {
                            $buffer = "\n";
                        }

                        $packages[$pName][$key] .= $buffer;
                    } else {
                        break;
                    }
                }

                break;

            default:
                $packages[$pName][$key] = $value;

                break;
        }
    }

    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }

    fclose($handle);
}

$ptable = new \Ease\Html\TableTag(null, ['class' => 'table', 'style' => 'background-color:rgba(0, 0, 0, 0.5);', 'id' => 'packs']);
$ptable->setHeader([_('Package name'), _('Version'), _('Age'), _('Release date'),
    _('Size'),
    _('Package')]);

$oPage->addJavascript('$(".hinter").popover();', null, true);
$oPage->addCss('.hinter { font-weight: bold; font-size: large; }');

foreach ($packages as $pName => $pProps) {
    $packFile = trim($pProps['Filename']);
    $icon = 'img/deb/'.$pName.'.png';

    if (!file_exists($icon)) {
        $icon = 'img/deb-package.png';
    }

    if (!file_exists($packFile)) {
        continue;
    }

    $fileMtime = filemtime($packFile);
    $incTime = date('Y m. d.', $fileMtime);
    $packAge = \VSCZ\ui\WebPage::secondsToTime((float) (time() - $fileMtime));

    $package = new \Ease\Html\ATag(
        $pProps['Filename'],
        '<img style="width: 18px;" src="img/deb-package.png">&nbsp;'.$pProps['Architecture'],
        ['class' => 'btn btn-xs btn-success'],
    );
    $pInfo = new \Ease\Html\ATag(
        '#',
        $pName,
        ['tabindex' => 0, 'class' => 'hinter', 'data-toggle' => 'popover', 'data-trigger' => 'hover',
            'data-content' => $pProps['Description']],
    );
    $ptable->addRowColumns(['<img class="debicon" src="'.$icon.'"> '.$pInfo,
        $pProps['Version'],
        $packAge, $incTime, \VSCZ\ui\WebPage::_format_bytes($pProps['Size']),
        $package]);
}

$pTab = $packTabs->addTab(_('Packages'), $ptable);

$packTabs->addTab(_('Instructions'), $reposinfo);

$oPage->addItem(new \Ease\TWB5\Container($packTabs))->addItem(new Ease\TWB5\LinkButton(
    'repostats.php',
    _('download count details').' ('._('please wait').')',
    'info',
));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
