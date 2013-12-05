<?php
import('core.util.RunFunc');


runFunc("adminUserVerify",array($this->_tpl_vars["IN"]["id"]));

$mailArray= array(
	"userId"=>$this->_tpl_vars["IN"]["id"]
);

$mailArray["verify_link"] ='/publish/index.php' . runFunc('encrypt_url',array('action=website&method=validateUser&staffId='.$this->_tpl_vars["IN"]["id"]));

runFunc('sendMail',array($mailArray,"user_verify"));

$item = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("手动激活 ".$item[0]["staffNo"]." 的账号",$this->_tpl_vars["name"]));


header("Location: ".runFunc('encrypt_url',array('action=cms&method=user&id='.$this->_tpl_vars["IN"]["id"].'&type=users')));