<?php import('core.util.RunFunc');


$this->_tpl_vars["name"] = runFunc('readSession',array());
$user_id = $this->_tpl_vars["IN"]["user_id"];
$content = $this->_tpl_vars["IN"]["content"];
if($content == "Send some messages to he or she.(80 words limit)"){
	$content = "";
}


$mailArray["userId"] = $this->_tpl_vars["name"];

$mailArray["friendId"] = $user_id;
$d_name = "";
$user_info = runFunc("getShareMemberInfoAllInOne",array($user_id));
if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
if($user_info[0]["first_name"]!=""){$d_name .= $user_info[0]["first_name"]." ";} $d_name .= trim($user_info[0]["last_name"]);
elseif($user_info[0]["show_nick"]==1):
$d_name .= $user_info["0"]["staffName"];
else:
$d_name .= $user_info["0"]["staffNo"];
endif;
$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
$mailArray["friend_name"] = $d_name;
$mailArray["friend_mail"] = $user_info[0]["email"];

$e_name = "";
$user_info = runFunc("getShareMemberInfoAllInOne",array($this->_tpl_vars["name"]));
if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):
if($user_info[0]["first_name"]!=""){$e_name .= $user_info[0]["first_name"]." ";} $e_name .= trim($user_info[0]["last_name"]);
elseif($user_info[0]["show_nick"]==1):
$e_name .= $user_info["0"]["staffName"];
else:
$e_name .= $user_info["0"]["staffNo"];
endif;

$message_id = runFunc("sendSiteMessage",array($user_id,$this->_tpl_vars["name"],"FRIEND REQUEST","",$content));

$mailArray["my_name"] = $e_name;
$mailArray["my_link"] = $site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$this->_tpl_vars["name"]));

$avatar = "../publish/avatar/".$user_info["0"]["user_id"]."_thumb.".$user_info["0"]["headImageUrl"];
if(!file_exists($avatar)){
	$avatar = $site_name."/skin/images/pic.jpg";
}else{
	$avatar = $site_name."/publish/avatar/".$user_info["0"]["user_id"]."_thumb.".$user_info["0"]["headImageUrl"];
}
$mailArray["friend_avatar"] = $avatar;
$mailArray["request_content"] =  $content;
$mailArray["confirm_link"] = $site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=confirm&message_id='.$message_id.'&user_id='.$this->_tpl_vars["name"]));
$mailArray["refuse_link"] = $site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=refuse&message_id='.$message_id.'&user_id='.$this->_tpl_vars["name"]));

runFunc('sendMail',array($mailArray,"friend_request"));