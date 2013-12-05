<?php
import('core.util.RunFunc');

$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["id"]));

$good = runFunc('getCatrGoods',array($this->_tpl_vars["IN"]["goods_id"]));

$pay_back_money = $this->_tpl_vars["IN"]["pay_back_money"];

$pay_back_info =  $this->_tpl_vars["IN"]["pay_back_info"];

$pay_back_message = $this->_tpl_vars["IN"]["pay_back_message"];

$settings = runFunc("adminGetGlobalSetting");

$credit = floor($pay_back_money / $settings[0]["credit_consumption"]);

$user = runFunc("getUser",array($order["orderUser"]));

if(($user[0]["credits"] - $credit)<=0){
$credit = $user[0]["credits"];
}
$mailArray = array();
//原来金额
$mailArray["previousBalance"] = $user[0]["balance"];

runFunc("normalCartPayback",array($this->_tpl_vars["IN"]["cart"],$pay_back_money,$pay_back_info,$pay_back_message)); //更新单个cart
runFunc("markOrderReturns",array($this->_tpl_vars["IN"]["id"]));		//更新ORDER
runFunc("addUserBalanceByAdmin",array($pay_back_money,$order["orderUser"]));	//修改用户资料
runFunc("takeUserCredit",array($credit,$order["orderUser"]));
$this->_tpl_vars["name"]=runFunc('readSession',array());
runFunc("makeAdminLog",array("订单退款 订单号：".$order["OrderNo"].",退款商品：".$good["goodsTitleCN"].",金额：".$pay_back_money,$this->_tpl_vars["name"]));
//获取现有金额
$user2 = runFunc("getUser",array($order["orderUser"]));
$mailArray["currentBalance"] = $user2[0]["balance"];
//增加邮件模版参数

$mailArray["userId"] = $order["orderUser"];

$mailArray["orderNo"] = $order["OrderNo"];

$mailArray["order_user"] = $order["fullName"];

$mailArray["PAY_BACK_MESSAGE"] = $pay_back_message;

$mailArray["good_name"] = $good["goodsTitleCN"];

$mailArray["goodsImg"] = $good["goodsImgURL1"];

$mailArray["goodsURL"] = $good["goodsURL"];

$mailArray["PAY_BACK_MONEY"] = $pay_back_money;
//增加退款记录(hutu,2013.01.27)
runFunc("adminMakeRechargeOrder",array(7,$mailArray["userId"],$pay_back_money));

$result = runFunc("sendMail",array($mailArray,"normal_order_cart_pay_back",));

$link = runFunc('encrypt_url',array("action=cms&method=order&id=".$this->_tpl_vars["IN"]["id"]."&type=".$this->_tpl_vars["IN"]["type"]));

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>操作成功</title>
	</head>
	<body>
		<script type="text/javascript">alert("操作成功!");
	location.href="'.$link.'"</script>
	</body>
	</html>';