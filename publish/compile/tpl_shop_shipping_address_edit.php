<?php
$loginUser = runFunc('readSession',array());
$tmpUser = runFunc('readCookie',array());
if($loginUser == ""){

	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}
?>
<form class="address_form " id="address_form" name="address_form" action="/publish/index.php" method="post">
		<table class="inputAdderss">
			<tr>
			<th width="25%" style="color: white;">
			<span style="margin-left: 16px;">SHIPPING</span>
			</th>
			<th width="50%" style="text-align: center;"></th>
			<th width="25%"></th>
			</tr>
		</table>
		<div class="default_address fl" style="font-size: 11px;">
			<table class="address_name1">
				<tr>
					<td style="line-height: 20px">Full Name *</td>
				</tr>
				<tr style="line-height: 61px;">
					<td>Address Line 1 *</td>
				</tr>
				<tr style="line-height: 24px;">
					<td>Address Line 2 (Optional)</td>
				</tr>
			</table>
			<table class="address_name">
				<tr>
					<td>Country *</td>
				</tr>
				<tr>
					<td>State/Province/Region *</td>
				</tr>
				<tr>
					<td>City *</td>
				</tr>
				<tr>
					<td>Zip (Optional)</td>
				</tr>
				<tr>
					<td>Phone 1 *</td>
				</tr>
				<tr>
					<td>Phone 2 (Optional)</td>
				</tr>
				<tr>
					<td>Email Address *</td>
				</tr>
			</table>
		</div>
		<input type="hidden" name="action" value="shop">
		<input type="hidden" name="user_id" value="<?php echo $current_user_id;?>">
		<input type="hidden" name = "address_id" value="<?php echo $address["addressId"];?>"/>
		<input type="hidden" name="method" value="new_updateAddress">
		<input type="hidden" name="check_type" value="<?php echo $this->_tpl_vars["IN"]["check_type"];?>">
		<input type="hidden" name="cartIdStr" value="<?php echo $this->_tpl_vars["IN"]["cartIdStr"];?>">
		<table class="inputAdderssTable1 fl">
			<tbody>
				<tr>
					<td><input type="text" class="nameText fl required" name="fullName" id="fullName"  value="<?php echo $address["fullName"];?>" />
						<div class="wrong fl" id="wrong_fullName"></div></td>
				</tr>
				<tr>
					<td>
						<input style="margin-top: 15px;" type="text" class="nameText fl required" name="address1" id="address1"  value="<?php echo $address["address1"];?>" />
						<div style="margin-top: 14px;" id="wrong_address1"class="wrong fl"></div>
						<br /><em class="fl">Street address, P.O.box, company name, c/o</em>
					</td>
				</tr>
				<tr>
					<td><input type="text" class="nameText fl" name="address2" id="address2"  value="<?php echo $address["address2"];?>" /><br />
						<em class="fl">Apartment, suite, unit, building,floor, etc.</em></td>
				</tr>
		</table>
		<table class="inputAdderssTable2 fl">
			<tr>
				<td>
				<select class="required" style="border: medium none; height: 20px; width: 140px; margin-top: 11px;" name="country">
					<?php foreach ($countries as $country):?>
						<option <?php if($address["country"] == $country["country"]){echo "selected=selected";}?> value="<?php echo $country["country"];?>">
							<?php echo $country["country"];?>
						</option>
						<?php endforeach;?>
				</select>
				</td>
			</tr>
			<tr>
				<td><input type="text" class="nameTextC required" name="province" id="region"  value="<?php echo $address["province"];?>" />
					<div id="wrong_region" class="wrong fl" style="margin-top: 22px;"></div>
				</td>
			</tr>

			<tr>
				<td class="fl"><input type="text" class="required" id="city" name="city" value="<?php echo $address["city"];?>" />
					<div class="wrong fl" id="wrong_city" style="margin-top: 22px;"></div>
				</td>
			</tr>
			<tr>
				<td><input id="zipcode" type="text" name="zip" value="<?php echo $address["zipcode"];?>" />
				</td>
			</tr>
			<tr>
				<td><input type="text" class="nameTextC required" name="cellphone" id="phone1"  value="<?php echo $address["cellphone"];?>" />
					<div class="wrong fl " id="wrong_cellphone" style="margin-top: 22px;"></div>
				</td>
			</tr>
			<tr>
				<td><input type="text" class="nameTextC" name="telephone" id="phone2"  value="<?php echo $address["telephone"];?>" />
				</td>
			</tr>
		</table>
		<table class="order_notice">
			<tr>
				<td>
					<p style="margin-top: 10px; color: #b6b6b6;">
						Shipping your order to someone else?<br /> By providing a shipping
						contact phone and email address, we may contact the recipient with
						any questions about delivery
					</p>
					<p style="margin-top: 10px; color: #b6b6b6;">
						Special note for gift givers <br />By including the recipient’s
						email address, you’re giving us permission to send them a
						confirmation email. If this is a gift, there’s a pretty good
						chance that email will spoil the "surprise" of a cool new gift
						arriving at their door.
					</p>
					<p style="color: #BAD782; margin-top: 10px;">You’d better provide
						your address in Chinese, if you couldn’t, our customer service
						will help you for the further information about your order later.</p>
				</td>
			</tr>
			</tbody>
		</table>

		<table class="inputAdderssTable3">
			<tr>
				<td><input type="text" class="fl email" id="email" name="email" value="<?php echo $address["email"];?>" />
					<div id="wrong_email" class="wrong fr"></div>
				</td>

			</tr>
		</table>

		<table style="float: left; line-height: 40px;width:100%">
			<tr>
				<td style="color: white; float: left; font-size: 10px; margin-left: 30px;line-height: 23px;">
				This email will automatic become your username to log in our website,after you submit, you need set your password.
				</td>
			</tr>
			<tr>
				<td><a href="<?php echo runFunc('encrypt_url',array("action=shop&method=WOWd2d&cartIdStr=".$cartIdStr."&check_type=".$this->_tpl_vars["IN"]["check_type"]));?>" class="order_submit fr register_address" style="display:block;text-align:center;color: white;margin-bottom:28px;margin-right: 20px;margin-top: 45px;" >CANCEL</a> <input class="order_submit fr register_address" style="color: white;margin-bottom:28px;margin-right: 20px;margin-top: 45px;" type="submit" value="SAVE" /></td>
			</tr>
		</table>
	</form>


<script type="text/javascript">
	$(function(){

		$("#address_form").validate({

			errorPlacement: function(error, element) {
				if($(error).text()!="This field is required."){
				if($(element).attr("id") == "email"){
					error.insertAfter(element);
					}
				}

        	},rules: {
        		email: {
                email: true,
                <?php if($loginUser==""):?>
                required: true,
                remote: "/check_mail.php"
                <?php endif;?>
              }
        	},messages: {
        	    email: { remote: "Already subscribed",required:" ",email:" "}
        	  }

			});


	});
</script>