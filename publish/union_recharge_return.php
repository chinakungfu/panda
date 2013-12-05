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

$order = getRechargeOrderNoSe($_REQUEST["Priv1"]);

$card_type = $order[0]["payment"];

import("core.union.netpayclient");

if($card_type == 9){
	$flag = buildKey("union_key/b2c/PgPubk.key");
}elseif($card_type == 8){
	$flag = buildKey("union_key/card/PgPubk.key");
}
elseif($card_type == 100){
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

	updateRechargerOrderSuccess($priv1);
	addUserBalanceNoSe($order[0]["user_id"],$order[0]["recharge"]);


	$user_info = getStaffInfoByIdNoSe($order[0]["user_id"]);

	$mailArray['userId'] = $order[0]["user_id"];

	$mailArray["BALANCE"] = $user_info[0]["balance"];
	$mailArray["P_BALANCE"] = $user_info[0]["balance"]-$order[0]["recharge"];

	runFunc('sendMail',array($mailArray,"recharge_success"));

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

function updateRechargerOrderSuccess($orderID){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "update cms_publish_recharge_order set status = 2  where id = '{$orderID}'";


	$result = mysql_query($sql);

}

function addUserBalanceNoSe($user_id,$balance){


	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "update cms_member_staff set balance = balance + {$balance} where staffId = '{$user_id}'";

	mysql_query($sql);
}

function getRechargeOrderNoSe($id){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "select * from cms_publish_recharge_order where id = {$id}";

	$result = mysql_query($sql);

	$row[0] = mysql_fetch_array($result);

	return $row;

}
