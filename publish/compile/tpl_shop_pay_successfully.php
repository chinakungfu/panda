<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
</head>
<body>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));
	$loginUser = runFunc('readSession',array());
	$user_info = runFunc("getStaffInfoById",array($loginUser));

	if($loginUser == ""){

		$current_user_id =  $tmpUser;
	}else{
		$current_user_id =  $loginUser;
	}
	?>
    <div class="content">
        <div class="register orderSuccess">
            <div class="regtitle">
                <h1>THANK YOU !</h1>
                <h2> YOUR ORDER PAYMENT IS COMPLETE </h2>
                <h3 class="hide">
                	You have got 184 points
                </h3>
            </div>
            <div class="orderSuccessCon">
           		<p>Your order NO.<?php echo $order['OrderNo'];?>. You can review your order in your <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a>.Order confirmation will be emailed to<font color="#5e97ed"> <?php echo $user_info[0]['email'];?></font>.</p>
                <br>
                <p>Wowshopping Customer Services team will now check your order. If any problem occurs i.e payment problems, unclear delivery address, item's out of stock or shipping issues... we will inform you as soon as possible by email or telephone.</p>
                <div class="orderSuccessNav">
                	<a class="orderToAccount" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">View Account Home</a>
                	<a class="orderToAccount hide" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$orderInfo['orderID']));?>">Exchange Your point</a>

                </div>
                <div class="clb"></div>
            </div>
        </div>
    </div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
</body>
</html>