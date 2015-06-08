<?php

/**
 * Reset hesla
 * 
 * @package VS
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2012 Vitex@hippy.cz (G)
*/
require_once 'includes/LBBegin.php';
require_once 'Ease/EaseMail.php';
require_once 'Ease/EaseHtmlForm.php';
$Success = false;

$EmailTo = $oPage->GetPostValue('Email');

if ($EmailTo) {
    $oPage->TakeMyTable();
    $UserEmail = $oPage->EaseAddSlashes($EmailTo);
    $UserFound = $oPage->MyDbLink->QueryToArray('SELECT u_id,u_username FROM users WHERE email=\'' . $UserEmail . '\'');
    if (count($UserFound)) {
        $UserID = intval($UserFound[0]['u_id']);
        $UserLogin = $UserFound[0]['u_username'];
        $NewPassword = $oPage->RandomString(8);

        $PassChanger = new LBUser($UserID);
        $PassChanger->PasswordChange($NewPassword);

        $Email = $oPage->addItem(new EaseShopMail($UserEmail, _('Nové heslo pro ') . $_SERVER['SERVER_NAME']));
        $Email->addItem(_("Tvoje přihlašovací údaje byly změněny:\n"));

        $Email->addItem(' Login: ' . $UserLogin . "\n");
        $Email->addItem(' Heslo: ' . $NewPassword . "\n");

        $Email->Send();

        $OUser->addStatusMessage('Tvoje nové heslo vám bylo odesláno mailem na zadanou adresu <strong>' . $_REQUEST['Email'] . '</strong>');
        $Success = true;
    } else {
        $OUser->addStatusMessage('Promiňnte, ale email <strong>' . $_REQUEST['Email'] . '</strong> nebyl v databázi nalezen', 'warning');
    }
} else {
    $OUser->addStatusMessage('Zadejte prosím váš eMail.');
}


$oPage->addItem(new LBPageTop('Obnova zapomenutého hesla'));



if (!$Success) {
    $oPage->addItem('<h1>Zapoměl jsem své heslo!</h1>');

    $oPage->addItem('Zapoměl jste heslo? Vložte svou e-mailovou adresu, kterou jste zadal při registraci a my Vám pošleme nové.');

    $EmailForm = $oPage->addItem(new EaseHtmlForm('PassworRecovery'));
    $EmailForm->addItem('Email: ');
    $EmailForm->addItem(new EaseHtmlInputTextTag('Email', null, array('size' => '40')));
    $EmailForm->addItem(new EaseHtmlInputSubmitTag('ok', _('Zaslat nové heslo')));

    if (isset($_POST)) {
        $EmailForm->FillUp($_POST);
    }
} else {
    $oPage->addItem(new EaseHtmlATag('Login.php', _('Pokračovat')));
}

$oPage->addItem(new LBPageBottom());

$oPage->draw();
?>
