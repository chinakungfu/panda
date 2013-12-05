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
<div class="content" style="width: 975px;">
<h2 width="100%" style="color: #333;margin:40px auto;font-size: 30px; font-weight: bold; text-align:center;">Recharge your account with gift card</h2>
<div class="recharge_main_box oh">
	<img src="../skin/images/recharge_banner.jpg" alt="" class="fl" />
	<div class="fl recharge_pay_detail_box">
		<h2>
			GET THE RECHARGE ACCOUNT MAKES YOU A MEMBER <br />OF WOWSHOPPING<sup>®</sup>  AND START SHOPPING MORE EASILY
		</h2>
		<div class="oh recharge_box_content">
			<img class="fl" src="../skin/images/recharge_card.png" alt="" />
			<div class="recharge_adv fl">
				Save money in future service <br />
				More faster and easier  for payment 
			</div>
		</div>
		<form id="recharge_form" action="index.php" method="post">
		<div class="recharge_money_box oh fr">
			<input autocomplete="off" style="width: 250px" class="white_big_input required" id="recharge_gift_card" type="text" name="recharge_gift_card" value="GIFT CARD PASSWORD"/>
		</div>
		<div style="width:100%" class="oh fr">
			<input class="recharge_money_submit fr" style="margin-top:35px;margin-right:50px;" type="submit" value="APPLY NOW"/>
		</div>
		<input type="hidden" name="method" value="recharge_gift_card_check"/>
		<input type="hidden" name="action" value="shop"/>
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

		$("#recharge_form").validate({

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


		$("#recharge_gift_card").blur(function(){
			if($(this).val() == ""){
					$(this).val("GIFT CARD PASSWORD");
				}
		});

		$("#recharge_gift_card").focus(function(){
			if($(this).val() == "GIFT CARD PASSWORD"){
					$(this).val("");
				}
		});
		
	});
</script>	
</body>
</html>
