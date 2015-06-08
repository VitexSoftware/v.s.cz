<?php

/**
 * Třídy pro práci s adresou uživatele/zákazníka
 * 
 * @author    <vitex@hippy.cz> Vítězslav Dvořák
 * @copyright 2008-2014 Vitex Software & Michal Tomášek Murka.cz
 * @package    EaseMoloch
 * @subpackage Engine
 */

require_once 'Ease/EaseTWBootstrap.php';

/**
 * Description of loginbox
 *
 * @author vitex
 */
class loginbox extends EaseHtmlDivTag {

    function __construct($target, $logincolumn, $passcolumn) {
        parent::__construct(null, null, array('id' => 'LoginFace'));
        $loginForm = $this->addItem(new EaseHtmlForm('Login', $target, 'POST', null, array('class' => 'form-vertical')));
        
        $loginForm->addItem( new EaseTWBFormGroup(_('Login'), new EaseHtmlInputTextTag($logincolumn)) );
        $loginForm->addItem( new EaseTWBFormGroup(_('Heslo'), new EaseHtmlInputPasswordTag($passcolumn)) );
        
        $loginForm->addItem(new EaseTWSubmitButton(EaseTWBPart::GlyphIcon('log-in') .'&nbsp;' . _('Přihlášení'), 'success'));
    }

}
