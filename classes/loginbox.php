<?php
/**
 * Třídy pro práci s adresou uživatele/zákazníka
 *
 * @author    <vitex@hippy.cz> Vítězslav Dvořák
 * @copyright 2008-2014 Vitex Software & Michal Tomášek Murka.cz
 * @package    EaseMoloch
 * @subpackage Engine
 */
require_once 'Ease/\Ease\TWB\ootstrap.php';

/**
 * Description of loginbox
 *
 * @author vitex
 */
class loginbox extends \Ease\Html\DivTag
{

    function __construct($target, $logincolumn, $passcolumn)
    {
        parent::__construct(null, null, ['id' => 'LoginFace']);
        $loginForm = $this->addItem(new \Ease\Html\Form('Login', $target,
            'POST', null, ['class' => 'form-vertical']));

        $loginForm->addItem(new \Ease\TWB\FormGroup(_('Login'),
            new \Ease\Html\InputTextTag($logincolumn)));
        $loginForm->addItem(new \Ease\TWB\FormGroup(_('Heslo'),
            new \Ease\Html\InputPasswordTag($passcolumn)));

        $loginForm->addItem(new EaseTWSubmitButton(\Ease\TWB\Part::GlyphIcon('log-in').'&nbsp;'._('Přihlášení'),
            'success'));
    }
}
