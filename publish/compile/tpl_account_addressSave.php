<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
	<?php 
		$updataArr['userId'] = $this->_tpl_vars["name"];
		$updataArr['Mr'] = $this->_tpl_vars["IN"]['Mr'];
		$updataArr['firstName'] = $this->_tpl_vars["IN"]['firstName'];
		$updataArr['lastName'] = $this->_tpl_vars["IN"]['lastName'];
		$updataArr['address1'] = $this->_tpl_vars["IN"]['address1'];
		$updataArr['address2'] = $this->_tpl_vars["IN"]['address2'];
		$updataArr['city'] = $this->_tpl_vars["IN"]['city'];
		$updataArr['province'] = $this->_tpl_vars["IN"]['province'];
		$updataArr['country'] = $this->_tpl_vars["IN"]['country'];
		$updataArr['email'] = $this->_tpl_vars["IN"]['email'];
		$updataArr['zipcode'] = $this->_tpl_vars["IN"]['zip'];
		$updataArr['telephone'] = $this->_tpl_vars["IN"]['telephone'];
		$updataArr['cellphone'] = $this->_tpl_vars["IN"]['cellphone'];
		$updataArr['status'] = 1;
		$updataArr['type'] = 'user';	
	
		$type = $this->_tpl_vars["IN"]['type'];
		
		if($type == 'insert'){
			$insertAddress = runFunc("createShippingAddress",array($updataArr));		
			if($insertAddress){
				if($this->_tpl_vars["IN"]['isdefault']){
					runFunc("setDefauleAddress",array($insertAddress,$updataArr['userId']));
				}
				header("Location: ".runFunc('encrypt_url',array("action=account&method=address")));
			}else{
				header("Location: ".runFunc('encrypt_url',array("action=account&method=addressCreate")));
			}	
		}

		if($type == 'update'){
			$addressId = $this->_tpl_vars["IN"]['addressId'];
			$updateAddress = runFunc("updateShippingAddress",array($addressId,$updataArr['userId'],$updataArr));
			if($updateAddress){
				if($this->_tpl_vars["IN"]['isdefault']){
					runFunc("setDefauleAddress",array($addressId,$updataArr['userId']));
				}			
				header("Location: ".runFunc('encrypt_url',array("action=account&method=address")));
			}else{
				header("Location: ".runFunc('encrypt_url',array("action=account&method=addressEdit&addressID=".$addressId)));
			}
		}
		if($type == 'delete'){

			$addressId = $this->_tpl_vars["IN"]['addressID'];		
			$updateAddress = runFunc("deleteAddressById",array($addressId,$updataArr['userId']));	
			header("Location: ".runFunc('encrypt_url',array("action=account&method=address")));
		}		
		
		if($type == 'setDufault'){
			$addressId = $this->_tpl_vars["IN"]['addressID'];
			runFunc("setDefauleAddress",array($addressId,$updataArr['userId']));
			header("Location: ".runFunc('encrypt_url',array("action=account&method=address")));
		}
		
	?>
<?php }?>

