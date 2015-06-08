<?php

/**
 * VitexSoftware - titulní strana
 * 
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new VSPageTop(_('Vitex Software')));

$oPage->addJavaScript('$(\'.carousel\').carousel();',null,true);
$oPage->includeJavaScript('js/bootstrap-carousel.js');

$oPage->addItem('
    
<div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="img/reference/slide-triband.png" alt="Triband">
                    <div class="carousel-caption">
                      <h4>Triband</h4>
                      <p>Elektronický obchod propojený s ekonomickým systémem PohodaSQL</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="img/reference/slide-legalizace.png" alt="">
                    <div class="carousel-caption">
                      <h4>Magazín legalizace</h4>
                      <p>Interaktivní objednávkový formulář</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="img/reference/slide-moloch.png" alt="FSMoloch">
                    <div class="carousel-caption">
                      <h4>Fakturační systém Moloch</h4>
                      <p>Objednávky, fakturace a peněžní denník</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="img/reference/slide-yinyang.png" alt="FSMoloch">
                    <div class="carousel-caption">
                      <h4><a href="http://www.yinyang.cz/">Obchod Yinyang.cz</a></h4>
                      <p>Doprogramování rozšířených atributů produktů. Update na PHP5.4</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="img/reference/mashhana.png" alt="Mash Hana">
                    <div class="carousel-caption">
                      <h4><a href="http://www.mashhana.cz/">Japonská restaurace MASH HANA</a></h4>
                      <p>Update OSCommerce na PHP5.4</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="img/reference/james-slide.png" alt="Gui & Commandline help">
                    <div class="carousel-caption">
                      <h4><a href="http://inmyhotel.net/">FaT DuX In My Hotel</a></h4>
                      <p>Captive networking portal for hotel customers</p>
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
              </div>
');


/*
$OPage->column3->addItem(new EaseHtmlH3Tag(_('Reference')));
$Reference = $OPage->column3->addItem( new EaseHtmlUlTag() );
$Reference->addItem(new EaseHtmlATag('/EaseFramework/', _('Ease Framework')));
$Trib = $Reference->addItem(new EaseHtmlATag('http://www.triband.cz/', _('Ease Shop společnosti triband')));
$Trib->addItem(new EaseHtmlImgTag('img/triband.png', 'Přehled zboží',200));

$Leg = $Reference->addItem(new EaseHtmlATag('http://www.magazin-legalizace.cz/', _('Objednávka předplatného magazínu Legalizace')));
$Leg->addItem(new EaseHtmlImgTag('img/magazin-legalizace.png', 'Registrace',200));

$Reference->addItem(new EaseHtmlATag('http://l.q.cz/', _('zkracovač adres LinkQuick')));
*/


$oPage->addItem(new VSPageBottom());


$oPage->draw();
?>
