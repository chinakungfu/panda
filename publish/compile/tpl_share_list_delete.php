<?php import('core.util.RunFunc'); 
	$result = runFunc("deleteMemberShareList",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["user_id"]));
	header("Location: ".runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$this->_tpl_vars["IN"]["user_id"])));
?>