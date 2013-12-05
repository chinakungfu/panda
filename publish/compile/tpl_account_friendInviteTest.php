<?php import('core.util.RunFunc');?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php 
	$inviteEmail = $this->_tpl_vars["IN"]['inviteEmail'];
	//检测是否已注册
	$result = runFunc('checkInviteEmail',array($inviteEmail));
	echo json_encode($result);