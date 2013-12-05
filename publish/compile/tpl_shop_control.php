<?php  import('core.util.RunFunc'); 
	if($this->_tpl_vars["IN"]["signUpType"]=="message_unregist"){
		$sessId = $_COOKIE['sesCoo'];		
		$dbSession = new dbSession();
		$userId= $dbSession->read($sessId);
		runFunc('saveMessages',array($this->_tpl_vars["IN"]["para"],$userId));
		
		
		$mailArray["CONTENT"]=$this->_tpl_vars["IN"]["para"]["content"];
		$mailArray["send_mail"]=$this->_tpl_vars["IN"]["para"]["send_mail"];
		$mailArray["userId"]= runFunc('readSession',array());
		runFunc('sendMail',array($mailArray,"message_help"));
	
		runFunc("notice_page",array("Message Send Successful", "Message Send Successful", "Our customer service will response within 24 hours. ", "shop","shopindex"));
	}

	
	
?>
