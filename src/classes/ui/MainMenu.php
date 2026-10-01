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

use Ease\Html\ATag;
use Ease\Html\DivTag;
use Ease\Shared;
use Ease\TWB5\Navbar;
use VSCZ\User;

/**
 * Hlavní menu.
 *
 * @author     Vitex <vitex@hippy.cz>
 */
class MainMenu extends Navbar
{
    /**
     * Menu aplikace.
     *
     * @param string $brand
     * @param array  $properties
     */
    public function __construct(string $name, $brand, $properties = [])
    {
        $this->mainpage = 'index.php';
        parent::__construct($brand, $name, $properties);
        $this->addTagClass('site-header navbar-expand-lg fixed-top');

        $this->addMenuItem(new ATag('automatizace.php', _('Automation')));
        $this->addMenuItem(new ATag('projects.php', _('Projects')));
        $this->addMenuItem(new ATag('debs.php', _('Packages')));
        //
        //        $this->addDropDownMenu(
        //            _('Projects'),
        //            [
        // //            'http://h.v.s.cz/' => _('Hosting'),
        //                'monitoring.php' => _('Monitoring'),
        //            'ease.php' => _('PHP Ease Framework'),
        //            'https://github.com/Spoje-NET/FlexiPeeHP' => _('FlexiPeeHP PHP Library'),
        //            'https://github.com/Spoje-NET/Flexplorer' => _('Flexplorer REST API Developer tool'),
        //            'http://flexiproxy.vitexsoftware.cz/c/demo' => _('FlexyProXY'),
        //            'http://shop4flexibee.vitexsoftware.cz' => _('Shop4FlexiBee'),
        //            'tbpackage.php' => _('Twitter Bootstrap pro Debian'),
        //            'imap2mx.php' => _('Imap2MX webmail plugins')//,
        //            ]
        //        );

        /*

                $this->addDropDownMenu(
                    '<img style="height: 19px;" src="img/abra-flexibee-square.png"> ' . _('AbraFlexi'),
                    [
                            'flexibee.php' => '<img style="height: 20px;" src="https://repo.vitexsoftware.cz/imgdeb/flexibee-server.png"> ' . _('Overview'),
                            '/multi-abraflexi-setup/login.php?login=demo&password=demo' => '<img style="height: 20px;" src="https://repo.vitexsoftware.cz/imgdeb/multi-abraflexi-setup.svg"> ' . _('Multi Setup'),
                            '/abraflexi-digest/' => '<img style="height: 20px" src="https://repo.vitexsoftware.cz/imgdeb/abraflexi-digest.svg"> ' . _('Digest'),
                            '/flexplorer/' => '<img style="height: 20px" src="https://repo.vitexsoftware.cz/imgdeb/flexplorer.png"> ' . _('FlexPlorer'),
                        ]
                );
         */
        $this->addDropDownMenu(
            _('Docs'),
            [
                '/abraflexi-api-doc-cs/' => '<img style="height: 20px;" src="img/abra-flexibee-square.png"> '._('AbraFlexi REST API (CS)'),
                '/abraflexi-api-doc-en/' => '<img style="height: 20px;" src="img/abra-flexibee-square.png"> '._('AbraFlexi REST API (EN)'),
                '/php-spojenet-abraflexi-doc/namespaces/abraflexi.html' => '<img style="height: 20px" src="img/php-flexibee.svg"> '._('PHP AbraFlexi'),
                '/php-vitexsoftware-ease-core-doc/namespaces/ease.html' => '<img style="height: 20px;" src="img/ease-core.svg"> '._('EaseCore'),
                '/php-vitexsoftware-abraflexi-bricks-doc/namespaces/abraflexi-bricks.html' => '<img style="height: 20px;" src="https://www.vitexsoftware.cz/img/php-flexibee-bricks.svg"> PHP Based AbraFlexi RestAPI/Json library Addons',
                //                    '/php-vitexsoftware-ease-bootstrap-widgets-doc' => 'Ease Framework Widgets',
                '/php-vitexsoftware-ease-bootstrap4-doc/namespaces/ease-TWB5.html' => '<img style="height: 20px;"  src="img/ease-twbootstrap4.svg">EasePHP Framework Twitter Bootstrap4',
                '/php-vitexsoftware-ease-bootstrap5-doc/namespaces/ease-twb5.html' => '<img style="height: 20px;"  src="img/php-ease-twbootstrap5.svg">EasePHP Framework Twitter Bootstrap5',
                //                    '/php-vitexsoftware-ease-bricks-doc' => 'Ease Framework Bricks',
                '/php-vitexsoftware-ease-fluentpdo-doc/namespaces/ease-sql.html' => '<img src="img/php-ease-fluentpdo.svg" style="height: 20px;"> Ease FluentPDO',
                '/php-vitexsoftware-ease-html-doc/namespaces/ease.html' => '<img src="img/ease-html.svg" style="width: 20px;"> EasePHP Framework HTML',
                '/php-vitexsoftware-rbczpremiumapi/index.html' => '<img src="img/php-rbczpremiumapi.svg" style="width: 20px;"> '._('Raiffeisenbank Premium API client library'),
                'https://multiflexi.readthedocs.io/en/latest/' => '<img src="https://multiflexi.readthedocs.io/en/latest/_images/project-logo.svg" style="width: 20px;"> '._('MultiFlexi'),
            ],
        );

        $this->addMenuItem(new ATag('articles.php', _('Articles')));

        //        $this->addMenuItem(new \Ease\Html\ATag('umim.php', _('My Skills')));
        //        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
        //        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Pricelist')));
        $this->addMenuItem(new ATag('kontakt.php', _('Contact')));

        if (User::singleton()->getUserLogin()) {
            $this->addMenuItem(new ATag('newsedit.php', _('News Editor')));
        }
    }

    /**
     * Mark the item of the current page as active (the parent compares the navbar's own href).
     *
     * @param mixed $content
     * @param mixed $enabled
     * @param mixed $placement
     */
    public function addMenuItem($content, $enabled = true, $placement = 'left')
    {
        $item = parent::addMenuItem($content, $enabled, $placement);

        if ($content instanceof ATag && basename((string) parse_url((string) $content->getTagProperty('href'), \PHP_URL_PATH)) === basename($_SERVER['SCRIPT_NAME'] ?? '')) {
            $item->addTagClass('active');
            $content->setTagProperties(['aria-current' => 'page']);
        }

        return $item;
    }

    /**
     * Menu items followed by the language switch, light/dark toggle and the call to action.
     */
    public function navBarCollapse()
    {
        $collapse = parent::navBarCollapse();
        $controls = new DivTag(null, ['class' => 'header-controls']);

        $langs = new DivTag(null, ['class' => 'lang-switch', 'role' => 'group', 'aria-label' => _('Language')]);

        foreach (array_keys(\Ease\Locale::singleton()->availble()) as $code) {
            $lang = substr($code, 0, 2);
            $langs->addItem(new ATag(
                '?'.http_build_query(array_merge($_GET, ['locale' => $code])),
                strtoupper($lang),
                ['class' => $code === \Ease\Locale::$localeUsed ? 'active' : '', 'hreflang' => $lang, 'lang' => $lang],
            ));
        }

        $controls->addItem($langs);
        $controls->addItem('<button type="button" class="icon-btn theme-toggle" aria-label="'._('Switch light / dark mode').'" title="'._('Switch light / dark mode').'">'
            .'<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.2M12 19.3v2.2M4.6 4.6l1.6 1.6M17.8 17.8l1.6 1.6M2.5 12h2.2M19.3 12h2.2M4.6 19.4l1.6-1.6M17.8 6.2l1.6-1.6"/></svg></button>');
        $controls->addItem(new ATag('kontakt.php', _('Get a free quote'), ['class' => 'btn btn-glow btn-sm']));
        $collapse->addItem($controls);

        return $collapse;
    }

    /**
     * Hamburger must toggle the collapsed menu (the parent uses "dropdown", which does nothing).
     */
    public function navBarToggler()
    {
        $toggler = parent::navBarToggler();
        $toggler->setTagProperties(['data-bs-toggle' => 'collapse']);

        return $toggler;
    }

    /**
     * Přidá do stránky javascript pro skrývání oblasti stavových zpráv.
     */
    public function finalize(): void
    {
        if (!empty(Shared::logger()->getMessages())) {
            WebPage::singleton()->addCss(<<<'EOD'


#smdrag { height: 8px;
          background-image:  url( img/slidehandle.png );
          background-color: #ccc;
          background-repeat: no-repeat;
          background-position: top center;
          cursor: ns-resize;
}
#smdrag:hover { background-color: #f5ad66; }


EOD);

            $this->addItem(WebPage::singleton()->getStatusMessagesBlock(['id' => 'status-messages', 'title' => _('Click to hide messages')]));
            $this->addItem(new DivTag(null, ['id' => 'smdrag', 'style' => 'margin-bottom: 5px']));
            // \Ease\Shared::singleton()->cleanMessages();
            WebPage::singleton()->addCss('.dropdown-menu { overflow-y: auto } ');
            WebPage::singleton()->addJavaScript(
                "$('.dropdown-menu').css('max-height',$(window).height()-100);",
                null,
                true,
            );
            $this->includeJavaScript('js/slideupmessages.js');
        }

        parent::finalize();
    }
}
