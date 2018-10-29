<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of SlideImage
 *
 * @author vitex
 */
class SlideImage extends \Ease\Html\DivTag
{

    public function __construct($img, $label)
    {
        parent::__construct(new \Ease\Html\ImgTag($img, $label,
            ['class' => 'img-responsive', 'style'=>' display: block; margin-left: auto;margin-right: auto;']),
            ['style' => 'padding-bottom: 200px;']);
    }
}
