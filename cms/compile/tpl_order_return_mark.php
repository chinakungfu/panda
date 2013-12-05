<?php import('core.util.RunFunc');
runFunc("markOrderReturns",array($this->_tpl_vars["IN"]["orderId"]));

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("操作成功!");
	location.href="'.runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["orderId"]."&type=orders")).'"</script>
	</body>
	</html>';

?>