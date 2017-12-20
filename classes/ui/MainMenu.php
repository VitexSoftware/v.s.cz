<?php

namespace VSCZ\ui;

/**
 * Hlavní menu
 *
 * @package    VitexSoftware
 * @author     Vitex <vitex@hippy.cz>
 */
class MainMenu extends \Ease\TWB\Navbar
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
        parent::__construct($name, $brand, $properties);

        $this->addMenuItem(new \Ease\Html\ATag('repostats.php',
            '<img style="height: 19px;" src="img/deb-package.png"> '._('Debian Repository')));

        $this->addDropDownMenu(
            _('Projects'),
            [
//            'http://h.v.s.cz/' => _('Hosting'),
            'monitoring.php' => _('Monitoring'),
            'ease.php' => _('PHP Ease Framework'),
            'https://github.com/Spoje-NET/FlexiPeeHP' => _('FlexiPeeHP PHP Library'),
            'https://github.com/Spoje-NET/Flexplorer' => _('Flexplorer REST API Developer tool'),
            'http://flexiproxy.vitexsoftware.cz/c/demo' => _('FlexyProXY'),
            'http://shop4flexibee.vitexsoftware.cz' => _('Shop4FlexiBee'),
//            'moloch.php' => _('Moloch the invoice system'),
//            'http://privator.eu/' => _('Privator.eu'),
            'tbpackage.php' => _('Twitter Bootstrap pro Debian'),
            'imap2mx.php' => _('Imap2MX webmail plugins')//,
            ]
        );

        $this->addMenuItem(new \Ease\Html\ATag('flexibee.php',
            '<img style="height: 19px;" src="img/abra-flexibee-square.png"> '._('FlexiBee')));

        $this->addMenuItem(new \Ease\Html\ATag('articles.php',
            '<img style="height: 19px;" src="img/news.svg"> '._('Articles')));



        $this->addMenuItem(new \Ease\Html\ATag('umim.php', _('My Skills')));
        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Pricelist')));
        $this->addMenuItem(new \Ease\Html\ATag('kontakt.php', _('Contact')),
            'left');

        if (\Ease\Shared::user()->getUserLogin()) {
            $this->addMenuItem(new \Ease\Html\ATag('newsedit.php',
                _('News Editor')), 'left');
        }
    }
}
