<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
if ($this->_tpl_vars["name"]==""){?>
<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

<?php } ?>
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
if($loginUser == ""){
	
	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}
$loginUser = runFunc('readSession',array());
$user_info = runFunc("getStaffInfoById",array($loginUser));
$settings = runFunc("getGlobalSetting");
	?>
<div class="content" style="width: 975px;">
        <div class="notic_content">
            <div class="notic_header" style="height:50px;padding-top:20px;padding-bottom:20px;">
                <h1 style="margin:0 auto;">Payment Procedure</h1>
            </div>
        </div> 
		<div class="paymentBank">
        	<form action="index.php" method="post" id="recharge_form">
        	<div class="paymentMethod">
            	<div class="paymentMethodTitle">Choose payment method</div>
                <ul>               	
                    <li><input class="checkPaymentType" type="radio" checked value="1" name="payment" id="paypal" />PAYPAL</li>
<!--                    <li><input class="checkPaymentType" type="radio" value="8" name="payment" id="card" />VISA or Master Card</li>
                    <li><input class="checkPaymentType" type="radio" value="9" name="payment" id="union" />China Union Pay</li>-->
                    <li><input class="checkPaymentType" type="radio" value="10" name="payment" id="bank" />Bank transfer</li>
                    <li class="hide"><input type="radio" value="11" name="payment" />WESTERN UNION</li>
                </ul>
            
            </div>         
          	<div class="paymentAccount paypal_box">
            	<div class="paymentAccountTitle">You are choosing PayPal</div>
            	<div class="paymentPaypal">
                	<img src="../../skin/images/paypal.png" />
                </div>
				<div style="text-align:center;color:#adaeab;">Payment by Paypal, you need to pay <font color="#d61f1f"><?php echo $settings[0]["paypal_fee"]*100;?>%</font> extra for the paypal service fee. </div>
            </div>
            
          	<div class="paymentAccount card_box hide">
            	<div class="paymentAccountTitle">You are choosing Visa or Master Card</div>
            	<div class="paymentVisa">
                	<img src="../../skin/images/visa.png" />
                </div>
				<div style="text-align:left;color:#adaeab; width:420px;margin:0 auto; line-height:20px;">Payment by Visa or Master, you need to pay <font color="#d61f1f"><?php echo $settings[0]["union_fee"]*100;?>%</font> extra for the bank service fee. In china, payment procedure only support  <font color="#d61f1f">Microsoft Windows</font> and <font color="#d61f1f">Internet Explorer (IE)</font>
				</div>
            </div> 
                        
          	<div class="paymentAccount union_box hide">
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
          	<div class="paymentAccount bank_box hide">
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
			<input type="hidden" name="method" value="recharge_final_pay"/>
			<input type="hidden" name="action" value="shop"/>
			<input type="hidden" name="money" value="<?php echo $this->_tpl_vars["IN"]["recharge_money_in"];?>"/>
            </form>
                  	
        </div>
		<div style="width:975px;font:normal 14px Arial, Helvetica, sans-serif; line-height:30px; color:#333;">
        	<p>1. When you transfer money via Bank Transfer in your local bank,please make a note about the informaiton as above.</p>
        	<p>2. Log in and go to "Recharge Account" page, choose "Bank Transfer", and then fill out the form, click "Submit" after </p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;you have confirmed all the information!</p>
            <p>3. We will check our account within 24 hours. If there are no problems, the money will be added to your account immediately. Please</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;pay attention to your wow account balance and account history.</p>
            <p>4. Now, you can find this order in your account home’s orderlist , and use wow account to finish payment.</p>
        </div>
        <div class="paymentSubmit"><a id="submit_payment">Pay</a></div>
</div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	
	<script type="text/javascript">
	$(function(){
		$(".checkPaymentType").click(function(){
			$(".paymentAccount").hide();
			var id = $(this).attr("id");
			var box = id + "_box";
			if(id == 'bank'){
				$("#submit_payment").hide();
			}else{
				$("#submit_payment").show();
			}
			$("."+box).show();
		});		
		
		$("#submit_payment").click(function(){
			$("#recharge_form").submit();
			
		});
		

		$("#recharge_form").validate({
			errorPlacement: function(error, element) {
				
			} 
		});

	})

</script>
</body>
</html>