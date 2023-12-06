<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of WISWYG
 *
 * @author vitex
 */
class WISWYG extends \Ease\Html\TextareaTag
{
    function finalize()
    {
        $this->includeJavaScript('js/tinymce/tinymce.min.js');
        $this->addJavaScript('tinymce.init({ selector:\'textarea\', plugins: [\'autolink lists link image charmap code fullscreen\'] });');
    }
}
