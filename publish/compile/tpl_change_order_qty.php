<?php import('core.util.RunFunc'); ?>
<?php
	$cartID = $this->_tpl_vars["cartID"];
	$itemQTY = $this->_tpl_vars["itemQTY"];
	$userId = $this->_tpl_vars["userId"];
	$cartType = $this->_tpl_vars["cartType"];
	$goodsShopId = $this->_tpl_vars["goodsShopId"];
	$orderID = $this->_tpl_vars["orderID"];
	
	$orderInfo = runFunc("getOrderCartStrByOrderId",array($orderID));
	$cartStr = $orderInfo["cartIDstr"];
	
	$cartInfo = runFunc("getOrderItemsById",array($cartID,'Order'));
	if($cartInfo['modifyPrice'] && $cartInfo['modifyPrice'] > 0){
		$itemPrice = $cartInfo['modifyPrice'];
	}else{
		$itemPrice = $cartInfo['itemPrice'];
	}
?>
<?php $settings =  runFunc("getGlobalSetting");?>
<?php $itemTotal = (float)($itemQTY * $itemPrice);?>
<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart set ItemQTY='{$itemQTY}',itemTotal = '{$itemTotal}' where cartID='{$cartID}'",
 );
	$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

<?php
	
	//更新总价
	$amount = runFunc("makeOrderAmout",array($cartStr));
	$shopNum = runFunc("makeOrderFreight",array($cartStr));
	
	$freight = $shopNum*$settings[0]["freight"];//总运费
	$service_fee = $settings[0]["service_fee"]*$amount["amount"];//所有商品服务费
	
	if($orderInfo['invoice'] == 1){
		$tax = ($service_fee + $amount["amount"] + $freight) * $settings[0]["tax_rate"];
	}else{
		$tax = 0;
	}
	
	$dataArray["service_fee"] = $service_fee;		//总服务费
	$dataArray["order_amount"] = $amount["amount"];	//商品总价
	$dataArray["order_freight"] = $freight;			//总运费
	$dataArray["tax"] = $tax;						//税价
		
	$dataArray["totalAmount"] = $amount["amount"]+$freight + $dataArray["service_fee"] + $dataArray["tax"];	//总总价钱
	$credit = floor($dataArray["totalAmount"] / $settings[0]["credit_consumption"]);
	
	
	$sql = '';
	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);
	$sql = "update cms_publish_order set $sql where orderID = {$orderID}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);	
		
	if($result){
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
			'action' => "sql",
			'return' => "cartInfo",
			'query' => "SELECT SUM(a.itemTotal) as totalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE a.ItemGoodsID=b.goodsid and a.UserName='{$userId}' and a.ItemStatus = 'Order' and a.cart_type = 1 and a.cartID in ({$cartStr}) and b.goodsShopId = '{$goodsShopId}'",
		 );
		$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
	    $this->_tpl_vars['PageInfo'] = &$PageInfo;		
		
		//商品总价
		$itemTotal = number_format($itemTotal, 2, '.', ',');		
		//店铺总价
		$sellerTotalPrice = number_format($this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"], 2, '.', ',');
		//店铺运费
		$sellerFreightPrice = number_format($settings[0]["freight"],2,'.',',');		
		//总价钱
		$sellerSubTotalPrice = number_format($dataArray["order_amount"],2,'.',',');
		//总服务费
		$serviceFeePrice = number_format($dataArray["service_fee"], 2, '.', ',');
		//总运费
		$sellerSubFreightPrice =  number_format($dataArray["order_freight"], 2, '.', ',');//总运费
		//总总价钱
		$sellerAllTotalPrice = number_format($dataArray["totalAmount"], 2, '.', ',');//总价钱
		$orderTax = number_format($tax, 2, '.', ',');//总价钱
		
	return $cartID."-".$goodsShopId."-".$itemTotal.'-'.$sellerTotalPrice. '-' .$sellerFreightPrice. '-' . $sellerSubTotalPrice. '-' .$serviceFeePrice. '-' .$sellerSubFreightPrice. '-' .$sellerAllTotalPrice.'-'. $orderTax .'-' .$credit;
	}else{
		return false;
	}
?>
