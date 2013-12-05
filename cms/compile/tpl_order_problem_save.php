<?php import('core.util.RunFunc');

runFunc("orderProblemSave",array($this->_tpl_vars["IN"]["order_problem"],$this->_tpl_vars["IN"]["orderId"]));


$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderId"]));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("记录交易问题  订单 ".$order["OrderNo"],$this->_tpl_vars["name"]));

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("交易问题保存成功!");
	location.href="'.runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["orderId"]."&type=".$this->_tpl_vars["IN"]["type"])).'"</script>
	</body>
	</html>';