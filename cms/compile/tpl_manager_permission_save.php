<?php

import('core.util.RunFunc');

$dataArray = array();

$dataArray["name"] = $this->_tpl_vars["IN"]["name"];

$permission_array = $_POST["permission"];

$dataArray["permission"] = json_encode($permission_array);

if($this->_tpl_vars["IN"]["id"]==""){
$dataArray["created"] = date("Y-m-d H:i:s");
runFunc("saveManagerPermission",array($dataArray));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增管理员权限 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}else{
	runFunc("updateManagerPermission",array($dataArray,$this->_tpl_vars["IN"]["id"]));
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	runFunc("makeAdminLog",array("更改管理员权限 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}

header("Location:".runFunc('encrypt_url',array('action=cms&method=manager_permission_list&type=main')));