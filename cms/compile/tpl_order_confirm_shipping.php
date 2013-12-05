<?php import('core.util.RunFunc');

runFunc("confirmShipping",array($this->_tpl_vars["IN"]["orderId"]));

$order = runFunc("getOrder",array($this->_tpl_vars["IN"]["orderId"]));


$user = runFunc("getStaffInfoByNo",array($order["orderUser"]));
$mailArray["orderNo"] = $order["OrderNo"];
$mailArray["userId"] = $order["orderUser"];
$mailArray["fullName"] = $order["fullName"];
$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));

$mailArray["LINK"] = $site_name . '/publish/index.php'.runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderId"]));
if($order["email"] == $user[0]["email"]){
	$mailArray["mailto"] = $order["email"];
}else{
$mailArray["mailto"] = $order["email"].",".$user[0]["email"];
}
runFunc('sendMail',array($mailArray,"shipping_confirm"));

$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("普通订单 ".$order["OrderNo"]."确认发货",$this->_tpl_vars["name"]));


echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("商品发货确认成功!");
	location.href="'.runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["orderId"]."&type=".$this->_tpl_vars["IN"]["type"])).'"</script>
	</body>
	</html>';