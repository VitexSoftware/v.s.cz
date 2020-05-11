<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of ShieldsBadge
 *
 * @author vitex
 */
class ShieldsBadge extends \Ease\Html\ImgTag
{
    public $baseUrl = 'https://img.shields.io/';
    public $style='flat';
    public $format='svg';


    public function __construct($image, $alt = null, $tagProperties = array())
    {
        parent::__construct($this->baseUrl.$image.'.'.$this->format.'?colorB=272d32&style=flat&format='.$this->format, $alt, $tagProperties);
    }
}
