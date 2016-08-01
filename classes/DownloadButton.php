<?php
namespace VSCZ;

/**
 * Description of VSDownloadButton
 *
 * @author vitex
 */
class DownloadButton extends \Ease\Html\ATag
{

    /**
     * Tlačítko ke stažení balíčku
     *
     * @param array $packageInfo
     * @param array $properties
     */
    public function __construct($packageInfo, $properties = null)
    {
        if (is_null($properties)) {
            $properties = array('class' => 'btn btn-sexy');
        } else {
            if (isset($properties['class'])) {
                $properties['class'] = 'btn btn-sexy ' . $properties['class'];
            } else {
                $properties['class'] = 'btn btn-sexy';
            }
        }
        $properties['style'] = 'margin-right: 5px;';
        parent::__construct('download/' . key($packageInfo), '<img style="width: 42px;" src="img/deb-package.png">&nbsp;' . key($packageInfo) . '<br><small>' . current($packageInfo) . '</small>', $properties);
    }

    function finalize()
    {
        $this->addCss('
.btn-sexy {
color:#08233e;
font:0.8em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
padding:14px;
background:url(../img/overlay.png) repeat-x center #ffcc00;background-color:rgba(255,204,0,1);
border:1px solid #ffcc00;
-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px;
border-bottom:1px solid #9f9f9f;
-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
cursor:pointer;
}

.btn-sexy:hover{background-color:rgba(255,204,0,0.8);}

.btn-sexy:active{position:relative;top:2px;}

.btn-sexy.save{
background-color:#a7dd32;background-color:rgba(167,221,50,1);
border-color:#a7dd32;
}

.btn-sexy.save:hover{
background-color:rgba(167,221,50,0.8);
}
            ');
    }

}
