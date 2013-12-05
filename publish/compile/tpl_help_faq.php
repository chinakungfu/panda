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
        <h3>FAQ</h3>
        <div class="fqaList">
        	<h4>Q1. Why do I need Wowshopping assistance to shop on Taobao?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A1.</div>
                <div class="answerCon fl">Taobao is a Chinese online shopping marketplace, to date it has no English translation services. We provide an Auto translation tool so you can search in English. We then guide you through the process of buying, right through to delivery. We also provide an after sales service, all provided by English speaking staff.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q2. Can I shop on Taobao.com on my own, buy from Taobao without help from WOW shopping?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A2.</div>
                <div class="answerCon fl">Yes, if you have an available Chinese e-bank account and know some written and spoken Chinese language.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q3: How do I pay for the items I want to order ? Is it Safe?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A3. </div>
                <div class="answerCon fl">We use secure, reliable payment methods which can process credit or debit cards or we can accept paypal and cash in person. For fast payments and ultimate convenience we recommend our Wow account which you can charge with money to use each time you shop. When we require your payment, or when you re-charge your Wow account, we provide you with the link to our Wowshopping payment system. It is 100% safe</div>
                <div class="clb"></div>
			</div>
            

        	<h4>Q4. What is the Wowshopping currency? What currency do you use?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A4. </div>
                <div class="answerCon fl">Chinese Yuan is used for all transactions on Wowshopping.com.cn.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q5. What are your charges for the Wowshopping service?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A5. </div>
                <div class="answerCon fl">We charge a very low service fee of 10% per order and a standard domestic shipping fee of 15rmb per seller; however shipping costs may vary due to size/weight of the items ordered.</br>

      For example: </br>
				<table>
                	<tr>
                    	<td style="width:150px;" align="left">Item cost:</td>
                    	<td align="left">200rmb</td>
                    </tr>
                	<tr>
                    	<td style="width:150px;" align="left">Standard shipping</td>
                    	<td align="left">15rmb</td>
                    </tr>
                	<tr>
                    	<td style="width:150px;" align="left">Service fee 10%</td>
                    	<td align="left">20rmb</td>
                    </tr>
                	<tr>
                    	<td style="width:150px;" align="left">Total Cost</td>
                    	<td align="left">235rmb</td>
                    </tr>                                                        
                </table>
				</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q6. What other costs may be involved?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A6. </div>
                <div class="answerCon fl">Heavy or oversized items may incur a higher shipping fee as will International deliveries. Shipping fees are determined by the seller and not WowShopping, therefore fees may be subject to change. We will always confirm fee changes with you.</br>

      Payments received via paypal or credit/debit cards will also be subject to 3.5% ~3.9% fee and possibly exchange rate 

      differences.</div>
                <div class="clb"></div>
			</div>
            
            
        	<h4>Q7. How to order from Wowshopping? How to buy from Wowshopping? What is the procedure?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A7. </div>
                <div class="answerCon fl">Please see <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=orderingWalkthrough'));?>">Ordering Walkthrough</a> for details on our order procedure.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q8. Why do you recommend a Wow Account?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A8. </div>
                <div class="answerCon fl">We recommend a Wow account as the simplest method of payment. You can charge your account at any time and if you pay in cash you can avoid any extra charges (see question 6). A Wow account can save you time and money.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q9. Can I invite my friends to shop with Wow?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A9. </div>
                <div class="answerCon fl">Yes absolutely. You can invite your friends to join WowShopping via the link in your account home page and they can also join us on <a href="http://www.facebook.com/WOWSHOPPING.COM.CN">Facebook</a>.</div>
                <div class="clb"></div>
			</div>  
            
            
            
        	<h4>Q10. Can I I create my own collection?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A10. </div>
                <div class="answerCon fl">You can create your own collection to share publicly with the community or privately with friends. To achieve this click “Collections” from the home page and then “add a collection” From there you can drag and drop items from your wish list or ordered items.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q11. Can I share my favourite items with my friends on Wowshopping?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A11. </div>
                <div class="answerCon fl">Yes. You can select the items you like and add them to your Wishlist or collection according to personal preference.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q12. Why Taobao.com? Can I buy from other Chinese online shopping websites?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A12. </div>
                <div class="answerCon fl">We recommend Taobao because it is China’s biggest shopping platform and has more than 80% of the market share, you can find everything there very easily.</div>
                <div class="clb"></div>
			</div>
            

        	<h4>Q13. How do check the status of my order?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A13. </div>
                <div class="answerCon fl">From your account homepage, click "<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">View Order History</a>" Here you can see the status of all your orders and also view them in more detail.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q14. Can I buy insurance for my order?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A14. </div>
                <div class="answerCon fl">For domestic transactions, we do not normally provide shipping insurance, however you may contact us if you would like to inure a domestic delivery. For international transactions, we would strongly recommend you contact customer services to arrange your specific needs.
				</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q15. What happens if my items break during transit?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A15. </div>
                <div class="answerCon fl">Please check your delivery and if it is obviously damaged do not accept the delivery. If this is not possible or the item 

        only shows as broken when you open the package, please contact us urgently and we will help you contact the seller.

        Unfortunately WowShopping cannot take responsibility for breakages/damages but we will do our best to help you. For 

        more information please see our Terms and Conditions.
</div>
                <div class="clb"></div>
			</div>
            
            
        	<h4>Q16. What if the items I bought are defective?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A16. </div>
                <div class="answerCon fl">Please return the item/s to WowShopping within three days of delivery. Smaller less expensive items may not be 

        returned after this time. Please contact our customer services team for more information.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q17. What if the item is not what I ordered or I ordered the wrong item?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A17. </div>
                <div class="answerCon fl">Please contact customer services as soon as the item arrives. They will send you the sellers address information by 

        e-mail. You can then send the item back to the seller. In the case of a wrong item shipped, the seller will pay for the 

        shipping. If you ordered the wrong item, the shipping cost is at your expense.  The correct item will be shipped by the 

        seller to you, or you will receive a refund.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q18. Can I cancel my order?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A18. </div>
                <div class="answerCon fl">You are able to cancel your order as long as it has not been processed by our customer service staff. Unfortunately, if our team has already started to process your order, it cannot be cancelled due to commitments we have made to buy 

        from the seller.</div>
                <div class="clb"></div>
			</div>                                                
            
        	<h4>Q19. What happens to my fees if I buy many items from one seller?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A19. </div>
                <div class="answerCon fl">You will pay only one standard shipping fee of 15rmb unless the items ordered are subject to an increase due to 

        weight/size of the parcel.Shipping fees are determined by the seller and not WowShopping, </div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q20. What happens if my item is out of stock?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A20. </div>
                <div class="answerCon fl">Our customer service will contact you about the amount refunded to your Wow account.</div>
                <div class="clb"></div>
			</div>
            
        	<h4>Q21. I do not live in China, can I buy from Wowshopping?</h4>
            <div class="fqaanswer">
                <div class="answerTag fl">A21. </div>
                <div class="answerCon fl">Yes, we’d be delighted to help you. Please contact our customer services team for further information on your specific country and needs.
</div>
                <div class="clb"></div>
			</div>            
                                           
        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Customer Service</a></div>
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