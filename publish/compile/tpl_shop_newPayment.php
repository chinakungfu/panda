<?php import('core.util.RunFunc'); ?>
<?php $userID = runFunc('readSession',array());?>
<?php 
if(!$userID){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=myCart')));
	exit();	
}
?>
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
<script language="javascript">
	$(function(){
		$(".inputBlur").focus(function(){
			if($(this).val() == $(this).attr("defaultValue")){
				$(this).val("");
			}
		});
	
		$(".inputBlur").blur(function(){
			if($(this).val() == ""){
				var defaultValue = $(this).attr("defaultValue");
				$(this).val(defaultValue);
			}
		});	
		
		
		$("#submit_coupons").click(function(){
			var coupons_code = $("#coupons_code").val();
			var coupons_default = $("#coupons_code").attr("defaultValue");
			if(coupons_code == '' || coupons_code == coupons_default){
				$("#promoCode").text("Please Enter Promo Code!");
				$("#promoCode").show();
				return false;
			}
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: "shop",
					method	: "use_coupons",
					coupon_code:coupons_code,
					order_id:"<?php echo $this->_tpl_vars["IN"]["orderID"];?>"
				},
				success : function(json)
				{
					if(json.error==1){
						$("#promoCode").text("Your coupon code is incorrect.");
						$("#promoCode").show();
					}
					if(json.error==2){
						$("#promoCode").text("Your coupon code is already used.");
						$("#promoCode").show();						
					}
					if(json.error==3){
						$("#promoCode").text("Total amount must be more than "+ json.limit +" RMB.");
						$("#promoCode").show();						
					}
					if(json.error==0){
						$("#promoCode").show();	
						$("#promoPrice").show();	
						$("#promoCode").text("Code:"+json.code);
						$("#promoPrice").html("<span> - </span> ¥ "+json.coupon_word);
						//更改总金额
						$("#order_amount").text(setCurrency(json.order_current_amount));
						$("#submit_coupons").remove();
						$("#coupons_code").hide();
					}

				},complete: function(){

				}
			});
		});		
		$(".checkPaymentType").click(function (){
			var paymentTypeVal = $(this).val();
			switch(paymentTypeVal){
				case '2':
					$(".paymentAccount").each(function(index, element) {
                        $(this).hide();
                    });
					$(".paymentTypeOne").show();
					$(".paymentBankTransfer").hide();	
					$(".paymentSubmit").show();					
					break;
				case '1':
					$(".paymentAccount").each(function(index, element) {
                        $(this).hide();
                    });
					$(".paymentTypeTwo").show();
					$(".paymentBankTransfer").hide();	
					$(".paymentSubmit").show();									
					break;
				case '3':
					$(".paymentAccount").each(function(index, element) {
                        $(this).hide();
                    });
					$(".paymentTypeThree").show();
					$(".paymentBankTransfer").hide();	
					$(".paymentSubmit").show();							
					break;
				case '4':
					$(".paymentAccount").each(function(index, element) {
                        $(this).hide();
                    });
					$(".paymentTypeFour").show();	
					$(".paymentBankTransfer").hide();	
					$(".paymentSubmit").show();									
					break;
				case '5':
					$(".paymentAccount").each(function(index, element) {
                        $(this).hide();
                    });
					$(".paymentTypeFive").show();
					$(".paymentBankTransfer").show();	
					$(".paymentSubmit").hide();		
					break;					
			}
		});	
		$("#submit_payment").click(function(){
			$("#final_pay_form").submit();
		});		
	});
</script>
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
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
    <?php
	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));
	$user_info = runFunc("getStaffInfoById",array($userID));
	$settings =  runFunc("getGlobalSetting");
	?>
	<div class="bagNav">
    	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderList'));?>">Your Orders</a> > <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderList'));?>">Waiting Payment</a> ><font color="#a10202"> NO.<?php echo $order['OrderNo'];?></font>
        <div style="margin:10px auto;">
        	<span style="color:#ff9900;font:normal 24px Arial, Helvetica, sans-serif;">Pay Your Order  </span> <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderDetail&orderID='.$order['orderID']));?>">  View Order Detail</a>
        </div>
    </div>
    <div class="payment">
    	<div style="float:right;width:310px;text-align:right;"><span>NO.<?php echo $order['OrderNo'];?></span></div>
    	<div style="float:right;width:320px;font-size:12px;text-align:left;"><span style="color:#adaeab;font-size:14px;">Submit time:</span><?php echo $order['orderTime_n'];?></div>
        <div class="clb"></div>
    	<div class="paymentContent">
            <table width="976px">
                <tr class="paymentTh">
                    <td width="220">Shipping Address</td>
                    <td width="450" align="center"></td>
                    <td width="170">Payment Info</td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td>Receiving Name</td>
                    <td align="center" class="cartThreeCN"><span id="cartThreeFirstName">
						<?php if($order['firstName'] && $order['lastName']):?>
							<?php echo $order['firstName'].' '.$order['lastName'];?>
						<?php else:?>
							<?php echo $order['fullName'];?>
						<?php endif;?>
						</span>
					</td>
                    <td>Merchandise Sub-Total: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo $order['order_amount'];?> </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td align="center"  class="cartThreeCN"><span id="cartThreeEmail"><?php echo $order['email'];?></span></td>
                    <td>Service Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo $order['service_fee'];?></td>
                </tr>       
                <tr>
                    <td>Phone</td>
                    <td align="center"><span id="cartThreeTelephone"><?php echo $order['telephone'].' '.$order['cellphone'];?></span></td>
                    <td>Freight Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo $order['order_freight'];?></td>
                </tr>
                <tr>
                    <td>Shipping Address </td>
                    <td align="center"><span id="cartThreeAddress1"><?php echo $order['address1'];?></span></td>
                    <td class="hide">Additinal Payment:</td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeAddress2"><?php echo $order['address2'];?></span></td>
                    <td class="hide">International Shipping:</td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeCity"><?php echo $order['city'].';'.$order['province'].';'.$order['country'];?></span></td>
                    <td class="hide"></td>
                    <td align="right"></td>
                </tr>
                <?php if($order['addressCN1']):?>
                <tr id="addressCN">
                    <td colspan="4">
                    <table>          
                        <tr>
                            <td width="220">Address in Chinese </td>
                            <td width="450" align="center" class="cartThreeCN">
                            	<span id="cartThreeCNCity"><?php echo $order['countryCN'].'; '.$order['provinceCN'].'; '.$order['cityCN'];?></span></td>
                            <td width="170"></td>
                            <td align="right"></td>
                        </tr> 
                        <tr>
                            <td><a href="#" class="cartThreeTaxi hide">Order a box of customized taxi card</a></td>
                            <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress1"><?php echo $order['addressCN1'];?></span></td>
                            <td></td>
                            <td align="right"></td>
                        </tr> 
                        <tr>
                            <td></td>
                            <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress2"><?php echo $order['addressCN2'];?></span></td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                    </table>
                    </td>
                </tr>
                <?php endif;?>
                <tr class="cartThreeInvoice" style="font:bold 14px Arial, Helvetica, sans-serif;">
                    <td colspan="2">Invoice</td>
                    <td>Estimated Tax:</td> 
                    <td align="right" class="cartThreeRmb"><span id="tax_view">¥ <?php if($order['tax']):echo $order['tax'];else:?>0.00 <?php endif;?> </span></td>
                </tr>  
                <?php if($order['invoice']):?> 
                <tr>
                    <td colspan="2" class="cartThreeInvoiceTitle">
                    	<div style="margin-left:50px;">Title: <?php echo $order['invoiceTitle'];?></div>
                    </td>
                    <td></td>
                    <td align="right"></td>
                </tr>
                <?php endif;?>
                <tr>
                    <td colspan="2" class="cartThreeInvoiceTitle">
                    <?php if($order['invoice']):?> 
                    	<div style="margin-left:50px;">Tax Number: <?php echo $order['invoiceNum'];?></div>
                    <?php endif;?>
                    </td>
                    <?php if(!$order['coupons']):?>
                    <td class="cartThreeApply"><input type="text" id="coupons_code" class="inputBlur" name="applyNum" defaultValue = "Enter Promo Code" value="Enter Promo Code" /></td>
                    <td align="right"><span id="submit_coupons" class="paymentApply" style="font:bold 14px Arial, Helvetica, sans-serif;">Apply</span></td>
                    <?php endif;?>
                </tr> 
                
                <tr class="promoTr">
                    <td></td>
                    <td colspan="3">
                    	<div id="promoPrice" class="promoPrice<?php if(!$order['coupons']):?> hide<?php endif;?>">
                        	<span> - </span> ¥ <?php echo $order['coupon_word'];?>
                        
                        </div>                    	
                        <div id="promoCode" class="<?php if(!$order['coupons']):?>hide<?php endif;?> hui fr">Code:<?php echo $order['coupons'];?>
                        </div>
                    </td>
                </tr>           	
                     
                <tr style="font-size:18px;border-top:2px solid #aaa;">
                    <td colspan="2"></td>
                    <td>Total:</td>
                    <td align="right" class="cartThreeRmb"><span id="order_amount">¥ <?php echo $order['totalAmount'];?></span></td>
                </tr>                    
               </table>
            </div>	
        </div>
		<div class="paymentBank">
        	<form action="index.php" method="post" id="final_pay_form">
        	<div class="paymentMethod">
            	<div class="paymentMethodTitle">Choose payment method</div>
                <ul>
                	<li><input class="checkPaymentType" type="radio" checked value="2" name="payment" />WOW ACCOUNT</li>
                    <li><input class="checkPaymentType" type="radio" value="1" name="payment" />PAYPAL</li>
                    <li><input class="checkPaymentType" type="radio" value="3" name="payment" />VISA or Master Card</li>
                    <li><input class="checkPaymentType" type="radio" value="4" name="payment" />China Union Pay</li>
                    <li><input class="checkPaymentType" type="radio" value="5" name="payment" />Bank transfer</li>
                    <li class="hide"><input type="radio" value="6" name="payment" />WESTERN UNION</li>
                </ul>
            
            </div>
            
        	<div class="paymentAccount paymentTypeOne">
            	<div class="paymentAccountTitle">You are choosing WOW account</div>
            	<div class="paymentBalance">YOUR BALANCE<span>¥ <?php echo $user_info[0]['balance'];?></span></div>
                <div class="paymentRemark">For saving money in future service and More faster and easier for 

                    payment, please choose WOW Account. You can recharge with 
                    
                    a bank card and PayPal, and  you can also come to our office to 
                    
                    recharge with cash or use wire transfer 
                </div>
                <div class="paymentRecharge"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>" target="_blank">GO to Recharge</a></div>
            </div>
            
          	<div class="paymentAccount paymentTypeTwo" style="display:none;">
            	<div class="paymentAccountTitle">You are choosing PayPal</div>
            	<div class="paymentPaypal">
                	<img src="../../skin/images/paypal.png" />
                </div>
				<div style="text-align:center;color:#adaeab;">Payment by Paypal, you need to pay <font color="#d61f1f"><?php echo $settings[0]["paypal_fee"]*100;?>%</font> extra for the paypal service fee. </div>
            </div>
            
          	<div class="paymentAccount paymentTypeThree" style="display:none;">
            	<div class="paymentAccountTitle">You are choosing Visa or Master Card</div>
            	<div class="paymentVisa">
                	<img src="../../skin/images/visa.png" />
                </div>
				<div style="text-align:left;color:#adaeab; width:420px;margin:0 auto; line-height:20px;">Payment by Visa or Master, you need to pay <font color="#d61f1f"><?php echo $settings[0]["union_fee"]*100;?>%</font> extra for the bank service fee. In china, payment procedure only support  <font color="#d61f1f">Microsoft Windows</font> and <font color="#d61f1f">Internet Explorer (IE)</font>
				</div>
            </div> 
                        
          	<div class="paymentAccount paymentTypeFour"  style="display:none;">
            	<div class="paymentAccountTitle">You are choosing China Union Pay</div>
            	<div class="paymentChinaUnion">
                	<img src="../../skin/images/chinaUnionPay.png" />
                </div>
				<div style="text-align:left;color:#adaeab; width:450px;margin:0 auto; line-height:20px;">
                	<font color="#d61f1f">* </font> CARD payment procedure only support <font color="#d61f1f">Internet Explorer (IE).</font> Due to most of the China’s bank online payment system has no English version, we only provide a few bank card and it is necessary to install the Chinese version Security Controls and open the online banking function, it is not convenient for Expats.
				</div>
                <div style="text-align:center;margin-top:5px;">
                	<img src="../../skin/images/chinaBankList.png" />
                </div>
            </div>
          	<div class="paymentAccount paymentTypeFive"  style="display:none;">
            	<div class="paymentAccountTitle">You are choosing Bank Transfer</div>
                <table width="400px" class="recharge_bank_content">
                    <tr><td width="115px" class="tname">Reciver name: </td><td class="tval">Fu Zheng Yang / 傅正扬</td></tr>
                    <tr><td class="tname">TT Account:  </td><td class="tval">6227 0020 0169 0013 171</td></tr>
                    <tr><td class="tname">Bank name: </td><td class="tval">China Construction Bank  / 中国建设银行</td></tr>
                    <tr><td class="tname">Swift code: </td><td class="tval">PCBCCNBJJSS</td></tr>
                    <tr><td class="tname" valign="top">Bank address: </td>
                        <td class="tval" valign="top">
                            <p>Orchard Manors Xing Ming Street, </p>
                            <p>Suzhou,Jiangsu</p>
                            <p>China</p>
                            <p>苏州工业园区星明街都市花园分理处</p>
                        </td>
                    </tr>
                    <tr><td colspan="2" align="right" valign="bottom" class="nan" style="font:bold 18px Arial, Helvetica, sans-serif;padding-right:10px;"><a target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=bankTransfer'));?>">Recharge Account Now</a></td></tr>
                </table>
            </div>                            
            <input type="hidden" name="method" value="final_pay"/>
            <input type="hidden" name="action" value="shop"/>
            <input type="hidden" name="order" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>"/>
            </form>
                  	
        </div>
        <div class="paymentSubmit"><a id="submit_payment">Pay</a></div>
        <div class="paymentBankTransfer" style="display:none;">
        	<ul style="list-style:none">
            	<li>1,&nbsp;&nbsp;When you transfer money via Bank Transfer in your local bank,please make a note about the informaiton as above</li>
                <li>2,&nbsp;&nbsp;Log in and go to “Recharge Account” page, choose “Bank Transfer”, and then fill out the form, click “Submit” after </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you have confirmed all the information!</li>
                <li>3,&nbsp;&nbsp;We will check our account within 24 hours. If there are no problems, the money will be added to your account immediately. Please </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pay attention to your wow account balance and account history.</li>
                <li>4,&nbsp;&nbsp;Now, you can find this order in your account home’s orderlist , and use wow account to finish payment.</li>
            </ol>
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