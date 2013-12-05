<?php
import('core.util.RunFunc'); 
$this->_tpl_vars["name"]=runFunc('readSession',array());
if($this->_tpl_vars["name"] ==""){
	header("Location: ".runFunc('encrypt_url',array('action=shop&method=myCart')));
	exit;
}


$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["order_id"]));

if($order["coupons"]!=""){
	exit;
}

$coupon = runFunc("getMemberCoupons",array(trim($this->_tpl_vars["IN"]["coupon_code"])));
$json = array();
$json["error"] = 1;
if(count($coupon)>0){
	
	if($coupon[0]["user_id"] || $coupon[0]["stutas"] == 2){
		//已经被使用
		$json["error"] = 2;
	}elseif($order["order_amount"] < $coupon[0]["order_limit"] and $coupon[0]["order_limit"] > 0){
		//未达到消费金额
		$json["error"] = 3;
		$json["limit"] = $coupon[0]["order_limit"];
		echo json_encode($json);
		exit;
	}else{
		if($coupon[0]["type"]==1){
			//减金额
			$amount = $order["totalAmount"]-$coupon[0]["money"];
			$json["coupon_word"] = $coupon[0]["money"];
		}else{
			//打折
			$amount = $order["totalAmount"]*$coupon[0]["price_rate"];
			//$json["coupon_word"] = ((1 - $coupon[0]["price_rate"])*100)."% discount off";
			$json["coupon_word"] = $order["totalAmount"] - $amount;
		}
		
		runFunc("updateOrderAmount",array($order["orderID"],array("totalAmount"=>$amount,"coupons"=>$this->_tpl_vars["IN"]["coupon_code"],"coupon_word"=>$json["coupon_word"])));
				
		runFunc("useMemberCoupons",array($coupon[0]["id"],array("user_id"=>$this->_tpl_vars["name"],"used_time"=>date("Y-m-d H:i:s"),"status"=>"2")));
		
		$json["error"] = 0;
		$json["order_current_amount"] = $amount;
		$json["code"] = $this->_tpl_vars["IN"]["coupon_code"];

	}
	
}else{
	
	$json["error"] = "1";
}


echo json_encode($json);

