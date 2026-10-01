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

/**
 * Spodek stránky.
 *
 * @author     Vitex <vitex@hippy.cz>
 */
class PageBottom extends \Ease\Html\FooterTag
{
    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->setTagID('footer');
        $this->addTagClass('footer');

        $columns = [
            _('Source codes') => [
                'https://git.vitexsoftware.cz/VitexSoftware' => 'GITEA',
                'https://github.com/VitexSoftware' => 'GitHub',
                'https://hub.docker.com/u/vitexsoftware/' => 'DockerHUB',
                'https://pypi.org/user/vitex/' => 'PyPI',
                'https://atlas.hashicorp.com/vitexsoftware/' => 'Vagrant',
            ],
            _('Applications') => [
                'https://multiflexi.vitexsoftware.com/' => 'MultiFlexi',
                'mcprack.php' => 'MCPRack',
                'automatizace.php' => _('Automation'),
            ],
            _('Services') => [
                'monitoring.php' => _('Monitoring'),
                'repos.php' => _('Repository'),
                'hosting.php' => _('Hosting'),
            ],
            _('Documentation') => [
                '/php-spojenet-abraflexi-doc/namespaces/abraflexi.html' => '<img src="img/php-flexibee.svg" alt=""> '._('PHP AbraFlexi'),
                '/php-vitexsoftware-ease-doc/namespaces/ease.html' => '<img src="img/ease-core.svg" alt=""> '._('EasePHP Framework Core'),
                '/php-vitexsoftware-ease-TWB5-doc/namespaces/ease-TWB5.html' => '<img src="img/ease-twbootstrap4.svg" alt=""> '._('EasePHP Framework Twitter Bootstrap4'),
                '/php-vitexsoftware-ease-twb5-doc/namespaces/ease-twb5.html' => '<img src="img/php-ease-twbootstrap5.svg" alt=""> '._('EasePHP Framework Twitter Bootstrap5'),
                '/php-vitexsoftware-abraflexi-bricks-doc/namespaces/abraflexi-bricks.html' => '<img src="img/php-flexibee-bricks.svg" alt=""> PHP Based AbraFlexi RestAPI/Json library Addons',
                '/php-vitexsoftware-ease-fluentpdo-doc/namespaces/ease-sql.html' => '<img src="img/php-ease-fluentpdo.svg" alt=""> Ease FluentPDO',
                '/php-vitexsoftware-ease-html-doc/namespaces/ease.html' => '<img src="img/ease-html.svg" alt=""> EasePHP Framework HTML',
                '/php-vitexsoftware-rbczpremiumapi/index.html' => '<img src="img/php-rbczpremiumapi.svg" alt=""> '._('Raiffeisenbank Premium API client library'),
                'https://multiflexi.readthedocs.io/en/latest/' => '<img src="https://multiflexi.readthedocs.io/en/latest/_images/project-logo.svg" alt=""> '._('MultiFlexi'),
            ],
            _('Related') => [
                'http://murka.cz' => _('Murka.cz'),
                'http://spoje.net' => _('Spoje.Net'),
            ],
            _('More') => [
                'reference.php' => _('Reference'),
                'cenik.php' => _('Pricelist'),
                'attic.php' => _('Old projects'),
                'kontakt.php' => _('Contacts'),
            ],
        ];

        $cols = '';

        foreach ($columns as $heading => $links) {
            $cols .= '<div><h4>'.$heading.'</h4><ul>';

            foreach ($links as $url => $label) {
                $cols .= '<li><a href="'.htmlspecialchars($url).'">'.$label.'</a></li>';
            }

            $cols .= '</ul></div>';
        }

        $motto = _('Code · Nature · Freedom');
        $mascot = _('Magnetic Nymph – the Vitex Software mascot');
        $copyright = _('&copy; 2012-2026 Vitex Software');
        $poweredBy = _('Powered by debian');

        $this->addItem(<<<HTML
<svg class="topo" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="1"><path d="M0 150C200 120 320 170 520 140S860 90 1060 130 1340 170 1440 140"/><path d="M0 170C220 145 330 190 540 160S880 115 1080 150 1350 190 1440 165"/><path d="M0 125C190 95 310 145 500 118S840 65 1040 105 1330 145 1440 115"/><path d="M0 100C180 72 300 120 480 95S820 42 1020 82 1320 120 1440 92"/></g></svg>
<div class="foot-wrap">
  <div class="foot-top">
    <a class="brand" href="index.php"><img src="img/vstux.png" alt="" width="36" height="36"><span class="brand-name"><b>Vitex</b> Software</span></a>
    <span class="motto hand"><a class="mascot-badge" href="img/magnetic-nymph-vitexsoftware.png" title="{$mascot}"><img src="img/magnetic-nymph-badge.webp" alt="{$mascot}" width="40" height="40" loading="lazy"></a>{$motto} ☮</span>
    <div class="social">
      <a class="icon-btn" rel="me" href="https://f.cz/@vitexsoftware" aria-label="Mastodon"><i class="fa-brands fa-mastodon"></i></a>
      <a class="icon-btn" href="https://www.linkedin.com/in/vitexsoftware" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
      <a class="icon-btn" href="https://github.com/VitexSoftware/" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
      <a class="icon-btn" href="mailto:info@vitexsoftware.cz" aria-label="E-mail"><i class="fa-regular fa-envelope"></i></a>
    </div>
  </div>
  <div class="foot-cols">{$cols}</div>
  <div class="foot-bottom">
    <span>{$copyright} · IČO 69438676</span>
    <a href="https://www.debian.org/"><img src="img/poweredbydebian.png" alt="{$poweredBy}"></a>
  </div>
</div>
HTML);
    }

    /**
     * Zobrazí přehled právě přihlášených a spodek stránky.
     */
    public function finalize(): void
    {
        if (isset($this->webPage->heroUnit) && !\count($this->webPage->heroUnit->pageParts)) {
            unset($this->webPage->container->pageParts['\Ease\Html\DivTag@heroUnit']);
        }

        parent::finalize();
    }
}
