<?php
import('core.util.RunFunc');



$dataArray["name"] = $this->_tpl_vars["IN"]["title"];

$dataArray["published"] = 1;

$dataArray["created"] = date("Y-m-d H:i:s");
	
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_product_brand_tag (".$str_field.") values (".$str_value.")";
	$id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

$json = array(
			"title"=>$this->_tpl_vars["IN"]["title"],
			"id"=>$id
		);

echo json_encode($json);
