<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
	<?php
	     $userID = $this->_tpl_vars["name"];
	     $changeType = $this->_tpl_vars["changeType"];
		 $dataType = $this->_tpl_vars["dataType"];
		 $changeTime = time();
		if($dataType == 'one'){
		 	$orderID = $this->_tpl_vars["orderID"];
			$order = runFunc("getOrder",array($orderID));
         	import('core.apprun.cmsware.CmswareNode');
         	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;	
			switch($changeType){
				case 'delete':
					$orderStatus = 22;
					break;
				case 'close':
					$orderStatus = 21;
					break;
				case 'trash':
					$orderStatus = 23;
					 $params = array (
						'action' => "sql",
						'return' => "updateOrder",
						'query' => "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$changeTime}' where orderID='{$orderID}'",
					 );					
					$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;					
					runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."被移到垃圾桶!",$userID));		
					break;
				case 'refund':
					$orderStatus = 17;
					runFunc("refundToCustomer",array($orderID,$order["cartIDstr"],$order['orderUser']));					
					//runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."执行退款操作",$userID));	
					break;
			}
            
		}else if($dataType == 'batch'){
		 	$orderIDs = explode(',',$this->_tpl_vars["orderID"]);
			import('core.apprun.cmsware.CmswareNode');
			import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;			
			switch($changeType){
				case 'trash':
					$orderStatus = 23;
					foreach($orderIDs as $orderID){
						 $params = array (
							'action' => "sql",
							'return' => "updateOrder",
							'query' => "update cms_publish_order set orderStatus='{$orderStatus}',deleteTime='{$changeTime}' where orderID='{$orderID}'",
						 );
						//更新数目
						$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
						$this->_tpl_vars['PageInfo'] = &$PageInfo;
						//添加日志
						$order = runFunc("getOrder",array($orderID));
						runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."被批量移到垃圾桶!",$userID));
					
					}					
				break;
			}
			$result = $this->_tpl_vars["orderID"];
		}
		return $result;
	?>
