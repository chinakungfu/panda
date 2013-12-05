<?php

import('core.util.RunFunc');
if($this->_tpl_vars["IN"]["delstatus"]){
	runFunc("userDeleteOrder",array($this->_tpl_vars["IN"]["orderID"]));
	header("Location:".runFunc('encrypt_url',array('action=website&method=account')));
}
$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["order_id"]));

if($order["orderStatus"]>4){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID='.$this->_tpl_vars["IN"]["order_id"])));
}

$cart_qtys = $_POST["qty"];
$cart_info = $_POST["order_info"];
foreach($cart_qtys as $key=>$cart_qty){
$info = $cart_info[$key];
	runFunc("updateCartDetail",array($cart_qty,$info,$key));
	$cart_array[] = $key;
}

$cart_str = implode(",", $cart_array);

runFunc("updateOrderCartStr",array($cart_str,$this->_tpl_vars["IN"]["order_id"]));



$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["order_id"]));


	$dataArray["fullName"] = $this->_tpl_vars["IN"]["fullName"];
	$dataArray["address1"] = $this->_tpl_vars["IN"]["address1"];
	$dataArray["address2"] = $this->_tpl_vars["IN"]["address2"];
	$dataArray["city"] = $this->_tpl_vars["IN"]["city"];
	$dataArray["state"] =  $this->_tpl_vars["IN"]["state"];
	$dataArray["province"] = $this->_tpl_vars["IN"]["province"];
	$dataArray["zipcode"] = $this->_tpl_vars["IN"]["zipcode"];
	$dataArray["telephone"] = $this->_tpl_vars["IN"]["telephone"];
	$dataArray["cellphone"] = $this->_tpl_vars["IN"]["cellphone"];
	$dataArray["email"] = $this->_tpl_vars["IN"]["email"];

runFunc("updateUserOrderModify",array($order["cartIDstr"],$this->_tpl_vars["IN"]["order_id"],$order["invoice"],$order["group_buy"],$dataArray));

header("Location:".runFunc('encrypt_url',array('action=shop&method=payment&orderID='.$this->_tpl_vars["IN"]["order_id"])));
