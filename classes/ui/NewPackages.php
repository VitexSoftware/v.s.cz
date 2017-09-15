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
class NewPackages extends \Ease\Html\Span
{

    public function __construct($content = null, $properties = array())
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
                        $packages[$pName][$key] = trim($value);
                        break;
                }
                $packages[$pName]['Name'] = $pName;
                if (isset($packages[$pName]['Filename'])) {
                    $packages[$pName]['fileMtime'] = filemtime($packages[$pName]['Filename']);
                }
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        $packagesByTime = self::reindexArrayBy($packages, 'fileMtime');

        krsort($packagesByTime);

        parent::__construct(new \Ease\Html\H1Tag(_('Fresh Packages'),
            ['style' => 'text-align: center;']));

        foreach (array_slice($packagesByTime, 0, 5, true) as $pProps) {
            $this->addItem(new \Ease\Html\PTag($this->debInfoBlock($pProps)));
        }

                $this->addItem(new \Ease\Html\PTag('<br>'));

        $this->addItem(new \Ease\Html\PTag(new \Ease\Html\ATag('repos.php',
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


        $download = new \Ease\Html\ATag($pProps['Filename'],
            '<img style="width: 30px;" src="img/deb-package.png">&nbsp;'.' '.\VSCZ\ui\WebPage::_format_bytes(intval($pProps['Size'])),
            ['class' => 'btn btn-success']);

        return ['<br clear="all">',
            new \Ease\Html\H3Tag($pName.' '.$pProps['Version'],
                ['style' => 'text-align: center;']),
            '<img style="width: 50%; display: block; margin: 0 auto;" class="img-responsive" src="'.$icon.'">',
            new \Ease\Html\DivTag($pProps['Description']),
            new \Ease\Html\DivTag($download, ['style' => 'text-align: center;'])
        ];
    }
}
