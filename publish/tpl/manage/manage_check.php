<?php
@session_start();
if($username=readsession()){
	if(!$user=unserialize($_SESSION['qy_member_info'])){
		$sql="select *, groupName+0 `group` from cms_member_staff where staffNo='$username' limit 1";
		$user=TStaticQuery::queryList($GLOBALS['currentApp']['dbaccess'], $sql);
		$user=$user[0];
		$_SESSION['qy_member_info']=serialize($user);
	}
	
	$this->assign('user', $user);
	//$this->_tpl_vars['user'] = $user;
}else{
	echo '<script type="text/javascript">top.location="/login.html";</script>';
	exit;
}
