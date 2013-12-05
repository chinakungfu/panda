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
		 $userInfo = runFunc("getUser",array($userID));
		 $userName = $userInfo[0]["staffNo"];

	     $changeType = $this->_tpl_vars["changeType"];
		 $dataType = $this->_tpl_vars["dataType"];

		 $changeTime = time();
		if($dataType == 'one'){
		 	$orderID = $this->_tpl_vars["orderID"];
			$order = runFunc("getBankTransfer",array($orderID));
			$orderUserInfo = runFunc("getUser",array($order['userID']));
			$orderUserName = $orderUserInfo[0]["staffNo"];
         	import('core.apprun.cmsware.CmswareNode');
         	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;	
			switch($changeType){
				case 'finish':
					$orderStatus = 19;
					 $params = array (
						'action' => "sql",
						'return' => "updateBankTransfer",
						'query' => "update cms_publish_bank_transfer set status='{$orderStatus}',rechargeTime='{$changeTime}',operator = '{$userName}' where id='{$orderID}'",
					 );					
					$this->_tpl_vars['updateBankTransfer'] = CMS::CMS_sql($params);
					$this->_tpl_vars['PageInfo'] = &$PageInfo;					
					runFunc("makeAdminLog",array($orderUserName."在".date("y-m-d H:i",$order['submitTime'])."提交的汇款已充值完成",$userID));		
					break;
			}
			$result = $this->_tpl_vars["orderID"];
            
		}else if($dataType == 'batch'){
/*		 	$orderIDs = explode(',',$this->_tpl_vars["orderID"]);
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
			$result = $this->_tpl_vars["orderID"];*/
		}
		return $result;
	?>
