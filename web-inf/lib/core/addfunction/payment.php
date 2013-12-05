<?php
import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
import('core.paypal.paypalfunctions');

function makeGiftCard($user_id,$money,$give_name,$give_email,$give_message,$card_type=null){

	$card_password = $user_id.$money.time();

	$card_password = md5($card_password);

	if($give_message == "input your message here"){
		$give_message = "";
	}

	$dataArray["password"] = $card_password;
	$dataArray["money"] = $money;
	$dataArray["user_id"] = $user_id;
	$dataArray["give_name"] = $give_name;
	$dataArray["give_email"] = $give_email;
	$dataArray["created"] = date("Y-m-d H:i:s");
	$dataArray["union_card_type"] = $card_type;
	$dataArray["give_message"] = $give_message;
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);
	$sql = "insert into cms_member_gift_card (".$str_field.") values (".$str_value.")";
	$card_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);

	return $card_id;
}

function gift_by_card($card_type,$money, $card_id){

	$settings = runFunc("getGlobalSetting");
		import("core.union.netpayclient");

		$t_str = mb_substr(time(),strlen(time())-7,strlen(time()),'utf-8');
		$action = "https://payment.ChinaPay.com/pay/TransGet";
		if($card_type == 1){
			$merid = buildKey("union_key/b2c/MerPrK_808080231802097_20121008151909.key");
			$ordid = date("Y")."02097".$t_str;
		}elseif($card_type == 2){
			$money = round($money * (1+$settings[0]["union_fee"]),2);
			$merid = buildKey("union_key/card/MerPrK_808080233202118_20121008151945.key");
			$ordid = date("Y")."02118".$t_str;
		}
		elseif($card_type == 3){
			$action = "http://payment-test.chinapay.com/pay/TransGet";
			$merid = buildKey("union_key/MerPrK_808080101292481_20121012132412.key");
			$ordid = date("Y")."92481".$t_str;
		}
		else{
			echo "ERROR!";
			exit;
		}

		$amount = padstr($money*100,12);

		$curyid = "156";

		$transdate = date('Ymd');

		$transtype = "0001";

		$priv1 = $card_id;

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
					<input  type=hidden  name="BgRetUrl"  value="'.$site_name.'/publish/gift_card_union_return.php"/>
					<input  type=hidden  name="PageRetUrl"  value="'.$site_name.'/publish/gift_card_union_success.php"/>
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
}
function recharge_phone_by_card($paymentType,$money, $card_id){

	$settings = runFunc("getGlobalSetting");
		import("core.union.netpayclient");

		$t_str = mb_substr(time(),strlen(time())-7,strlen(time()),'utf-8');
		$action = "https://payment.ChinaPay.com/pay/TransGet";
		if($paymentType == 3){
			$money = round($money * (1+$settings[0]["union_fee"]),2);
			$merid = buildKey("union_key/card/MerPrK_808080233202118_20121008151945.key");
			$ordid = date("Y")."02118".$t_str;
		}elseif($paymentType == 4){
			$merid = buildKey("union_key/b2c/MerPrK_808080231802097_20121008151909.key");
			$ordid = date("Y")."02097".$t_str;
		}else{
			echo "ERROR!";
			exit;
		}

		$amount = padstr($money*100,12);

		$curyid = "156";

		$transdate = date('Ymd');

		$transtype = "0001";

		$priv1 = $card_id;

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
					<input  type=hidden  name="BgRetUrl"  value="'.$site_name.'/publish/recharge_phone_union_return.php"/>
					<input  type=hidden  name="PageRetUrl"  value="'.$site_name.'/publish/recharge_phone_union_success.php"/>
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
}

function recharge_by_card($payment,$money, $order_id){
	$settings = runFunc("getGlobalSetting");
		import("core.union.netpayclient");
		$t_str = mb_substr(time(),strlen(time())-7,strlen(time()),'utf-8');
		$action = "https://payment.ChinaPay.com/pay/TransGet";
		if($payment == 9){
			$merid = buildKey("union_key/b2c/MerPrK_808080231802097_20121008151909.key");
			$ordid = date("Y")."02097".$t_str;
		}elseif($payment == 8){
			$money = round($money * (1+$settings[0]["union_fee"]),2);
			$merid = buildKey("union_key/card/MerPrK_808080233202118_20121008151945.key");
			$ordid = date("Y")."02118".$t_str;
		}
		elseif($payment == 100){
			$action = "http://payment-test.chinapay.com/pay/TransGet";
			$merid = buildKey("union_key/MerPrK_808080101292481_20121012132412.key");
			$ordid = date("Y")."92481".$t_str;
		}
		else{
			$success_content = "The carrier system maintenance, line connection problems caused, your conduct will not be charged.<br/>Please wait for over a period of time before recharge, or recharge through other payment method.";
			header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=share&link_method=homePage')));
			exit;
		}
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
					<input  type=hidden  name="BgRetUrl"  value="'.$site_name.'/publish/union_recharge_return.php"/>
					<input  type=hidden  name="PageRetUrl"  value="'.$site_name.'/publish/union_recharge_success.php"/>
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


}

function gift_by_paypal($money,$card_id){

	$settings = runFunc("getGlobalSetting");
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

	$paymentAmount = round($money/$settings[0]["USD_rate"] * (1+$settings[0]["paypal_fee"]),2);
	$shipToName = 0;
	$shipToStreet = 0;
	$shipToStreet2 = 0;
	$shipToCity = 0;
	$shipToState = 0;
	$shipToCountryCode = "US"; // Please refer to the PayPal country codes in the API documentation
	$shipToZip = 0;
	$phoneNum =0;
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	$itemName = "WOW GIFT CARD PAY";


	$returnURL = $site_name."/publish/gift_card_paypal_return.php";

	$cancelURL = $settings[0]["cancelURL"];

	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallMarkExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------
	$resArray = CallMarkExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL,
	$cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
	$shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum, $card_id ,$itemName
	);


	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['reshash']=$token;
		RedirectToPayPal ( $token );
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}

function recharge_by_paypal($money,$orderID){

	$settings = runFunc("getGlobalSetting");


	$paymentAmount = round($money/$settings[0]["USD_rate"] * (1+$settings[0]["paypal_fee"]),2);
	$shipToName = 0;
	$shipToStreet = 0;
	$shipToStreet2 = 0;
	$shipToCity = 0;
	$shipToState = 0;
	$shipToCountryCode = "US"; // Please refer to the PayPal country codes in the API documentation
	$shipToZip = 0;
	$phoneNum =0;
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	$itemName = "WOW RECHARGE PAY";


	$returnURL = $settings[0]["recharge_returnURL"];

	$cancelURL = $settings[0]["cancelURL"];

	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallMarkExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------
	$resArray = CallMarkExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL,
	$cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
	$shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum, $orderID ,$itemName
	);


	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['reshash']=$token;
		RedirectToPayPal ( $token );
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}
function recharge_phone_by_paypal($money,$orderID){

	$settings = runFunc("getGlobalSetting");
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

	$paymentAmount = round($money/$settings[0]["USD_rate"] * (1+$settings[0]["paypal_fee"]),2);
	$shipToName = 0;
	$shipToStreet = 0;
	$shipToStreet2 = 0;
	$shipToCity = 0;
	$shipToState = 0;
	$shipToCountryCode = "US"; // Please refer to the PayPal country codes in the API documentation
	$shipToZip = 0;
	$phoneNum =0;
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	$itemName = "WOW RECHARGE PHONE PAY";
	$returnURL = $site_name."/publish/recharge_phone_paypal_return.php";

	$cancelURL = $settings[0]["cancelURL"];
	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallMarkExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------
	$resArray = CallMarkExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL,
	$cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
	$shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum, $orderID ,$itemName
	);

	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['reshash']=$token;
		RedirectToPayPal ( $token );
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}

function pay_by_paypal($order_id){
$settings = getGlobalSetting();

$order = getOrder($order_id);

	$paymentAmount = round($order["totalAmount"]/$settings[0]["USD_rate"] * (1+$settings[0]["paypal_fee"]),2);
	$shipToName = $order["fullName"];
	$shipToStreet = $order["address1"];
	$shipToStreet2 = $order["address2"];
	$shipToCity = $order["city"];
	$shipToState = $order["province"];
	$shipToCountryCode = "US"; // Please refer to the PayPal country codes in the API documentation
	$shipToZip = $order["zipcode"];
	$phoneNum = $order["cellphone"];
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	$itemName = "WOW ORDER PAY";

	$items = getOrderItemByCartStr($order["cartIDstr"]);

	$orderID = $order["orderID"];
	$returnURL = $settings[0]["returnURL"];

	$cancelURL = $settings[0]["cancelURL"];

	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallMarkExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------
	$resArray = CallMarkExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL,
	$cancelURL, $shipToName, $shipToStreet, $shipToCity, $shipToState,
	$shipToCountryCode, $shipToZip, $shipToStreet2, $phoneNum, $orderID ,$itemName
	);


	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		$_SESSION['reshash']=$token;
		RedirectToPayPal ( $token );
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}

function check_balance($need_pay,$user_id){

	$sql = "select count(*) as count from cms_member_staff where balance >= '{$need_pay}' and staffId = '{$user_id}'";

	$result = TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result[0];

}

function pay_balance($need_pay,$user_id){

	$check = check_balance($need_pay,$user_id);

	if($check["count"]==0){

		$result = 0;
		return $result;
	}

	$sql = "update cms_member_staff set balance = balance - {$need_pay} where staffId = '{$user_id}'";

	$result = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);

	return $result;

}

function pay_success($order_id,$user_id){

	$date = date("Y-m-d H:i:s");

	$sql = "update cms_publish_order set orderStatus = 5,payTime = '{$date}',pending = 2 where orderID = '{$order_id}' and orderUser = '{$user_id}'";

	$results = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}
function rechargePhone_pay_success($order_id,$user_id){

	$date = time();

	$sql = "update cms_publish_phone_order set orderStatus = 5,payTime = '{$date}' where id = '{$order_id}' and userID = '{$user_id}'";

	$results = TStaticQuery::updatedata($GLOBALS['currentApp']['dbaccess'],$sql);
}
function adminMakeRechargeOrder($payment,$user_id,$money,$card_type=null,$OrderNo=null,$orderID=0){

	$created = date("Y-m-d H:i:s");
	$sql ="insert into cms_publish_recharge_order (payment,user_id, recharge,created,card_type,status,orderNo,orderID) values('{$payment}','{$user_id}','{$money}','{$created}','{$card_type}',2,'{$OrderNo}','{$orderID}') ";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
function makeRechargeOrder($payment,$user_id,$money,$card_type=null){

	$created = date("Y-m-d H:i:s");
	$sql ="insert into cms_publish_recharge_order (payment,user_id, recharge,created,card_type) values('{$payment}','{$user_id}','{$money}','{$created}','{$card_type}') ";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}

function successRechargeOrder($payment,$user_id,$money){
	$created = date("Y-m-d H:i:s");
	$sql ="insert into cms_publish_recharge_order (payment,user_id, recharge,created,status) values('{$payment}','{$user_id}','{$money}','{$created}',2) ";
	$result = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql);
	return $result;
}
