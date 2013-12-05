
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
$give_name = $this->_tpl_vars["IN"]["give_name"];
$give_email = $this->_tpl_vars["IN"]["give_email"];
$give_message = nl2br($this->_tpl_vars["IN"]["gift_card_message"]);
$settings =  runFunc("getGlobalSetting");
$money_array=array(500,1000,2000);

switch($payment){

	case 1:
		
		if(!in_array($money, $money_array)){
		
				
		echo '<script type="text/javascript">
			alert("Please select correct gift card");
			location.href="index.php'.runFunc('encrypt_url',array('action=share&method=homePage')).'"
			</script>';
			
			exit;
		}
		
		$card_id = runFunc("makeGiftCard",array($user_id,$money,$give_name,$give_email,$give_message));

		runFunc("gift_by_paypal",array($money,$card_id));
		
		break;
		
	case 3:
		
		if(!in_array($money, $money_array)){
		
		echo '<script type="text/javascript">
			alert("Please select correct gift card");
			location.href="index.php'.runFunc('encrypt_url',array('action=share&method=homePage')).'"
			</script>';
			
			exit;
		}
		$card_type = $this->_tpl_vars["IN"]["card_type"];
		
		$card_id = runFunc("makeGiftCard",array($user_id,$money,$give_name,$give_email,$give_message,$card_type));
		
		runFunc("gift_by_card",array($card_type,$money,$card_id));

}
?>

</body>
</html>