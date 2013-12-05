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

$order = getRechargePhoneOrderNoSe($_REQUEST["Priv1"]);

$card_type = $order["paymentType"];

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
		$success_content = "The carrier system maintenance, line connection problems caused, payment failed.<br/>Please wait for over a period of time and pay again.";
		header("Location: /publish/index.php".runFunc('encrypt_url',array('action=website&method=notice&alert_title=Recharge failure&alert_content='.$success_content.'&link_action=website&link_method=index')));
		exit;
}elseif($status == "1001")
{
	updateRechargePhoneSuccess($priv1);
	header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=recharge_with_phone_pay_success&orderID='.$priv1)));
}

function updateRechargePhoneSuccess($order_id){
	
	$db_config = $GLOBALS['currentApp']['dbconfig'];
		
		$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
		
		mysql_select_db($db_config['a0222211743']["dbName"], $con);

		$date = time();
		
		$sql = "update cms_publish_phone_order set orderStatus = 5,payTime='{$date}' where id = '{$order_id}'";

		$result = mysql_query($sql);
}


function getRechargePhoneOrderNoSe($id){

	$db_config = $GLOBALS['currentApp']['dbconfig'];

	$con = mysql_connect("localhost",$db_config['a0222211743']["loginName"],$db_config['a0222211743']["loginPassword"]);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($db_config['a0222211743']["dbName"], $con);


	$sql = "select * from cms_publish_phone_order where id = {$id}";

	$result = mysql_query($sql);

	$row = mysql_fetch_array($result);

	return $row;

}
