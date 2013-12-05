<?php import('core.util.RunFunc');
	
$dataArray = array(
	"service_fee"=>$this->_tpl_vars["IN"]["service_fee"],
	"freight"=>$this->_tpl_vars["IN"]["freight"],
	"tax_rate"=>$this->_tpl_vars["IN"]["tax_rate"],
	"USD_rate"=>$this->_tpl_vars["IN"]["USD_rate"],
	"paypal_fee"=>$this->_tpl_vars["IN"]["paypal_fee"],
	"union_fee"=>$this->_tpl_vars["IN"]["union_fee"],
	"limit_recharge"=>$this->_tpl_vars["IN"]["limit_recharge"],
	"credit_consumption"=>$this->_tpl_vars["IN"]["credit_consumption"],
	"credit_to_money"=>$this->_tpl_vars["IN"]["credit_to_money"],
	"order_notice_mail"=>$this->_tpl_vars["IN"]["order_notice_mail"]
);

runFunc("updateMainSettings",array($dataArray));

$this->_tpl_vars["name"]=runFunc('readSession',array());

runFunc("makeAdminLog",array("更改服务设置",$this->_tpl_vars["name"]));

header("Location:".runFunc('encrypt_url',array('action=cms&method=main_settings&type=main')));