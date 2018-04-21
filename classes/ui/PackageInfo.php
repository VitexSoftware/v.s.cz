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
class PackageInfo extends \Ease\TWB\Panel
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
            ['class' => 'btn btn-lg btn-success']);

        $heading = new \Ease\TWB\Row();
        $heading->addColumn(2,
            self::packageLogo($pName, ['style' => ' height: 90px;']));
        $heading->addColumn(14,
            new \Ease\Html\H1Tag($pName.' '.$pProps['Version']));

        parent::__construct($heading, 'info', null, $packageDownloadLink);

        $this->addItem(new \Ease\TWB\Well($pProps['Description']));

        $infotable = new \Ease\Html\TableTag(null, ['class' => 'table']);

        $infotable->addRowColumns([_('Filename'), $packageDownloadLink]);
        $infotable->addRowColumns([_('Version'), $pProps['Version']]);
        $infotable->addRowColumns([_('Age in days'), intval($packAge)]);
        $infotable->addRowColumns([_('Release date'), $incTime]);
        $infotable->addRowColumns([_('Size'), WebPage::_format_bytes($pProps['Size'])]);
        $infotable->addRowColumns([_('Installs'), $installs]);
        $infotable->addRowColumns([_('Downloads'), $downloads]);

        $pDetails = explode(PHP_EOL, shell_exec('LC_ALL=C dpkg -I '.$packFile));
        if (count($pDetails)) {
            foreach ($pDetails as $row) {
                if (strstr($row, ': ')) {
                    list($key, $value) = explode(': ', $row);
                    switch (trim($key)) {
                        case 'Version':
                            $version = $value;
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

        
        $infoColumns = new \Ease\TWB\Row();
        $infoColumns->addColumn(8, $infotable);

        $rightColumn = new \Ease\Html\DivTag();
        $rightColumn->addItem(self::packageLogo($pName));

        $infoColumns->addColumn(4, $rightColumn);

        $this->addItem($infoColumns);
        
        $this->addItem(new \Ease\Html\PreTag(shell_exec('dpkg-query -L '.$pName)));

        
        if(strlen($projectUrl)){
            $this->addItem( new HtmlMarkdownReadme( $projectUrl , $version ) );
        }

        $howmuch = "SELECT REPLACE( request_uri, '_all.deb','' ) AS ver, COUNT(*) AS howmuch, from_unixtime(time_stamp) FROM vs_access_log WHERE request_uri LIKE '/pool/main/%%/%s_%%' GROUP BY request_uri ORDER BY request_uri DESC ";

        $popularityTable = new \Ease\Html\TableTag(null, ['class' => 'table']);

        $popularityTable->addRowHeaderColumns([_('Version'), _('Download/Install count'),
            _('Last hit')]);

        $installs = $this->stDB->queryToArray(sprintf($howmuch, $pName));

        foreach ($installs as $iinfo) {
            $iinfo['ver'] = basename($iinfo['ver']);
            $popularityTable->addRowColumns($iinfo);
        }

        $this->addItem($popularityTable);

        
        
        }

    public static function packageLogo($pName,
                                       $properties = ['class' => 'img-responsive',
            'style' => 'margin: auto auto;'])
    {
        $icon = 'img/deb/'.$pName.'.png';
        if (!file_exists($icon)) {
            $icon = 'img/deb-package.png';
        }

        return new \Ease\Html\ImgTag($icon, $pName, $properties);
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
