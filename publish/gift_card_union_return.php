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

$order = getGiftOrderNoSe($_REQUEST["Priv1"]);

$card_type = $order["union_card_type"];

import("core.union.netpayclient");

if($card_type == 1){
	$flag = buildKey("union_key/b2c/PgPubk.key");
}elseif($card_type == 2){
	$flag = buildKey("union_key/card/PgPubk.key");
}
elseif($card_type == 3){
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

	$success_content = "The carrier system maintenance, line connection problems caused, your conduct will not be charged.<br/>Please wait for over a period of time before recharge, or recharge through other payment method.";
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=share&link_method=homePage')));
	
	exit;
}elseif($status == "1001")
{

	updateGiftCardSuccess($priv1);
	$card = getGiftOrderNoSe($priv1);
	
	$mailArray["give_name"] = $card["give_name"];
	$mailArray["give_email"] = $card["give_email"];
	$mailArray["card"] = $card["password"];
	$mailArray['userId'] = $card["user_id"];
	$mailArray["MONEY"] = $card["money"];
	$mailArray["give_message"] = $card["give_message"];
	runFunc('sendMail',array($mailArray,"gift_card"));
	runFunc('sendMail',array($mailArray,"gift_card_maker"));
//	$success_content = "You Friend have received your gift card,and you can check your gift card in you account.";
	//header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Payment Successful&alert_content='.$success_content.'&link_action=share&link_method=homePage')));
		
	//header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=send_payment_success_mail&orderID='.$priv1)));
}

function getStaffInfoByIdNoSe($user_id){
	
$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "select * from cms_member_staff where staffId = {$user_id}";

	$result = mysql_query($sql);

	$row[0] = mysql_fetch_array($result);

	return $row;
	

}

function updateGiftCardSuccess($card_id){
	
	$db_config = $GLOBALS['currentApp']['dbconfig'];
		
		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		
		mysql_select_db($db_config['a0222211743']["dbName"], $con);

		$date = date("Y-m-d H:i:s");
		
		$sql = "update cms_member_gift_card set status = 1 where id = '{$card_id}'";
		

		$result = mysql_query($sql);
		
}


function getGiftOrderNoSe($id){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "select * from cms_member_gift_card where id = {$id}";

	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	return $row;

}
