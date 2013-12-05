<?php
import('core.util.RunFunc');

$item = runFunc("getManagerPermissionById",array($this->_tpl_vars["IN"]["id"]));

runFunc("deleteManagerPermission",array($this->_tpl_vars["IN"]["id"]));

$uid=runFunc('readSession',array());
runFunc("makeAdminLog",array("删除管理员权限 ".$item[0]["name"],$uid));

header("Location:".runFunc('encrypt_url',array('action=cms&method=manager_permission_list&type=main')));
