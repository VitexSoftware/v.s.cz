<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of NewPackages
 *
 * @author vitex
 */
class NewPackages extends \Ease\Html\SpanTag
{

    use \Ease\SQL\Orm;
    /**
     *
     * @var string table name we work on 
     */
    public $myTable = 'vs_access_log';

    /**
     * 
     * @param mixed $content
     * @param array $properties
     */
    public function __construct($content = null, $properties = array())
    {
        $this->dbType   = constant('STATS_TYPE');
        $this->server   = constant('STATS_SERVER');
        $this->username = constant('STATS_USERNAME');
        $this->password = constant('STATS_PASSWORD');
        $this->database = constant('STATS_DATABASE');
        $this->port     = constant('STATS_PORT');


        $packages = [];
        $pName    = null;
        $handle   = fopen("/var/lib/apt/lists/v.s.cz_dists_stable_main_binary-amd64_Packages",
            "r");
        $position = 0;
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                if (!strstr($buffer, ':')) {
                    continue;
                }
                list( $key, $value ) = explode(':', $buffer);
                switch ($key) {
                    case 'Package':
                        $pName                  = trim($value);
                        $position++;
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
                        $packages[$pName][$key] = trim($value);
                        break;
                }
                $packages[$pName]['Name'] = $pName;


                if (isset($packages[$pName]['Filename']) && file_exists($packages[$pName]['Filename'])) {
                    $packages[$pName]['fileMtime'] = filemtime($packages[$pName]['Filename'])
                        + $position;
                } else {
                    $packages[$pName]['fileMtime'] = time();
                }
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        $packagesByTime = \Ease\Functions::reindexArrayBy($packages, 'fileMtime');

        krsort($packagesByTime);

        parent::__construct(new \Ease\Html\H1Tag(_('Fresh Packages'),
                ['style' => 'text-align: center;']));

        foreach (array_slice($packagesByTime, 0, 5, true) as $pProps) {
            $this->addItem(new \Ease\Html\PTag($this->debInfoBlock($pProps)));
        }

        $this->addItem(new \Ease\Html\PTag('<br>'));

        $this->addItem(new \Ease\Html\PTag(new \Ease\Html\ATag('repostats.php',
                    '<img style="width: 30px;" src="img/deb-package.png">&nbsp;'.' '._('All Packages').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>
', ['class' => 'btn btn-info btn-lg btn-block']),
                ['style' => 'text-align: center;']));
    }

    public function debInfoBlock($pProps)
    {
        $pName    = trim($pProps['Name']);
        $packFile = trim($pProps['Filename']);
        $icon     = 'img/deb/'.$pName.'.png';
        if (!file_exists($icon)) {
            $icon = 'img/deb-package.png';
        }
        $counts = $this->getPullCounts($pProps['Filename'], $pProps['Version']);


        $download = new \Ease\Html\ATag($pProps['Filename'],
            '<img style="width: 30px;" src="img/deb-package.png">&nbsp;'.' '.\VSCZ\ui\WebPage::_format_bytes(intval($pProps['Size'])),
            ['class' => 'btn btn-success']);

        return ['<br clear="all">',
            new \Ease\Html\H3Tag('<a href="package.php?package='.$pName.'">'.$pName.' '.$pProps['Version'].'</a>',
                ['style' => 'text-align: center;']),
            '<div style="text-align: center;"><small>'._('Installed').': '.$counts['installs'].'&nbsp&nbsp;'._('Downloaded').': '.$counts['downloads'].'</small></div>'.
            '<a href="package.php?package='.$pName.'"><img style="width: 50%; display: block; margin: 0 auto;" class="img-responsive" src="'.$icon.'"></a>',
            new \Ease\Html\DivTag($pProps['Description']),
            new \Ease\Html\DivTag($download, ['style' => 'text-align: center;'])
        ];
    }

    /**
     * Get Package pull counts
     * 
     * @param string $package package base name
     * 
     * @return array of int
     */
    public function getPullCounts($package)
    {
        $installs  = $this->getFluentPDO()->from('vs_access_log')->select('COUNT(*)')->where(sprintf('request_uri LIKE \'/%s%%\'',
                    $package))->where('agent LIKE \'Debian APT%%\'');
        $downloads = $this->getFluentPDO()->from('vs_access_log')->select('COUNT(*)')->where(sprintf('request_uri LIKE \'/%s%%\'',
                    $package))->where('agent NOT LIKE \'Debian APT%%\'');
        return ['installs' => $installs, 'downloads' => $downloads];
    }
}
