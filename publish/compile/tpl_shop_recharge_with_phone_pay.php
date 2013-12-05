<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title></title>
</head>
<body>
	<?php import('core.util.RunFunc');
	$loginUser = runFunc('readSession',array());
if ($loginUser==""){
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		exit;
 } 

	//生成订单号
	$dataArray["orderNo"] = runFunc("getPhoneOrderNo");
	$dataArray["userID"] = $loginUser;
	$dataArray["submitTime"] = time();
	$dataArray["orderStatus"] = 4;
	$dataArray["rechargeMoney"] = $this->_tpl_vars["IN"]["recharge_money"];	//充值金额
	$dataArray["service_fee"] = $dataArray["rechargeMoney"] * 0.00;		//总服务费
	$dataArray["rechargeTotal"] = $dataArray["rechargeMoney"] + $dataArray["service_fee"];	//付款总额	
	$dataArray["paymentType"] = $this->_tpl_vars["IN"]["recharge_pay_type"];		//付款方式
	$dataArray["phoneNum"] = $this->_tpl_vars["IN"]["recharge_phone_num"];		//充值号码

	$money_array=array(50,100,200,500);
	if(!in_array($dataArray["rechargeMoney"], $money_array)){	
	echo '<script type="text/javascript">
		alert("Please select correct Amount");
		location.href="/publish/index.php'.runFunc('encrypt_url',array('action=shop&method=recharge_with_phone')).'"
		</script>';
		exit;
	}	
	
	foreach ($dataArray as $key => $val)
	{
		$str_field .= $key.",";
		$str_value .= ":".$key.",";
	}
	$str_field = substr($str_field,0,-1);
	$str_value = substr($str_value,0,-1);

	//生成订单
	$sql = "insert into cms_publish_phone_order (".$str_field.") values (".$str_value.")";
	$order_id = TStaticQuery::insertdata($GLOBALS['currentApp']['dbaccess'],$sql,$dataArray);
	/*  2:recharge 1:paypal 3:card */

	switch($dataArray["paymentType"]){
		case 1:
			runFunc("recharge_phone_by_paypal",array($dataArray["rechargeTotal"],$order_id));
			break;
		case 2:
			
			$result = runFunc("pay_balance",array($dataArray["rechargeTotal"],$loginUser));

			if($result ==0){
				echo '<script type="text/javascript">
		alert("Whoops! Your account balance is not enough, recharge or choose other payment methods");
		location.href="/publish/index.php'.runFunc('encrypt_url',array('action=shop&method=recharge_with_phone')).'"
						</script>';
			}else{
				//更新状态
				runFunc("rechargePhone_pay_success",array($order_id,$loginUser));
				$mailArray = array();
				$mailArray["orderNo"] = $dataArray["orderNo"];
				$mailArray["userId"] = $loginUser;
				$mailArray["order_type"] = "电话充值订单";
				$mailArray["totalAmount"] = $dataArray["rechargeTotal"];
				$mailArray["phone_num"] = $dataArray["phoneNum"];
				//更新商品状态
				//runFunc('sendMail',array($mailArray,"payment_finished"));
				runFunc('sendMail',array($mailArray,"phone_order_admin_notice"));
				header("Location: ".runFunc('encrypt_url',array('action=shop&method=recharge_with_phone_pay_success&orderID='.$order_id)));
			}
			break;
		case 3:
		case 4:
			runFunc("recharge_phone_by_card",array($dataArray["paymentType"],$dataArray["rechargeTotal"],$order_id));
			break;
	}

	?>

</body>
</html>
