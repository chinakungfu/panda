<?php import('core.util.RunFunc');


$site_settings_site_url=array(
	"varValue"=>$this->_tpl_vars["IN"]["SITE_DOMAIN"],
	"varId"=>3
);

runFunc("updateGlobalSettingsVar",array($site_settings_site_url));


$site_settings_site_name=array(
	"varValue"=>$this->_tpl_vars["IN"]["Site_Name"],
	"varId"=>2
);

runFunc("updateGlobalSettingsVar",array($site_settings_site_name));


$seo_array = array(
	"seoKeywords"=>$this->_tpl_vars["IN"]["seoKeywords"],
	"seoDescription"=>$this->_tpl_vars["IN"]["seoDescription"]
);

runFunc("updateSeoSettings",array($seo_array));

$this->_tpl_vars["name"]=runFunc('readSession',array());

runFunc("makeAdminLog",array("更改站点设置",$this->_tpl_vars["name"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=site_settings&type=main')));