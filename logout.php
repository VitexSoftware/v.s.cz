<?php

/**
 * Odhlašovací stránka
 * 
 * @package   VitexSoftware
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

unset($_SESSION['access_token']); //Twitter OAuth 

if ($OUser->GetUserID()) {
    $OUser->Logout();
    $MessagesBackup = $OUser->GetStatusMessages(true);
    $OUser = new EaseAnonym();
    $OUser->AddStatusMessages($MessagesBackup);
}

$oPage->addItem(new \VSCZ\ui\PageTop(_('Odhlášení')));

$oPage->heroUnit->addItem(new \Ease\Html\Div( _('Děkujeme za vaši přízeň a těšíme se na další návštěvu')));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
?>
