<?php import('core.util.RunFunc');
if($this->_tpl_vars["data"]){

	parse_str($this->_tpl_vars["data"],$fromData);
	$updataArr['userId'] = $fromData['user_id'];
	$updataArr['Mr'] = $fromData['Mr'];
	$updataArr['firstName'] = $fromData['firstName'];
	$updataArr['userId'] = $fromData['user_id'];
	$updataArr['lastName'] = $fromData['lastName'];
	$updataArr['address1'] = $fromData['address1'];
	$updataArr['address2'] = $fromData['address2'];
	$updataArr['city'] = $fromData['city'];
	$updataArr['province'] = $fromData['province'];
	$updataArr['country'] = $fromData['country'];
	$updataArr['email'] = $fromData['email'];
	$updataArr['zipcode'] = $fromData['zip'];
	$updataArr['telephone'] = $fromData['telephone'];
	$updataArr['cellphone'] = $fromData['cellphone'];
	$updataArr['status'] = 1;
	$updataArr['type'] = 'user';	

	$type = $fromData['type'];
	
	if($type == 'insert'){
		$insertAddress = runFunc("createShippingAddress",array($updataArr));		
		if($insertAddress){
			if($fromData['isdefault']){
				runFunc("setDefauleAddress",array($insertAddress,$fromData['user_id']));
				$updataArr['isdefault'] = 1;
			}
			$updataArr['addressId'] = $insertAddress;
			$addressResult = runFunc("getUserAddressByAddressId",array($fromData['user_id'],$insertAddress));
			$updataArr['addressListArr'] = implode('|',$addressResult[0]);
			return $updataArr;
		}else{
			return false;
		}	
	}
	if($type == 'update'){
		
		$addressId = $fromData['addressId'];
		$updateAddress = runFunc("updateShippingAddress",array($addressId,$fromData['user_id'],$updataArr));

		if($updateAddress){	
			if($fromData['isdefault']){
				runFunc("setDefauleAddress",array($addressId,$fromData['user_id']));
				$updataArr['isdefault'] = 1;
			}
			$updataArr['addressId'] = $addressId;				
			$addressResult = runFunc("getUserAddressByAddressId",array($fromData['user_id'],$addressId));
			$updataArr['addressListArr'] = implode('|',$addressResult[0]);			
			return $updataArr;
		}else{
			return false;
		}		
		
	}
	if($type == 'setDufault'){
		$addressId = $fromData['addressId'];
		runFunc("setDefauleAddress",array($addressId,$fromData['user_id']));
	}

}else{
	return false;
}
?>


