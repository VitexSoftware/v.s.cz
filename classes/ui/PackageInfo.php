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
class PackageInfo extends \Ease\TWB4\Panel
{

    //put your code here
    public function __construct($pName)
    {
        $projectUrl = null;
        $this->stDB = new \Ease\SQL\PDO([
            'dbType' => constant('STATS_TYPE'),
            'server' => constant('STATS_SERVER'),
            'username' => constant('STATS_USERNAME'),
            'password' => constant('STATS_PASSWORD'),
            'database' => constant('STATS_DATABASE'),
            'port' => constant('STATS_PORT')
        ]);


        $pProps = $this->packageInfo($pName);

        $packFile = trim($pProps['Filename']);


        $installs = $this->stDB->queryToValue(sprintf(
                "SELECT COUNT(*) FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' AND agent LIKE 'Debian APT%%' ",
                $pName));

        $downloads = $this->stDB->queryToValue(sprintf(
                "SELECT COUNT(*) FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' AND agent NOT LIKE 'Debian APT%%' "
                , $pName));

        $fileMtime = filemtime($packFile);
        $incTime   = date("Y m. d.", $fileMtime);
        $packAge   = WebPage::secondsToTime(doubleval(time() - $fileMtime));

        $packageDownloadLink = new \Ease\Html\ATag($pProps['Filename'],
            '<img style="width: 18px;" src="img/deb-package.png">&nbsp;'.$pProps['Filename'],
            ['class' => 'btn btn-lg btn-default']);

        $packageInstallLink = new \Ease\Html\ATag('install.php?package='.$pName,
            '<img style="width: 18px;" src="img/deb-package.png">&nbsp;'.$pName,
            ['class' => 'btn btn-lg btn-success']);


        $heading = new \Ease\TWB4\Row();
        $heading->addColumn(2,
            self::packageLogo($pName, ['style' => ' height: 90px;']));
        $heading->addColumn(14,
            new \Ease\Html\H1Tag($pName.' '.$pProps['Version']));

        parent::__construct($heading, 'info', null,
            [$packageDownloadLink, $packageInstallLink]);

        $this->addItem(new \Ease\TWB4\Well($pProps['Description']));

        $infotable = new \Ease\Html\TableTag(null, ['class' => 'table']);

        $infotable->addRowColumns([_('Filename'), $packageDownloadLink]);
        $infotable->addRowColumns([_('Version'), $pProps['Version']]);
        $infotable->addRowColumns([_('Age in days'), intval($packAge)]);
        $infotable->addRowColumns([_('Release date'), $incTime]);
        $infotable->addRowColumns([_('Size'), WebPage::_format_bytes($pProps['Size'])]);
        $infotable->addRowColumns([_('Installs'), $installs]);
        $infotable->addRowColumns([_('Downloads'), $downloads]);
        $depIcons = '';
        $pDetails = explode(PHP_EOL, shell_exec('LC_ALL=C dpkg -I '.$packFile));
        if (count($pDetails)) {
            foreach ($pDetails as $row) {
                if (strstr($row, ': ')) {
                    list($key, $value) = explode(': ', $row);
                    switch (trim($key)) {
                        case 'Version':
                            $version  = $value;
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
                                '<a href="'.$value.'">'.$value.'</a>'
                            ]);
                            break;
                        default:
                            $infotable->addRowColumns([_($key), trim($value)]);
                            break;
                    }
                }
            }
        }


        $infoColumns = new \Ease\TWB4\Row();
        $infoColumns->addColumn(8, $infotable);

        $rightColumn = new \Ease\Html\DivTag();
        $rightColumn->addItem(self::packageLogo($pName));
        if (strlen($depIcons)) {
            $rightColumn->addItem('<h3>'._('see also').'</h3>'.$depIcons);
        }


        $infoColumns->addColumn(4, $rightColumn);

        $this->includeJavaScript('js/jquery.tablesorter.min.js');
        $this->addJavaScript('$("#dwlstats").tablesorter();');

        $howmuch = "SELECT REPLACE( request_uri, '_all.deb','' ) AS ver, COUNT(*) AS howmuch, from_unixtime(time_stamp) FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' GROUP BY request_uri ORDER BY request_uri DESC ";

        $popularityTable = new \Ease\Html\TableTag(null,
            ['class' => 'table', 'id' => 'dwlstats']);

        $popularityTable->addRowHeaderColumns([_('Version'), _('Download/Install count'),
            _('Last hit')]);

        $installs = $this->stDB->queryToArray(sprintf($howmuch, $pName));

        foreach ($installs as $iinfo) {
            $iinfo['ver'] = basename($iinfo['ver']);
            $popularityTable->addRowColumns($iinfo);
        }


        $packageTabs     = new \Ease\TWB4\Tabs('PkgInfoTabs');
        $packageTabs->addTab(_('Info'), $infoColumns);
        $packageContents = shell_exec('dpkg-query -L '.$pName);
        if (strlen($packageContents)) {
            $packageTabs->addTab(_('Files'),
                new \Ease\Html\PreTag($packageContents));
        }
        if (strstr($projectUrl, 'github.com')) {
            $packageTabs->addTab(_('Read Me'),
                new HtmlMarkdownReadme($projectUrl, $version));
        }
        $packageTabs->addTab(_('Download stats'), $popularityTable);
        $this->addItem($packageTabs);
    }

    static public function packagesIcons($packs)
    {
        $packIcons = [];
        foreach (array_keys($packs) as $packName) {
            $icon = 'img/deb/'.$packName.'.png';
            if (file_exists($icon)) {
                $packIcons[] = '<div><a href="package.php?package='.$packName.'">'.$packName.'</a></div>';
                $packIcons[] = '<a href="package.php?package='.$packName.'">'.self::packageLogo($packName).'</a>';
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
            $icon = 'img/deb/'.$pack.'.png';
            if (file_exists($icon)) {
                $packs[$pack] = '<a href="package.php?package='.$pack.'">'.$name.'</a>';
            } else {
                $packs[$pack] = '<a href="https://packages.debian.org/stretch/'.$pack.'">'.$name.'</a>';
            }
        }

        return implode(' , ', $packs);
    }

    public static function getPackageIcon($package)
    {
        $icon = 'img/deb/'.$package.'.png';
        if (!file_exists($icon)) {
            $icon = 'img/deb-package.png';
        }
        return $icon;
    }

    public static function packageLogo($pName,
                                       $properties = ['class' => 'img-responsive',
            'style' => 'margin: auto auto;'])
    {

        return new \Ease\Html\ImgTag(self::getPackageIcon($pName), $pName,
            $properties);
    }

    static public function getPackagesInfo()
    {
        $packages = [];
        $pName    = null;
        $handle   = @fopen("/var/lib/apt/lists/v.s.cz_dists_stable_main_binary-amd64_Packages",
                "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                if (!strstr($buffer, ':')) {
                    continue;
                }
                list( $key, $value ) = explode(':', trim($buffer));
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
            return $packages;
        }
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
        $packagesInfo = self::getPackagesInfo();
        return array_key_exists($pName, $packagesInfo) ? $packagesInfo[$pName] : null;
    }
}
