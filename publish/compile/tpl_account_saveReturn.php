<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php if($this->_tpl_vars["name"]){?>
	<?php
	$userID = $this->_tpl_vars["name"];
	$cartID = $this->_tpl_vars['IN']['returnCartID'];
	$orderID = $this->_tpl_vars['IN']['returnOrderID'];
	$returnType = $this->_tpl_vars['IN']['returnType'];
	$returnInstructions = trim($this->_tpl_vars['IN']['instructions']);
	$returnPhoto = $this->_tpl_vars['IN']['returnPhoto'];
	$returnTime = time();

	if($returnType == '1'){
		$cartStatus = 12;
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params,$PageInfo2,$params2;
		 $params = array (
			'action' => "sql",
			'return' => "updateCart",
			'query' => "update cms_publish_cart set order_item_status='{$cartStatus}',returnTime='{$returnTime}',returnInstructions='{$returnInstructions}',returnPhoto='{$returnPhoto}' where cartID='{$cartID}' and UserName = {$userID}",
		 );

		$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;

		 $params2 = array (
			'action' => "sql",
			'return' => "updateOrder",
			'query' => "update cms_publish_order set replacement='1',replacementTime = '{$returnTime}' where orderID='{$orderID}' and orderUser = {$userID}",
		 );

		$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params2);
		$this->_tpl_vars['PageInfo'] = &$PageInfo2;
	}else if($returnType == '2'){
		$cartStatus = 14;
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params,$PageInfo2,$params2;
		 $params = array (
			'action' => "sql",
			'return' => "updateCart",
			'query' => "update cms_publish_cart set order_item_status='{$cartStatus}',returnTime='{$returnTime}',returnInstructions='{$returnInstructions}',returnPhoto='{$returnPhoto}' where cartID='{$cartID}' and UserName = {$userID}",
		 );

		$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;

		 $params2 = array (
			'action' => "sql",
			'return' => "updateOrder",
			'query' => "update cms_publish_order set Returned='1',returnedTime = '{$returnTime}' where orderID='{$orderID}' and orderUser = {$userID}",
		 );

		$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params2);
		$this->_tpl_vars['PageInfo'] = &$PageInfo2;

	}

	if($this->_tpl_vars['updateCart'] && $this->_tpl_vars['updateOrder']){
		header("Location: ".runFunc('encrypt_url',array('action=account&method=returnItemSucceed&orderID='.$orderID.'&cartID='.$cartID)));
	}else{
		header("Location: ".runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$orderID)));
	}
	?>

<?php }?>