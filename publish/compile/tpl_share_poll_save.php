<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$poll=array(
	"name"=>$this->_tpl_vars["IN"]["poll_name"],
	"end_time"=>$this->_tpl_vars["IN"]["close_date"],
	"created"=>date("Y-m-d H:i:s"),
	"user_id"=>$this->_tpl_vars["name"]

);

if($this->_tpl_vars["IN"]["poll_id"]!=""){
	
	runFunc("updatePoll",array($poll,$this->_tpl_vars["IN"]["poll_id"]));
	$poll_id = $this->_tpl_vars["IN"]["poll_id"];
	runFunc("removePollItems",array($poll_id));
	
}else{
	
	$poll_id = runFunc("saveMyPoll",array($poll));
	runFunc("sendFriendNotice",array($this->_tpl_vars["name"],"POLL CREATE",$poll_id));
}




$items =  $_POST["poll_items"];
$poll_item_titles = $_POST["poll_diy_title"];


foreach($items as $key=>$item){

	$poll_item = array(
		"goods_id"=>$item,
		"poll_id"=>$poll_id,
		"title" =>$poll_item_titles[$key]
	);

	runFunc("savePollItem",array($poll_item));
}




header("Location: ".runFunc('encrypt_url',array('action=share&method=PollPage&id='.$poll_id)));