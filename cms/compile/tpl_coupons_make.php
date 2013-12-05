<?php
import('core.util.RunFunc'); 
$settings = runFunc("adminGetGlobalSetting");
$coupons = array(
	"type" =>$this->_tpl_vars["IN"]["type"],
	"end_time" =>$this->_tpl_vars["IN"]["end_time"],
	"order_limit" =>$this->_tpl_vars["IN"]["order_limit"],
	"created" =>date("Y-m-d H:i:s"),
);
$make_num = $this->_tpl_vars["IN"]["make_num"];
$key =  $settings[0]["code_key"];


if($coupons["type"] == 1){
	
	$coupons["money"] = $this->_tpl_vars["IN"]["money"];
	for($i=1;$i<=$make_num;$i++){
		$coupons["code"] = md5(time().$key.$i);

		runFunc("makeCoupons",array($coupons));
		
	}
}

if($coupons["type"] == 2){

$coupons["price_rate"] = $this->_tpl_vars["IN"]["price_rate"];
	for($i=1;$i<=$make_num;$i++){
		$coupons["code"] = md5(time().$key.$i);
		
		runFunc("makeCoupons",array($coupons));
		
	}
}
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("生成了".$this->_tpl_vars["IN"]["make_num"]."张 优惠券",$this->_tpl_vars["name"]));
header("Location:".runFunc('encrypt_url',array('action=cms&method=coupons&type=users')));
