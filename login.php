<?php
/**
 * VitexSoftware - Login page
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2017 info@vitexsoftware.cz (G)
 */

namespace VSCZ;

require_once 'includes/VSInit.php';

if (!is_object($oUser)) {
    die(_('Cookies required'));
}

$login = $oPage->getRequestValue('login');
if ($login) {
    $oUser = \Ease\Shared::user(new User());
//    \Ease\Shared::user()->SettingsColumn = 'settings';
    if ($oUser->tryToLogin($_POST)) {
        $oPage->redirect('newsedit.php');
        exit;
    }
} else {
        $oPage->addStatusMessage(_('Please enter your login and password'));
}

$oPage->addItem(new ui\PageTop(_('Sign in')));
$oPage->addPageColumns();

$loginFace = new \Ease\Html\Div(null,['id'=>'LoginFace']);


$oPage->container->addItem($loginFace);


$loginRow = new \Ease\TWB\Row();
$infoColumn = $loginRow->addItem(new \Ease\TWB\Col(4));

$infoBlock = $infoColumn->addItem(new \Ease\TWB\Well(new \Ease\Html\ImgTag('img/password.png')));
$infoBlock->addItem(_('Welcome to VitexSoftware.cz'));


$loginColumn = $loginRow->addItem(new \Ease\TWB\Col(4));


$submit = new \Ease\TWB\SubmitButton(_('Sign in'), 'success');

$loginPanel = new \Ease\TWB\Panel(new \Ease\Html\ImgTag('img/vitexsoftwarelogo.png',
    null, ['style' => 'width: 100px;']), 'success', null, $submit);
$loginPanel->addItem(new \Ease\TWB\FormGroup(_('Username'), new \Ease\Html\InputTextTag('login', $login)));
$loginPanel->addItem(new \Ease\TWB\FormGroup(_('Login'), new \Ease\Html\InputPasswordTag('password')));


$loginColumn->addItem($loginPanel);

$passRecoveryColumn = $loginRow->addItem(new \Ease\TWB\Col(4, new \Ease\TWB\LinkButton('passwordrecovery.php', '<i class="fa fa-key"></i>
' . _('Password recovery'), 'warning')));


$passRecoveryColumn->additem(new \Ease\TWB\LinkButton('createaccount.php', '<i class="fa fa-user"></i>
' . _('Create account'), 'success'));

$oPage->container->addItem(new \Ease\TWB\Form('Login', null, 'POST', $loginRow));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
