<?php

declare(strict_types=1);

/**
 * This file is part of the VitexSoftware package
 *
 * https://vitexsoftware.com/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VSCZ\ui;

/**
 * LoginBox.
 *
 * @author    <vitex@hippy.cz> Vítězslav Dvořák
 * @copyright 2008-2014 Vitex Software & Michal Tomášek Murka.cz
 */
class loginbox extends \Ease\Html\DivTag
{
    public function __construct($target, $logincolumn, $passcolumn)
    {
        parent::__construct(null, ['id' => 'LoginFace']);
        $loginForm = $this->addItem(new \Ease\Html\Form(
            'Login',
            $target,
            'POST',
            null,
            ['class' => 'form-vertical'],
        ));

        $loginForm->addItem(new \Ease\TWB5\FormGroup(
            _('Username'),
            new \Ease\Html\InputTextTag($logincolumn),
        ));
        $loginForm->addItem(new \Ease\TWB5\FormGroup(
            _('Password'),
            new \Ease\Html\InputPasswordTag($passcolumn),
        ));

        $loginForm->addItem(new \Ease\TWB5\SubmitButton(
            \Ease\TWB5\Part::GlyphIcon('log-in').'&nbsp;'._('Sign In'),
            'success',
        ));
    }
}
