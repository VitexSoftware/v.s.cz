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

require_once 'includes/VSInit.php';

$success = false;

$emailTo = $oPage->getPostValue('Email');

if (empty($emailTo)) {
    $oUser->addStatusMessage(_('Please enter your email.'));
} else {
    $userEmail = addslashes($emailTo);

    $controlUser = new \VSCZ\User();
    $controlData = $controlUser->getColumnsFromSql(
        [$controlUser->getkeyColumn()],
        ['email' => $userEmail],
    );

    if (empty($controlData)) {
        \Ease\Shared::user()->addStatusMessage(sprintf(
            _('unknow email address %s'),
            '<strong>'.$_REQUEST['Email'].'</strong>',
        ), 'warning');
    } else {
        $controlUser->loadFromSQL((int) $controlData[0][$controlUser->getkeyColumn()]);
        $userLogin = $controlUser->getUserLogin();
        $newPassword = \Ease\Functions::randomString(8);

        if ($controlUser->passwordChange($newPassword)) {
            $email = $oPage->addItem(new \Ease\HtmlMailer(
                $userEmail,
                \constant('EASE_APPNAME').' -'.sprintf(
                    _('New password for %s'),
                    $_SERVER['SERVER_NAME'],
                ),
            ));

            $email->setMailHeaders(['From' => \constant('EMAIL_FROM')]);
            $email->addItem(_('Sign On informations was changed').":\n");

            $email->addItem(_('Username').': '.$userLogin."\n");
            $email->addItem(_('Password').': '.$newPassword."\n");

            $email->send();

            $oUser->addStatusMessage(sprintf(
                _('Your new password was sent to %s'),
                '<strong>'.$emailTo.'</strong>',
            ));
            $success = true;
        }
    }
}

$oPage->addItem(new PageTop(_('Lost password recovery')));

$pageRow = new \Ease\TWB5\Row();

$columnI = $pageRow->addColumn('4');
$columnII = $pageRow->addColumn('4');
$columnIII = $pageRow->addColumn('4');

$oPage->addItem($pageRow);

if (!$success) {
    $columnIII->addItem(new \Ease\TWB5\Badge( _('Tip')));

    $columnIII->addItem(new \Ease\TWB5\Card(
        _('Forgot your password? Enter your e-mail address you entered during the registration and we will send you a new one.'),
    ));

    $titlerow = new \Ease\TWB5\Row();
    $titlerow->addColumn(4, new \Ease\Html\ImgTag('img/keys.svg', _('Password'), ['style' => 'height: 40px;']));
    $titlerow->addColumn(8, new \Ease\Html\H3Tag(_('Password Recovery')));

    $loginPanel = new \Ease\TWB5\Panel(
        new \Ease\TWB5\Container($titlerow),
        'success',
        null,
        new \Ease\TWB5\SubmitButton(_('Sent New Password'), 'success'),
    );
    $loginPanel->addItem(new \Ease\TWB5\FormGroup(
        _('Email'),
        new \Ease\Html\InputTextTag(
            'Email',
            $emailTo,
            ['type' => 'email'],
        ),
    ));
    $loginPanel->body->setTagProperties(['style' => 'margin: 20px']);

    $mailForm = $columnII->addItem(new \Ease\TWB5\Form(['name' => 'PasswordRecovery']));
    $mailForm->addItem($loginPanel);

    if ($oPage->isPosted()) {
        $mailForm->fillUp($_POST);
    }
} else {
    $columnII->addItem(new \Ease\TWB5\LinkButton(
        'login.php',
        _('Continue'),
    ));
    $oPage->redirect('login.php');
}

$oPage->addItem(new PageBottom());

$oPage->draw();
