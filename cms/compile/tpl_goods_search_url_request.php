<?php

import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
include_once('../publish/appfunc/taobao_interface.php');

$url = $this->_tpl_vars["IN"]["search_url"];

	$goods = runFunc("checkItemUrl",array($url));

	if(count($goods)>0){

		$id = $goods[0]["goodsid"];
		if($goods[0]["goodsType"]=="inside"){

			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
			<html lang="en">
			<head>
				<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
				<title>该产品已经被录入过了！</title>
			</head>
			<body>
				<script type="text/javascript">
					alert("该产品已经被录入过了！");
					location.href="'.runFunc('encrypt_url',array('action=cms&method=product_edit&type=products&id='.$id)).'";
				</script>
			</body>
			</html>';

			exit;
		}
	}else{
	$result = GetGoodsInfo($url);
	$img_array = array();
	foreach($result["img"] as $img){
		$img_array[] = $img["url"];

	}
	$this->_tpl_vars["nodeId"]=runFunc('getGlobalModelVar',array('outsideGoodsNode'));
	$this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"]));

	$this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"];

	$this->_tpl_vars["name"]=runFunc('readSession',array());
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
		"published"=>0,
		"created"=>time(),
		"goodsAddUser"=>$this->_tpl_vars["name"],
		"goodsShopId"=>$result['goodsShopId'],
		"goodsShopName"=>$result['goodsShopName'],
		"goodsShopUrl"=>$result['goodsShopUrl']
	);
	//$id = insertAdminSearchGood($result["goodsDetail"],$result["title"],$result["price"],$img_array[0],$img_array[1],$img_array[2],$img_array[3],$url,$id,$result["props"]);
	$id =	runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$goods));
	}

	header("Location:".runFunc('encrypt_url',array('action=cms&method=product_edit&type=products&id='.$id)));


function insertAdminSearchGood($goodsDetail,$goodsTitleCN,$goodsUnitPrice,$goodsImgURL,$goodsImgURL1,$goodsImgURL2,$goodsImgURL3,$goodsURL,$goodsAddUser,$props){

	$sql = "insert into cms_publish_goods (goodsDetail,nodeId,goodsTitleCN,goodsUnitPrice,goodsFreight,goodsImgURL,goodsImgURL1,goodsImgURL2,goodsImgURL3,goodsURL,goodsStatus,goodsType,goodsAddUser,props)";

	$sql .=" values('{$goodsDetail}','GoodsmanagementUkeM','{$goodsTitleCN}','{$goodsUnitPrice}','15','{$goodsImgURL}','{$goodsImgURL1}','{$goodsImgURL2}','{$goodsImgURL3}','{$goodsURL}','Open','outside','{$goodsAddUser}','{$props}')";
	return TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);

}
