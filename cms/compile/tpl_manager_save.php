<?php import('core.util.RunFunc');




if($this->_tpl_vars["IN"]["id"]!=""){
	
	$manager_account = array(
	"staffNo"=>$this->_tpl_vars["IN"]["manger_email"],
	"staffName"=>$this->_tpl_vars["IN"]["manger_name"],
	"phone"=>$this->_tpl_vars["IN"]["manger_phone"],
	"staffId"=>$this->_tpl_vars["IN"]["id"],
	"block"=>$this->_tpl_vars["IN"]["block"],
	"manager_permission"=>$this->_tpl_vars["IN"]["manager_permission"],
	);
	
	if(trim($this->_tpl_vars["IN"]["password"])!=""){
		$manager_account["password"] = md5($this->_tpl_vars["IN"]["password"]);
	}
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	runFunc("makeAdminLog",array("修改了管理员 ".$this->_tpl_vars["IN"]["manger_email"]."的信息",$this->_tpl_vars["name"]));
	runFunc("adminUpdateUser",array($manager_account));
}else{
	$manager_account = array(
	"staffNo"=>$this->_tpl_vars["IN"]["manger_email"],
	"staffName"=>$this->_tpl_vars["IN"]["manger_name"],
	"password"=>md5($this->_tpl_vars["IN"]["password"]),
	"groupName"=>"Site Manager",
	"phone"=>$this->_tpl_vars["IN"]["manger_phone"],
	"registerDate"=>date("Y-m-d H:i:s"),
	"verifyDate"=>date("Y-m-d H:i:s"),
	"manager_permission"=>$this->_tpl_vars["IN"]["manager_permission"],
	);
	
	
	$id = runFunc("adminAddUser",array($manager_account));
	
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	runFunc("makeAdminLog",array("新增管理员 ".$this->_tpl_vars["IN"]["manger_email"],$this->_tpl_vars["name"]));
	runFunc("makeManagerProfile",array($id));
}

header("Location:".runFunc('encrypt_url',array('action=cms&method=managers&type=main')));

