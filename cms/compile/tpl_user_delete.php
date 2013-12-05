<?php
import('core.util.RunFunc');
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}

$user_info = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$uid=runFunc('readSession',array());
if($uid){
runFunc("makeAdminLog",array("删除会员 ".$user_info[0]["staffNo"],$uid));

runFunc(adminDeleteUser,array($this->_tpl_vars["IN"]["id"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=users&type=users&page='.$page)));	
}
