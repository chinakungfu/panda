<?php
import('core.util.RunFunc');
$this->_tpl_vars["name"]=runFunc('readSession',array());

$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["order_id"]));

$coupon = runFunc("getMemberCoupons",array(trim($order["coupons"])));

if($coupon[0]["type"]==1){

	$amount = $order["totalAmount"]+$coupon[0]["money"];
}else{
	$amount = $order["totalAmount"]/$coupon[0]["price_rate"];
}

runFunc("updateOrderAmount",array($order["orderID"],array("totalAmount"=>$amount,"coupons"=>"","coupon_word"=>"")));


runFunc("useMemberCoupons",array($coupon[0]["id"],array("user_id"=>"","used_time"=>"")));


if($this->_tpl_vars["name"]){

 		$pay_link = 'action=shop&method=payment&orderID=';
 	}else{
 	
 		
 		$pay_link = "action=shop&method=orderSubmit&orderID=";
 	}


header("Location:index.php".runFunc('encrypt_url',array($pay_link.$this->_tpl_vars["IN"]["order_id"])));
