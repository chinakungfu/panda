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
     $sendType = $this->_tpl_vars["sendType"];
	 $dataType = $this->_tpl_vars["dataType"];
		switch($sendType){
			case 'payment':
				$emailType = "order_remind";
				break;
			case 'confirmation':
				$emailType = "order_arrived";
				break;
			case 'refund':
				$emailType = "order_refund";
				break;
		}
		if($dataType == 'one'){
		 	$orderID = $this->_tpl_vars["orderID"];
			$order = runFunc("getOrder",array($orderID));
			$user_info =runFunc('getStaffInfoById',array($order["orderUser"]));
			$mailArray = array();
			$mailArray["userId"] = $order["orderUser"];
			$mailArray["orderNo"] = $order["OrderNo"];
			$result = runFunc("sendMail",array($mailArray,$emailType));
            //添加日志
			runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."提醒付款",$userID));
            $result = $orderID;

		}else if($dataType == 'batch'){
		 	$orderIDs = explode(',',$this->_tpl_vars["orderID"]);
			foreach($orderIDs as $orderID){
				$order = runFunc("getOrder",array($orderID));
				$user_info =runFunc('getStaffInfoById',array($order["orderUser"]));
				$mailArray = array();
				$mailArray["userId"] = $order["orderUser"];
				$mailArray["orderNo"] = $order["OrderNo"];
				$result = runFunc("sendMail",array($mailArray,$emailType));
	            //添加日志
				runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."批量提醒付款",$userID));
			}
			$result = $this->_tpl_vars["orderID"];
		}
		return $result;
	?>
