<?php import('core.util.RunFunc');

if( $this->_tpl_vars["IN"]["type"] == "set_default"){


	runFunc("setDefauleAddress",array($this->_tpl_vars["IN"]["addressId"],$this->_tpl_vars["IN"]["userId"]));
}
elseif($this->_tpl_vars["IN"]["type"] == "delete"){

	runFunc("deleteAddressById",array($this->_tpl_vars["IN"]["addressId"],$this->_tpl_vars["IN"]["userId"]));

}
else{

$fullName = $this->_tpl_vars["IN"]["fullName"];
$address1 = $this->_tpl_vars["IN"]["address1"];
$address2 = $this->_tpl_vars["IN"]["address2"];
$country = $this->_tpl_vars["IN"]["country"];
$province = $this->_tpl_vars["IN"]["province"];
$city = $this->_tpl_vars["IN"]["city"];
$zip = $this->_tpl_vars["IN"]["zip"];
$cellphone = $this->_tpl_vars["IN"]["cellphone"];
$telephone = $this->_tpl_vars["IN"]["telephone"];
$email = $this->_tpl_vars["IN"]["email"];
$user_id = $this->_tpl_vars["IN"]["user_id"];
$address_id = $this->_tpl_vars["IN"]["address_id"];
if($address_id!=""){

runFunc("updateShippingAddress",array($address_id,$fullName,$address1,$address2,$country,$province,$city,$zip,$cellphone,$telephone,$email,$user_id,$address_id));

}else{

	$set_default = $this->_tpl_vars["IN"]["set_default"];
runFunc("createShippingAddress",array($fullName,$address1,$address2,$country,$province,$city,$zip,$cellphone,$status,$type,$telephone,$email,$user_id,$set_default));
}
}


if($this->_tpl_vars["IN"]["cartIdStr"]){
	header("Location: ".runFunc('encrypt_url',array("action=shop&method=WOWd2d&cartIdStr=".$this->_tpl_vars["IN"]["cartIdStr"]."&check_type=".$this->_tpl_vars["IN"]["check_type"])));
}else{
	header("Location: ".runFunc('encrypt_url',array("action=shop&method=WOWd2d&check_type=".$this->_tpl_vars["IN"]["check_type"])));
}






?>


