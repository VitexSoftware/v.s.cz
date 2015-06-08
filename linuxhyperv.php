<?php

/**
 * VitexSoftware - další balíčky
 * 
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';


$oPage->addItem(new VSPageTop(_('Linux kernel for Hyper-V guest')));
$oPage->AddPageColumns();
$oPage->column1->setTagClass('span4');
$oPage->column2->setTagClass('span5');
$oPage->heroUnit->addItem('<h2>* * * This package was obsoleted due new Wheezy kernels * * *</h2>');


$prehled = $oPage->column1->addItem(new EaseHtmlDivTag());

$Prehled2 = $oPage->column1->addItem(new EaseHtmlDivTag());
$Prehled2->addItem('Custom image of latest <a href="http://kernel.org/">Linux kernel</a> with Microsoft <a href="http://technet.microsoft.com/en-us/windowsserver/dd448604">Hyper-V</a> drivers compiled-in.' );

$oPage->column1->addItem('<br>');

$oPage->column2->addItem(new EaseHtmlH3Tag(_('Download')));

$dwDir = "/var/www/download/";
$d = dir($dwDir);
$downloads = array();
while (false !== ($entry = $d->read())) {
    if ($entry[0] == '.') {
        continue;
    }
    $downloads[$entry] = VSWebPage::_format_bytes(filesize($dwDir . $entry));
}
$d->close();
ksort($downloads);
$SquirelPackage = array();
$RoundcubePackage = array();
foreach ($downloads as $file=>$size){
    if(strstr($file, 'linux-image')){
        $LinuxHypervPackage = array($file=>$size);
    }
}


$oPage->column2->addItem('Unofficial Linux kernel image package for Microsoft HyperV virtual machines</br>');

$oPage->column2->addItem(new EaseHtmlATag('download/'.key($LinuxHypervPackage), '<img style="width: 42px;" src="img/deb-package.png">&nbsp;' . key($LinuxHypervPackage) . ' '.current($LinuxHypervPackage) ,array('class'=>'btn btn-success')));


$oPage->column1->addItem(new EaseHtmlH4Tag(_('Hyper-V kernel modules info')));

$oPage->column1->addItem('<pre>
Hypervisor detected: Microsoft HyperV
HyperV: features 0x67f, hints 0x2c
hv_vmbus: Hyper-V Host OS Build:7601-6.1-17-0.17939
hv_vmbus: registering driver hv_storvsc
hv_vmbus: registering driver hv_netvsc
hv_vmbus: registering driver hid_hyperv
hv_vmbus: registering driver hv_balloon
hv_utils: Registering HyperV Utility Driver
hv_vmbus: registering driver hv_util
</pre>');

$oPage->column1->addItem('<br>');

$oPage->column1->addItem('<h5>Compatible with</h5>');
$oPage->column1->addItem('<a href="http://debian.org/"><img style="width: 60px;" title="Debian Linux" src="img/debian.png"></a>');
$oPage->column1->addItem('<a href="http://ubuntu.com/"><img style="width: 60px;" title="Ubuntu Linux" src="img/ubuntulogo.png"></a>');

$oPage->addItem(new VSPageBottom());


$oPage->draw();
?>
