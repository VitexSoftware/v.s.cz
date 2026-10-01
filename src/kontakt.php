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

/**
 * VitexSoftware - kontakty.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop('Vitex Software - '._('contacts')));
$oPage->container->addItem(new ui\PageHero(
    _('Contact'),
    _('Write or call – we will gladly show you what can be automated in your company.'),
    'Vitex Software',
));

$t = static fn (string $text): string => _($text);

// https://outlook.office365.com/owa/calendar/SoftwaredevelopmentServeradministration@spojenet.cz/bookings/
$oPage->container->addItem(<<<HTML
<div class="contact-grid">
  <div class="glass-card contact-card">
    <div class="contact-person">
      <img src="img/vitex-avatar-240.webp" alt="Vítězslav Dvořák" width="104" height="104">
      <div><b>Vítězslav Dvořák</b><span class="dim">{$t('Programming, integrations and server administration')}</span></div>
    </div>
    <div class="contact-actions">
      <a class="btn btn-glow" href="mailto:info@vitexsoftware.cz"><i class="fa-regular fa-envelope"></i> info@vitexsoftware.cz</a>
      <a class="btn btn-line" href="tel:+420739778202"><i class="fa-solid fa-phone"></i> +420 739 778 202</a>
    </div>
  </div>
  <div class="glass-card contact-card">
    <h2>{$t('Billing details')}</h2>
    <dl>
      <dt>{$t('Company')}</dt><dd>Vítězslav Dvořák – Vitex Software</dd>
      <dt>IČO</dt><dd>69438676</dd>
      <dt>DIČ</dt><dd>CZ7808072811</dd>
      <dt>{$t('Bank account')}</dt><dd>2800677051 / 2010</dd>
      <dt>IBAN</dt><dd>CZ95 2010 0000 0028 0067 7051</dd>
    </dl>
  </div>
  <div class="glass-card contact-card">
    <h2>{$t('Elsewhere on the web')}</h2>
    <ul class="contact-links">
      <li><a href="https://multiflexi.eu/"><i class="fa-solid fa-rotate"></i> multiflexi.eu</a></li>
      <li><a href="https://github.com/VitexSoftware"><i class="fa-brands fa-github"></i> GitHub</a></li>
      <li><a href="https://www.linkedin.com/in/vitexsoftware"><i class="fa-brands fa-linkedin-in"></i> LinkedIn</a></li>
      <li><a rel="me" href="https://f.cz/@vitexsoftware"><i class="fa-brands fa-mastodon"></i> Mastodon</a></li>
    </ul>
  </div>
</div>
HTML);

// $oPage->column1->addItem(new \Ease\Html\H4Tag(_('Bitcoins accepted')));
// $oPage->column1->addItem('<a href="bitcoin:1CiBn9CT99amr8VoasYqKznwyfo36HKZLB?label=VitexSoftware"><pre>1Au9b6pkd5eqAP3pprjJRkFduyS9uhFE8m</pre></a>');
// $oPage->column1->addItem(new \Ease\Html\ImgTag('img/donatebitcoins.png'));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
