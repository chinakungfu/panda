<?php
import('core.util.RunFunc');


runFunc(adminDeleteUser,array($this->_tpl_vars["IN"]["id"]));

$user_info = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$uid=runFunc('readSession',array());
runFunc("makeAdminLog",array("删除管理员 ".$user_info[0]["staffNo"],$uid));

header("Location:".runFunc('encrypt_url',array('action=cms&method=managers&type=main')));