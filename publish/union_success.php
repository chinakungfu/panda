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
require_once(corepath.'/core/param/param.php');
import('core.controller.Controller');
import('core.util.RunFunc');



$order = getUnionOrderById($_REQUEST["Priv1"]);

$card_type = $order["order_type"];

import("core.union.netpayclient");

if($card_type == 4){
	$flag = buildKey("union_key/b2c/PgPubk.key");
}elseif($card_type == 3){
	$flag = buildKey("union_key/card/PgPubk.key");
}
elseif($card_type == 7){
	$flag = buildKey("union_key/PgPubk.key");
}


if(!$flag) {
echo "导入公钥文件失败！";
exit;
}
$merid = $_REQUEST["merid"];
$orderno = $_REQUEST["orderno"];
$transdate = $_REQUEST["transdate"];
$amount = $_REQUEST["amount"];
$currencycode = $_REQUEST["currencycode"];
$transtype = $_REQUEST["transtype"];
$status = $_REQUEST["status"];
$checkvalue = $_REQUEST["checkvalue"];
$gateId = $_REQUEST["GateId"];
$priv1 = $_REQUEST["Priv1"];
$plain = $merid . $orderno . $amount . $currencycode . $transdate . $transtype . $status . $checkvalue;

$flag = verifyTransResponse($merid, $orderno, $amount, $currencycode, $transdate, $transtype, $status, $checkvalue);

if(!$flag or $status != "1001") {
	
	return false;
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=orderPayFailed&orderID='.$priv1)));
}elseif($status == "1001")
{
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=send_payment_success_mail&orderID='.$priv1)));
}
function updateUnionCartPay($cart_str){
	
	$db_config = $GLOBALS['currentApp']['dbconfig'];
	
	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "update cms_publish_cart set order_item_status = 5 where cartID in ({$cart_str})";

	$result = mysql_query($sql);

}

function updateUnionOrderSuccess($orderID,$payment){
	
	$db_config = $GLOBALS['currentApp']['dbconfig'];
		
		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		
		mysql_select_db($db_config['a0222211743']["dbName"], $con);

		$date = date("Y-m-d H:i:s");
		
		$sql = "update cms_publish_order set orderStatus = 5 ,payTime = '{$date}',pending = 2,payment='{$payment}' where orderID = '{$orderID}'";
		

		$result = mysql_query($sql);
		
}
function addUnionUserCredit($credit,$user_id){
	$db_config = $GLOBALS['currentApp']['dbconfig'];
	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "update cms_member_staff set credits = credits + {$credit} where staffId = '{$user_id}'";

	mysql_query($sql);

}
function  union_getglobalsetting(){


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
			$setting[0]["credit_consumption"] = $row["credit_consumption"];
		}

		mysql_close($con);

		return $setting;
}
function getUnionOrderById($orderID){

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
			$order["totalAmount"] = $row["totalAmount"];
		}
		
		return $order;
}



