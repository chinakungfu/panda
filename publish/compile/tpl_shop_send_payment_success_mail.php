<?php import('core.util.RunFunc');

$order_id = $this->_tpl_vars["IN"]["orderID"];
$order = runFunc("getOrder",array($order_id));
$loginUser = runFunc('readSession',array());
$settings = runFunc("getGlobalSetting");
$credit = floor($order["totalAmount"] / $settings[0]["credit_consumption"]);
$mailArray["CREDIT"] = $credit;

$mailArray["orderNo"] = $order["OrderNo"];
$mailArray["userId"] = $loginUser;
$mailArray["order_type"] = "普通订单";
if($order["group_buy"]==1){
	$mailArray["order_type"] = "团购订单";
}
$mailArray["totalAmount"] = $order['totalAmount'];
runFunc('sendMail',array($mailArray,"payment_finished"));
runFunc('sendMail',array($mailArray,"order_admin_notice"));


//第一次购买
$userInfo = runFunc("getUser",array($loginUser));
if($userInfo[0]['invitee'] && $userInfo[0]['firstBuy'] == 1){
	$inviteUserInfo = runFunc("getUser",array($userInfo[0]['invitee']));
	$inviteUserArray['staffId'] = $inviteUserInfo[0]['staffId'];
	$inviteUserArray['balance'] = $inviteUserInfo[0]["balance"] + 50;
	$updateResult = runFunc('adminUpdateUser',array($inviteUserArray));	//充值
	if($updateResult){
		//充值记录
		runFunc("adminMakeRechargeOrder",array(14,$userInfo[0]['invitee'],50,'',$order["OrderNo"],$order["orderID"]));
		//更新购买次数
		$memberArray['staffId'] = $userInfo[0]['staffId'];
		$memberArray['firstBuy'] = 2;
		runFunc('adminUpdateUser',array($memberArray));	
		//更新邀请表
		runFunc('updateInviteStatus',array('pay',$userInfo[0]['email'],$userInfo[0]['invitee']));
		//给邀请人发邮件 
		$inviteMailArray['userId'] = $inviteUserInfo[0]['staffId'];
/*		$inviteMailArray["BALANCE"] = $inviteUserInfo[0]["balance"];
		$inviteMailArray["P_BALANCE"] = $inviteUserInfo[0]["balance"] + 50;*/
		runFunc('sendMail',array($inviteMailArray,"invited_successfully"));
	}
}
header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=pay_success&orderID='.$order_id)));
		