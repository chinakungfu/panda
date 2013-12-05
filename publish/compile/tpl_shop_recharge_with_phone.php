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
<script language="javascript">
$(function(){
		$(".recharge_phone_num").focus(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == defaultVal){	
				$(this).val("");
			}
			$(this).css("color","#333");
		});
		$(".recharge_phone_num").blur(function(){
			var defaultVal = $(this).attr("defaultVal");
			var urlVal = $(this).val();
			if(urlVal == ''){
				$(this).val(defaultVal);
				$(this).css("color","#A0A0A0");
			}
		});
		$(".recharge_money_radio input").click(function(){
			var rechargemoney = $(this).val();
			var rechargeFeeRate = 0;
			var rechargeFee = setCurrency(rechargemoney*rechargeFeeRate);
			var rechargeTotal = setCurrency(parseInt(rechargemoney) + rechargemoney*rechargeFeeRate);
			$(".recharge_money_radio").each(function(index, element) {
                $(this).removeClass("phone_select");
            });
			$(this).parent().addClass("phone_select");
			$("#recharge_service_fee").text("¥"+rechargeFee);
			$("#recharge_phone_tatal").text("¥"+rechargeTotal);
		});
		$("#recharge_phone_submit").click(function(){
			var re=new RegExp("^(13[0-9]{9}|15[012356789][0-9]{8}|18[0256789][0-9]{8}|147[0-9]{8}$)","g");
			var phoneNum = $(".recharge_phone_num").val();
			var s2=phoneNum.replace(re,"");
			if(s2){
				alert("Please enter the correct phone number!");
				$(".recharge_phone_num").focus();
				return false;
			}else{
				$("#recharge_phone_form").submit();
			}			
		});

});
</script>
</head>
<body>
<?php $settings =  runFunc("getGlobalSetting");?>
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

	if($loginUser == ""){

	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}

$loginUser = runFunc('readSession',array());
$user_info = runFunc("getStaffInfoById",array($loginUser));

	?>
<div class="content" style="width: 976px;">
        <div class="notic_content">
            <div class="notic_header" style="height:120px;">
                <h1 style="margin:0 auto 10px;">CHARGE YOUR MOBILE PHONE ONLINE</h1>
                <h3 style="text-align:center;color:#adaeab;font:18px normal Arial, Helvetica, sans-serif;">It will arrive within 15-30 minutes after your payment </h3>
                <h3 style="margin:10px auto;text-align:center;color:#ae0c0c;font:18px normal Arial, Helvetica, sans-serif;">Service Time:     9:00 AM to 5:30 PM MON - FRI</h3>
            </div>
        </div>
<div class="recharge_main_box oh" style="margin:20px auto 0;">
	<img src="../../skin/images/charegePhone.jpg" alt="" class="fl" />
	<div class="fl recharge_phone_detail_box">
		<div class="recharge_phone_money_box oh">
            <form id="recharge_phone_form" action="index.php" method="post">
            	<div style="color:#a10000; margin:10px auto; font:bold 24px Arial, Helvetica, sans-serif;height:30px;">Your Phone Number:</div>
            
            <input class="recharge_phone_num" type="text" name="recharge_phone_num" defaultVal="Type 11 Numbers Here" value="Type 11 Numbers Here"/>
  				<div style="color:#a10000; margin:15px auto 5px; font:bold 18px Arial, Helvetica, sans-serif;height:30px;">Please Select Amount：</div>
               <!--<div class="recharge_money_radio phone_select" style="margin-left:0;"><input type="radio" name="recharge_money" checked="checked" value="50" /> ¥50</div>-->
               <div class="recharge_money_radio phone_select" style="margin-left:0;"><input type="radio" name="recharge_money" value="100" checked="checked" /> ¥100</div>
               <div class="recharge_money_radio"><input type="radio" name="recharge_money" value="200" /> ¥200</div> 
               <div class="recharge_money_radio"><input type="radio" name="recharge_money" value="500" /> ¥500</div>
               <div class="clb"></div>
               <div class="recharge_service_fee"><!--* SERVICE FEE  5%<span id="recharge_service_fee" >¥2.50</span>--></div>
               <div class="recharge_pay_type"><span class="fl">Select Payment：</span>
                   <select name="recharge_pay_type" >
                   <option value="2">WOWaccount</option>
                   <option value="1">PayPal</option>
                   <option value="3">Visa or Master Card</option>
                   <option value="4">China Unipay</option>
                   </select>
               </div>
               <div class="clb" style="color:#fff;">No Service Fee For Limited TIme Only! <span class="hong">*</span></div>
               <div style="margin-top:50px; width:340px; border-bottom:1px solid #fed061;"></div>
               <div class="recharge_phone_tatal">Total:<span id="recharge_phone_tatal">¥100.00</span></div>
            <div style="width:100%" class="oh fr">
            <button class="recharge_phone_submit" type="button" name="recharge_phone_submit" id="recharge_phone_submit">Pay</button>
            </div>
            <input type="hidden" name="method" value="recharge_with_phone_pay"/>
            <input type="hidden" name="action" value="shop"/>
            </form>
		</div>
	</div>
    
</div>
	<div class="recharge_phone_info">
		<ul>
        	<li><span class="hong" style="position:relative;top:3px;">*</span> Payment by Paypal, you need to pay <span class="hong">3.4%</span> extra for the paypal service fee.</li>
            <li><span class="hong" style="position:relative;top:3px;">*</span> Payment by Visa or Master, you need to pay <span class="hong">3%</span> extra for the bank service fee. </li>
            <li>&nbsp;&nbsp;In China, payment procedures can only support <span class="hong">Microsoft Windows</span> and <span class="hong">Internet Explorer (IE)</span></li>
            <li><span class="hong" style="position:relative;top:3px;">*</span> Invoices are not available when using this service. </li>
        	<li><span class="hong" style="position:relative;top:3px;">*</span> Nomal Service Fee 5%.</li>            
        </ul>
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