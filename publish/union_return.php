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
	//header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=orderPayFailed&orderID='.$priv1)));
}elseif($status == "1001")
{
	updateUnionOrderSuccess($priv1,$card_type);
	updateUnionCartPay($order["cartIDstr"]);
	//bookUnionOrderItemByCartStr($order["cartIDstr"]);
	$settings = union_getglobalsetting();
	$credit = floor($order["totalAmount"] / $settings[0]["credit_consumption"]);
	addUnionUserCredit($credit,$order["user_id"]);	
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

		return $setting;
}

function bookUnionOrderItemByCartStr($cart_str){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select * from cms_publish_cart where cartID in ({$cart_str})";

	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result)){

		if($row["event_id"]>0){

			UnionBookingEvent($row["event_id"],$row["UserName"]);

			$event = UnionGetEvent($row["event_id"]);

			UnionEventMessage($event["user_id"],$row["UserName"],"EVENT BOOKING",$row["event_id"]);
		}
	}


}

function UnionEventMessage($to,$from,$type,$about_id){

	$mailArray['userId'] = $to;

	$user_info = getUnionShareMemberInfoAllInOne($from);
	if($user_info["real_name"]==1 and ($user_info["first_name"]!="" or $user_info["last_name"] !="")):
	if($user_info["first_name"]!=""){$e_name .= $user_info["first_name"]." ";} $e_name .= trim($user_info["last_name"]);
	elseif($user_info["show_nick"]==1):
	$e_name .= $user_info["staffName"];
	else:
	$e_name .= $user_info["staffNo"];
	endif;

	$mailArray["from"] = $e_name;

	$event = UnionGetEvent($about_id);

	if(strlen($event["name"])> 30){
		$title =  mb_substr($event["name"],0,20,'utf-8')."...";
	}else{
		$title = $event["name"];
	}

	$mailArray["sub"] = " booked your event:".$title;

	$mailArray["to_link"] = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));
	$mailArray["comment_content"] = "";
	runFunc('sendMail',array($mailArray,"comment_notice"));


}

function getUnionShareMemberInfoAllInOne($staffId){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select * from  cms_member_staff as a left join cms_profile as b on a.staffId =b.user_id where a.staffId = {$staffId}";

	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	return $row;


}

function UnionGetEvent($id){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$sql = "select a.*,b.headImageUrl from cms_share_event as a left join cms_member_staff as b on a.user_id = b.staffId where id = '{$id}'";

	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	return $row;
}

function UnionBookingEvent($id,$user_id){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);

	$date = date("Y-m-d H:i:s");
	$sql = "insert into cms_share_event_member (user_id,event_id,book_date) values('{$user_id}','{$id}','{$date}')";

	mysql_query($sql);
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



