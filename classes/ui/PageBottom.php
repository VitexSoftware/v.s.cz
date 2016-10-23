<?php

namespace VSCZ\ui;

/**
 * Spodek stránky
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class PageBottom extends \Ease\TWB\Container
{

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->SetTagID('footer');
        $this->addItem('<hr>');

        $rowFluid1 = new \Ease\TWB\Row;
        $colA      = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listA1    = $colA->addItem(new \Ease\Html\UlTag(_('Zdrojáky'),
            ['style' => 'list-style-type: none']));
        $listA1->addItemSmart(new \Ease\Html\ATag('/redmine', 'Redmine'));
        $listA1->addItemSmart(new \Ease\Html\ATag('https://github.com/VitexSoftware',
            'GitHub'));
        $listA1->addItemSmart(new \Ease\Html\ATag('https://hub.docker.com/u/vitexsoftware/',
            'DockerHUB'));


        $colB   = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listB1 = $colB->addItem(new \Ease\Html\UlTag(_('Aplikace'),
            ['style' => 'list-style-type: none']));
        $listB1->addItemSmart(new \Ease\Html\ATag('ease.php', 'Ease Framework'));
        $listB1->addItemSmart(new \Ease\Html\ATag('monitoring.php',
            'Icinga Editor'));
        $listB1->addItemSmart(new \Ease\Html\ATag('moloch.php', 'Moloch'));

        $colC   = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listC1 = $colC->addItem(new \Ease\Html\UlTag(_('Služby'),
            ['style' => 'list-style-type: none']));
        $listC1->addItemSmart(new \Ease\Html\ATag('monitoring.php', 'Monitoring'));
        $listC1->addItemSmart(new \Ease\Html\ATag('repos.php', _('Repozitář')));
        $listC1->addItemSmart(new \Ease\Html\ATag('http://h.v.s.cz/',
            _('Hosting')));

        $colD   = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listD1 = $colD->addItem(new \Ease\Html\UlTag(_('Dokumentace'),
            ['style' => 'list-style-type: none']));
        $listD1->addItemSmart(new \Ease\Html\ATag('/EaseDoc', 'Ease Framework'));
        $listD1->addItemSmart(new \Ease\Html\ATag('/IciEditDoc', 'Icinga Editor'));

        $colE   = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listE1 = $colE->addItem(new \Ease\Html\UlTag(_('Spřízněné'),
            ['style' => 'list-style-type: none']));
        $listE1->addItemSmart(new \Ease\Html\ATag('http://murka.cz',
            _('Murka.cz')));
        $listE1->addItemSmart(new \Ease\Html\ATag('http://spoje.net',
            _('Spoje.Net')));
        $listE1->addItemSmart(new \Ease\Html\ATag('http://rclick.cz',
            _('Rclick.cz')));

        $colF   = $rowFluid1->addItem(new \Ease\TWB\Col(2));
        $listF1 = $colF->addItem(new \Ease\Html\UlTag(_('Více'),
            ['style' => 'list-style-type: none']));
        $listF1->addItemSmart(new \Ease\Html\ATag('reference.php',
            _('Reference')));
        $listF1->addItemSmart(new \Ease\Html\ATag('cenik.php', _('Cenník prací')));
        $listF1->addItemSmart(new \Ease\Html\ATag('kontakt.php', _('Kontakty')));


        $this->addItem($rowFluid1);

        $rowFluid2 = new \Ease\TWB\Row;

        $socialIcons = '
        <a class = "btn btn-primary social-login-btn social-facebook" href = "https://www.facebook.com/vitexsoftware"><i class = "fa fa-facebook"></i></a>
        <a class = "btn btn-primary social-login-btn social-twitter" href = "https://twitter.com/Vitexus"><i class = "fa fa-twitter"></i></a>
        <a class = "btn btn-primary social-login-btn social-linkedin" href = "https://www.linkedin.com/in/vitexsoftware"><i class = "fa fa-linkedin"></i></a>
        <a class = "btn btn-primary social-login-btn social-google" href = "https://plus.google.com/100397009727603037623"><i class = "fa fa-google-plus"></i></a>
        <a class = "btn btn-primary social-login-btn social-github" href = "https://github.com/Vitexus/"><i class = "fa fa-github"></i></a>
        ';

        $rowFluid2->addItem(new \Ease\TWB\Col(12,
            [new \Ease\TWB\Col(8, $socialIcons), new \Ease\TWB\Col(4,
                _('&copy; 2012-2015 Vitex Software'))]));

        $this->addItem($rowFluid2);
    }

    /**
     * Zobrazí přehled právě přihlášených a spodek stránky
     */
    function finalize()
    {
        if (isset($this->webPage->heroUnit) && !count($this->webPage->heroUnit->pageParts)) {
            unset($this->webPage->container->pageParts['\Ease\Html\DivTag@heroUnit']);
        }

        $this->includeCss('css/font-awesome.min.css');
    }
}
