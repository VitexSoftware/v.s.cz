<?php
/**
 * VitexSoftware - titulní strana
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new \VSCZ\ui\PageTop(_('Deb Repository')));

$reposinfo = new \Ease\TWB\Well(new \Ease\Html\H3Tag(_('How to use repository')));

$steps = $reposinfo->addItem(new \Ease\Html\UlTag(null,
    ['class' => 'list-group']));

$steps->addItemSmart('wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key | sudo apt-key add -',
    ['class' => 'list-group-item']);
$steps->addItemSmart('echo deb http://v.s.cz/ stable main | sudo tee /etc/apt/sources.list.d/vitexsoftware.list ',
    ['class' => 'list-group-item']);
$steps->addItemSmart('sudo aptitude update', ['class' => 'list-group-item']);
$steps->addItemSmart('sudo aptitude install <em>package(s)</em>',
    ['class' => 'list-group-item']);


$oPage->addItem(new \Ease\TWB\Container($reposinfo));

$packages = [];
$pName    = null;
$handle   = @fopen("/var/lib/apt/lists/v.s.cz_dists_stable_main_binary-amd64_Packages",
        "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        list( $key, $value ) = explode(':', $buffer);
        switch ($key) {
            case 'Package':
                $pName                  = trim($value);
                break;
            case 'Description':
                $packages[$pName][$key] = $value;
                while (($buffer                 = fgets($handle, 4096)) !== false) {
                    if (strlen(trim($buffer))) {
                        if (trim($buffer) == '.') {
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

$ptable = new \Ease\Html\TableTag(null, ['class' => 'table']);
$ptable->setHeader([_('Package name'), _('Version'), _('Release date'), _('Size'),
    _('Package')]);

$oPage->addJavascript('$(".hinter").popover();', null, true);
$oPage->addCss('.hinter { font-weight: bold; font-size: large; }');

foreach ($packages as $pName => $pProps) {
    if (!file_exists(trim($pProps['Filename']))) {
        continue;
    }
    $incTime = date("m. d. Y H:i:s", filemtime(trim($pProps['Filename'])));
    $package = new \Ease\Html\ATag($pProps['Filename'],
        '<img style="width: 18px;" src="img/deb-package.png">&nbsp;'.$pProps['Architecture'],
        ['class' => 'btn btn-xs btn-success']);
    $pInfo   = new \Ease\Html\ATag('#', $pName,
        ['tabindex' => 0, 'class' => 'hinter', 'data-toggle' => 'popover', 'data-trigger' => 'hover',
        'data-content' => $pProps['Description']]);
    $ptable->addRowColumns([$pInfo, $pProps['Version'], $incTime, \VSCZ\ui\WebPage::_format_bytes($pProps['Size']),
        $package]);
}

$oPage->addItem(new \Ease\TWB\Container($ptable));


$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
