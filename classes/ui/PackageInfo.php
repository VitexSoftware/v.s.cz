<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of PackageInfo
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class PackageInfo extends \Ease\Html\DivTag
{
    public function __construct($pName)
    {
        $projectUrl = null;

        $repostats = new \VSCZ\AccessLog();

        $pProps = $this->packageInfo($pName);

        $packFile = trim($pProps['Filename']);

//        $installs = $repostats->getPackageInstalls($pName);
//        $downloads = $repostats->getPackageDownloads($pName);

        $fileMtime = $pProps['fileMtime'];
        $incTime = date("Y m. d.", strtotime($fileMtime));
        $packAge = WebPage::secondsToTime(doubleval(time() - strtotime($fileMtime)));

        $packageDownloadLink = new \Ease\Html\ATag(
            'https://repo.vitexsoftware.cz/' . $pProps['Filename'],
            '<img style="width: 18px;" src="img/deb-package.png">&nbsp;' . $pProps['Filename'],
            ['class' => 'btn btn-lg btn-default']
        );

        $packageInstallLink = new \Ease\Html\ATag(
            'install.php?package=' . $pName,
            '<img style="width: 18px;" src="img/deb-package.png">&nbsp;' . $pName,
            ['class' => 'btn btn-lg btn-success']
        );

        $heading = new \Ease\TWB4\Row();
        $heading->addColumn(
            2,
            self::packageLogo($pName, ['style' => ' height: 90px;'])
        );
        $heading->addColumn(
            14,
            new \Ease\Html\H1Tag($pName . ' ' . $pProps['Version'])
        );

        parent::__construct([$heading, $packageDownloadLink, $packageInstallLink]);

        $this->addItem(new \Ease\TWB4\Well($pProps['Description']));

        $infotable = new \Ease\Html\TableTag(null, ['class' => 'table']);

        $infotable->addRowColumns([_('Filename'), $packageDownloadLink]);
        $infotable->addRowColumns([_('Version'), $pProps['Version']]);
        $infotable->addRowColumns([_('Age in days'), intval($packAge)]);
        $infotable->addRowColumns([_('Release date'), $incTime]);
        $infotable->addRowColumns([_('Size'), \Ease\Functions::humanFilesize(intval($pProps['Size']))]);
//        $infotable->addRowColumns([_('Installs'), $installs]);
//        $infotable->addRowColumns([_('Downloads'), $downloads]);
        $depIcons = '';

        foreach ($pProps as $key => $value) {
            switch ($key) {
                case 'Version':
                    $version = $value;
                    break;
                case 'Depends':
                case 'Suggests':
                case 'Recommends':
                case 'Conflicts':
                case 'Replaces':
                    $infotable->addRowColumns([
                        _($key),
                        self::addPackageLinks($value)
                    ]);
                    $depIcons .= self::packagesIcons(self::DependsToArray($value));

                    break;
                case 'Homepage':
                    $projectUrl = $value;
                    $infotable->addRowColumns([
                        _('Homepage'),
                        '<a href="' . $value . '">' . $value . '</a>'
                    ]);
                    break;
                default:
                    $infotable->addRowColumns([_($key), is_array($value) ? implode(
                        ',',
                        $value
                    ) : $value]);
                    break;
            }
        }


        $infoColumns = new \Ease\TWB4\Row();
        $infoColumns->addColumn(8, $infotable);

        $rightColumn = new \Ease\Html\DivTag();
        $rightColumn->addItem(self::packageLogo($pName));
        if (strlen($depIcons)) {
            $rightColumn->addItem('<h3>' . _('see also') . '</h3>' . $depIcons);
        }


        $infoColumns->addColumn(4, $rightColumn);

        $this->includeJavaScript('js/jquery.tablesorter.min.js');
        $this->addJavaScript('$("#dwlstats").tablesorter();');

        $popularityTable = new \Ease\Html\TableTag(
            null,
            ['class' => 'table', 'id' => 'dwlstats']
        );

        $popularityTable->addRowHeaderColumns([_('Version'), _('Download/Install count'),
            _('Last hit')]);

        foreach ($repostats->getPackageVersionInstalls($pName) as $iinfo) {
            $popularityTable->addRowColumns($iinfo);
        }

        $packageTabs = new \Ease\TWB4\Tabs([_('Info') => $infoColumns], ['id' => 'ptabs']);

        $filer = new \VSCZ\Files();
        $packageContents = $filer->getPackageFiles($pProps['Name']);

        if ($packageContents) {
            $fileTable = new \Ease\Html\TableTag();
            $fileTable->addRowHeaderColumns(_('Path'), _('Size'));
            foreach ($packageContents as $pc) {
                $fileTable->addRowColumns(['path' => $pc['path'], 'size' => $pc['size']]);
            }

            $packageTabs->addTab(_('Files'), $fileTable);
        }
        if (strstr($projectUrl, 'github.com')) {
            $packageTabs->addTab(
                _('Read Me'),
                new HtmlMarkdownReadme($projectUrl, $version)
            );
        }
        $packageTabs->addTab(_('Download stats'), $popularityTable);
        $this->addItem($packageTabs);
    }

    public static function packagesIcons($packs)
    {
        $packIcons = [];
        foreach (array_keys($packs) as $packName) {
            $icon = 'img/deb/' . $packName . '.png';
            if (file_exists($icon)) {
                $packIcons[] = '<div><a href="package.php?package=' . $packName . '">' . $packName . '</a></div>';
                $packIcons[] = '<a href="package.php?package=' . $packName . '">' . self::packageLogo($packName) . '</a>';
            }
        }
        return implode('', $packIcons);
    }

    public static function DependsToArray($dependsRaw)
    {
        $packagesRaw = explode(',', str_replace('|', ',', $dependsRaw));
        foreach ($packagesRaw as $pid => $package) {
            $package = trim($package);
            if (strstr($package, ' ')) {
                $packageName = explode(' ', $package)[0];
            } else {
                $packageName = trim($package);
            }
            $packages[$packageName] = $package;
        }
        return $packages;
    }

    public static function addPackageLinks($dependsRaw)
    {
        $packs = self::DependsToArray($dependsRaw);
        foreach ($packs as $pack => $name) {
            $icon = 'img/deb/' . $pack . '.png';
            if (file_exists($icon)) {
                $packs[$pack] = '<a href="package.php?package=' . $pack . '">' . $name . '</a>';
            } else {
                $packs[$pack] = '<a href="https://packages.debian.org/stretch/' . $pack . '">' . $name . '</a>';
            }
        }

        return implode(' , ', $packs);
    }

    public static function getPackageIcon($package)
    {
        $icon = 'img/deb/' . $package . '.png';
        if (!file_exists($icon)) {
            $icon = 'img/deb/' . $package . '.svg';
        }
        if (!file_exists($icon)) {
            $icon = 'img/deb-package.png';
        }
        return $icon;
    }

    public static function packageLogo(
        $pName,
        $properties = ['class' => 'img-responsive',
                'style' => 'margin: auto auto; width: 200px;']
    ) {

        return new \Ease\Html\ImgTag(
            self::getPackageIcon($pName),
            $pName,
            $properties
        );
    }

    /**
     * Obtain DPKG info for given package
     *
     * @param string $pName package-name
     *
     * @return array dpkg info
     */
    public function packageInfo($pName)
    {
        $packager = new \VSCZ\Packages($pName, ['autoload' => true]);

        $candidates = $packager->getData();

        return $candidates[0];
    }
}
