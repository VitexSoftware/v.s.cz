<?php
/**
 * Založení nového accountu
 *
 * @package VitexSoftware
 * @author  Vitex <vitex@hippy.cz>
 */
require_once 'includes/VSInit.php';
require_once 'Ease/EaseMail.php';
require_once 'Ease/EaseJQueryWidgets.php';

if (!is_object($oPage->MyDbLink)) {
    $oPage->TakeMyTable();
}


$process = false;
if (isset($_POST) && count($_POST)) {
    $process = true;

    $firstname     = addslashes($_POST['firstname']);
    $lastname      = addslashes($_POST['lastname']);
    $email_address = addslashes(strtolower($_POST['email_address']));

    if (isset($_POST['parent'])) {
        $CustomerParent = addslashes($_POST['parent']);
    } else {
        $CustomerParent = $OUser->GetUserID();
    }
    $login        = addslashes($_POST['login']);
    if (isset($_POST['password'])) $password     = addslashes($_POST['password']);
    if (isset($_POST['confirmation']))
            $confirmation = addslashes($_POST['confirmation']);

    $error = false;

    if (strlen($firstname) < 2) {
        $error = true;
        $OUser->addStatusMessage(_('jméno je příliš krátké'), 'warning');
    }

    if (strlen($lastname) < 2) {
        $error = true;
        $OUser->addStatusMessage(_('příjmení je příliš krátké'), 'warning');
    }

    if (strlen($firstname) + strlen($lastname) > 30) {
        $error = true;
        $OUser->addStatusMessage(_('jména jsou dohromady příliš dlouhá'),
            'warning');
    }

    if (strlen($email_address) < 5) {
        $error = true;
        $OUser->addStatusMessage(_('mailová adresa je příliš krátká'), 'warning');
    } else {
        if (!$OUser->isEmail($email_address, true)) {
            $error = true;
            $OUser->addStatusMessage(_('email address check error'), 'warning');
        } else {
            $check_email = $oPage->MyDbLink->QueryToArray("SELECT COUNT(*) AS total FROM users WHERE email = '".$oPage->EaseAddSlashes($email_address)."'");
            if ($check_email[0]['total'] > 0) {
                $error = true;
                $OUser->addStatusMessage(_('email address allready registred'),
                    'warning');
            }
        }
    }



    if (strlen($password) < 5) {
        $error = true;
        $OUser->addStatusMessage(_('heslo je příliš krátké'), 'warning');
    } elseif ($password != $confirmation) {
        $error = true;
        $OUser->addStatusMessage(_('kontrola hesla nesouhlasí'), 'warning');
    }

    $oPage->MyDbLink->ExeQuery('SELECT id FROM users WHERE login=\''.$oPage->EaseAddSlashes($login).'\'');
    if ($oPage->MyDbLink->GetNumRows()) {
        $error = true;
        $OUser->addStatusMessage(sprintf(_('Zadané uživatelské jméno %s je již v databázi použito. Zvolte prosím jiné.'),
                $login), 'warning');
    }

    if ($error == false) {

        $NewOUser     = new VSUser();
        //TODO zde by se měly doplnit defaultní hodnoty z konfiguráku Registry.php
        $CustomerData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email_address,
            'password' => $NewOUser->EncryptPassword($password),
            'parent' => (int) $CustomerParent,
            'login' => $login];

        $CustomerID = $NewOUser->InsertToMySQL($CustomerData);

        if ($CustomerID) {
            $NewOUser->SetMyKey($CustomerID);

            $OUser->addStatusMessage(_('Zákaznický účet byl vytvořen'),
                'success');
            $NewOUser->LoginSuccess();

            $Email = $oPage->addItem(new EaseMail($NewOUser->getDataValue('email'),
                'Potvrzení registrace'));
            $Email->SetMailHeaders(['From' => EMAIL_FROM]);
            $Email->addItem(new \Ease\Html\Div("Právě jste byl/a zaregistrován/a do Apl   ikace LB s těmito přihlašovacími údaji:\n"));
            $Email->addItem(new \Ease\Html\Div(' Login: '.$NewOUser->GetUserLogin()."\n"));
            $Email->addItem(new \Ease\Html\Div(' Heslo: '.$_POST['password']."\n"));
            $Email->Send();

            $Email = $oPage->addItem(new EaseShopMail(SEND_ORDERS_TO,
                'Nová registrace do LBu: '.$NewOUser->getUserLogin()));
            $Email->SetMailHeaders(['From' => EMAIL_FROM]);
            $Email->addItem(new \Ease\Html\Div("Do id právě zaregistrován nový uživatel:\n"));
            $Email->addItem(new \Ease\Html\DivTag('login',
                ' Login: '.$NewOUser->getUserLogin()."\n"));
            $Email->addItem($NewOUser->CustomerAddress);
            $Email->Send();

            $_SESSION['User'] = clone $NewOUser;
            $oPage->Redirect('index.php');
            exit;
        } else {
            $OUser->addStatusMessage(_('Zápis do databáze se nezdařil!'),
                'error');
            $Email = $oPage->addItem(new EaseMail(constant('SEND_ORDERS_TO'),
                'Registrace uzivatel se nezdařila'));
            $Email->addItem(new \Ease\Html\DivTag('Fegistrace',
                $oPage->printPre($CustomerData)));
            $Email->Send();
        }
    }
}


$oPage->AddCss('
#RegFace {
    display: inline-block;
    overflow: auto
}

#WelcomeHint {
    width: 400px;
    float:left;
}

#Spacer {
    width: 60px;
    float:left;
}

#LoginForm {
    float:left;
}

#Account {
    float:left;
    bacgroud-color: white;
}

#Personal {
    float:left;
    bacgroud-color: white;
}

#Personal {
    float:left;
    bacgroud-color: white;
}

#Submit {
    padding: 20px;
}

input.ui-button { width: 100%; }
');


$oPage->addItem(new \VSCZ\ui\PageTop(_('Registrace')));
$oPage->AddPageColumns();

$RegForm = $oPage->column2->addItem(new \Ease\Html\Form('create_account',
    'createaccount.php'));
$RegForm->SetTagID('LoginForm');

$Account = new \Ease\Html\H3Tag(_('Účet'));
$Account->addItem(new EaseLabeledTextInput('login', null,
    _('přihlašovací jméno').' *'));
$Account->addItem(new EaseLabeledPasswordStrongInput('password', null,
    _('heslo').' *'));
$Account->addItem(new EaseLabeledPasswordControlInput('confirmation', null,
    _('potvrzení hesla').' *', ['id' => 'confirmation']));

$Personal = new \Ease\Html\H3Tag(_('Osobní'));
$Personal->addItem(new EaseLabeledTextInput('firstname', null, _('jméno').' *'));
$Personal->addItem(new EaseLabeledTextInput('lastname', null,
    _('příjmení').' *'));
$Personal->addItem(new EaseLabeledTextInput('email_address', null,
    _('emailová adresa').' *'.' (pouze malými písmeny)'));

$RegForm->addItem(new \Ease\Html\DivTag('Account', $Account));
$RegForm->addItem(new \Ease\Html\DivTag('Personal', $Personal));
$RegForm->addItem(new \Ease\Html\DivTag('Submit',
    new EaseJQuerySubmitButton('Register', _('Registrovat'),
    _('dokončit registraci'), [])));

$oPage->column1->addItem(new \Ease\Html\DivTag('WelcomeHint',
    _('Registrací získáš možnost spravovat své lokality a psát o nich.')));

if (isset($_POST)) {
    $RegForm->FillUp($_POST);
}

$oPage->addItem(new \VSCZ\ui\PageBottom());
$oPage->draw();
?>

