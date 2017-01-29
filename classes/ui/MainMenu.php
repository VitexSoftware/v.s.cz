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
     *
     * @param type $name
     * @param type $brand
     * @param type $properties
     */
    function __construct($name = null, $brand = null, $properties = null)
    {
        parent::__construct($name, $brand, $properties);

        $this->addMenuItem(new \Ease\Html\ATag('repos.php',
            '<img style="height: 19px;" src="img/deb-package.png"> '._('Repo')));

        $this->addDropDownMenu(
            _('Projects'),
            [
//            'http://h.v.s.cz/' => _('Hosting'),
            'monitoring.php' => _('Monitoring'),
            'ease.php' => _('PHP Ease Framework'),
            'https://github.com/Spoje-NET/FlexiPeeHP' => _('FlexiPeeHP PHP Library'),
            'https://github.com/Spoje-NET/Flexplorer' => _('Flexplorer REST API Developer tool'),
//            'moloch.php' => _('Moloch the invoice system'),
//            'http://privator.eu/' => _('Privator.eu'),
            'tbpackage.php' => _('Twitter Bootstrap pro Debian'),
            'imap2mx.php' => _('Imap2MX webmail plugins')//,
            ]
        );


        $this->addMenuItem(new \Ease\Html\ATag('umim.php', _('Co umím')));
        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Ceník')));
        $this->addMenuItem(new \Ease\Html\ATag('kontakt.php', _('Kontakt')));
    }
}
