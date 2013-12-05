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
            <div class="notic_header" style="height:160px;">
                <h1 style="margin:0 auto 10px;">Exchange your points</h1>
                <h3 style="text-align:center;color:#adaeab;font:18px normal Arial, Helvetica, sans-serif;">Buy More get more points!</h3>
                <h2 style="margin:20px auto 20px;">Your points :  <font color="#a10000;"> <?php echo $user_info[0]["credits"];?></font></h2>
            </div>
        </div>
<h2 style="margin:20px auto;color:#777;font-size:24px; font-weight:bold;">Recharge your account <font size="4">(Points exchange)</font></h2>

<div class="recharge_main_box oh">
	<img src="../skin/images/recharge_banner.jpg" alt="" class="fl" />
	<div class="fl recharge_pay_detail_box">
		<h2>
			Enjoy the convenience of a WOW account.<br>
 
			For faster, easier payments.

		</h2>
		<div class="oh recharge_box_content">
			<img class="fl" src="../skin/images/recharge_card.png" alt="" />
			<div class="recharge_adv fl">

				<span>Current exchange rate</span>
				<br />
				<span>200 Points = 1 RMB</span>
			</div>
		</div>
		
		<div class="recharge_money_box oh fr">
			<?php if($user_info[0]["credits"]<$settings[0]["credit_to_money"]){?>  
                    <font style="color:white;font-size:18px;">Your credit is not enough.</font>
            <?php }else{?>
            		<form id="credits_form" action="index.php" method="post">
                    <input class="recharge_money_in" type="text" name="recharge_credits_in" id="creditsPoints" value="<?php echo $user_info[0]["credits"];?>"/>
                    <span style="color:#fff;font-size:16px;">POINTS</span>
                    <div style="width:100%" class="oh fr">
                    <input class="recharge_money_submit fr" type="button" id="credits_submit" value="APPLY NOW" style="margin-top:38px;"/>
                    </div>
                    <input type="hidden" name="method" value="recharge_with_credits_save"/>
                    <input type="hidden" name="action" value="shop"/>
                    </form>
            <?php }?>
		</div>
	</div>
</div>
<script language="javascript">
$(function(){
	$("#credits_submit").click(function(){
		var creditsVal = $("#creditsPoints").val();
		if(creditsVal >= <?php echo $settings[0]["credit_to_money"];?> && isNum(creditsVal)){
			$("#credits_form").submit();
		}else{
			alert("请输入大于<?php echo $settings[0]["credit_to_money"];?>的整数!");
			var intcreditsVal = parseInt(creditsVal);
			$("#creditsPoints").val(intcreditsVal);
		}
	});
});
</script>
</div>
	<div class="itemRequest creditsRequest">
		<div class="itemRequestTop creditsRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>How does the points works?</h2>
            <p>1. Consumption: Receive 1 credit for every Chinese Yuan you spend on items fee and domestic shipping fee.<br>
            	2. Participate in events: WOWshopping will hold WOWshopping point’ s events, you can gain WOWshopping points 
    by participating in our events.</p>
			
            <h2>What is the WOWshopping point’s usage policy?</h2>
        	<p>WOWshopping points cannot be transferred, but can be used as part payment within this website.</p>
            <h2>What is the point’s valid period?</h2>
        	<p>The member points have no valid period in principle.</p>
			<!--<p style="float:right;">Learn more about <span style="color:#5e97ed">Delivery</span></p>-->
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

</body>
</html>