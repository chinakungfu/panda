<?php import('core.util.RunFunc'); ?>

<?php

$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

$this->_tpl_vars["mailArr"]["verifyLink"] = "";

$order = runFunc("getOrder",array($this->_tpl_vars["IN"]["orderId"]));

$carts = runFunc('getOrderCarts',array($order["cartIDstr"]));

$user_id = $order["orderUser"];

$user_info =runFunc('getStaffInfoById',array($order["orderUser"]));

$email = $user_info[0]["staffNo"];

$item_box = "";

$mailArray = array();

$mailArray["userId"] = $order["orderUser"];

$mailArray["orderNo"] = $order["OrderNo"];

$mailArray["order_user"] = $order["fullName"];

$mailArray["mailto"] = $user_info["email"];

$this->_tpl_vars["siteName"]= runFunc('getGlobalModelVar',array('Site_Domain'));

$result = runFunc("sendMail",array($mailArray,"order_remind",));

$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("订单 ".$order["OrderNo"]."提醒付款",$this->_tpl_vars["name"]));

if($result){

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("提醒邮件发送成功!");
	location.href="'.runFunc('encrypt_url',array("action=cms&method=order&id=".$order["orderID"]."&type=".$this->_tpl_vars["IN"]["type"])).'"</script>
	</body>
	</html>';
}

?>