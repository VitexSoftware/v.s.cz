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

namespace VSCZ\ui;

/**
 * Description of Repositor.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Repositor extends \Ease\Html\DivTag
{
    /**
     * @var array supported distro list
     */
    public static array $distributions = ['bionic' => 'ubuntu', 'buster' => 'debian', 'natty' => 'ubuntu',
        'sid' => 'debian', 'stretch' => 'debian'];
    public $repodir;
    public $packages = [];
    public $repoUrl = 'https://repo.vitexsoftware.com/';
    private \VSCZ\Packages $packager;

    /**
     * @param string $repodir
     */
    public function __construct($repodir)
    {
        parent::__construct();
        $this->packager = new \VSCZ\Packages();
        $this->repodir = $repodir;

        foreach (array_keys(self::$distributions) as $distroname) {
            $this->loadInRelease($distroname);
        }
    }

    public function finalize(): void
    {
        $repostats = new \VSCZ\AccessLog();
        $this->includeJavaScript('js/jquery.tablesorter.min.js');
        $this->addJavaScript('$("#packs").tablesorter();');

        $packages = self::flatPackageListing($this->packages);

        $ptable = new \Ease\Html\TableTag(
            null,
            ['class' => 'table table-dark table-striped', 'id' => 'packs'],
        );
        $ptable->setHeader([_('Package name'), _('Version'), _('Age'), _('Release date'),
            _('Size'),
            _('Package'), _('Installs'), _('Downloads')], ['class' => 'thead-dark']);

        $this->addJavascript('$(".hinter").popover();', null, true);
        $this->addCss('.hinter { font-weight: bold; font-size: large; }');

        foreach ($packages as $pName => $pProps) {
            $packFile = trim($pProps['Filename']);
            $icon = \VSCZ\Deb::getIcon($pName);
            $installs = 0; // $repostats->getPackageInstalls($pName);

            $downloads = 0; // $repostats->getPackageDownloads($pName);

            $fileMtime = new \DateTime($pProps['fileMtime']);
            $incTime = $fileMtime->format('Y m. d.');
            $packAge = WebPage::secondsToTime((float) (time() - $fileMtime->getTimestamp()));

            $pathParts = explode('/', $pProps['Filename']);
            $packFileBase = str_replace($pathParts[0].'/'.$pathParts[1], '', $pProps['Filename']);

            $pkgs = [];

            foreach ($pProps['Distro'] as $distro) {
                $pkgs[$this->repoUrl.'pool/'.$distro.$packFileBase] = $distro;
            }

            $package = new \Ease\TWB4\DropdownButton('<img style="width: 18px;" src="img/deb-package.png">&nbsp;'._('Download'), 'success', $pkgs);

            $pInfo = new \Ease\Html\ATag(
                'package.php?package='.$pName.'#',
                $pName,
                ['tabindex' => 0, 'class' => 'hinter', 'data-toggle' => 'popover',
                    'data-trigger' => 'hover',
                    'data-content' => $pProps['Description']],
            );
            $ptable->addRowColumns(['<img class="debicon" src="'.$icon.'"> '.$pInfo,
                $pProps['Version'],
                $packAge, $incTime, \Ease\Functions::humanFilesize($pProps['Size']),
                $package, $installs, $downloads]);
        }

        $ptable->setTagProperty('style', 'background-color:rgba(0, 0, 0, 0.5); color: white;');

        $this->addItem($ptable);
    }

    public static function htmlize($tableData)
    {
        $htmlized = [];

        foreach ($tableData as $packageRow) {
            $htmlized[] = self::htmlizeRow($packageRow);
        }

        return $htmlized;
    }

    public static function htmlizeRow($packageData)
    {
        unset($packageData['Maintainer']);
        $packageData['Depends'];

        return $packageData;
    }

    public static function flatPackageListing($packagesTree)
    {
        $packages = [];

        foreach ($packagesTree as $distro => $inDistro) {
            foreach ($inDistro as $component => $inComponent) {
                foreach ($inComponent as $arch => $inArch) {
                    foreach ($inArch as $packageName => $packageInfo) {
                        if (!\array_key_exists($packageName, $packages)) {
                            $packages[$packageName] = $packageInfo;
                        }

                        $packages[$packageName]['Distro'][$distro] = $distro;
                        $packages[$packageName]['Component'][$component] = $component;
                        $packages[$packageName]['Arch'][$arch] = $arch;
                    }
                }
            }
        }

        return $packages;
    }

    /**
     * Release loader.
     *
     * @param string $distroname
     */
    public function loadInRelease($distroname): void
    {
        $candidates = $this->packager->listingQuery()->where('Distribution', $distroname);

        if ($candidates->count()) {
            foreach ($candidates as $candidat) {
                $this->packages[$distroname][$candidat['Suite']][$candidat['Architecture']][$candidat['Name']] = $candidat;
            }
        }
    }

    /**
     * @param mixed $distroArchDir
     *
     * @return array packages in Distro/Arch
     */
    public function loadPackages($distroArchDir)
    {
        $packages = [];
        $pName = null;

        return $packages;
    }
}
