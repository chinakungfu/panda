<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$inc_tpl_file=includeFunc("common/header/common_header.tpl");
include($inc_tpl_file);
?>

</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>

	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	?>

<?php 
	$orderID = $this->_tpl_vars["IN"]["orderID"];
	if(!$orderID){
		exit();
	}
?>
<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "orderInfo",
	'query' => "SELECT * FROM cms_publish_order WHERE orderUser = '{$this->_tpl_vars["name"]}' and orderID = '{$orderID}'",
	);

	$this->_tpl_vars['orderInfo'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	
	$orderInfo = $this->_tpl_vars['orderInfo']['data'][0];
?>
    <div class="content">
        <div class="register orderToPay">
            <div class="regtitle">
                <h1>THANK YOU !</h1>
                <h2> ORDER SUBMIT SUCCESSFULLY</h2>
                <h3 style="color:#912b2b;font:bold 14px Arial, Helvetica, sans-serif;text-align:center;">ORDER NO.<?php echo $orderInfo['OrderNo'];?></h3>
            </div>
            <div class="orderToPayCon">
           		<p><span style="font:bold 18px Arial, Helvetica, sans-serif;">We receive your order</span> - We will begin check and processing your order soon. You may not be able to edit or pay your order until the order enters the the Payment acceptble order status.</p>
				<p>If you don’t have any problem with your order, you can continue to payment procedure now.</p>
                <div class="orderToPayNav">

                	<a class="orderToPayBtn" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$orderInfo['orderID']));?>">Continue</a>
                	<a class="orderToAccount" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">View Account Home</a>
                </div>
                <div class="clb"></div>
                <div style="text-align:center;font:normal 12px Arial, Helvetica, sans-serif; margin-top:100px;">By clicking continue, you acknowledge that the terms of WOWshopping <a style="color:#5e97ed;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=terms'));?>" target="_blank">Sales and Refunds</a> will govern your purchase.</div>
            </div>
        </div>   
    </div>	
	<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</div>
</body>
</html>

