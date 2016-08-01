<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Like Button Facebooku
 */
class FBLikeButton extends \Ease\Html\IframeTag
{

    /**
     * Like Button facebooku
     *
     * @param string $src Url pro lajk facebooku
     */
    function __construct($src)
    {
        $Properties['scrcolling']  = 'no';
        $Properties['frameborder'] = 'no';
        parent::__construct('http://www.facebook.com/plugins/like.php?href='.$src,
            $Properties);
    }

}
