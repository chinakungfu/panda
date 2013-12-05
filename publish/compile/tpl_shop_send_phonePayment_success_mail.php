<?php import('core.util.RunFunc');

$order_id = $this->_tpl_vars["IN"]["orderID"];
$orderInfo = runFunc("getPhoneOrder",array($order_id));
$mailArray = array();
$mailArray["orderNo"] = $orderInfo["orderNo"];
$mailArray["userId"] = $orderInfo["userID"];
$mailArray["order_type"] = "电话充值订单";
$mailArray["totalAmount"] = $orderInfo["rechargeTotal"];
$mailArray["phone_num"] = $orderInfo["phoneNum"];
runFunc('sendMail',array($mailArray,"phone_order_admin_notice"));

header("Location: /publish/index.php".runFunc('encrypt_url',array('action=shop&method=recharge_with_phone_pay_success&orderID='.$order_id)));
		