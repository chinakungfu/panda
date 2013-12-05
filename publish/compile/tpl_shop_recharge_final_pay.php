<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title>
</head>
<body>
	
<?php import('core.util.RunFunc'); 

$payment = $this->_tpl_vars["IN"]["payment"];

$user_id = runFunc('readSession',array());

$money = $this->_tpl_vars["IN"]["money"];

$settings =  runFunc("getGlobalSetting");

switch($payment){
	case 1:	
		if($money<$settings[0]["limit_recharge"]){
		echo '<script type="text/javascript">
			alert("Recharge Minimum '.$settings[0]["limit_recharge"].' RMB.");
			location.href="/publish/index.php'.runFunc('encrypt_url',array('action=website&method=index')).'"
			</script>';
			
			exit;
		}	
		$order_id = runFunc("makeRechargeOrder",array($payment,$user_id,$money));
		runFunc("recharge_by_paypal",array($money,$order_id,1));		
		break;
		
	case 8:
	case 9:
		
		if($money<$settings[0]["limit_recharge"]){		
			echo '<script type="text/javascript">
				alert("Recharge Minimum '.$settings[0]["limit_recharge"].' RMB.");
				location.href="/publish/index.php'.runFunc('encrypt_url',array('action=website&method=index')).'"
				</script>';		
				exit;
		}
		
		$order_id = runFunc("makeRechargeOrder",array($payment,$user_id,$money));
		
		runFunc("recharge_by_card",array($payment,$money,$order_id));
}
?>

</body>
</html>