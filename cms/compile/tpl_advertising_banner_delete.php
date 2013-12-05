<?php
import('core.util.RunFunc');

$adv_current_img = runFunc("getAdvertisingBannerById",array($this->_tpl_vars["IN"]["id"]));

$adv_current_img_src = "../adv_banners/".$adv_current_img[0]["img"];
if(file_exists($adv_current_img_src)){
		
	unlink($adv_current_img_src);
}

runFunc("deleteAdvertisingBanner",array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=advertising_edit&id='.$adv_current_img[0]["adv_id"].'&type=media')));