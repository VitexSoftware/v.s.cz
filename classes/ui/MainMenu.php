<?php

namespace VSCZ\ui;

/**
 * Hlavní menu
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class MainMenu extends \Ease\TWB\Navbar
{

    /**
     * Menu aplikace
     *
     *
     * @param type $name
     * @param type $Brand
     * @param type $Properties
     */
    function __construct($name = null, $Brand = null, $Properties = null)
    {
        parent::__construct($name, $Brand, $Properties);

        $this->addMenuItem(new \Ease\Html\ATag('repos.php',
            '<img style="height: 19px;" src="img/deb-package.png"> '._('Repo')));

        $this->addDropDownMenu(
            _('Projekty'),
            array(
            'http://h.v.s.cz/' => _('Hosting'),
            'monitoring.php' => _('Monitoring'),
            'ease.php' => _('PHP Ease Framework'),
            'moloch.php' => _('Fakturační systém Moloch'),
//            'http://privator.eu/' => _('Privator.eu'),
            'tbpackage.php' => _('Twitter Bootstrap pro Debian'),
            'imap2mx.php' => _('Imap2MX webmail plugins')//,
//                'easeshop.php' => _('elektronický obchod Ease Shop'),
//                'moloch.php' =>  _('Fakturační systém Moloch')
            )
        );


//$nav->addMenuItem(new \Ease\Html\ATag('monitoring.php', _('Monitoring')));
        $this->addMenuItem(new \Ease\Html\ATag('reference.php', _('Reference')));
        $this->addMenuItem(new \Ease\Html\ATag('cenik.php', _('Ceník')));
        $this->addMenuItem(new \Ease\Html\ATag('kontakt.php', _('Kontakt')));
    }

}
