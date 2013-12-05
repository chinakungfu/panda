<?php import('core.util.RunFunc');


$type = $this->_tpl_vars["IN"]["type"];


if($type == "confirm"){
	$member_one = runFunc('readSession',array());
	$member_two = $this->_tpl_vars["IN"]["user_id"];

	runFunc("deleteFriend",array($member_one,$member_two));
	runFunc("confirmAddFriend",array($member_one,$member_two));

	$message_id = $this->_tpl_vars["IN"]["message_id"];


	runFunc("readMessage",array($message_id));

	runFunc("sendSiteMessage",array($member_one,$member_two,"FRIEND ADDED"));
	runFunc("sendSiteMessage",array($member_two,$member_one,"FRIEND ADDED"));
}else{

	$message_id = $this->_tpl_vars["IN"]["message_id"];


	runFunc("readMessage",array($message_id));
}

header("Location: ".runFunc('encrypt_url',array('action=share&method=messageAll')));