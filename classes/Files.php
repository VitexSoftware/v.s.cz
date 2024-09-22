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

namespace VSCZ;

/**
 * Description of Files.
 *
 * @author vitex
 */
class Files extends \Ease\SQL\Engine
{
    public $myTable = 'files';

    public function packageFiles($package)
    {
        return $this->listingQuery()->leftJoin('packages ON packages.id = files.packages_id')->where('packages.Name', $package);
    }

    public function getPackageFiles($package)
    {
        $contents = $this->packageFiles($package);

        return $contents->count() ? $contents->fetchAll() : [];
    }
}
