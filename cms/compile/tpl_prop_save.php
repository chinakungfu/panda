<?php 
import('core.util.RunFunc'); 
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


$id = $this->_tpl_vars["IN"]["id"];

$title = addslashes($this->_tpl_vars["IN"]["title"]);

$published = $this->_tpl_vars["IN"]["published"];

$attrs = $_POST["attr"];

$sql = "replace into cms_product_prop (id,title,published) values('{$id}','{$title}','{$published}')";
$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

if($id!=""){
	$sql = "delete from cms_product_prop_attr where prop_id = {$id}";
	TStaticQuery::deletedata($GLOBALS['currentApp']['dbaccess'],$sql);
}

foreach ($attrs as $attr){
	if($attr==""){
		continue;
	}
	$sql = "insert into cms_product_prop_attr (value,prop_id) values('{$attr}',{$result})";
	TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
}

if($this->_tpl_vars["IN"]["id"] ==""){
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增商品属性  ".$title,$this->_tpl_vars["name"]));
}else{
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("更新商品属性 ".$title,$this->_tpl_vars["name"]));
}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=prop_list&type=products')));