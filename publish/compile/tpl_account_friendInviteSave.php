<?php 
	import('core.util.RunFunc'); 
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	$userInfo = runFunc('getUser',array($this->_tpl_vars["name"]));
	if($this->_tpl_vars["name"]){
		$inviteEmail = $this->_tpl_vars["IN"]['inviteEmail'];
		if(is_array($inviteEmail)){
			foreach($inviteEmail as $k =>$v){
				$dataArray["userID"] = $this->_tpl_vars["name"];
				$dataArray["submitTime"] = time();
				$dataArray["status"] = 1;
				$dataArray["inviteMoney"] = 50;
				$dataArray["inviteEmail"] = $v;	
				$inviteID = runFunc('addInviteEmail',array($dataArray));
				if($inviteID){
					$mailArray["mail_address"] = $v;
					$mailArray["userId"] = $this->_tpl_vars["name"];
					$mailArray["friend_name"] = $v;	
					$mailArray["invite_link"] = $userInfo[0]['inviteUrl'];		
					runFunc('sendMail',array($mailArray,"invite_mail"));				
				}
			}
			runFunc("notice_page",array("Invite Successful", "Invite Successful", "Thank you for supporting WOWSHOPPING", "account","friendInvite"));			
		}else{
			$mailArray["mail_address"] = $inviteEmail;
			$mailArray["userId"] = $this->_tpl_vars["name"];	
			$mailArray["friend_name"] = $inviteEmail;	
			$mailArray["invite_link"] = $userInfo[0]['inviteUrl'];						
			runFunc('sendMail',array($mailArray,"invite_mail"));
			runFunc("notice_page",array("Invite Again Successful", "Invite Again Successful", "Thank you for supporting WOWSHOPPING", "account","friendInvite"));							
		}

	}