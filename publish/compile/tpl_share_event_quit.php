<?php

import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$event_id = $this->_tpl_vars["IN"]["id"];


$check = runFunc("checkEventBooking",array($event_id,$this->_tpl_vars["name"]));

if(count($check)>0){
	
	runFunc("quitEvent",array($this->_tpl_vars["name"],$event_id));
	
	//$circle_info = runFunc("getCircleById",array($circle_id));

	//runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$this->_tpl_vars["name"],"CIRCLE QUIT",$circle_id));
	
	$event = runFunc("getEvent",array($event_id));

	runFunc("sendSiteMessage",array($event[0]["user_id"],$this->_tpl_vars["name"],"EVENT QUIT",$event_id));
}



header("Location: ".runFunc('encrypt_url',array('action=share&method=eventMain')));