<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php if($this->_tpl_vars["name"]){?>
	<?php
	     $userID = $this->_tpl_vars["name"];
	     $changeType = $this->_tpl_vars["changeType"];
		 $dataType = $this->_tpl_vars["dataType"];
		 $deleteTime = time();

		if($dataType == 'one'){
		 	$orderID = $this->_tpl_vars["orderID"];
			switch($changeType){
				case 'delete':
					$orderStatus = 31;
					$sql = "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$deleteTime}' where orderID='{$orderID}' and orderUser = {$userID}";
					break;
				case 'cancel':
					$orderStatus = 30;
					$sql = "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$deleteTime}' where orderID='{$orderID}' and orderUser = {$userID}";					
					break;
				case 'trash':
					$orderStatus = 32;
					$sql = "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$deleteTime}' where orderID='{$orderID}' and orderUser = {$userID}";					
					break;
				case 'confirm':
					$orderStatus = 19;
					$order = runFunc("getOrder",array($orderID));
					$dataArry['confirmReceiptTime'] = $deleteTime;
					$dataArry['order_item_status'] = 19;
					runFunc("updateItemInfoByCartstr",array($userID,$order['cartIDstr'],$dataArry));
					$sql = "update cms_publish_order set orderStatus='{$orderStatus}',confirmTime='{$deleteTime}' where orderID='{$orderID}' and orderUser = {$userID}";					
					break;				
			}			
         	import('core.apprun.cmsware.CmswareNode');
         	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	         $params = array (
	            'action' => "sql",
	            'return' => "updateOrder",
	            'query' => $sql,
	         );
            //更新数目
            $this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
            $this->_tpl_vars['PageInfo'] = &$PageInfo;


            //return $this->_tpl_vars["name"]."--".$orderStatus."--".$dataType."--".$deleteTime;
            $result = $orderID;


		}else if($dataType == 'batch'){
		 	$orderIDs = explode(',',$this->_tpl_vars["orderID"]);
			
			switch($changeType){
				case 'delete':
					$orderStatus = 31;
					break;
				case 'cancel':
					$orderStatus = 30;
					break;
				case 'trash':
					$orderStatus = 32;
					break;
				case 'confirm':
					$orderStatus = 19;
					break;				
			}			
			
         	import('core.apprun.cmsware.CmswareNode');
         	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			foreach($orderIDs as $orderID){

		         $params = array (
		            'action' => "sql",
		            'return' => "updateOrder",
		            'query' => "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$deleteTime}' where orderID='{$orderID}' and orderUser = {$userID}",
		         );
	            //更新数目
	            $this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
	            $this->_tpl_vars['PageInfo'] = &$PageInfo;
			}

			$result = $this->_tpl_vars["orderID"];
		}

		return $result;
	?>

<?php }?>