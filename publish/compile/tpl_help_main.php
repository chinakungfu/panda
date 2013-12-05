<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
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
	<div class="box">
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

<div class="contentHelp clb">
	<h2>Help Center</h2>      
        <div class="contHelp">
            <dl class="contBorder">
                <dt>Account & Member</dt>
                <div class="one">
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=accountRegistration'));?>">Account Registration</a></dd>
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=rechargeAccount'));?>">Recharge Account</a></dd>
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=credits'));?>">Points & E-coupons</a></dd>
                </div>
            </dl>
            <dl class="contBorder">
                <dt>Order & Payment</dt>
                <div class="two">
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=orderingWalkthrough'));?>">Ordering Walkthrough</a></dd>
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=paymentWalkthrough'));?>">Payment Walkthrough</a></dd>
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=faq'));?>">FAQ</a></dd>
                </div>
            </dl>
            <dl class="contBorder">
                <dt>Services</dt>
                <div class="three">
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=service'));?>">Service & Shipping Fee</a></dd>
                <!--<dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=shopping'));?>">Shipping Fee & Tax</a></dd>-->
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=refunds'));?>">Refunds & Returns</a></dd>
                </div>
            </dl>
            <dl>
                <dt>Others</dt>
                <div class="four">
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=conversionCharts'));?>">Conversion Charts</a></dd>
                <dd><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=exchangeRate'));?>">Exchange Rate</a></dd>
                </div>
            </dl>            
            
        </div>
        <div class="helpMinFooter">
            <dl>
                <dt>Contact Us <a href="http://plus.google.com/109014735129552208549"><img src="../../skin/images/google.png"></a> <a href="http://www.facebook.com/WOWSHOPPING.COM.CN"><img src="../../skin/images/facebook.png"></a> <a href="http://www.linkedin.com/pub/wowshopping-china/7a/887/2b3"><img src="../../skin/images/linkedin.png"></a> <a href="http://pinterest.com/wowshopping/"><img src="../../skin/images/pinterest.png"></a></dt>
                <dd>9:00 AM to 5:30 PM   MON - FRI</dd>
                <dd>Email:    service@wowshopping.com.cn</dd>
                <dd>Office:   Block 76-2, Orchard Manors, Xing Ming Street, SIP SuZhou, China</dd>
            </dl>         
            
        </div>
</div>

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>
		</div>
	</body>
</html>