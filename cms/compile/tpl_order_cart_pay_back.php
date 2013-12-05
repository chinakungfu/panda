<?php import('core.util.RunFunc');?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php
	$userInfo = runFunc('getUser',array($this->_tpl_vars["name"]));
	$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderID"]));
	$link = runFunc('encrypt_url',array("action=cms&method=order&orderID=".$order['orderID']));
	if($order['order_return'] != '1' || $order['orderStatus'] < 5 || $order['orderStatus'] > 18){
		runFunc('showMsg',array("退款失败!这不是待退款订单,或者是未付款订单,或者是已完成订单!",$link ,'',3000));
		exit;
	}
	$settings = runFunc('adminGetGlobalSetting');
	$amount = runFunc('makeOrderAmout',array($order['cartIDstr']));//小总价
	$refundAmount = $amount["refundAmount"]; //总退款金额
	if(!$refundAmount){
		runFunc('showMsg',array("退款失败!退款金额不能为0!",$link ,'',3000));
		exit;
	}	
	
	$credit = floor($refundAmount / $settings[0]["credit_consumption"]);
	$user = runFunc('getUser',array($order['orderUser']));
	if(($user[0]["credits"] - $credit)<=0){
		$credit = $user[0]["credits"];
	}
	
	//更新订单
	$orderArray["refundTime"] = time();
	$orderArray["order_return"] = 2;
	$orderArray["refundAmount"] = $refundAmount;
	//$orderArray["orderStatus"] = 17;
	$orderArray["refunder"] = $userInfo[0]["staffNo"];
	
	
	$updateOrderResult = runFunc('updateOrderStatus',array($order['orderID'],$orderArray));
	if(!$updateOrderResult){
		runFunc('showMsg',array("更新订单失败!",$link ,'',3000));
		exit;
	}	
	
	//加钱
	runFunc('addUserBalanceByAdmin',array($refundAmount,$order['orderUser']));
	//减积分
	runFunc('takeUserCredit',array($credit,$order['orderUser']));	
	//日志记录
	runFunc('makeAdminLog',array("订单退款 订单号：".$order["OrderNo"].",金额：".$refundAmount,$userInfo[0]["staffId"]));
	
	$mailArray = array();
	//原来金额
	$mailArray["previousBalance"] = $user[0]["balance"];
	//获取现有金额
	$user2 = runFunc('getUser',array($order['orderUser']));
	$mailArray["currentBalance"] = $user2[0]["balance"];
	//增加邮件模版参数
	$mailArray["userId"] = $order["orderUser"];
	$mailArray["orderNo"] = $order["OrderNo"];
	if(!$user2[0]["staffName"]){
		$mailArray["order_user"] = $user2[0]["staffNo"];
	}else{
		$mailArray["order_user"] = $user2[0]["staffName"];
	}

	//$mailArray["PAY_BACK_MESSAGE"] = $pay_back_message;
	//$mailArray["good_name"] = $good["goodsTitleCN"];
	//$mailArray["goodsImg"] = $good["goodsImgURL1"];
	//$mailArray["goodsURL"] = $good["goodsURL"];
	//$mailArray["PAY_BACK_MONEY"] = $pay_back_money;

	//增加退款记录(hutu,2013.01.27)
	runFunc('adminMakeRechargeOrder',array(7,$mailArray["userId"],$refundAmount,'',$order["OrderNo"],$order["orderID"]));
	//发送邮件
	$result = runFunc('sendMail',array($mailArray,"order_refund"));
	if($result){
		runFunc('showMsg',array("退款成功",$link ,'',3000));
	}else{
		runFunc('showMsg',array("退款成功,但发送Email失败!",$link ,'',3000));
	}
