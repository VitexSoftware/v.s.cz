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
 * Description of News.
 *
 * @author vitex
 */
class Packages extends \Ease\SQL\Engine
{
    public $myKeyColumn = 'id';
    public string $myTable = 'packages';

    /**
     * Where to look for record's name.
     */
    public string $nameColumn = 'Name';

    /**
     * Sloupeček obsahující datum vložení záznamu do shopu.
     */
    public string $myCreateColumn = 'created';

    /**
     * Slopecek obsahujici datum poslení modifikace záznamu do shopu.
     */
    public string $myLastModifiedColumn = 'updated';
}
