<?php import('core.util.RunFunc');



	
	$manager_account = array(
	"staffNo"=>$this->_tpl_vars["IN"]["manger_email"],
	"staffName"=>$this->_tpl_vars["IN"]["manger_name"],
	"phone"=>$this->_tpl_vars["IN"]["manger_phone"],
	"staffId"=>1,
	"block"=>0
	);
	
	if(trim($this->_tpl_vars["IN"]["password"])!=""){
		$manager_account["password"] = md5($this->_tpl_vars["IN"]["password"]);
	}
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	runFunc("makeAdminLog",array("修改了超级管理员 ".$this->_tpl_vars["IN"]["manger_email"]."的信息",$this->_tpl_vars["name"]));
	runFunc("adminUpdateUser",array($manager_account));


header("Location:".runFunc('encrypt_url',array('action=cms&method=admin_user_settings&type=main')));

