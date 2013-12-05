<?php import('core.util.RunFunc');

if($this->_tpl_vars["IN"]["order_type"]!="GROUPBUY"){
	$g = false;
	$link = runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["id"]."&type=".$this->_tpl_vars["IN"]["type"]));
}else{
	$g = true;
	$link = runFunc('encrypt_url',array("action=cms&method=groupBuyOrderItem&order_id=".$this->_tpl_vars["IN"]["id"]."&type=orders"));
}

runFunc('deleteCart',array($this->_tpl_vars["IN"]["delete_cart"],$this->_tpl_vars["IN"]["all_cart"],$this->_tpl_vars["IN"]["id"],$g));

$cart= runFunc("getOrderCartStrByOrderId",array($this->_tpl_vars["IN"]["id"]));


$amount = runFunc("makeOrderAmout",array($cart["cartIDstr"]));
$freight = runFunc("makeOrderFreight",array($cart["cartIDstr"]));


runFunc("makeOrderAmoutAgain",array($this->_tpl_vars["IN"]["id"],$amount["amount"],$freight["amount"]));

if($this->_tpl_vars["IN"]["order_type"]!="GROUPBUY"){

	$link = runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["id"]."&type=".$this->_tpl_vars["IN"]["type"]));
}else{
	$link = runFunc('encrypt_url',array("action=cms&method=groupBuyOrderItem&order_id=".$this->_tpl_vars["IN"]["id"]."&type=orders"));
}


echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("订单信息更新成功!");
	location.href="'.$link.'"</script>
	</body>
	</html>';