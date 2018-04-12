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

    public function __construct($github,$packagist, $properties = array())
    {
        parent::__construct($this->baseUrl.$github,
            new ShieldsBadge('packagist/dt/'.$packagist,
            _('Packagist Downloads')), $properties);
    }
}
