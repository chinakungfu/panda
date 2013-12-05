<?php import('core.util.RunFunc'); ?>
<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "update cms_publish_order set cartIDstr='{$this->_tpl_vars["newcartIdStr"]}' where orderID='{$this->_tpl_vars["orderId"]}'",
 );
	//更新数目
	$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;

?>
<?php
	$settings = runFunc("getGlobalSetting");
	//更新总价
	$amount = runFunc("makeOrderAmout",array($this->_tpl_vars["newcartIdStr"]));
	//总运费
	$shopNum = runFunc("makeOrderFreight",array($this->_tpl_vars["newcartIdStr"]));
	$freight = $shopNum*$settings[0]["freight"];	
	//总服务费
	$serviceFeePrice = $settings[0]["service_fee"]*$amount["amount"];
		
	if($serviceFeePrice < 20 && $serviceFeePrice > 0){
		$serviceFeePrice = 20;
	}	
	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["orderId"]));

	if($order["invoice"] == 1){

		$tax = ($serviceFeePrice + $amount["amount"] + $freight) * $settings[0]["tax_rate"];
	}else{

		$tax = 0;
	}	
	$dataArray["order_amount"] = $amount["amount"];
	$dataArray["order_freight"] = $freight;
	$dataArray["tax"] = $tax;
	$dataArray["service_fee"] = $serviceFeePrice;
	$dataArray["totalAmount"] = $amount["amount"]+$freight + $dataArray["service_fee"] + $dataArray["tax"];	
	
	
	

	$sql = '';

	foreach ($dataArray as $key => $var)
	{
		$sql .= "$key =:$key,";
	}
	$sql = substr($sql,0,-1);

	$sql = "update cms_publish_order set $sql where orderID = {$this->_tpl_vars["orderId"]}";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	
	if($result){
		return $dataArray["order_amount"]."-".$dataArray["order_freight"]."-".$dataArray["tax"]."-".$dataArray["service_fee"].'-'.$dataArray["totalAmount"];
	}else{
		return false;
	}
?>