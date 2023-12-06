<?php

/**
 * VitexSoftware Homepage - News Handler
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2015-2020 Vitex Software
 */

namespace VSCZ;

/**
 * Description of News
 *
 * @author vitex
 */
class News extends \Ease\SQL\Engine
{
    public $myKeyColumn = 'id';
    public $myTable     = 'news';

    /**
     * Sloupeček obsahující datum vložení záznamu do shopu
     * @var string
     */
    public $myCreateColumn = 'DatCreate';

    /**
     * Slopecek obsahujici datum poslení modifikace záznamu do shopu
     * @var string
     */
    public $myLastModifiedColumn = 'DatSave';



    /**
     * News listing query
     * @return \Envms\FluentPDO
     */
    public function listingQuery()
    {
        return parent::listingQuery()->select('user.login')->leftJoin('user ON user.id = author');
    }
}
