<?php import('core.util.RunFunc');
$type = trim($_REQUEST['type']);
if($type == "userName"){
	$userName = trim($_REQUEST['userName']);
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $params;
	$params = array (
	'action' => "sql",
	'return' => "reguser",
	'query' => "select staffId from cms_member_staff WHERE staffName = '{$userName}' limit 1",
	);
	$this->_tpl_vars['reguser'] = CMS::CMS_sql($params);
	if($this->_tpl_vars['reguser']["data"]["0"]){
		echo $this->_tpl_vars["reguser"]["data"]["0"]["staffId"];
	}else{
		echo 0;
	}
}else if($type == "userEmail"){
	$userEmail = trim($_REQUEST['userEmail']);
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $params;
	$params = array (
	'action' => "sql",
	'return' => "reguser2",
	'query' => "select staffId from cms_member_staff WHERE email = '{$userEmail}' limit 1",
	);
	$this->_tpl_vars['reguser2'] = CMS::CMS_sql($params);
	if($this->_tpl_vars['reguser2']["data"]["0"]["staffId"]){
		echo $this->_tpl_vars["reguser2"]["data"]["0"]["staffId"];
	}else{
		echo 0;
	}
}else if($type == "resetpwdEmail"){
	$passwordEmail = trim($_REQUEST['passwordEmail']);
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $params;
	$params = array (
	'action' => "sql",
	'return' => "resetpwd",
	'query' => "select staffId,email from cms_member_staff WHERE email = '{$passwordEmail}' limit 1",
	);
	$this->_tpl_vars['resetpwd'] = CMS::CMS_sql($params);
	if($this->_tpl_vars['resetpwd']["data"]["0"]["email"]){
		echo 0;
	}else{
		echo $this->_tpl_vars['resetpwd']["data"]["0"]["staffId"];
	}
}else if($type == "login"){
	$staffNo = trim($_REQUEST['staffNo']);
	$password = $_REQUEST['password'];
	$result =runFunc('checkLogin',array($staffNo,$password));
	if ($result){

		if($result[0]["block"] == 1){
				echo -1;
		}
		$this->_tpl_vars["CookieUser"]=runFunc('readCookie',array());
		if ($this->_tpl_vars["CookieUser"]){
			 import('core.apprun.cmsware.CmswareNode');
			 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "updateCoupons",
				'query' => "update cms_member_coupons SET user_id= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE `user_id`= '{$this->_tpl_vars["CookieUser"]}'",
			 );
			$this->_tpl_vars['updateCoupons'] = CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;


			 //import('core.apprun.cmsware.CmswareNode');
			 //import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "updateCart",
				'query' => "update cms_publish_cart SET UserName= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
			 );

			$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;

			 //import('core.apprun.cmsware.CmswareNode');
			 //import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "updateOrder",
				'query' => "update cms_publish_order SET orderUser= '{$this->_tpl_vars["result"]["0"]["staffId"]}' WHERE orderUser= '{$this->_tpl_vars["CookieUser"]}'",
			 );

			$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;



		}
	}
	if($staffNo){
		echo $staffNo;
	}else{
		echo "1";
	}

}

?>
