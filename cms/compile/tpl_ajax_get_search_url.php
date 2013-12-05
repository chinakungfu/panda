<?php

import('core.util.RunFunc'); 
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
include_once('../publish/appfunc/taobao_interface.php');

$url = $this->_tpl_vars["IN"]["search_url"];

if(strpos($url,'wowshopping') !== false){

	$url_array = explode("LCMSPID=",$url);

	$decode_url =  runFunc("decrypt_url",array("$url_array[1]"));

	$decode_array = explode("&",$decode_url);

	$decode_id_array = explode("=",$decode_array[2]);

	$id =  $decode_id_array[1];

	$goods = runFunc("getAdminGoodsById",array($id));

}else{

	$goods = runFunc("checkItemUrl",array($url));

	if(count($goods)>0){
		
		$id = $goods[0]["goodsid"];
		
		$goods = $goods[0];

		$result = $goods;
	}else{
	$result = GetGoodsInfo($url);

	if($result == -1){
		exit;
	}

	$img_array = array();
	foreach($result["img"] as $img){
		$img_array[] = $img["url"];
		
	}
	
	$this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('outsideGoodsNode')); 
	$this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); 

	$this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; 

	
	$goods = array(
		"goodsDetail"=>$result["goodsDetail"],
		"goodsTitleCN"=>$result["title"],
		"goodsUnitPrice"=>$result["price"],
		"goodsFreight"=>$result["postage"],
		"goodsImgURL"=>$img_array[0],
		"goodsImgURL1"=>$img_array[1],
		"goodsImgURL2"=>$img_array[2],
		"goodsImgURL3"=>$img_array[3],
		"click_url" =>$result["click_url"],
		"goodsURL"=>$url,
		"goodsAddUser"=>$id,
		"props"=>$result["props"],
		"goodsType" =>"inside",
		"goodsStatus"=>"open",
		"nodeId" =>$this->_tpl_vars["nodeId"],
		"other_get" =>$this->_tpl_vars["IN"]["other_get"],
		"published"=>0
	);
	//$id = insertAdminSearchGood($result["goodsDetail"],$result["title"],$result["price"],$img_array[0],$img_array[1],$img_array[2],$img_array[3],$url,$id,$result["props"]);
	$id =	runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$goods));
	
	
	}
//	$goods["goodsUnitPrice"] = number_format($goods["goodsUnitPrice"], 2, '.', ',');
	$goods["goodsUnitPrice"] = $goods["goodsUnitPrice"];
	
	
	}
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
$goods["id_link"] = $site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$id."&show_type=collections&from=collections_page"));
$goods["goodsid"]=$id;
	echo json_encode($goods);

