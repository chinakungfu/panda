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
        <h3>Refunds & Returns</h3>
        <div>
            <p style="font:normal 14px Arial, Helvetica, sans-serif;margin:20px auto;line-height:26px;color:#333;">You can easily return any WowShopping product to the seller from whom you purchased it, however it is subject to that sellers own return policy.</p>
        	<h4 style="margin:10px auto 40px;">WOWSHOPPING Product 3-Day Refund Policy</h4>
            
            <h4>What products are eligible for a refund?</h4>
            <div class="conList">    
            	<ol>
                	<li>Products are eligible for a refund if they do not match the colour/size or configuration you requested. They are also 

eligible if they are defective or broken. However since we are not the seller or manufacturer, we cannot offer refunds 

for items which are not defective/broken or that are the right colour/size or configuration that you ordered.
</li>
                 	<li><span style="font-weight:bold;">Please note:</span> Some sellers do not accept returns/exchange if they have shipped the correct item, in this case, we will 

not be able to request an exchange/refund. Some sellers may accept a return/exchange and in this case, you will be 

liable for the shipping costs of said item/s.</li>                      
                </ol>            
            </div>
            
        	<h4>How do I return a product for a Refund?</h4>
            <div class="conList">    
            	<ol style="list-style-type:inherit;">
                	<li>Please call or email us to explain why you would like to return the product as soon as you have received your 
          
         delivery.</li>                      
                	<li>Return the product to the WowShopping office address with 3 days of delivery either by hand or by post. The 

         original packaging is appreciated.</li> 
                	<li>In the case of broken or defective items or items shipped incorrectly by the seller, you will not be liable for shipping

         costs, simply mark your item Cash on Delivery. Please understand that in all other cases, you will be liable for 

         return shipping costs.</li>
                	<li>Please enclose your original sales receipt or invoice (if it was provided).</li>                              
                </ol>            
            </div>
            
        	<h4>Timing and Service Fee Information</h4>
            <div class="conList">    
            	<ol>
                	<li>WowShopping do not charge a service fee in respect of returns. We will negotiate with the seller on your behalf and if 

all parties agree, we will return the item to the seller. We can only refund any monies to your Wow Account once the 

seller has refunded the amount back to us. We will update your account within 24hours of receiving confirmation of 

refund amount. This may be subject to shipping fees dependant on circumstances.</li>                      
                </ol>            
            </div>
            

        	<h4>Returns Address:</h4>
            <div class="conList">    
            	<ol>
                	<li>WowShopping</br>

A: Block 76-2, Orchard Manors, Xing Ming Street, SIP, Suzhou, Jiangsu, China. Zip: 215021</br>

T: +86-512-62519973</br>

E: service@wowshopping.com.cn</br>
</li>                      
                </ol>            
            </div>

        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a> </div>
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