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
	?>
    <div class="content">
        <div class="register returnSuccess">
            <div class="regtitle">
                <h1 style="font-size:24px;">Submit Successfully</h1>
                <h2 style="font-size:12px;color:#adaeab;"> Order No <?php echo $order['OrderNo'];?> </h2>
                <h3 style="text-align:center;font-size:12px;color:#adaeab;">Item ID <?php echo $this->_tpl_vars["IN"]["cartID"];?></h3>
            </div>
            <div style="width:975px;margin:0 auto; padding-top:80px;font:normal 14px Arial, Helvetica, sans-serif;color:#333; line-height:30px;text-align:center;">
           		<p>We received your request, we will check and reply withing 24hours.</p>
                <p>Please wait for the guidance from our customer service to begin return process</p>
                <p>You can find status in your order detail.</p>
                <div style="text-align:right;margin-top:60px;padding-right:50px;">
                	<a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">View Account Home</a>&nbsp;&nbsp;
                	<a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$this->_tpl_vars["IN"]["orderID"]));?>">Order Detail</a>

                </div>
            </div>
        </div>
    </div>
    
	<div class="itemRequest cartRequest"  style="height:250px;">
		<div class="itemRequestTop" style="height:253px;">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>How to return items after I submit this application?</h2>
        	<p>After we check your request,We will send you the sellers address information by e-mail. You can then 
send the item back to the seller. In the case of a wrong item shipped, the seller will pay for the shipping. 
If you ordered the wrong item, the shipping cost is at your expense.  The correct item will be shipped again 
by the seller to you, or you will receive a refund.</p>

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