<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title></title>
</head>
<body>
	<?php import('core.util.RunFunc');
	$loginUser = runFunc('readSession',array());
	$payment = $this->_tpl_vars["IN"]["payment"];
	$order_id = $this->_tpl_vars["IN"]["order"];
	$order_info = runFunc("getOrderInfoById",array($order_id));
	$order = runFunc("getOrder",array($order_id));
	$settings = runFunc("getGlobalSetting");
	if($order["orderStatus"]>4){

		echo '<script type="text/javascript">
			alert("You have paid for this order already.");
			location.href="index.php'.runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$order_id)).'"
			</script>';
		exit;
	}

	/*  2:recharge 1:paypal 3:card */

	switch($payment){
		case 1:
			runFunc("pay_by_paypal",array($order_id));
			break;
		case 2:
			
			$result = runFunc("pay_balance",array($order_info["totalAmount"],$loginUser));
			$credit = floor($order_info["totalAmount"] / $settings[0]["credit_consumption"]);

			if($result ==0){
				echo '<script type="text/javascript">
		alert("Whoops! Your account balance is not enough, recharge or choose other payment methods");
		location.href="index.php'.runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$order_id)).'"
						</script>';
			}else{

				$mailArray = array();
				$mailArray["orderNo"] = $order["OrderNo"];
				$mailArray["userId"] = $loginUser;
				//更新状态
				runFunc("pay_success",array($order_id,$loginUser));
				
				$mailArray["order_type"] = "普通订单";
				if($order["group_buy"]==1){
					$carts = runFunc("getOrderItemByCartStr",array($order["cartIDstr"]));
					foreach($carts as $cart){

						if($cart["event_id"]>0){

							runFunc("bookingEvent",array($cart["event_id"],$order["orderUser"]));

							$event = runFunc("getEvent",array($cart["event_id"]));

							runFunc("sendSiteMessage",array($event[0]["user_id"],$order["orderUser"],"EVENT BOOKING",$cart["event_id"]));
						}
					}

					$mailArray["order_type"] = "团购订单";
				}
				$mailArray["totalAmount"] = $order_info['totalAmount'];
				$mailArray["CREDIT"] = $credit;
				runFunc("markOrderPayment",array($payment,$order_id));
				//更新商品状态
				runFunc("updateBlanceCartPay",array($order["cartIDstr"]));
				runFunc('sendMail',array($mailArray,"payment_finished"));
				runFunc('sendMail',array($mailArray,"order_admin_notice"));
				runFunc("addUserCredit",array($credit,$loginUser));
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
						$inviteMailArray["BALANCE"] = $inviteUserInfo[0]["balance"];
						$inviteMailArray["P_BALANCE"] = $inviteUserInfo[0]["balance"] + 50;
						runFunc('sendMail',array($inviteMailArray,"invited_successfully"));
					}
				}	
				header("Location: ".runFunc('encrypt_url',array('action=shop&method=pay_success&orderID='.$order_id)));
			}
			break;
		case 3:
		case 4:
			$money = $order["totalAmount"];
			import("core.union.netpayclient");
			$t_str = mb_substr(time(),strlen(time())-7,strlen(time()),'utf-8');
			$action = "https://payment.ChinaPay.com/pay/TransGet";
			if($payment == 3){
				$money = round($order_info["totalAmount"] * (1+$settings[0]["union_fee"]),2);
				$merid = buildKey("union_key/card/MerPrK_808080233202118_20121008151945.key");
				$ordid = date("Y")."02118".$t_str;	
			}else if($payment == 4){
				$merid = buildKey("union_key/b2c/MerPrK_808080231802097_20121008151909.key");
				$ordid = date("Y")."02097".$t_str;				
			}
			runFunc("setUnionCheck",array($payment,$order_id));	
			$amount = padstr($money*100,12);

			$curyid = "156";

			$transdate = date('Ymd');

			$transtype = "0001";

			$priv1 = $order_id;

			$chkvalue = signOrder($merid, $ordid, $amount, $curyid, $transdate, $transtype);

			$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

			$html = '<form id="union_pay" action="'.$action.'"  METHOD=POST>
					<input  type=hidden  name="MerId"  value="'.$merid.'"/>
					<input  type=hidden  name="OrdId"  value="'.$ordid.'"/>
					<input  type=hidden  name="TransAmt"  value="'.$amount.'"/>
					<input  type=hidden  name="CuryId"  value="'.$curyid.'"/>
							<input  type=hidden  name="TransDate"  value="'.$transdate.'"/>
							<input  type=hidden  name="TransType"  value="'.$transtype.'"/>
							<input  type=hidden  name="Version"  value="20040916"/>
							<input  type=hidden  name="BgRetUrl"  value="'.$site_name.'/publish/union_return.php"/>
									<input  type=hidden  name="PageRetUrl"  value="'.$site_name.'/publish/union_success.php"/>
									<input  type=hidden  name="GateId"  value="">
									<input  type=hidden  name="Priv1"  value="'.$priv1.'">
									<input  type=hidden  name="ChkValue"  value="'.$chkvalue.'">
											</form>
											<script type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></script>
											<script type="text/javascript">

											$(function(){

												$("#union_pay").submit();

											});
											</script>
											Your order payment is processing, do not close this window!
											';
			echo $html;
			break;								
		case 7:	//test

			$money = $order["totalAmount"];
			$order = runFunc("getOrderInfoById",array($order_id));

			import("core.union.netpayclient");

			$card_type =  $this->_tpl_vars["IN"]["card_type"];

			$t_str = mb_substr(time(),strlen(time())-7,strlen(time()),'utf-8');
			$action = "https://payment.ChinaPay.com/pay/TransGet";
			if($card_type == 1){
				$merid = buildKey("union_key/b2c/MerPrK_808080231802097_20121008151909.key");
				$ordid = date("Y")."02097".$t_str;
			}elseif($card_type == 2){
				$money = round($order["totalAmount"] * (1+$settings[0]["union_fee"]),2);
				$merid = buildKey("union_key/card/MerPrK_808080233202118_20121008151945.key");
				$ordid = date("Y")."02118".$t_str;
			}
			elseif($card_type == 3){
				$action = "http://payment-test.chinapay.com/pay/TransGet";
				$merid = buildKey("union_key/MerPrK_808080101292481_20121012132412.key");
				$ordid = date("Y")."92481".$t_str;
			}
			else{

				header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=newPayment&orderID=' .$order_id)));
			}

			
			runFunc("setUnionCheck",array($card_type,$order_id));

			$amount = padstr($money*100,12);

			$curyid = "156";

			$transdate = date('Ymd');

			$transtype = "0001";

			$priv1 = $order_id;

			$chkvalue = signOrder($merid, $ordid, $amount, $curyid, $transdate, $transtype);

			$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

			$html = '<form id="union_pay" action="'.$action.'"  METHOD=POST>
					<input  type=hidden  name="MerId"  value="'.$merid.'"/>
					<input  type=hidden  name="OrdId"  value="'.$ordid.'"/>
					<input  type=hidden  name="TransAmt"  value="'.$amount.'"/>
					<input  type=hidden  name="CuryId"  value="'.$curyid.'"/>
							<input  type=hidden  name="TransDate"  value="'.$transdate.'"/>
							<input  type=hidden  name="TransType"  value="'.$transtype.'"/>
							<input  type=hidden  name="Version"  value="20040916"/>
							<input  type=hidden  name="BgRetUrl"  value="'.$site_name.'/publish/union_return.php"/>
									<input  type=hidden  name="PageRetUrl"  value="'.$site_name.'/publish/union_success.php"/>
									<input  type=hidden  name="GateId"  value="">
									<input  type=hidden  name="Priv1"  value="'.$priv1.'">
									<input  type=hidden  name="ChkValue"  value="'.$chkvalue.'">
											</form>
											<script type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></script>
											<script type="text/javascript">

											$(function(){

												$("#union_pay").submit();

											});
											</script>
											Your order payment is processing, do not close this window!
											';
			echo $html;
			break;

	}

	?>

</body>
</html>
