<?php import('core.util.RunFunc'); ?>
	<?php
		$cartID = $this->_tpl_vars['IN']['cartID'];
		$orderID = $this->_tpl_vars['IN']['orderID'];
		$returnType = $this->_tpl_vars['IN']['returnType']; 
	if($returnType == 'replacement'){
		$cartStatus = 13;
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		 $params = array (
			'action' => "sql",
			'return' => "updateCart",
			'query' => "update cms_publish_cart set order_item_status='{$cartStatus}' where cartID='{$cartID}'",
		 );
		$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;
		
	}else if($returnType == 'return'){

		$cartStatus = 15;
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		 $params = array (
			'action' => "sql",
			'return' => "updateCart",
			'query' => "update cms_publish_cart set order_item_status='{$cartStatus}' where cartID='{$cartID}'",
		 );

		$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;
	}
	$link = "/cms/index.php".runFunc('encrypt_url',array('action=cms&method=orderReturnDetail&orderID='.$orderID.'&cartID='.$cartID));
	if($this->_tpl_vars['updateCart']){
		runFunc('showMsg',array('更新成功!',$link,'',3000));
	}else{
		runFunc('showMsg',array('更新失败!',$link,'',3000));
	}
?>
 