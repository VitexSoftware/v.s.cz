<?php

namespace VSCZ\ui;

/**
 * LoginBox
 *
 * @author    <vitex@hippy.cz> Vítězslav Dvořák
 * @copyright 2008-2014 Vitex Software & Michal Tomášek Murka.cz
 */
class loginbox extends \Ease\Html\DivTag
{
    function __construct($target, $logincolumn, $passcolumn)
    {
        parent::__construct(null, ['id' => 'LoginFace']);
        $loginForm = $this->addItem(new \Ease\Html\Form(
            'Login',
            $target,
            'POST',
            null,
            ['class' => 'form-vertical']
        ));

        $loginForm->addItem(new \Ease\TWB4\FormGroup(
            _('Username'),
            new \Ease\Html\InputTextTag($logincolumn)
        ));
        $loginForm->addItem(new \Ease\TWB4\FormGroup(
            _('Password'),
            new \Ease\Html\InputPasswordTag($passcolumn)
        ));

        $loginForm->addItem(new \Ease\TWB4\SubmitButton(
            \Ease\TWB4\Part::GlyphIcon('log-in') . '&nbsp;' . _('Sign In'),
            'success'
        ));
    }
}
