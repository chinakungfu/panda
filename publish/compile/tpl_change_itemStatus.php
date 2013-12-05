<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php if($this->_tpl_vars["name"]){?>
	<?php
	     $userID = $this->_tpl_vars["name"];
	     $cartID = $this->_tpl_vars["cartID"];
		 $dataType = $this->_tpl_vars["dataType"];
		 $dataTime = time();
		switch($dataType){
			case 'confirmReceipt':
				$itemStatus = 19;
				break;
		}


		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		 $params = array (
			'action' => "sql",
			'return' => "updateCart",
			'query' => "update cms_publish_cart set order_item_status='{$itemStatus}',confirmReceiptTime='{$dataTime}' where cartID='{$cartID}' and UserName = {$userID}",
		 );

		$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
		$this->_tpl_vars['PageInfo'] = &$PageInfo;


		$result = $cartID;

		return $result;
	?>

<?php }?>