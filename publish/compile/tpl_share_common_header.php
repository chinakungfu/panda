<?php import('core.util.RunFunc');



if($this->_tpl_vars["IN"]["user_id"]!=""){
	
	$user_id = $this->_tpl_vars["IN"]["user_id"];
}else{
	
	$user_id = $this->_tpl_vars["name"];
}

//****************************select profile****************************************

$user_info = runFunc("getShareMemberInfoAllInOne",array($user_id));

?>




