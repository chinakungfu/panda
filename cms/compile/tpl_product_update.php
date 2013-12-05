<?php
import('core.util.RunFunc');
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
include_once('../publish/appfunc/taobao_interface.php');
$dataType = $this->_tpl_vars["IN"]["dataType"]; 
if($dataType == 'one'){
	$id = $this->_tpl_vars["IN"]["id"];
	$goodsInfo = runFunc("getAdminGoodsById",array($id));
	$result = GetGoodsInfo($goodsInfo['goodsURL']);
	if($result['status'] > 0){
		$goods = array(
			"goodsDetail"=>$result["goodsDetail"],
			"goodsTitleCN"=>$result["title"],
			"goodsUnitPrice"=>$result["price"],
			"click_url" =>$result["click_url"],
			"props"=>$result["props"],
			"goodsShopId"=>$result['goodsShopId'],
			"goodsShopName"=>$result['goodsShopName'],
			"goodsShopUrl"=>$result['goodsShopUrl']
		);

		$resultid = runFunc('updateAdminGoodsById',array($id ,$goods));

		if($resultid){
			runFunc('showMsg',array('更新成功',$link,'',2000));
		}else{
			runFunc('showMsg',array('更新失败',$link,'',3000));
		}	
	}else{
		if($result['status'] == '-3'){
			runFunc('showMsg',array('更新失败,商品过期或已下架!',$link,'',3000));
			exit;
		}
		if($result['status'] == '-1'){
			runFunc('showMsg',array('更新失败,商品URL地址不正确!',$link,'',3000));
			exit;
		}
	}

}else if($dataType == 'batch'){
	$goodsID = explode(',',$this->_tpl_vars["IN"]["id"]);
	for($i = 0; $i < count($goodsID);$i++){
		$goodsInfo = runFunc("getAdminGoodsById",array($goodsID[$i]));
		$result = GetGoodsInfo($goodsInfo['goodsURL']);	
		if($result['status'] > 0){
			$goods = array(
				"goodsDetail"=>$result["goodsDetail"],
				"goodsUnitPrice"=>$result["price"],
				"click_url" =>$result["click_url"],
				"props"=>$result["props"],
				"goodsShopId"=>$result['goodsShopId'],
				"goodsShopName"=>$result['goodsShopName'],
				"goodsShopUrl"=>$result['goodsShopUrl']
			);

			$resultid = runFunc('updateAdminGoodsById',array($goodsID[$i] ,$goods));
			if($resultid){
				$result2['status'] = 1;
			}else{
				$result2['status'] = 0;
				break;
			}
		}		
	}
	echo json_encode($result2);
}