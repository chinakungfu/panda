<?php

$setting = runFunc("getGlobalSetting");
if($this->_tpl_vars["method"]!="WOWd2d"){

	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));

	if($order["group_buy"]==1){

		$this->_tpl_vars["IN"]["check_type"]="group_buy";
	}
	$subTotal = $order["order_amount"];
	$freight = $order["order_freight"];
	if($order["changed_service_fee"]<0){
		$service_fee = $order["service_fee"];

	}else{
		$service_fee = $order["changed_service_fee"];

	}

}else{

	$loginUser = runFunc('readSession',array());
	$tmpUser = runFunc('readCookie',array());
	if($loginUser == ""){

		$current_user_id =  $tmpUser;
	}else{
		$current_user_id =  $loginUser;
	}
	if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){

		$items = runFunc("getUserCart",array($current_user_id,false,2,$cartIdStr));
	}else{
		if($cartIdStr){
			$items = runFunc("getUserCart",array($current_user_id,false,1,$cartIdStr));
		}else{
			$items = runFunc("getUserCart",array($current_user_id));
		}
	}

	$subTotal = 0;
	$service_fee = 0;
	//$freight = $setting[0]["freight"] * count($items);
	$itemcounts = 0;
	foreach($items as $item){
		$subTotal += ($item["itemPrice"] * $item["ItemQTY"]);
		if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){
			$group_buy_item = runFunc("getSiteGroupBuyItem",array($item["goodsid"]));
			if($group_buy_item[0]["sell_way"] == 1){

				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $group_buy_item[0]["price_rate"]* $setting[0]["service_fee"];
			}else{
				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $setting[0]["service_fee"];
			}
		}else{
			if($item["ItemType"] == "ivi"){
				$service_fee += 0;
			}else{
				$service_fee += $item["itemPrice"] * $item["ItemQTY"] * $setting[0]["service_fee"];
				$itemcounts++;
			}
		}
	}
	$freight = $setting[0]["freight"] * $itemcounts;
	if($this->_tpl_vars["IN"]["check_type"]!="group_buy"){
		//$service_fee = $subTotal  * $setting[0]["service_fee"];
		if($service_fee<20 && $service_fee > 0){
			$service_fee = 20;
		}
	}
}
?>
<div class="subMitRight fr">
	<h2 style="border-bottom: 1px solid; color: #51555D; font-size: 14px; font-weight: bold; padding: 5px;margin-top:17px">
	PAYMENT INFO
	<?php if($this->_tpl_vars["method"]!="WOWd2d"):?>
	<?php if($order["changed_by_admin"]>0):?>
	<font style="color:#7C0000;font-size:12px;">changed by seller</font>
	<?php endif;?>
	<?php endif;?>
	</h2>
	<table class="subMitNameSubTotal">
		<tr>
			<td width="100%" style="line-height: 24px;">Merchandise Sub-Total</td>
		</tr>
		<tr width="100%">
			<td align="right">¥ <?php echo number_format($subTotal, 2, '.', ',');?></td>
		</tr>
	</table>
	<table class="subMitNameSubTotal" style="margin-top: 30px;">

		<tr style="margin-top: 35px;">
			<td>Seller Freight Total</td>
		</tr>
		<tr>
			<td align="right"><?php if ($freight<=0){?>No Freight<?php }else{ ?>
							¥ <?php echo number_format($freight, 2, '.', ','); ?>
						 <?php } ?></td>
		</tr>
	</table>
	<!--
	<table class="subMitNameSubTotal" style="margin-top: 30px;">
		<tr>
			<td>Delivery and Processing</td>
		</tr>
		<tr>
			<td style="color: #bad782;" align="right">¥ 0.00<br> <em
				style="float: left; font-size: 10px;">Specil delivery services are
					not avalible yet </em>
			</td>
		</tr>
	</table>
 -->
	<table class="subMitNameSubTotal" style="margin-top: 30px;">

		<tr>
			<td>Service Fee <?php if($this->_tpl_vars["IN"]["check_type"]!="group_buy"):?>(<?php echo $setting[0]["service_fee"]*100;?>%)<?php endif;?></td>

		</tr>
		<tr>

			<td valign="top" align="right">
			¥ <?php echo number_format($service_fee, 2, '.', ',');?>
			</td>
		</tr>

	</table>
	<?php if($this->_tpl_vars["method"]!="WOWd2d" and $order["group_buy"]==0){?>
	<table style="margin-top: 35px;" width="100%">
		<tr>
			<td><span class="coupons_error_box"></span></td>
		</tr>
		<tr>
			<td>
			<?php if($order["coupons"]==""):?>
			<input style="width: 100%; height: 15px;" type="text" id="coupons_code" value="Coupons"/>
			<?php else:?>
			<div class="payment_info_title_word fl">Coupon used: </div>
			<div class="fr coupon_word"><?php echo $order["coupon_word"];?></div>
			<div class="fl" style="width:100%"><?php echo $order["coupons"];?></div>
			<div class="fr"><a href="<?php echo runFunc('encrypt_url',array('action=shop&method=coupon_cancel&order_id='.$order["orderID"]));?>" onClick="javascript:return confirm('You don\'t want to use this coupon ?')" id="cancel_coupon_button">Cancel This Coupon</a></div>
			<?php endif;?>
		</td>
		</tr>
		<tr>
			<td>

			<br />
			<?php if($order["coupons"]==""):?>
				<input type="button" value="APPLY"
				style="width: 84px; border: height: 22px; font-weight: bold; color: #777777;"
				class="submit_coupons fr">
			<?php endif;?>
			</td>
		</tr>
	</table>
	<?php }?>
	<!--

	 -->
	<?php if($this->_tpl_vars["method"]=="WOWd2d"){?>
	<script type="text/javascript">
		$(function(){

				var tax = <?php echo ($subTotal+$freight + $service_fee)*$setting[0]["tax_rate"];?>;
				var amount = <?php echo $freight + $subTotal + $service_fee;?>;
				$(".order_invoice").click(function(){
					if($(this).val() == 1){
						$("#tax_view").text("¥ "+setCurrency(tax));
						$("#order_amount").text("¥ "+setCurrency(amount + tax));
					}else{
						$("#tax_view").text("¥ 0.00");
						$("#order_amount").text("¥ "+setCurrency(amount));
					}
				});
		});
	</script>
	<form id="submit_form" action="/publish/index.php" method="post">
	<script type="text/javascript">
		$(function(){

				$("#invoice_help").qtip({
					   content: 'Attention: If you choose to need invoice, it must assume <?php echo $setting[0]["tax_rate"] * 100;?>% tax.<br/>Specific billing issues by e-mail and communicate with our Customer Service.',
					   show: 'mouseover',
					    position: {
						  corner: {
							 target: 'topLeft',
							 tooltip: 'bottomLeft'
						  }
					   },
					   style: {
						      name: 'cream'
						   }

					});
			});
	</script>
	<table style="margin-top: 25px; font-size: 14px;" width="100%">
		<tr>
			<td width="30%">Invoice<span id="invoice_help" style="margin-left: 5px; color: #c11361; font-size: 14px; font-weight: bold;cursor:pointer;">?</span>
			</td>
			<td width="70%">
			<input id="invoice_yes" class="order_invoice" style="margin-left: 10px; margin-right: 10px;" width="60%" type="radio" name="invoice" value="1" />
			<label for="invoice_yes">yes</label>
			<input id="invoice_no" class="order_invoice" style="margin-left: 10px; margin-right: 10px;" width="50%"  checked="checked" type="radio" name="invoice" value="0" />
			<label for="invoice_no">no,thank you</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>

	</table>
	<?php }?>
	<table class="subMitNameSubTotal" style="margin-bottom: 30px;">

		<tr>
			<td>Estimated Tax</td>
		</tr>
		<tr>
			<td id="tax_view" align="right">
			<?php if($this->_tpl_vars["method"]=="WOWd2d"):?>
			¥ 0.00
			<?php else:?>
			<?php if($order["invoice"]>0):?>
			<?php echo "¥ ".$order["tax"];?>
			<?php else:?>
			¥ 0.00
			<?php endif;?>
			<?php endif;?>
			</td>
		</tr>
	</table>
	<?php if($this->_tpl_vars["method"]!="WOWd2d" and $order["orderStatus"]>4):?>
	<table class="subMitNameSubTotal" style="margin-bottom: 30px;">

		<tr>
			<td>Payment</td>
		</tr>
		<tr>
			<td id="tax_view" align="right">
				<?php echo runFunc("getOrderPayment",array($order["orderID"],true));?>
			</td>
		</tr>
	</table>
	<?php endif;?>
	<table class="subMitNameSubTotal" style="font-weight: bold;">

		<tr>
			<td style="border-top: 1px solid #51555D;">Your Order Total</td>
		</tr>
		<tr>
			<td id="order_amount" align="right">¥
			<?php if($this->_tpl_vars["method"]=="WOWd2d"):?>
			<?php echo number_format($freight + $subTotal + $service_fee , 2, '.', ',');?>
			<?php else:?>
			<span id="order_total_amount"><?php echo number_format($order["totalAmount"], 2, '.', ',');?></span>
			<?php endif;?>
			</td>
		</tr>

		<tr>
			<td>
			<?php if(count($address)>0 and $this->_tpl_vars["IN"]["type"] ==""){?>

					<input type="hidden" name="action" value="shop">
					<input type="hidden" name="method" value="submitOrder">
                    <input type="hidden" name="cartIdStr" value="<?php echo $cartIdStr;?>">
					<?php if($this->_tpl_vars["IN"]["check_type"] == "group_buy"):?>
					<input type="hidden" name="check_type" value="group_buy" />
					<?php endif;?>
					<input type="hidden" id="orderAddressId" name="orderAddressId" value="<?php echo $address["addressId"];?>" />
					<input style="margin-top: 5px;" type="submit" value="SUBMIT" class="pay_submit fr" />
					<p style="float: right;font-size: 11px;font-weight: normal;margin-top: 10px;">Note: Item total price below 200RMB will be charge at least 20RMB service fee.</p>
			</form>

			<?php }?>

		<?php if($order["orderStatus"]==4 and $loginUser ==""):?>
		<input style="margin-top: 5px;" id="register_pay" type="button" value="SUBMIT" class="pay_submit fr" />
		 <p style="float: right;font-size: 11px;font-weight: normal;margin-top: 10px;">Note: Item total price below 200RMB will be charge at least 20RMB service fee.</p>
		<script type="text/javascript">
			$(function(){
				$("#register_pay").click(function(){
					$("#order_regist_form").submit();
				});
			})
		</script>
		<?php endif;?>
		<?php if($order["orderStatus"]==4 and $loginUser !="" and $this->_tpl_vars["method"]=="payment"):?>
		<a style="margin-top: 5px;text-align:center;line-height:22px;" class="pay_submit fr cp">PAY</a>
		<p style="float: right;font-size: 11px;font-weight: normal;margin-top: 10px;">Note: Item total price below 200RMB will be charge at least 20RMB service fee.</p>
		<script type="text/javascript">
			 $(function(){
				$(".payment_note_box").dialog({
					autoOpen: false,
					show: { effect: 'drop', direction: "up" },
					hide: { effect: 'drop', direction: "up" },
					width: 430,
					modal: true
					});
				<?php if(!$this->_tpl_vars["IN"]["guestOrder"]):?>
				$(".payment_note_box").dialog("open");
				<?php endif;?>
				$(".payment_note_box_close").click(function(){
						window.location.href="<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>";
						return false;
					});
				$(".payment_note_box_submit").click(function(){
					//$("#final_pay_form").submit();
					$(".payment_note_box").dialog( "close" );
				});
					$(".pay_submit").click(function(){

						if($(".select_payment_button:checked").val()==3 && $("#card_type").val()=="" ){
								alert("Please select your card type.")
								return false;
						}else{
							$("#final_pay_form").submit();
						}

                     });
			});

		</script>
		<?php endif;?>
		<?php if($order["orderStatus"]==4 and $loginUser !="" and ($this->_tpl_vars["method"]=="orderSubmit" or $this->_tpl_vars["method"] == "orderPayFailed")):?>
			 <!--<a style="margin-top: 5px;text-align:center;line-height:22px;" href="<?php echo runFunc('encrypt_url',array('action=shop&method=payment&orderID=' . $order["orderID"]));?>"  class="pay_submit fr cp">PAY</a>-->
			 <p style="float: right;font-size: 11px;font-weight: normal;margin-top: 10px;">Note: Item total price below 200RMB will be charge at least 20RMB service fee.</p>
		<?php endif;?>

		<?php if($order["orderStatus"]==7 and $loginUser !=""):?>
		<a onClick="javascript:return confirm('Are you sure you get what you need?')" style="margin-top: 5px;text-align:center;line-height:22px;" class="pay_submit fr" href="<?php echo runFunc('encrypt_url',array('action=shop&method=order_final_confirm&orderID=' . $order["orderID"]));?>">Confirm</a>
		<?php endif;?>
		</td>
		</tr>
	</table>
<div class="payment_note_box gray_line_box oh hide">
	<div class="payment_note_box_tite">
		NOTE
	</div>
	<div class="payment_note_box_content">
		<p style="color:#af0303">Your order has been submitted and is with our customer service. However in case of the following questions (see below) please do not proceed with your payment but instead click CANCEL and await a response from our customer service team. Only once you receive a payment notice, please go to payment information on your account page and finish your order.</p>
        <br />
		<ul>
			<li>The item price shown on WOWshopping differs from the price advertised on Taobao</li>
			<li>Shipping cost charged for each item purchased from the same seller,thus multiplying your total shipping fee</li>
		</ul>
		<p>WOWshopping delivery fee is a fixed amount of 15RMB. You won’t be charged extra, even if the actual shipping cost is higher.</p>
		<p>However WOWshopping reserves the right to still charge the fixed amount when actual shipping cost is lower than the fixed rate, as sellers determine their delivery rate. Package weight and distance also change with each order.</p>
	</div>
	<div class="payment_note_box_ctrls">
		<input class="payment_note_box_submit blue_button_sm" type="submit" value="Proceed" />
		<a class="payment_note_box_close">Cancel</a>
	</div>
</div>
</div>

<script type="text/javascript">
	$(function(){

		function setMoneyCurrency(s){
			s = String(s);
			if(s.indexOf('-')==0){
				//计算负数
				s= s.substring(1,s.lenght);
				alert("ddddd"+s);
				if(/[^0-9\.\-]/.test(s)) return "invalid value";
				s=s.replace(/^(\d*)$/,"$1.");

				s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
				s=s.replace(".",",");
				var re=/(\d)(\d{3},)/;
				while(re.test(s))
				s=s.replace(re,"$1,$2");
				s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

				return '-'+s.replace(/^\./,"0.")
			}else{
				//计算正数
				if(/[^0-9\.\-]/.test(s)) return "invalid value";
				s=s.replace(/^(\d*)$/,"$1.");

				s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
				s=s.replace(".",",");
				var re=/(\d)(\d{3},)/;
				while(re.test(s))
				s=s.replace(re,"$1,$2");
				s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

				return s.replace(/^\./,"0.")
			}
		}

			$("#coupons_code").focus(function(){
				if($(this).val() == "Coupons"){
						$(this).val("");
					}
			});

			$("#coupons_code").blur(function(){
				if($(this).val() == ""){
						$(this).val("Coupons");
					}
			});

			$(".submit_coupons").click(function(){


				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "shop",
						method	: "use_coupons",
						coupon_code:$("#coupons_code").val(),
						order_id:"<?php echo $this->_tpl_vars["IN"]["orderID"];?>"

					},
					success : function(json)
					{

						if(json.error==1){
							$(".coupons_error_box").text("Your coupon code is incorrect.");
						}
						if(json.error==2){
							$(".coupons_error_box").text("Your coupon code is already used.");
						}
						if(json.error==3){
							$(".coupons_error_box").text("Total amount must be more than "+ json.limit +" RMB.");
						}
						if(json.error==0){

							$(".coupons_error_box").text("");
							$("#order_total_amount").text(setMoneyCurrency(json.order_current_amount));
							var cancel_link_html = '<div class="fr"><a href="<?php echo runFunc('encrypt_url',array('action=shop&method=coupon_cancel&order_id='.$order["orderID"]));?>" onClick="javascript:return confirm(\'You do not want to use this coupon ?\')" id="cancel_coupon_button">Cancel This Coupon</a></div>';
							$("#coupons_code").replaceWith("<div class='payment_info_title_word fl'>Coupon used: </div><div class='fr coupon_word'>"+json.coupon_word+"</div><div class='fl' style='width:100%'>"+json.code+"</div>" + cancel_link_html);
							$(".submit_coupons").remove();
							}

					},complete: function(){

						}
				});

				});
		});
</script>