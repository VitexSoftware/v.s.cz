<?php

/**
 * VitexSoftware - Logout page
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2017 info@vitexsoftware.cz (G)
 */

namespace VSCZ;

require_once 'includes/VSInit.php';

if ($oUser->getUserID()) {
    $oUser->logout();
    $messagesBackup = $oUser->getStatusMessages(TRUE);
    \Ease\Shared::user(new \Ease\Anonym());
    $oUser->addStatusMessages($messagesBackup);
}

$oPage->addItem(new ui\PageTop(_('Sign off')));


$oPage->container->addItem('<br/><br/><br/><br/>');
$oPage->container->addItem(new \Ease\Html\DivTag(  new \Ease\Html\ATag('login.php', _('Good bye & next time'), ['class' => 'jumbotron'])));
$oPage->container->addItem('<br/><br/><br/><br/>');

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
