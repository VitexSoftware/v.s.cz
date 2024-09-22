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
class News extends \Ease\SQL\Engine
{
    public $myKeyColumn = 'id';
    public $myTable = 'news';

    /**
     * Sloupeček obsahující datum vložení záznamu do shopu.
     */
    public string $myCreateColumn = 'DatCreate';

    /**
     * Slopecek obsahujici datum poslení modifikace záznamu do shopu.
     */
    public string $myLastModifiedColumn = 'DatSave';

    /**
     * News listing query.
     *
     * @return \Envms\FluentPDO
     */
    public function listingQuery()
    {
        return parent::listingQuery()->select('user.login')->leftJoin('user ON user.id = author');
    }
}
