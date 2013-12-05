<?php import('core.util.RunFunc'); 

$loginUser = runFunc('readSession',array());
$user_info = runFunc("getShareMemberInfoAllInOne",array($loginUser));
//$member_credits = $user_info[0]["credits"];
$member_credits = (int)$this->_tpl_vars["IN"]['recharge_credits_in'];
$settings =  runFunc("getGlobalSetting");

if($member_credits && $member_credits>=$settings[0]["credit_to_money"]){
	//算出可以兑换多少钱
	$money = floor($member_credits/$settings[0]["credit_to_money"]);
	$credit = $money * $settings[0]["credit_to_money"];
	//更新用户金额和积分
	runFunc("addUserBalance",array($loginUser,$money));
	runFunc("userCredits",array($loginUser,$credit));

	$user_info = runFunc("getShareMemberInfoAllInOne",array($loginUser));
	$mailArray['userId'] = $loginUser;
	$mailArray["P_BALANCE"] = $user_info[0]["balance"]-$money;
	$mailArray["BALANCE"] = $user_info[0]["balance"];
	runFunc("successRechargeOrder",array(5,$loginUser,$money));
	runFunc('sendMail',array($mailArray,"recharge_success"));
	
	header("Location:/publish/index.php".runFunc('encrypt_url',array('action=shop&method=recharge_with_credits_success&balance='.$user_info[0]["balance"].'&credits='.$user_info[0]["credits"])));	
	
/*	$success_content = "Recharge successful,please check your email ".$user_info[0]["email"]." about your account details. Thank you!
<br />For further questions, please contact service@wowshopping.com.cn.";
	header("Location:/publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge successful&alert_content='.$success_content.'&link_action=website&link_method=account')));*/
}else{

$success_content = "Your credits is not enough.";
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=website&link_method=account')));
}