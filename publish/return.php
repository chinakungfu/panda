<?php
require_once('publish_applparam.php');
require_once('publish_mvcconfig.php');
require_once('publish_appAjax.php');
$app_dir = str_replace('\\','/',realpath(dirname(__FILE__)));
$tempAppDir = substr($app_dir,0,strripos($app_dir,'/'));
$core_dir=$tempAppDir.'/web-inf/lib';
if (!defined('corepath'))
{
	define('corepath',$core_dir);
}
if (!defined('apppath'))
{
	define('apppath',$app_dir);
}

require_once(corepath.'/coreconfig/public_gloablparam.php');
require_once(corepath.'/coreconfig/public_func.php');
require_once(corepath.'/coreconfig/public_htmltag.php');
require_once(corepath.'/coreconfig/public_logictag.php');
require_once(corepath.'/coreconfig/public_dbconfig.php');
require_once(corepath.'/coreconfig/public_tableconfig.php');
require_once(corepath.'/coreconfig/public_appconfig.php');
//载入核心函数
require_once(corepath.'/core/incfunc.php');
//include(apppath.'config.php');

import('core.controller.Controller');
import('core.util.RunFunc');

$token = "";

if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];
}
// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.
if ( $token != "" )
{
	require_once('paypalfunctions.php');
	/*
	'------------------------------------
	' Calls the GetExpressCheckoutDetails API call
	'
	' The GetShippingDetails function is defined in PayPalFunctions.jsp
	' included at the top of this file.
	'-------------------------------------------------
	*/
	$resArray = GetShippingDetails( $token );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING")
	{
		/*
		' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review
		' page
		*/
		$email 				= $resArray["EMAIL"]; // ' Email address of payer.
		$payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
		$payerStatus		= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
		$salutation			= $resArray["SALUTATION"]; // ' Payer's salutation.
		$firstName			= $resArray["FIRSTNAME"]; // ' Payer's first name.
		$middleName			= $resArray["MIDDLENAME"]; // ' Payer's middle name.
		$lastName			= $resArray["LASTNAME"]; // ' Payer's last name.
		$suffix				= $resArray["SUFFIX"]; // ' Payer's suffix.
		$cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
		$business			= $resArray["BUSINESS"]; // ' Payer's business name.
		$shipToName			= $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
		$shipToStreet		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
		$shipToStreet2		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET2"]; // ' Second street address.
		$shipToCity			= $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
		$shipToState		= $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
		$shipToCntryCode	= $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code.
		$shipToZip			= $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
		$addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal
		$invoiceNumber		= $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
		$phonNumber			= $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one.

		$resConfirmArray = ConfirmPayment ( $resArray["AMT"] );
		if($resConfirmArray["PAYMENTINFO_0_PAYMENTSTATUS"]=="Completed"){
			updatePaypalOrderSuccess($resConfirmArray["PAYMENTINFO_0_AMT"],$resArray["PAYMENTREQUEST_0_INVNUM"]);
			$order = getPaypalOrderById($resArray["PAYMENTREQUEST_0_INVNUM"]);
			updatePaypalCartPay($order["cartIDstr"]);
			$settings = paypal_getglobalsetting();
			$credit = floor($order["totalAmount"] / $settings[0]["credit_consumption"]);
			addPaypalUserCredit($credit,$order["orderUser"]);
			header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=send_payment_success_mail&orderID='.$resArray["PAYMENTREQUEST_0_INVNUM"])));
		}
		else{
			header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=orderPayFailed&orderID='.$resArray["PAYMENTREQUEST_0_INVNUM"])));
		}
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}

function addPaypalUserCredit($credit,$user_id){
	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "update cms_member_staff set credits = credits + {$credit} where staffId = '{$user_id}'";

	mysql_query($sql);

}

function updatePaypalCartPay($cart_str){

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$date = date("Y-m-d H:i:s");

	$sql = "update cms_publish_cart set order_item_status = 5 where cartID in ({$cart_str})";


	$result = mysql_query($sql);

}

function getPaypalOrderById($orderID){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select * from cms_publish_order where orderID = '{$orderID}'";

	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){

		$order["order_type"] = $row["union_pay_check"];
		$order["user_id"] = $row["orderUser"];
		$order["orderNo"] = $row["OrderNo"];
		$order["cartIDstr"] = $row["cartIDstr"];
	}

	return $order;
}

function  paypal_getglobalsetting(){


		$db_config = $GLOBALS['currentApp']['dbconfig'];

		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db($db_config['a0222211743']["dbName"], $con);


		$sql = "select * from cms_website_global_setting";

		$result = mysql_query($sql);

		$setting = array();

		while($row = mysql_fetch_array($result)){

			$setting[0]["API_UserName"] = $row["API_UserName"];
			$setting[0]["API_Password"] = $row["API_Password"];
			$setting[0]["API_Signature"] = $row["API_Signature"];
			$setting[0]["SandboxFlag"] = $row["SandboxFlag"];
		}

		mysql_close($con);

		return $setting;
}

function updatePaypalOrderSuccess($paypal_pay,$orderID){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db($db_config['a0222211743']["dbName"], $con);

		$date = date("Y-m-d H:i:s");

		$sql = "update cms_publish_order set orderStatus = 5 ,payTime = '{$date}',payment = 1,paypal_pay = '{$paypal_pay}' where orderID = '{$orderID}'";


		$result = mysql_query($sql);

}

