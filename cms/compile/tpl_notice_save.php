<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
$id = $this->_tpl_vars["IN"]["id"];

$group_buy = $this->_tpl_vars["IN"]["group_buy"];
$page = $this->_tpl_vars["IN"]["page"];

$dataArray["title"] = $this->_tpl_vars["IN"]["title"];
$dataArray["content"] = $this->_tpl_vars["IN"]["notice_content"];
$dataArray["published"] = $this->_tpl_vars["IN"]["published"];

if($id !=""){
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	$dataArray["updated"] = time();
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	runFunc("makeAdminLog",array("更新公告 ".$this->_tpl_vars["IN"]["title"],$this->_tpl_vars["name"]));
 	$sql = "update cms_publish_notice set $sql where id = '{$id}'";
	TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	$result = $id;

}else{
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	$dataArray["created"] = time();
	$dataArray["updated"] = time();
	$dataArray["author"] = $this->_tpl_vars["name"];
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	
	$sql = "insert into cms_publish_notice (".$str_field.") values (".$str_value.")";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	runFunc("makeAdminLog",array("发布公告 ".$this->_tpl_vars["IN"]["title"],$this->_tpl_vars["name"]));
}
header("Location: ".runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&page='.$page)));
?>
