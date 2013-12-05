<?php
import('core.util.RunFunc');


$vote = array(
	"item_id" => $this->_tpl_vars["IN"]["item_id"],
	"user_id" => $this->_tpl_vars["IN"]["user_id"],
	"created" => date("Y-m-d H:i:s")
);

$item_name = $this->_tpl_vars["IN"]["item_name"];

if(strlen($item_name)> 20){
	$current_item_name =  mb_substr($item_name,0,20,'utf-8')."...";
}else{
	$current_item_name = $item_name;
}

$vote_id = runFunc("votePollItem",array($vote));

$items = runFunc("getPollItemsVoteCount",array($this->_tpl_vars["IN"]["poll_id"]));

$poll = runFunc("getPoll",array($this->_tpl_vars["IN"]["poll_id"]));


$items[0]["current_title"] = $current_item_name;
$items[0]["vote_id"] = $vote_id;



runFunc("sendSiteMessage",array($poll["user_id"],$this->_tpl_vars["IN"]["user_id"],"POLL VOTED",$this->_tpl_vars["IN"]["poll_id"]));


echo json_encode($items);