<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of PackagistBadge
 *
 * @author vitex
 */
class PackagistBadge extends \Ease\Html\ATag
{
    public $baseUrl = 'https://packagist.org/packages/';

    /**
     * 
     * @param string $github
     * @param string $packagist
     * @param string $type        dt|v
     * @param array $properties
     */
    public function __construct($github,$packagist, $type = 'dt', $properties = array())
    {
        $label = str_replace(['dt','v'], [_('Packagist Downloads'),_('Packagist Version')], $type) ;
        
        parent::__construct($this->baseUrl.$packagist,
            new ShieldsBadge('packagist/'.$type.'/'.$packagist,
            $label), $properties);
    }
}
