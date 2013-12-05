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
        <h3>Ordering Walkthrough</h3>
        <div>
        	<h4>This guide takes you through the whole process of ordering with WowShopping. </h4>
            <p style="font:normal 14px Arial, Helvetica, sans-serif;margin:20px auto;color:#333;">These pages are available once you have registered with WowShopping.</p>
            <div class="conList">    
            	<ol style="list-style:decimal">
                	<li>If you already have a Taobao link copied, that you would like to add to your shopping bag: Paste your link into the 

         box on top, then click <span style="font-weight:bold">"GO"</span>.</br>
</li>
                 	<img src="../../skin/images/help/orderingWalkthrough001.png" />
                    
                	<li>If you would like to search for an item on Taobao in English, please enter the name of the item in above box,. You 

         will then be taken to Taobao where the results of your search are displayed. Once you have found the item you 

         wish to buy, copy the link at the top of the screen and proceed as Step 1)</li> 
         
                	<li>On the next page after you click <span style="font-weight:bold">"GO"</span>, you can check the item is correct and select colour, size and quantity if 

         appropriate. Then click <span class="nan">"ADD TO BAG"</span> to place the item in your shopping bag automatically. From here you may 

         also add the item to your wish list using the <span class="nan">"+Add to wish list"</span> link. If the picture is not available to view, do not 

         worry, it will not affect your purchase in any way.</br>

         If the price looks different from TAOBAO, please click the button and request a <IMG src="../../skin/images/help/orderingWalkthrough002.png" /> before <span class="nan">ADD to BAG</span> and <span class="nan">SUBMIT</span> order. The order status will automatic change to pending.Please wait less than 24hours. We will verify and send a fixed order for you to  continue.You will receive an email to guide you to our payment procedure.
         			<img src="../../skin/images/help/orderingWalkthrough003.jpg" />
         
         			</li> 
                     <li>The shopping bag page allows you to check the items in your shopping bag and you able to change quantities,
         delete or add extra information to your order. You will also see the total amount for the items with the service
         fee is added. Once you are happy with all the details of your order, please click <span style="font-weight:bold;">"Checkout"</span> </li> 
         
         
                	<li>Follow the steps, in step <span style="font-weight:bold;">2.Shipping Address</span>. if this is your first visit please enter your shipping address carefully 

         to ensure safe and speedy delivery. Returning customers can simply check the default address shown or add a 

         new address if required.<br>
         				<img src="../../skin/images/help/orderingWalkthrough004.jpg" /> </br>
                   
         				In step <span style="font-weight:bold;">3.Confirm order infomation and submit</span> info you will see the total amount of your order including our 

     service fee. Here you may also add any gift/discount codes you have received and you may request an invoice. 

     Note When you request an invoice you become liable for any taxes applied.</br></br>
         
         				Once your payment is complete WowShopping customer service staff will begin to process your order checking all 

      the details as they do so. If any problems occur, for example address issues, out of stock goods or shipping cost 

      changes, we will verify and send a fixed order for you to continue.You will receive an email to guide you to our 

      payment procedure.
         
         
         
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