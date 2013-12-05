<?php
import('core.util.RunFunc');

$password = $this->_tpl_vars["IN"]["password"];
if(trim($password) !=""){$memberArray['password'] = md5($password);}
$memberArray['staffNo'] = $this->_tpl_vars["IN"]["staffNo"];
$memberArray['staffName'] = $this->_tpl_vars["IN"]["staffName"];
$memberArray['balance'] = $this->_tpl_vars["IN"]["balance"];
$memberArray['credits'] = $this->_tpl_vars["IN"]["credits"];
$memberArray['block'] = $this->_tpl_vars["IN"]["block"];
$memberArray['staffName'] = $this->_tpl_vars["IN"]["staffName"];
$memberArray['staffId'] = $this->_tpl_vars["IN"]["id"];

$item = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));

if($item[0]["balance"]!=$this->_tpl_vars["IN"]["balance"]){

	$mailArray["BALANCE"] = $this->_tpl_vars["IN"]["balance"];
	$mailArray["P_BALANCE"] = $item[0]["balance"];
	$mailArray["userId"] = $this->_tpl_vars["IN"]["id"];

	$recharge_money = $this->_tpl_vars["IN"]["balance"] - $item[0]["balance"];
	runFunc('sendMail',array($mailArray,"recharge_success"));
	$this->_tpl_vars["name"]=runFunc('readSession',array());

	runFunc("makeAdminLog",array("为 ".$item[0]["staffNo"]." 的账号 充值 ".$recharge_money,$this->_tpl_vars["name"]));	
	runFunc("adminMakeRechargeOrder",array(6,$this->_tpl_vars["IN"]["id"],$recharge_money));
}
if($memberArray['block'] == 1 and $item[0]["block"]==0){

	$mailArray = array("userId"=>$this->_tpl_vars["IN"]["id"]);

	$this->_tpl_vars["name"]=runFunc('readSession',array());
	runFunc("makeAdminLog",array("阻止 ".$item[0]["staffNo"]." 的账号",$this->_tpl_vars["name"]));

	runFunc('sendMail',array($mailArray,"user_block"));

}

if($memberArray['block'] == 0 and $item[0]["block"]==1){

	$mailArray = array("userId"=>$this->_tpl_vars["IN"]["id"]);
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	runFunc("makeAdminLog",array("解除阻止 ".$item[0]["staffNo"]." 的账号",$this->_tpl_vars["name"]));
	runFunc('sendMail',array($mailArray,"user_lifed"));

}


$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("修改 ".$item[0]["staffNo"]." 的账号",$this->_tpl_vars["name"]));
runFunc("adminUpdateUser",array($memberArray));

header("Location: ".runFunc('encrypt_url',array('action=cms&method=user&id='.$this->_tpl_vars["IN"]["id"].'&type=users')));
