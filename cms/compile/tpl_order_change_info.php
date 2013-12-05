<?php import('core.util.RunFunc');?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php $user_info = runFunc("getUser",array($this->_tpl_vars["name"]));?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
	$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderID"]));
	$link = runFunc('encrypt_url',array("action=cms&method=order&orderID=".$order['orderID']));
	switch($this->_tpl_vars["IN"]["type"]){
		case 'waitingPayment':
			if($order['orderStatus'] != '4'){
				runFunc('showMsg',array("审核订单失败!只有未付款订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				if($order['pending'] == '2'){
					runFunc('showMsg',array("审核订单失败!此订单已经是审核过了,不用再审了.!",$link ,'',3000));
					exit;
				}else{
					//更新订单
					$orderArray["modifyTime"] = time();
					$orderArray["mender"] = $user_info[0]['staffNo'];
					$orderArray["pending"] = 2;
					$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
					if(!$updateOrderResult){
						runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
						exit;
					}
					//日志记录
					runFunc('makeAdminLog',array("审核订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
					//发送邮件
					$mailArray["orderNo"] = $order["OrderNo"];
					$mailArray['userId'] = $order['orderUser'];

					$result = runFunc('sendMail',array($mailArray,"order_remind"));
					if($result){
						runFunc('showMsg',array("审核订单成功!",$link ,'',3000));
					}else{
						runFunc('showMsg',array("审核订单成功!,但发送Email失败!",$link ,'',3000));
					}
				}
			}
		break;
		case 'verified':
			if($order['orderStatus'] < 5 || $order['orderStatus'] > 6){
				runFunc('showMsg',array("验证订单失败!此订单已经验证过了!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["verifyTime"] = time();
				$orderArray["verifier"] = $user_info[0]['staffNo'];
				$orderArray["verify"] = 1;
				$orderArray["orderStatus"] = 6;
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("验证订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
				runFunc('showMsg',array("验证订单成功!",$link ,'',3000));
			}
		break;
		case 'purchased':
			if($order['orderStatus'] != 6){
				runFunc('showMsg',array("purchased订单失败!只有待采购订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//检查是否填写采购价格
				$checkResult = runFunc('checkItemService',array("purchased",$order['cartIDstr']));
				if($checkResult){
					//更新订单
					$orderArray["purchaseTime"] = date("Y-m-d H:i:s");
					$orderArray["buyer"] = $user_info[0]['staffNo'];
					$orderArray["orderStatus"] = 7;
					$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
					if(!$updateOrderResult){
						runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
						exit;
					}
					//日志记录
					runFunc('makeAdminLog',array("采购订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
					runFunc('showMsg',array("采购订单成功!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("采购订单失败,请填写每一项采购价格!",$link ,'',3000));
				}
			}
		break;
		case 'onTheWay':
			if($order['orderStatus'] != 7){
				runFunc('showMsg',array("onTheWay订单失败!只有已采购订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//检查是否填写运单号
				$checkResult = runFunc('checkItemService',array("onTheWay",$order['cartIDstr']));
				if($checkResult){
					//更新订单
					$orderArray["orderStatus"] = 10;
					$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
					if(!$updateOrderResult){
						runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
						exit;
					}
					//日志记录
					runFunc('makeAdminLog',array("订单发货中成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
					runFunc('showMsg',array("订单发货中成功!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("订单发货中失败,至少填写一项运单号!",$link ,'',3000));
				}
			}
		break;
		case 'shipped':
			if($order['orderStatus'] != '10'){
				runFunc('showMsg',array("shipped订单失败!只有发货中的订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["orderStatus"] = 18;
				$orderArray["shippingTime"] = date("Y-m-d H:i:s");
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("shipped订单成功!,等待用户确认,订单号：".$order["OrderNo"],$user_info[0]['staffId']));

				//发送邮件
				$mailArray["orderNo"] = $order["OrderNo"];
				$mailArray['userId'] = $order['orderUser'];
				$result = runFunc('sendMail',array($mailArray,"order_shipped"));
				if($result){
					runFunc('showMsg',array("shipped订单成功!等待用户确认!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("shipped订单成功!,但发送Email失败!",$link ,'',3000));
				}
			}
		break;
		case 'returned':
			if($order['orderStatus'] != '14'){
				runFunc('showMsg',array("returned订单失败!只有待退货的订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["orderStatus"] = 15;
				$orderArray["Returned"] = 2;
				$orderArray["returnedTime"] = time();
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("returned订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
				//发送邮件
				$mailArray["orderNo"] = $order["OrderNo"];
				$mailArray['userId'] = $order['orderUser'];
				$result = runFunc('sendMail',array($mailArray,"order_returned"));
				if($result){
					runFunc('showMsg',array("returned订单成功!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("returned订单成功!,但发送Email失败!",$link ,'',3000));
				}
			}
		break;
		case 'replacement':
			if($order['orderStatus'] != '12'){
				runFunc('showMsg',array("replacement订单失败!只有待换货的订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["orderStatus"] = 13;
				$orderArray["replacement"] = 2;
				$orderArray["replacementTime"] = time();
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("replacement订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));

				//发送邮件
				$mailArray["orderNo"] = $order["OrderNo"];
				$mailArray['userId'] = $order['orderUser'];
				$result = runFunc('sendMail',array($mailArray,"order_replacement"));
				if($result){
					runFunc('showMsg',array("replacement订单成功!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("replacement订单成功!,但发送Email失败!",$link ,'',3000));
				}
			}
		break;
		case 'refund':
			if($order['orderStatus'] < 5){
				runFunc('showMsg',array("待退款订单失败!此订单未付款不能执行此操作!",$link ,'',3000));
				exit;
			}else if($orderArray["order_return"] == 1){
				runFunc('showMsg',array("待退款订单失败!此订单已经是待退款订单,不能重复执行此操作!",$link ,'',3000));
				exit;
			}else if($orderArray["order_return"] == 2){
				runFunc('showMsg',array("待退款订单失败!此订单已经退款,不能执行此操作!",$link ,'',3000));
				exit;
			}else if($order['orderStatus'] >= 19){
				runFunc('showMsg',array("待退款订单失败!此订单已经确认或已经关闭,不能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["order_return"] = 1;
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("订单待退款成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
				runFunc('showMsg',array("订单待退款成功!",$link ,'',3000));
			}
		break;
		case 'paidBack'://废除
			if($order['orderStatus'] != '16'){
				runFunc('showMsg',array("paidBack订单失败!只有待退款的订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["orderStatus"] = 17;
				$orderArray["refundTime"] = date("Y-m-d H:i:s");
				$orderArray["order_return"] = 2;
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("paidBack订单成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));

				//发送邮件
				$mailArray["orderNo"] = $order["OrderNo"];
				$mailArray['userId'] = $order['orderUser'];
				$result = runFunc('sendMail',array($mailArray,"order_refund"));
				if($result){
					runFunc('showMsg',array("paidBack订单成功!",$link ,'',3000));
				}else{
					runFunc('showMsg',array("paidBack订单成功!,但发送Email失败!",$link ,'',3000));
				}
			}
		break;
		case 'close':
			if($order['orderStatus'] > 5){
				runFunc('showMsg',array("close订单失败!只有未付款订单才能关闭!",$link ,'',3000));
				exit;
			}else{
				//更新订单
				$orderArray["orderStatus"] = 21;
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("订单close成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
				runFunc('showMsg',array("订单close成功!",$link ,'',3000));
			}
		break;
		case 'finished':
/*			if($order['orderStatus'] != 18){
				runFunc('showMsg',array("finished订单失败!只有已确认订单才能执行此操作!",$link ,'',3000));
				exit;
			}else{*/
				//更新订单
				$orderArray["orderStatus"] = 19;
				$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
				if(!$updateOrderResult){
					runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
					exit;
				}
				//日志记录
				runFunc('makeAdminLog',array("订单finished成功!订单号：".$order["OrderNo"],$user_info[0]['staffId']));
				runFunc('showMsg',array("订单finished成功!",$link ,'',3000));
	/*		}*/
		break;

}


