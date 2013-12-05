<?php 
import('core.util.RunFunc'); 
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');


$id = $this->_tpl_vars["IN"]["id"];

$title = addslashes($this->_tpl_vars["IN"]["title"]);

$published = $this->_tpl_vars["IN"]["published"];

$cat_id = $this->_tpl_vars["IN"]["cat_id"];



$sql = "replace into cms_product_tag (id,title,cat_id,published) values('{$id}','{$title}','{$cat_id}','{$published}')";
$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

if($this->_tpl_vars["IN"]["id"] ==""){
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增商品标签  ".$title,$this->_tpl_vars["name"]));
}else{
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("更新商品标签  ".$title,$this->_tpl_vars["name"]));
}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=tag_list&type=products')));