<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of Repositor
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Repositor extends \Ease\Html\DivTag
{
    /**
     * @var array supported distro list 
     */
    public $distributions = ['bionic', 'buster', 'ilegal', 'natty', 'sid', 'stretch'];
    public $repodir       = null;
    public $packages      = [];

    /**
     * 
     * @param string $repodir
     */
    public function __construct($repodir)
    {
        parent::__construct();
        $this->repodir = $repodir;
        foreach ($this->distributions as $distroname) {
            $this->loadInRelease($distroname);
        }

        $this->addItem('<pre>'.var_dump(self::flatPackageListing($this->packages),
                true).'</pre>');
    }

    public function flatPackageListing($packagesTree)
    {
        $packages = [];
        foreach ($packagesTree as $distro => $inDistro) {
            foreach ($inDistro as $component => $inComponent) {
                foreach ($inComponent as $arch => $inArch) {
                    foreach ($inArch as $packageName => $packageInfo) {
                        if (!array_key_exists($packageName, $packages)) {
                            $packages[$packageName] = $packageInfo;
                        }
                        $packages[$packageName]['Distro'][$distro]       = $distro;
                        $packages[$packageName]['Component'][$component] = $component;
                        $packages[$packageName]['Arch'][$arch]           = $arch;
                    }
                }
            }
        }
        return $packages;
    }

    /**
     * Release loader
     * 
     * @param string $distroname
     */
    function loadInRelease($distroname)
    {
        $inReleaseFile       = $this->repodir.'/dists/'.$distroname.'/InRelease';
        $inRelease           = file($inReleaseFile);
        $inReleaseProperties = [];
        foreach ($inRelease as $inReleaseLine) {
            if (strstr($inReleaseLine, ':')) {
                list($key, $value) = explode(':', trim($inReleaseLine));
                if ($value) {
                    $inReleaseProperties[$key] = trim($value);
                }
            }
        }

        foreach (explode(' ', trim($inReleaseProperties['Components'])) as $component) {
            $componentDir = $this->repodir.'/dists/'.$distroname.'/'.$component;
            $d            = dir($componentDir);
            while (false !== ($arch         = $d->read())) {
                if ($arch[0] != '.') {
                    $this->packages[$distroname][$component][$arch] = $this->loadPackages($componentDir.'/'.$arch);
                }
            }
            $d->close();
        }
    }

    /**
     * 
     * @param string $packagesFile
     * 
     * @return array packages in Distro/Arch
     */
    public function loadPackages($distroArchDir)
    {
        $packages = [];
        $pName    = null;

        if (file_exists($distroArchDir.'/Packages')) {
            $handle   = fopen($distroArchDir.'/Packages', "r");
            $position = 0;
            if ($handle) {
                while (($buffer = fgets($handle, 4096)) !== false) {
                    if (!strstr($buffer, ':')) {
                        continue;
                    }
                    list( $key, $value ) = explode(':', trim($buffer));
                    switch ($key) {
                        case 'Package':
                            $pName                               = trim($value);
                            $position++;
                            break;
                        case 'Description':
                            $packages[$pName][$key]              = trim($value);
                            $packages[$pName]['LongDescription'] = '';
                            while (($buffer                              = fgets($handle,
                            4096)) !== false) {
                                if (strlen(trim($buffer))) {
                                    if (strstr($buffer, ': ')) {
                                        list( $key, $value ) = explode(':',
                                            trim($buffer));
                                        $packages[$pName][$key] = trim($value);
                                        break;
                                    } else {
                                        $packages[$pName]['LongDescription'] .= $buffer;
                                        $packages[$pName]['LongDescription'] = trim($packages[$pName]['LongDescription']);
                                    }
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
        }

        return $packages;
    }
}
