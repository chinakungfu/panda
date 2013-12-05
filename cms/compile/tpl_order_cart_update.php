<?php import('core.util.RunFunc');

runFunc('updateCart',array($this->_tpl_vars["IN"]["cartID"],$this->_tpl_vars["IN"]["ItemQTY"],$this->_tpl_vars["IN"]["itemFreight"],$this->_tpl_vars["IN"]["itemPrice"]));

$cart= runFunc("getOrderCartStrByOrderId",array($this->_tpl_vars["IN"]["orderId"]));


$amount = runFunc("makeOrderAmout",array($cart["cartIDstr"]));
$freight = runFunc("makeOrderFreight",array($cart["cartIDstr"]));


runFunc("makeOrderAmoutAgain",array($this->_tpl_vars["IN"]["orderId"],$amount["amount"],$freight["amount"]));



if($this->_tpl_vars["IN"]["order_type"]!="GROUP BUY"){

	$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderId"]));
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	runFunc("makeAdminLog",array("更新 普通订单 ".$order["OrderNo"],$this->_tpl_vars["name"]));
	$link = runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["orderId"]."&type=".$this->_tpl_vars["IN"]["type"]));
}else{
	$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderId"]));
	$this->_tpl_vars["name"]=runFunc('readSession',array());
	runFunc("makeAdminLog",array("更新 团购订单 ".$order["OrderNo"],$this->_tpl_vars["name"]));
	$link = runFunc('encrypt_url',array("action=cms&method=groupBuyOrderItem&order_id=".$this->_tpl_vars["IN"]["orderId"]."&type=orders"));
}
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("商品信息更新成功!");
	location.href="'.$link.'"</script>
	</body>
	</html>';

