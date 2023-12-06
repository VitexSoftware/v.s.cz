<?php

namespace VSCZ\ui;

/**
 * Description of FacebookWall
 *
 * @author vitex
 */
class FacebookWall extends \Ease\Html\DivTag
{
    public function __construct($content = 'VitexSoftware', $properties = null)
    {
        $properties['class'] = 'fb-page';

        $properties['data-href']                  = 'https://www.facebook.com/VitexSoftware/';
        $properties['data-tabs']                  = 'timeline,events,messages';
        $properties['data-width']                 = 1000;
        $properties['data-small-header']          = 'true';
        $properties['data-adapt-container-width'] = 'true';
        $properties['data-hide-cover']            = 'false';
        $properties['data-show-facepile']         = 'true';

        parent::__construct(new \Ease\Html\DivTag(
            '<blockquote cite="' . $properties['data-href'] . '"><a href="' . $properties['data-href'] . '">' . $content . '</a></blockquote>',
            ['class' => 'fb-xfbml-parse-ignore']
        ), $properties);
    }

    public function finalize()
    {
        \Ease\Shared::webPage()->addJavaScript('
  window.fbAsyncInit = function() {
    FB.init({
      appId      : \'144742582740786\',
      xfbml      : true,
      version    : \'v2.6\'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/cs_CZ/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, \'script\', \'facebook-jssdk\'));            ');
    }
}
