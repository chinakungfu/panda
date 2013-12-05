<?php import('core.util.RunFunc');
	$user_id = $this->_tpl_vars["IN"]["user_id"];
	$user_info = runFunc("getStaffInfoById",array($user_id));
	if($user_info){
		$updataArr['userId'] = $user_id;
		$updataArr['Mr'] = $this->_tpl_vars["IN"]['Mr'];
		$updataArr['firstName'] = $this->_tpl_vars["IN"]['firstName'];
		$updataArr['lastName'] = $this->_tpl_vars["IN"]['lastName'];
		$updataArr['address1'] = $this->_tpl_vars["IN"]["address1"];
		$updataArr['address2'] = $this->_tpl_vars["IN"]["address2"];
		$updataArr['country'] = $this->_tpl_vars["IN"]["country"];
		$updataArr['province'] = $this->_tpl_vars["IN"]["province"];
		$updataArr['city'] = $this->_tpl_vars["IN"]["city"];
		$updataArr['zipcode'] = $this->_tpl_vars["IN"]["zip"];
		$updataArr['cellphone'] = $this->_tpl_vars["IN"]["cellphone"];
		$updataArr['telephone'] = $this->_tpl_vars["IN"]["telephone"];
		//$updataArr['email'] = $user_info[0]["email"];
		$updataArr['set_default'] = 1;
		$updataArr['status'] = 1;
		$updataArr['type'] = 'user';	
			
		$insertAddress = runFunc("createShippingAddress",array($updataArr));
		if($insertAddress){
			header("Location: ".runFunc('encrypt_url',array("action=website&method=addRegAddressToNext")));
		}else{
			header("Location: ".runFunc('encrypt_url',array("action=website&method=addRegAddressToNext")));
		}
	}
?>


