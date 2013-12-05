<?php

import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());


$circle_id = $this->_tpl_vars["IN"]["circle_id"];


$check = runFunc("checkJoin",array($circle_id,$this->_tpl_vars["name"]));

if(count($check)>0){
	
	runFunc("quitCircle",array($this->_tpl_vars["name"],$circle_id));
	
	$circle_info = runFunc("getCircleById",array($circle_id));

	runFunc("sendSiteMessage",array($circle_info[0]["user_id"],$this->_tpl_vars["name"],"CIRCLE QUIT",$circle_id));
}



header("Location: ".runFunc('encrypt_url',array('action=share&method=circlesMain')));