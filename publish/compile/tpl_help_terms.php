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
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Company
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Terms and Conditions</h3>
        <div>
            <p style="font:normal 14px Arial, Helvetica, sans-serif;margin:20px 10px 20px 0;line-height:26px;color:#333;">
By using WOWShopping.com.cn, you agree to the following terms and conditions:
</p>

        	<h4>Privacy Statement :</h4>
            <div class="conList">    
            	<ol>
                	<li>It has always been our primary concern to protect your privacy. The information collected from you at the time you 

place an order is stored in our database and is used purely to carry out your instructions and action your payment. 

There is no personal data stored on our server online. There are no circumstances under which, this information might 

be passed to a third party.
 </li>                       
                </ol>
            </div>

        	<h4>Contact：</h4>
            <div class="conList">    
            	<ol>
                	<li>By providing us with your personal email, you authorize us to contact you in connection with your instructions and to 

keep you well informed about your order process. We will not email you about anything unrelated to your order.
 </li>                       
                </ol>
            </div>
            
        	<h4>Service:</h4>
            <div class="conList">    
            	<ol>
                	<li>We will provide buying services, domestic and international shipping services. We buy the items on your behalf from

Taobao.com, as per your instruction, and deliver them to you via our sellers shipping services. We may present, in our 

site, products with links to third party sites (mainly taobao.com and tmall.com) only for your convenience.
 </li>                       
                </ol>
            </div>            
            
            
        	<h4>Transaction Security</h4>
            <div class="conList">    
            	<ol>
                	<li>All payments made by you for our services are made through a secure gateway using any major credit card. We do

not hold, nor do we store any credit card information.
 </li>                       
                </ol>
            </div>              
            
 
         	<h4>Delivery </h4>
            <div class="conList">    
            	<ol>
                	<li>In average, domestic delivery takes 3 days to arrive to our warehouse or your expected place. International delivery

time does not depend on Wowshopping and we cannot provide any guarantee as for duration of shipping.

 </li>                       
                </ol>
            </div> 
 
          	<h4>The delivery time for international shipping, check: Shipping fee</h4>
            <div class="conList">    
            	<ol>
                	<li>Delivery time depends on the destination country, in particular on the speed of the local customs clearance and 

local postal services. However, the time for arrival does not depend on us and we are not liable to any delay in delivery. 

We always try our best to ask for information and give you the feedback in time. We can inquire additional information 

about your parcel only if online tracking did not appear within 10 days of shipping date or if delivery time exceeds the 

above estimated time.
 </li>                       
 					<li>The risk of loss or damage to your order shall pass to delivery company upon international shipping.</li>
                </ol>
            </div>            
            
            
          	<h4>Cancellation</h4>
            <div class="conList">    
            	<ol>
                	<li>You can cancel your order at any time before we start purchasing items. In that case, full amount of the payment 

will be refunded. If the seller has shipped the item, then neither the shipping fee nor the service fee can be refunded. 

Shipping the item/s back to the seller will also be at your expense. Please note: If the item has already been purchased 

from the seller, cancellations are not always possible because some sellers/stores do not accept the return of goods 

for refund. </li>
                </ol>
            </div> 
            
            
          	<h4>Refunds and Returns</h4>
            <div class="conList">    
            	<ol>
                	<li>If the item meets the characteristics described by seller and corresponds to your request (color, size, configuration, 

etc.) and there are no defects, such item is not eligible for return and refund, It is only possible to return items which ar

significantly different from photographs and description provided by the seller. 

Please note that some Taobao sellers don’t accept return/exchange if they have shipped the correct item. In that case, 

we are unable to request a refund/exchange.</li>
					<li>If items are eligible for return/exchange, under normal circumstances we do not charge an extra service fee, the any

shipping fees would be at your expense.</li>
                </ol>
            </div>             
            
            
          	<h4>Disclaimer and Limitation of Liability</h4>
            <div class="conList">    
            	<ol>
                	<li> While we try to offer reliable information, we cannot promise that the content of our website will always be accurate 

and up-to-date, and cannot be held responsible for any inaccuracies in it.</li>
					<li>While we help facilitate the buying process between you and the seller, we have no control over and do not guarantee
 
the quality, safety, or legality of items you choose to buy. We are not responsible for the seller’s content, actions, or 

inactions, items he lists or his description of allegedly fraudulent items.</li>

					<li>We shall not be liable for any claim arising out of the performance, non-performance, customs clearance, delay in 

delivery of or defect in your order, nor for any special, indirect, economic or consequential loss or damage howsoever 

arising or howsoever caused (including loss of profit or loss of revenue).
</li>
                </ol>
            </div>                           


          	<h4>Copyright Issues </h4>
            <div class="conList">    
            	<ol>
                	<li>Copyright and other relevant intellectual property rights exist in the full content of this website, including logo, images

web design and all text concerning our service.
</li>
                </ol>
            </div>
            
                                   
        </div>

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