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
        <div class="notic_content">
            <div class="notic_header" style="height:150px;">
                <h1 style="margin:20px auto 20px;">My WOW Account</h1>
                <h2 style="margin:20px auto 20px;">Account Balance: <font color="#a10000;"> ¥ <?php echo $user_info[0]["balance"];?></font></h2>
            </div>
        </div> 
<h2 width="100%" style="margin:20px auto;color:#777;font-size:24px; font-weight:bold;">Recharge your account <font size="4">(online payment)</font></h2>
<div class="recharge_main_box oh">
	<img src="../skin/images/recharge_banner.jpg" alt="" class="fl" />
	<div class="fl recharge_pay_detail_box">

		<div class="oh recharge_box_content">
<!--			<div style="width: 218px" class="fl">
			<img src="../skin/images/recharge_card.png" alt="" />
			</div>-->
          
			<div class="recharge_account_adv fl">
                <h3>
                    Enjoy the convenience of a WOW account. <br />For faster, easier payments.
                </h3>              
				•	You can recharge with <?php echo $settings[0]["limit_recharge"]?> RMB or more.<br />
				<br>
				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_with_gift_card'));?>" style="color:#fff">•	 Have a gift certificates?  <br>&nbsp;&nbsp;To use a gift certificates recharge <font color="#dfcf1d">Click here</font></a>
				<div style="height:60px;"></div>
				<div style="color:#E9D81F;margin-top:10px;width:450px;text-align:right;">
					<form id="recharge_form" action="index.php" method="post">
						<div style="margin-top: 20px;">
							<input class="recharge_money_in" type="text" name="recharge_money_in" value="<?php echo $settings[0]["limit_recharge"]?>"/>&nbsp;&nbsp;&nbsp;
							<span style="float:right;">RMB</span>
						</div>
						<div >
							<input class="recharge_money_submit fr" type="submit" value="APPLY NOW" style="margin-top: 18px;border:none;"/>
						</div>
						<input type="hidden" name="method" value="recharge_submit_page"/>
						<input type="hidden" name="action" value="shop"/>
					</form>
				</div>
			</div>

		</div>

	</div>
</div>

 
</div>
	<div class="itemRequest rechargeRequest">
		<div class="itemRequestTop rechargeRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>What payment methods can I use?</h2>
            <p>You can pay in a variety of ways, including credit/debit cards, PayPal and China Unipay.<br><img src="../../skin/images/yhrecharge.png" /></p>
			
            <h2>If I don’t have any credit cards, how to pay?</h2>
        	<p>We also provide <font color="#5e97ed">Wire Transfer</font> and <font color="#5e97ed">Western Union</font> to let you transfer money to us. However this will take more time and steps to 
finish your payments,</p>
            <h2>Can I go to your office?</h2>
        	<p>To recharge with cash. Currently available in Suzhou only. More locations will be opening soon.<br>
Visit our office in Suzhou : Block 76-2, Orchard Manors, Xing Ming Street, SIP <br>
Time: 9:00~11:30 am 13:00~17:30pm ( 7 days)<br>
Tel: +86-512-62519973   +86-512-69176632</p>
			<p style="float:right;">Learn more about <a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=paymentWalkthrough'));?>">Payment Walkthrough</a></p>
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


	});
</script>
</body>
</html>