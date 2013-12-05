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
<div class="box">	
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<div class="contentHelp clb">
    <div class="navHelp">
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Order & Payment
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Payment Walkthrough</h3>
        <div>
        	<h4>Fees and costs breakdown</h4>
            <div class="conList">    
            	<ol style="list-style:decimal">
                	<li>Total fees = Item price + domestic delivery fee + service fee. Any international delivery fees (if requested) will be 
     
        added at a later stage.
</li>
                 	<li>We charge you a low standard shipping fee of 15rmb per seller. Please note that delivery rates depend upon 

         distance and package weight. Delivery fees are determined by the seller and the delivery service they use, so the 

         standard fee may be subject to an increase.</li>
                    
                	<li>Service fee = 10% of the item price</br>

         For example: You buy 3 items (total price = 150rmb) from one seller, the total costs will be:</br>

         Item price: 150rmb + 15rmb standard delivery fee + 15rmb service fee  </br>

         Total cost: 180rmb.</br>

         If you buy two from different sellers (total price 500rmb), the total costs will be:</br>

         Item Price 500rmb + 30rmb standard delivery fee (15rmb per seller) + 50rmb service fee</br>
  
         Total cost: 580rmb.</li>                       
                </ol>
            
            
            </div>
            
            
        	<h4>Payment Methods</h4>
            <div class="conList">    
            	<ol>
                	<li><img src="../../skin/images/help/paymentWalkthrough001.png" /></li>
                 	<li>Please note: Most other Chinese banking systems do not support an English language payment system which

can make them very difficult to access if you do not write and read the Chinese language. For this reason we 

have only included the following banks with China Union Pay... Some of those mentioned do have an English Language function.</li>
                    
                	<li><img src="../../skin/images/help/paymentWalkthrough002.png" /></li> 
                    <li>When you finally click "submit" after shopping you are taken to our payments page.</li>  
                    
                    <li><img src="../../skin/images/help/paymentWalkthrough003.png" /></li> 
                    
                    <li><span class="hong"> * </span> In China, Visa or Master Card, or China Union Pay payment procedures can only suppport <span class="hong">Microsoft Windows </span>and <span class="hong">Internet Explorer (IE)9.0</span>.</li>
                    
                    <li><span class="hong"> * </span> Sometimes payments by Paypal will be reviewed by the Paypal system itself, usually due to security checks according to Paypals own payment policies. Once verified, Paypal will transfer the payment to your WowShopping account within 24 hours. Please do wait as these checks are for your online security. Once we receive your payment, we will continue the transaction as usual. If you have any further questions, please contact our customer services team <a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>">here</a>.
</li>                       
                </ol>            
            </div>
            
            
        	<h4>WOW ACCOUNT</h4>
            <div class="conList">    
            	<ol>
                	<li>For convenient, fast and easy payments, we highly recommend you to use our Wow account. Your wow account 

can be charged by PayPal and online methods as above or by calling at our office with cash deposits.( SUZHOU 

only )</li>
                 	<li>To recharge your WOW ACCOUNT, please visit our "<a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>">Recharge Account</a>" page.</li>
                    
                	<li>The minimum re-chargeable amount is 500rmb but you may increase this amount using the white box.</li>  
                    
                    <li><img src="../../skin/images/help/rechargeAccount001.jpg" /></li>
                    
                    <li>You will now be taken through the payment process as above depending on which method you choose.</li>                      
                </ol>
            
            
            </div>            
            
        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=faq'));?>">FAQ</a></div>
    </div>
    

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
help/main/right.tpl
LNMV
);
//include($inc_tpl_file);
?>    
    
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