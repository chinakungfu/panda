<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
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
$settings =  runFunc("getGlobalSetting");
	?>
<div class="content" style="width: 916px;">
<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">Your payment
<?php if($order["orderStatus"]=="4"):?>
 <a style="color:#9B2F2F;font-size:11px" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify&orderID='.$this->_tpl_vars["IN"]["orderID"]));?>">Modify This Order</a>
<?php endif;?>
<font style="font-size:11px">|</font>
<a style="color:#9B2F2F;font-size:11px;cursor:pointer;" id="order_print">Print</a>
</h2>
<script type="text/javascript">
	$("#order_print").click(function(){
			$(".pageContentSubmit").show();
			window.print();
			return false;
		});
</script>
<div class="subMitConfirm  fl">
			<div class="order_address fl success_order_address" width="100%">
				<h2>SHIPPING ADDRESS</h2>
				<table>
					<tr>
						<td width=12%>Name:</td>
						<td width="40%"><?php echo $order["fullName"];?></td>
						<td width=12%>Email:</td>
						<td><?php echo $order["email"];?></td>
					</tr>
					<tr>
						<td>Address1:</td>
						<td colspan=3><?php echo $order["address1"];?></td>
					</tr>
					<tr>
						<td>Address2:</td>
						<td colspan=3><?php echo $order["address2"];?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?php echo $order["city"];?></td>
						<td>Province:</td>
						<td><?php echo $order["province"];?></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><?php echo $order["country"];?></td>
						<td>Zip:</td>
						<td><?php echo $order["zipcode"];?></td>
					</tr>
					<tr>
						<td>Phone1:</td>
						<td><?php echo $order["cellphone"];?></td>
						<td>Phone2:</td>
						<td><?php echo $order["telephone"];?></td>
					</tr>
				</table>
			</div>

			<div class="order_payment_info fl">
			<form action="index.php" method="post" id="final_pay_form">
				<h2 class="b_box_g_info">PAYMENT</h2>
				<table class="pay_select_table">
					<tr>
						<td width="25%">PAYMENT OPTION</td>
						<td width="40%" style="text-align: center;"><input class="select_payment_button" type="radio" value="2" checked="checked" name="payment" id="recharge"/> <label for="recharge">RECHARGE ACCOUNT</label></td>
						<td width="20%" style="text-align: center;"><input class="select_payment_button" type="radio" value="1" name="payment" id="paypal"/> <label for="paypal">PAYPAL</label></td>
						<td width="20%" style="text-align: center;"><input class="select_payment_button" type="radio" value="3" name="payment" id="card"/> <label for="card">CARD</label></td>
					</tr>
				</table>
				<div class="paypal_box payment_box hide">
					<table class="payment_content">
						<tr>
							<td><font style="color:#ffcf50">Payment by Paypal, you need to pay <?php echo $settings[0]["paypal_fee"]*100;?>% extra for the paypal service fee.</font>
							<br /><br />
							<center><img src="../skin/images/paypal_icon.png" alt="" /></center>
							</td>
						</tr>
					</table>

				</div>
				<div class="recharge_box payment_box">
				<!-- <table class="recharge_table payment_content">
					<tr>
						<td width="25%">SECURITY CODE*</td>
						<td><input type="text" name="recharge_security" id="security_input"/></td>
					</tr>
				</table> -->
				<table class="payment_content" style="margin-top:4px">
					<tr>
						<td width="25%">YOUR BALANCE</td>
						<td><span class="recharge_balance">¥ <?php echo $user_info[0]["balance"];?></span></td>
					</tr>
					<tr>
						<td colspan="2" style="color:#ffcf50">
							For saving money in future service and More faster and easier for payment, please choose Recharge Account. You can recharge with a bank card and PayPal, and also you can come to our office cash recharge. <br />( Minimum <?php echo $settings[0]["limit_recharge"]?>RMB)
						</td>

					</tr>
					<tr>
						<td colspan="2">
							<font style="color:#ffcf50">You can also come to our office to recharge with cash.<br></font><font style="color:#20a345">Recharge Location:  </font><font style="color:#ffcf50">Block 76-2, Orchard Manors, Xing Ming Street, SIP</font>
						</td>
					</tr>
					<?php if($user_info[0]["balance"]<$order["totalAmount"]):?>
					<tr>
						<td style="font-size:18px;text-align:center" colspan=2>Whoops! Your account balance is not enough <br/><a href="<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>" style="color:#BAD782">Recharge</a> or choose other payment methods
						</td>
					</tr>
					<?php endif;?>

				</table>
				</div>
				<div class="card_box payment_box hide">
				<table class="card_table payment_content">
					<tr>
						<td width="25%">CARD TYPE*</td>
						<td>
						<select name="card_type" id="card_type">
							<option value="">choose</option>
							<option value="1">bank card</option>
							<option value="2">visa (<?php echo $settings[0]["union_fee"]*100;?>% extra for the visa service fee)</option>
							<!-- <option value="3">test card</option> -->
						</select>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<font style="color:#ffcf50">* Note:</font>  <font style="color:#fff">CARD payment procedure only support Internet Explorer (IE)</font>
							</br>
							<font style="color:#ffcf50">Due to most of the China’s bank online payment system has no English version, and it is necessary to install the Chinese version Security Controls and open the online banking function, it is not convenient for Expats. So we only opened two bank interface: Agriculture Bank of China and Bank of Communications.</font>
							<center><img style="margin-top: 10px;" src="../skin/images/cards.png" alt="" /></center>
						</td>
					</tr>
				</table>
				</div>
				<input type="hidden" name="method" value="final_pay"/>
				<input type="hidden" name="action" value="shop"/>
				<input type="hidden" name="order" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>"/>
				</form>
			</div>
</div>
	<div class="fr" style="width:300px;position:relative;">
		<div class="submitOrderNo">
		Order <span>(No:<?php echo $order["OrderNo"];?>)</span>
		</div>

			<?php

			$inc_tpl_file=includeFunc(<<<LNMV
shop/paymentInfo.tpl
LNMV
			);
			include($inc_tpl_file);?>
		</div>
		<style type="text/css">
			.subMitRight{
				height: 465px;
			}
			.order_view {
				margin-top: 3px;
			}
		</style>

			<div class="fl">
			<?php
			// ******************order Review**************************
			$inc_tpl_file=includeFunc(<<<LNMV
shop/orderReview.tpl
LNMV
			);
			include($inc_tpl_file);?>
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

		})

</script>
</body>
</html>
<?php }else{ ?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
}
?>