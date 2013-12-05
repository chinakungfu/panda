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
	'query' => "SELECT * FROM cms_publish_phone_order WHERE userID = '{$this->_tpl_vars["name"]}' and id = '{$orderID}'",
	);

	$this->_tpl_vars['orderInfo'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	
	$orderInfo = $this->_tpl_vars['orderInfo']['data'][0];
?>
    <div class="content">
        <div class="register orderSuccess">
            <div class="regtitle">
                <h1>THANK YOU !</h1>
                <h2>YOUR ORDER PAYMENT IS COMPLETE</h2>
            </div>
            <div class="orderSuccessCon" style="margin-bottom:80px;">
           		<p>Please wait 15-30 minutes. You will receive a text message from your mobile service 
provider in chinese when charge success.</p>
				</br>
				<p>If unknown causes of failure from the telephone service provider, we will refund the 
money to your WOW Account. You can check in your <a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=phoneOrderHistroy'));?>">Mobile Phone Charge History</a></p>
                <div class="orderSuccessNav" style="margin-top:60px;">
                	<a class="orderToAccount" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=phoneOrderHistroy'));?>">Mobile Phone Charge History</a>
                </div>
                <div class="clb"></div>
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

