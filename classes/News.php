<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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