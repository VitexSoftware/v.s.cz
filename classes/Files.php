<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ;

/**
 * Description of Files
 *
 * @author vitex
 */
class Files extends \Ease\SQL\Engine {

    public $myTable = 'files';

    public function packageFiles($package) {
        return $this->listingQuery()->leftJoin('packages ON packages.id = files.packages_id')->where('packages.Name', $package);
    }

    public function getPackageFiles($package) {
        $contents = $this->packageFiles($package);
        return $contents->count() ? $contents->fetchAll() : [];
    }

}
