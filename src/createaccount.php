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

namespace VSCZ;

require_once 'includes/VSInit.php';

// Public registration is not offered – accounts exist only for the article editors.
// (The former form relied on the removed EaseMail / TakeMyTable API.)
$oPage->addItem(new ui\PageTop(_('Create account')));
$oPage->container->addItem(new ui\PageHero(
    _('Registration is not available'),
    _('Accounts on this site are only for editors. If you need access or anything else, write to us.'),
    'Vitex Software',
    [new \Ease\Html\ATag('kontakt.php', _('Contact').' <span class="arrow">→</span>', ['class' => 'btn btn-glow'])],
));
$oPage->addItem(new ui\PageBottom());
$oPage->draw();
