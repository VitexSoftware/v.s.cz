<?php

namespace VSCZ\ui;

/**
 * Hlavní menu
 *
 * @package    VitexSoftware
 * @author     Vitex <vitex@hippy.cz>
 */
class MainMenu extends \Ease\TWB4\Navbar
{
    /**
     * Menu aplikace
     *
     * @param string $name
     * @param string $brand
     * @param array  $properties
     */
    function __construct($name = null, $brand = null, $properties = null)
    {
        parent::__construct($brand, $properties);
        $this->addTagClass('navbar-inverse bg-inverse navbar-toggleable-sm  navbar-expand-lg bg-secondary text-uppercase fixed-top');

        $this->addMenuItem(new \Ease\Html\ATag(
            'debs.php',
            '<img style="height: 19px;" src="img/deb-package.png"> ' . _('Debian Packages')
        ));
        //
//        $this->addDropDownMenu(
//            _('Projects'),
//            [
////            'http://h.v.s.cz/' => _('Hosting'),
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




        $this->addDropDownMenu(
            '<img style="height: 19px;" src="img/abra-flexibee-square.png"> ' . _('AbraFlexi'),
            [
                    'flexibee.php' => '<img style="height: 20px;" src="https://repo.vitexsoftware.cz/imgdeb/flexibee-server.png"> ' . _('Overview'),
                    '/multi-abraflexi-setup/login.php?login=demo&password=demo' => '<img style="height: 20px;" src="https://repo.vitexsoftware.cz/imgdeb/multi-abraflexi-setup.svg"> ' . _('Multi Setup'),
                    '/abraflexi-digest/' => '<img style="height: 20px" src="https://repo.vitexsoftware.cz/imgdeb/abraflexi-digest.svg"> ' . _('Digest'),
                    '/flexplorer/' => '<img style="height: 20px" src="https://repo.vitexsoftware.cz/imgdeb/flexplorer.png"> ' . _('FlexPlorer'),
                ]
        );

        $this->addDropDownMenu(
            '<img style="height: 19px;" src="img/docs.svg"> ' . _('Docs'),
            [
                    '/php-spojenet-abraflexi-doc/namespaces/abraflexi.html' => '<img style="height: 20px" src="https://repo.vitexsoftware.cz/imgdeb/php-abraflexi.svg"> ' . _('PHP AbraFlexi'),
                    '/php-vitexsoftware-ease-core-doc/namespaces/ease.html' => '<img style="height: 20px;" src="https://repo.vitexsoftware.cz/imgdeb/php-ease-core.png"> ' . _('EaseCore'),
                    '/php-vitexsoftware-abraflexi-bricks-doc/namespaces/abraflexi-bricks.html' => '<img style="height: 20px;" src="https://www.vitexsoftware.cz/img/php-flexibee-bricks.svg"> PHP Based AbraFlexi RestAPI/Json library Addons',
            //                    '/php-vitexsoftware-ease-bootstrap-widgets-doc' => 'Ease Framework Widgets',
                    '/php-vitexsoftware-ease-bootstrap4-doc/namespaces/ease-twb4.html' => '<img style="height: 20px;"  src="/img/ease-twbootstrap4.svg"> EasePHP Framework Twitter Bootstrap4',
                    '/php-vitexsoftware-ease-bootstrap5-doc/namespaces/ease-twb5.html' => '<img style="height: 20px;"  src="/img/ease-twbootstrap5.svg"> EasePHP Framework Twitter Bootstrap5',
            //                    '/php-vitexsoftware-ease-bricks-doc' => 'Ease Framework Bricks',
                    '/php-vitexsoftware-ease-fluentpdo-doc/namespaces/ease-sql.html' => '<img src="/img/php-ease-fluentpdo.svg" style="height: 20px;"> Ease FluentPDO',
                    '/php-vitexsoftware-ease-html-doc/namespaces/ease.html' => '<img src="/img/ease-html.svg" style="width: 20px;"> EasePHP Framework HTML',
                    '/php-vitexsoftware-rbczpremiumapi/html/' => '<img src="/img/php-rbczpremiumapi.svg" style="width: 20px;"> ' . _('Raiffeisenbank Premium API client library'),
                ]
        );

        $this->addMenuItem(new \Ease\Html\ATag(
            'articles.php',
            '<img style="height: 19px;" src="img/news.svg"> ' . _('Articles')
        ));

        $this->addMenuItem(new \Ease\Html\ATag('attic.php', '<img style="height: 19px;" src="img/Treasure_chest.svg"> ' . _('Old projects')));

        $this->addMenuItem(new \Ease\Html\ATag('umim.php', _('My Skills')));
        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
//        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Pricelist')));
        $this->addMenuItem(new \Ease\Html\ATag('kontakt.php', _('Contact')), 'left');

        if (\VSCZ\User::singleton()->getUserLogin()) {
            $this->addMenuItem(new \Ease\Html\ATag('newsedit.php', _('News Editor')), 'left');
        }

        $this->addMenuItem(new \Ease\TWB4\Widgets\LangLinks(), 'right');
    }

    /**
     * Přidá do stránky javascript pro skrývání oblasti stavových zpráv.
     */
    public function finalize()
    {

        WebPage::singleton()->addCss('
.navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox=\'0 0 32 32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath stroke=\'rgba(255,255,255, 1)\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-miterlimit=\'10\' d=\'M4 8h24M4 16h24M4 24h24\'/%3E%3C/svg%3E");
}
');
        if (!empty(\Ease\Shared::logger()->getMessages())) {
            WebPage::singleton()->addCss('

#smdrag { height: 8px; 
          background-image:  url( img/slidehandle.png ); 
          background-color: #ccc; 
          background-repeat: no-repeat; 
          background-position: top center; 
          cursor: ns-resize;
}
#smdrag:hover { background-color: #f5ad66; }

');

            $this->addItem(WebPage::singleton()->getStatusMessagesBlock(['id' => 'status-messages', 'title' => _('Click to hide messages')]));
            $this->addItem(new \Ease\Html\DivTag(null, ['id' => 'smdrag', 'style' => 'margin-bottom: 5px']));
            //\Ease\Shared::singleton()->cleanMessages();
            WebPage::singleton()->addCss('.dropdown-menu { overflow-y: auto } ');
            WebPage::singleton()->addJavaScript(
                "$('.dropdown-menu').css('max-height',$(window).height()-100);",
                null,
                true
            );
            $this->includeJavaScript('js/slideupmessages.js');
        }

        parent::finalize();
    }
}
