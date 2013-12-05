<?php
import('core.util.RunFunc');

$cart = runFunc("getCartPayMoney",array($this->_tpl_vars["IN"]["cart_id"]));
$settings = runFunc("adminGetGlobalSetting");


if($cart[0]["sell_way"]==1){
	$service_fee = $cart[0]["itemPrice"] * $settings[0]['service_fee'] * $cart[0]["price_rate"];

}else{

	$service_fee = $cart[0]["itemPrice"] * $settings[0]['service_fee'] ;
}

if($cart[0]["tax"]==1){

	echo $money = ($cart[0]["itemFreight"] + $cart[0]["itemPrice"] + $service_fee)*(1+$settings[0]["tax_rate"]);
}else{

	$money = ($cart[0]["itemFreight"] + $cart[0]["itemPrice"] + $service_fee);
}

runFunc("payBackMoney",array($money,$this->_tpl_vars["IN"]["user_id"]));

runFunc("updateCartPayStatus",array($this->_tpl_vars["IN"]["cart_id"]));


$user_info = runFunc("getUser",array($this->_tpl_vars["IN"]["user_id"]));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array($cart[0]["item_name"]." 团购退款  用户 ".$user_info[0]["staffNo"],$this->_tpl_vars["name"]));


header("Location: ".runFunc('encrypt_url',array('action=cms&method=groupFailed&type=orders')));