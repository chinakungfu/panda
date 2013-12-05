<?php import('core.util.RunFunc');
$user_id = $this->_tpl_vars["name"];
//****************************select profile****************************************
$user_info = runFunc("getShareMemberInfoAllInOne",array($user_id));
?>
<?php $avatar = "../publish/avatar/".$user_info["0"]["staffId"]."_thumb.".$user_info["0"]["headImageUrl"];?>



