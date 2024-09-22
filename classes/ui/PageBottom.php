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
        $this->addItem('<hr>');

        $rowFluid1 = new \Ease\TWB4\Row();
        $colA = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listA1 = $colA->addItem(new \Ease\Html\UlTag(
            _('Source codes'),
            ['style' => 'list-style-type: none'],
        ));
        $listA1->addItemSmart(new \Ease\Html\ATag('https://git.vitexsoftware.cz/VitexSoftware', 'GITEA'));
        $listA1->addItemSmart(new \Ease\Html\ATag(
            'https://github.com/VitexSoftware',
            'GitHub',
        ));
        $listA1->addItemSmart(new \Ease\Html\ATag(
            'https://hub.docker.com/u/vitexsoftware/',
            'DockerHUB',
        ));
        $listA1->addItemSmart(new \Ease\Html\ATag(
            'https://atlas.hashicorp.com/vitexsoftware/',
            'Vagrant',
        ));

        $colB = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listB1 = $colB->addItem(new \Ease\Html\UlTag(
            _('Applications'),
            ['style' => 'list-style-type: none'],
        ));
        //        $listB1->addItemSmart(new \Ease\Html\ATag('cease.php', 'Ease Framework'));
        //        $listB1->addItemSmart(new \Ease\Html\ATag('monitoring.php','Icinga Editor'));
        //        $listB1->addItemSmart(new \Ease\Html\ATag('/flexplorer', 'FlexPlorer'));
        $listB1->addItemSmart(new \Ease\Html\ATag('https://multiflexi.vitexsoftware.com/', 'MultiFlexi'));

        $colC = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listC1 = $colC->addItem(new \Ease\Html\UlTag(
            _('Services'),
            ['style' => 'list-style-type: none'],
        ));
        $listC1->addItemSmart(new \Ease\Html\ATag('monitoring.php', 'Monitoring'));
        $listC1->addItemSmart(new \Ease\Html\ATag('repos.php', _('Repository')));
        $listC1->addItemSmart(new \Ease\Html\ATag('hosting.php', _('Hosting')));

        $colD = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listD1 = $colD->addItem(new \Ease\Html\UlTag(
            _('Documentation'),
            ['style' => 'list-style-type: none'],
        ));
        $listD1->addItemSmart(new \Ease\Html\ATag('/EaseDoc', 'Ease Framework'));
        $listD1->addItemSmart(new \Ease\Html\ATag('/IciEditDoc', 'Icinga Editor'));

        $colE = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listE1 = $colE->addItem(new \Ease\Html\UlTag(
            _('Related'),
            ['style' => 'list-style-type: none'],
        ));
        $listE1->addItemSmart(new \Ease\Html\ATag(
            'http://murka.cz',
            _('Murka.cz'),
        ));
        $listE1->addItemSmart(new \Ease\Html\ATag(
            'http://spoje.net',
            _('Spoje.Net'),
        ));

        $colF = $rowFluid1->addItem(new \Ease\TWB4\Col(2));
        $listF1 = $colF->addItem(new \Ease\Html\UlTag(
            _('More'),
            ['style' => 'list-style-type: none'],
        ));
        $listF1->addItemSmart(new \Ease\Html\ATag(
            'reference.php',
            _('Reference'),
        ));
        $listF1->addItemSmart(new \Ease\Html\ATag('cenik.php', _('Pricelist')));
        $listF1->addItemSmart(new \Ease\Html\ATag('kontakt.php', _('Contacts')));

        $rowFluid2 = new \Ease\TWB4\Row();

        $socialIcons = <<<'EOD'
        <a class = "btn btn-primary social-login-btn social-mastodon" href="https://f.cz/@vitexsoftware"><i class = "fa fa-mastodon"></i></a>
        <a class = "btn btn-primary social-login-btn social-facebook" href="https://www.facebook.com/vitexsoftware"><i class = "fa fa-facebook"></i></a>
        <a class = "btn btn-primary social-login-btn social-twitter" href="https://twitter.com/Vitexus"><i class = "fa fa-twitter"></i></a>
        <a class = "btn btn-primary social-login-btn social-linkedin" href="https://www.linkedin.com/in/vitexsoftware"><i class = "fa fa-linkedin"></i></a>
        <a class = "btn btn-primary social-login-btn social-github" href="https://github.com/VitexSoftware/"><i class = "fa fa-github"></i></a>

EOD;

        $rowFluid2->addItem(new \Ease\TWB4\Col(
            12,
            [new \Ease\TWB4\Col(8, $socialIcons), new \Ease\TWB4\Col(
                4,
                _('&copy; 2012-2023 Vitex Software'),
            )],
        ));

        $mainBottomRow = new \Ease\TWB4\Row();
        $mainBottomRow->addColumn(10, [$rowFluid1, $rowFluid2]);
        $mainBottomRow->addColumn(
            2,
            new \Ease\Html\ATag(
                'https://www.debian.org/',
                new \Ease\Html\ImgTag(
                    'img/poweredbydebian.png',
                    _('Powered by debian'),
                    ['class' => 'img-responsive', 'style' => 'width: 100%'],
                ),
            ),
        );

        $this->addItem($mainBottomRow);
    }

    /**
     * Zobrazí přehled právě přihlášených a spodek stránky.
     */
    public function finalize(): void
    {
        if (isset($this->webPage->heroUnit) && !\count($this->webPage->heroUnit->pageParts)) {
            unset($this->webPage->container->pageParts['\Ease\Html\DivTag@heroUnit']);
        }

        $this->includeCss('css/font-awesome.min.css');
    }
}
