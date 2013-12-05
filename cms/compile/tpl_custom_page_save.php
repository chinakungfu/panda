<?php
import('core.util.RunFunc');


$dataArray = array(
	"title" => $this->_tpl_vars["IN"]["title"],
	"position" => $this->_tpl_vars["IN"]["position"],
	"publish" => $this->_tpl_vars["IN"]["publish"],
	"content" => $this->_tpl_vars["IN"]["content"],
	"created" => date("Y-m-d H:i:s") 
);

if($this->_tpl_vars["IN"]["id"]!=""){
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("修改活动页 ".$this->_tpl_vars["IN"]["title"],$uid));
	runFunc("updateCustomPage",array($dataArray,$this->_tpl_vars["IN"]["id"]));
	$id = $this->_tpl_vars["IN"]["id"];
}else{
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("新增活动页 ".$this->_tpl_vars["IN"]["title"],$uid));
	$id = runFunc("saveCustomPage",array($dataArray));
}



header("Location:".runFunc('encrypt_url',array('action=cms&method=custom_page_edit&id='.$id.'&type=media')));