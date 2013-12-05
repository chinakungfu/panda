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
<h2 width="100%" style="color: #333;margin:40px auto;font-size: 30px; font-weight: bold; text-align:center;">REFER A FRIEND GIFT CERTIFICATES</h2>
<div class="gift_main_box oh">
	<img src="../skin/images/gift_card_adv.jpg" alt="" class="fl" />
	<div class="fl gift_pay_detail_box">
		<h2>
			A WOWshopping gift card, a lovely way to say thanks, Happy Birthday or just because ….
		</h2>
		<form action="index.php" id="gift_form" method="post">
		<div class="oh recharge_box_content">
			<img class="fl" src="../skin/images/gift_card.jpg" alt="" />
			<div class="fl gift_card_money">
				<input checked="checked" type="radio" name="gift_cart_money" id="gift_cart_money_1" value="500"/>&nbsp;&nbsp;&nbsp;&nbsp;<label for="gift_cart_money_1">500 <span>RMB</span></label><br />
				<input type="radio" name="gift_cart_money" id="gift_cart_money_2" value="1000"/>&nbsp;&nbsp;<label for="gift_cart_money_2">1000 <span>RMB</span></label><br />
				<input type="radio" name="gift_cart_money" id="gift_cart_money_3" value="2000" />&nbsp;&nbsp;<label for="gift_cart_money_3">2000 <span>RMB</span></label>
			</div>
		</div>
		<div class="gift_message_detail">

			<input type="hidden" name="method" value="gift_card_submit"/>
			<input type="hidden" name="action" value="shop"/>
			<table>
				<tr>
					<td><input id="friend_name" name="friend_name" type="text" class="white_big_input required" value="input your friend’s name here"/></td>
					<td></td>
				</tr>
				<tr>
					<td><input id="friend_email" name="friend_email" type="text" class="white_big_input email required" value="input your friend’s email here"/></td>
					<td></td>
				</tr>
				<tr>
					<td style="padding-bottom:0"><textarea name="gift_card_message" id="gift_card_message" cols="30" rows="10">input your message here</textarea></td>
					<td style="padding-bottom:0"><input class="recharge_money_submit fr" type="submit" value="APPLY NOW" /></td>
				</tr>
			</table>

		</div>
		</form>
	</div>
</div>
<div style="text-align:left;font:12px normal Arial, Helvetica, sans-serif;margin:5px auto 80px;color:#444;">Once complete, we will email e gift certificates etc.</div>
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

		$("#gift_form").validate({

			errorPlacement: function(error, element) {


        	},rules: {
        		recharge_money_in: {
   					required: true,
   					number: true,
   					min: <?php echo $settings[0]["limit_recharge"]?>
              }
        	},messages: {

        	  }

			});

		$("#friend_name").focus(function(){
			if($(this).val() == "input your friend’s name here"){
					$(this).val("");
				}
		});

		$("#friend_name").blur(function(){
			if($(this).val() == ""){
					$(this).val("input your friend’s name here");
				}
		});

		$("#friend_email").focus(function(){
			if($(this).val() == "input your friend’s email here"){
					$(this).val("");
				}
		});

		$("#friend_email").blur(function(){
			if($(this).val() == ""){
					$(this).val("input your friend’s email here");
				}
		});

		$("#gift_card_message").focus(function(){
			if($(this).val() == "input your message here"){
					$(this).val("");
				}
		});

		$("#gift_card_message").blur(function(){
			if($(this).val() == ""){
					$(this).val("input your message here");
				}
		});

	});
</script>
</body>
</html>