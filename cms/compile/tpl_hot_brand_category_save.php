<?php import('core.util.RunFunc');


$id = $this->_tpl_vars["IN"]["id"];



$dataArray["name"] = $this->_tpl_vars["IN"]["name"];

$dataArray["published"] = $this->_tpl_vars["IN"]["published"];

if($id ==""){
	$dataArray["created"] = date("Y-m-d H:i:s");
	
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_hot_brand_category (".$str_field.") values (".$str_value.")";
	$gid = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
}else{
	
	
	$sql = '';
		foreach ($dataArray as $key => $var)
		{
			$sql .= "$key =:$key,";
		}
		$sql = substr($sql,0,-1);

		$sql = "update cms_hot_brand_category set $sql where id = '{$id}'";

		$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
}


if($this->_tpl_vars["IN"]["id"] ==""){
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("新增商品热门品牌分类 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}else{
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("更新商品热门品牌分类 ".$this->_tpl_vars["IN"]["name"],$this->_tpl_vars["name"]));
}

header("Location: ".runFunc('encrypt_url',array('action=cms&method=hot_brand_category_list&type=products')));

?>


