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
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Service
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Service Fee & Shipping Fee</h3>
        <div>
        	<h4>Fees and costs breakdown</h4>
            <div class="conList">    
            	<ol style="list-style:decimal">
                	<li>Total fees = Item price + domestic delivery fee + service fee. Any international delivery fees (if requested) will be added at a later stage.</li>
                 	<li>We charge you a low standard shipping fee of 15rmb per seller. Please note that delivery rates depend upon distance and package weight. Delivery fees are determined by the seller and the delivery service they use, so the standard fee may be subject to an increase.</li>
                	<li>Service fee = 10% of the item price</br>

         For example: You buy 3 items (total price = 150rmb) from one seller, the total costs will be:</br>

         Item price: 150rmb + 15rmb standard delivery fee + 15rmb service fee       </br>

         Total cost: 180rmb.</br>

         If you buy two from different sellers (total price 500rmb), the total costs will be:</br>

         Item Price 500rmb + 30rmb standard delivery fee (15rmb per seller) + 50rmb service fee</br>
  
         Total cost: 580rmb.
 </li>                       
                </ol>
            
            
            </div>

        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=paymentWalkthrough'));?>">Payment walkthrough</a></div>
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