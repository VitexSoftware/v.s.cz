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
        $OUser->addStatusMessage(_('Name is too short'), 'warning');
    }

    if (strlen($lastname) < 2) {
        $error = true;
        $OUser->addStatusMessage(_('Lastname is too short'), 'warning');
    }

    if (strlen($firstname) + strlen($lastname) > 30) {
        $error = true;
        $OUser->addStatusMessage(_('the names are too long together'), 'warning');
    }

    if (strlen($email_address) < 5) {
        $error = true;
        $OUser->addStatusMessage(_('mail address is too short'), 'warning');
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
        $OUser->addStatusMessage(_('the password is too short'), 'warning');
    } elseif ($password != $confirmation) {
        $error = true;
        $OUser->addStatusMessage(_('password check disagrees'), 'warning');
    }

    $oPage->MyDbLink->ExeQuery('SELECT id FROM users WHERE login=\''.$oPage->EaseAddSlashes($login).'\'');
    if ($oPage->MyDbLink->GetNumRows()) {
        $error = true;
        $OUser->addStatusMessage(sprintf(_('The specified username %s is already in the database. Please choose another one.'),
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

            $OUser->addStatusMessage(_('účet byl vytvořen'), 'success');
            $NewOUser->LoginSuccess();

            $email = $oPage->addItem(new EaseMail($NewOUser->getDataValue('email'),
                    'Potvrzení'));
            $email->SetMailHeaders(['From' => EMAIL_FROM]);
            $email->addItem(new \Ease\Html\DivTag("Právě jste byl/a zaregistrován/a do Apl   ikace LB s těmito přihlašovacími údaji:\n"));
            $email->addItem(new \Ease\Html\DivTag(' Login: '.$NewOUser->GetUserLogin()."\n"));
            $email->addItem(new \Ease\Html\DivTag(' Heslo: '.$_POST['password']."\n"));
            $email->Send();

            $email = $oPage->addItem(new \Ease\Mailer(SEND_ORDERS_TO,
                    'Nová registrace do v.s.cz: '.$NewOUser->getUserLogin()));
            $email->SetMailHeaders(['From' => EMAIL_FROM]);
            $email->addItem(new \Ease\Html\DivTag("Do id právě zaregistrován nový uživatel:\n"));
            $email->addItem(new \Ease\Html\DivTag('login',
                    ' Login: '.$NewOUser->getUserLogin()."\n"));
            $email->addItem($NewOUser->CustomerAddress);
            $email->Send();

            $_SESSION['User'] = clone $NewOUser;
            $oPage->Redirect('index.php');
            exit;
        } else {
            $oUser->addStatusMessage(_('Database entry failed!'), 'error');
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


$oPage->addItem(new \VSCZ\ui\PageTop(_('Sign On')));
$oPage->AddPageColumns();

$regForm = $oPage->column2->addItem(new \Ease\Html\Form('create_account',
    'createaccount.php'));
$regForm->SetTagID('LoginForm');

$account = new \Ease\Html\H3Tag(_('Account'));
$account->addItem(new EaseLabeledTextInput('login', null, _('Username').' *'));
$account->addItem(new EaseLabeledPasswordStrongInput('password', null,
        _('Password').' *'));
$account->addItem(new EaseLabeledPasswordControlInput('confirmation', null,
        _('Password confirmation').' *', ['id' => 'confirmation']));

$personal = new \Ease\Html\H3Tag(_('Osobní'));
$personal->addItem(new EaseLabeledTextInput('firstname', null, _('jméno').' *'));
$personal->addItem(new EaseLabeledTextInput('lastname', null, _('příjmení').' *'));
$personal->addItem(new EaseLabeledTextInput('email_address', null,
        _('emailová adresa').' * ('._('lowercase letters only').')'));

$regForm->addItem(new \Ease\Html\DivTag('Account', $account));
$regForm->addItem(new \Ease\Html\DivTag('Personal', $personal));
$regForm->addItem(new \Ease\Html\DivTag('Submit',
    new EaseJQuerySubmitButton('Register', _('Register'), _('finish'), [])));

$oPage->column1->addItem(new \Ease\Html\DivTag('WelcomeHint',
    _('Letsgo')));

if (isset($_POST)) {
    $regForm->FillUp($_POST);
}

$oPage->addItem(new \VSCZ\ui\PageBottom());
$oPage->draw();


