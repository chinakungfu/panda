<?php
import('core.util.RunFunc');


$dataArray = array(
		"title" =>$this->_tpl_vars["IN"]["title"],
		"published" =>$this->_tpl_vars["IN"]["published"],
		
		);


if($this->_tpl_vars["IN"]["id"] !=""){
	$dataArray["id"] = $this->_tpl_vars["IN"]["id"];
	runFunc("circleCategoryUpdate",array($dataArray));
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("更新商店分类 ".$this->_tpl_vars["IN"]["title"],$uid));
	
}else{
	
	runFunc("circleCategoryAdd",array($dataArray));
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("新增商店分类 ".$this->_tpl_vars["IN"]["title"],$uid));
}


header("Location:".runFunc('encrypt_url',array('action=cms&method=circle_category&type=share')));