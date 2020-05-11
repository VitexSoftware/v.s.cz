<?php

namespace VSCZ\ui;

/**
 * Hlavní menu
 *
 * @package    VitexSoftware
 * @author     Vitex <vitex@hippy.cz>
 */
class MainMenu extends \Ease\TWB4\Navbar {

    /**
     * Menu aplikace
     *
     * @param string $name
     * @param string $brand
     * @param array  $properties
     */
    function __construct($name = null, $brand = null, $properties = null) {
        parent::__construct($brand, $properties);
        $this->addTagClass('navbar-expand-lg bg-secondary text-uppercase fixed-top');

        $this->addMenuItem(new \Ease\Html\ATag('debs.html',
                        '<img style="height: 19px;" src="img/deb-package.png"> ' . _('Debian Repository')));
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

        $this->addMenuItem(new \Ease\Html\ATag('flexibee.php',
                        '<img style="height: 19px;" src="img/abra-flexibee-square.png"> ' . _('FlexiBee')));

        $this->addMenuItem(new \Ease\Html\ATag('articles.php',
                        '<img style="height: 19px;" src="img/news.svg"> ' . _('Articles')));

        $this->addMenuItem(new \Ease\Html\ATag('attic.php', '<img style="height: 19px;" src="img/Treasure_chest.svg"> ' . _('Old projects')));

        $this->addMenuItem(new \Ease\Html\ATag('umim.php', _('My Skills')));
        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
//        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Pricelist')));
        $this->addMenuItem(new \Ease\Html\ATag('kontakt.php', _('Contact')),
                'left');

        if (\VSCZ\User::singleton()->getUserLogin()) {
            $this->addMenuItem(new \Ease\Html\ATag('newsedit.php',
                            _('News Editor')), 'left');
        }

        $this->addMenuItem(new \Ease\TWB4\Widgets\LangSelect(), 'right');
    }

    /**
     * Přidá do stránky javascript pro skrývání oblasti stavových zpráv.
     */
    public function finalize() {

        if (!empty(\Ease\Shared::singleton()->getStatusMessages())) {

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
            \Ease\Shared::singleton()->cleanMessages();
            WebPage::singleton()->addCss('.dropdown-menu { overflow-y: auto } ');
            WebPage::singleton()->addJavaScript("$('.dropdown-menu').css('max-height',$(window).height()-100);",
                    null, true);
            $this->includeJavaScript('js/slideupmessages.js');
        }
        
        parent::finalize();
    }

}
