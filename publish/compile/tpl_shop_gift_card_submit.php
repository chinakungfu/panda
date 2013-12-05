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

<script type="text/javascript">
	$(function(){
		$(".order_view").click(function(){
			$(".pageContentSubmit").toggle();
			
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
<div class="content" style="width: 916px;">
<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">REFER A FRIEND GIFT CERTIFICATES</h2>
<div class="recharge_main_box oh">
	<img src="../skin/images/gift_card_adv.jpg" alt="" class="fl" />
	<div class="fl gift_pay_detail_box">
		<h2 style="margin-top: 46px;">
			GIFT CARD <?php echo $this->_tpl_vars["IN"]["gift_cart_money"]?> <span>RMB</span> 
		</h2>
		<h2 class="b_box_g_info">PAYMENT</h2>
		<form action="index.php" method="post" id="gift_card_pay_submit">
				<table class="pay_select_table">
					<tr>
						<td width="25%">PAYMENT OPTION</td>
						<td width="20%"><input class="select_payment_button" checked="checked" type="radio" value="1" name="payment" id="paypal"/> <label for="paypal">PAYPAL</label></td>
						<td width="20%"><input class="select_payment_button" type="radio" value="3" name="payment" id="card"/> <label for="card">CARD</label></td>
					</tr>
				</table>
				<div class="paypal_box payment_box " style="height: 283px;">
					<table class="payment_content">
						<tr>
							<td>Payment by Paypal, you need to pay 3% extra for the paypal service fee.
							<br /><br />
							<center><img src="../skin/images/paypal_icon.png" alt="" /></center>
							</td>
						</tr>
					</table>
					
				</div>
				<div class="card_box payment_box hide" style="height: 283px;">
				<table class="card_table payment_content">
					<tr>
						<td width="25%">CARD TYPE*</td>
						<td>
						<select name="card_type" class="required" id="card_type">
							<option value="">choose</option>
							<option value="1">bank card</option>
							<option value="2">visa (3% extra for the visa service fee)</option>
							<!-- <option value="3">test card</option> -->
						</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							Due to most of the China’s bank online payment system has no English version, and it is necessary to install the Chinese version Security Controls and open the online banking function, it is not convenient for Expats. So we only opened two bank interface: Agriculture Bank of China and Bank of Communications.
							<center><img style="margin-top: 10px;" src="../skin/images/cards.png" alt="" /></center>
						</td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="method" value="gift_card_final_pay"/>
			<input type="hidden" name="action" value="shop"/>
			<input type="hidden" name="give_name" value="<?php echo $this->_tpl_vars["IN"]["friend_name"]?>"/>
			<input type="hidden" name="give_email" value="<?php echo $this->_tpl_vars["IN"]["friend_email"]?>"/>
			<textarea name="gift_card_message" class="hide" id="gift_card_message" cols="30" rows="10"><?php echo $this->_tpl_vars["IN"]["gift_card_message"]?></textarea>
			<input type="hidden" name="money" value="<?php echo $this->_tpl_vars["IN"]["gift_cart_money"]?>"/>
			<input style="margin-top: 0px;" class="recharge_money_submit fr" type="submit" value="PAY NOW"/>
			</form>
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
	
	
	<script type="text/javascript">
	$(function(){

			$(".select_payment_button").click(function(){

					$(".payment_box").hide();
					var id = $(this).attr("id");
					var box = id + "_box";

					
					$("."+box).show();
				});


			$("#gift_card_pay_submit").validate({

				errorPlacement: function(error, element) {

					
	        	} 		

				});

			
			
		})

</script>
</body>
</html>