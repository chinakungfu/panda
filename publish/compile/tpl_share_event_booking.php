<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());

$id = $this->_tpl_vars["IN"]["id"];
$check = runFunc("checkEventBooking",array($id,$this->_tpl_vars["name"]));
if(count($check)>0){
	
	exit;
}


runFunc("bookingEvent",array($id,$this->_tpl_vars["name"]));

$event = runFunc("getEvent",array($id));

runFunc("sendSiteMessage",array($event[0]["user_id"],$this->_tpl_vars["name"],"EVENT BOOKING",$id));

$member_count = runFunc("getEventMember",array($id,10,true));

$json = array(
	"count" => $member_count[0]["count"]
);


echo json_encode($json);