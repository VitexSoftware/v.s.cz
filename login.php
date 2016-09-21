<?php
/**
 * Přihlašovací stránka
 *
 * @package   VS
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';
require_once 'Ease/EaseJQueryWidgets.php';
require_once 'classes/VSTwitter.php';
require_once 'classes/VSFacebook.php';

if (!is_object($OUser)) {
    die(_('Cookies jsou vyžadovány'));
}

$Login = $oPage->getRequestValue('login');

if ($Login) {
    $_SESSION['User'] = new VSUser();
    if ($OUser->tryToLogin($_POST)) {
        $NextUrl = $oPage->getRequestValue('NextUrl');
        if (($NextUrl != 'logout.php') && !is_null($NextUrl)) {
            $oPage->redirect($NextUrl);
        } else {
            $oPage->redirect('index.php');
        }
        exit;
    }
}


$oPage->addItem(new \VSCZ\ui\PageTop(_('Přihlaš se')));

$loginFace = new \Ease\Html\DivTag('LoginFace');


$loginFace->addItem(new \Ease\Html\DivTag('WelcomeHint',
    _('<p>Zadejte, prosím, Vaše přihlašovací údaje:</p>')));
$loginFace->addItem(new \Ease\Html\DivTag('Spacer', '&nbsp;'));

$loginForm = $loginFace->addItem(new \Ease\Html\Form('Login'));
$loginForm->SetTagID('LoginForm');
$loginForm->addItem(new EaseLabeledInput('login', null, _('Login')));
$loginForm->addItem(new EaseLabeledPasswordInput('password', null, _('Heslo')));
$loginForm->addItem(new EaseJQuerySubmitButton('LogIn', _('Přihlášení')));




$oPage->column2->addItem(new \Ease\Html\Div($loginFace, ['class' => 'col1']));
$oPage->column1->addItem(new \Ease\Html\Div(_('Po přihlášení budete moci sledovat vybrané lokality a přispívat zprávami z nich'),
    ['class' => 'col2']));
$oPage->column3->addItem(new \Ease\Html\Div(VSTwitter::authButton('auth.php'),
    ['class' => 'col3']));

/**
  $Collumn3->addItem( VSOpenIDUser::loginForm('login2-openid.php') );
  $Collumn3->addItem( VSFacebook::getLoginButton() );

  $Collumn3->addItem( '<a href="https://www.facebook.com/dialog/oauth?client_id='. FB_APP_ID.'&redirect_uri='.urlencode(dirname(EasePage::phpSelf()).'/fbauth.php').'&scope=offline_access,user_checkins,friends_checkins">Connect with Facebook</a>' );
 */
$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
?>