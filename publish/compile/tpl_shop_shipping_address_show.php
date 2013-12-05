<table class="inputAdderss">
	<tr>
		<th width="25%" style="color: white;">
			<span style="margin-left: 16px;">SHIPPING</span>
		</th>
		<?php if(runFunc('readSession',array())):?>
		<th width="50%" style="text-align: center;">
		<a id="new_address_request" style="font-weight: normal; color: #BAD782;" href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=WOWd2d&type=create&check_type='.$this->_tpl_vars["IN"]["check_type"].'&cartIdStr='.$cartIdStr));?>">
		Enter a new shipping address</a>
		</th>
		<?php endif;?>
		<th width="25%">
			<span style="float: right; margin-right: 24px;">
				<a id="edit_request" style="color: #BAD782;">EDIT</a>
			</span>
			<form id="address_edit_request" method="post" action="/publish/index.php">
				<input type="hidden" name="action" value="shop" />
				<input type="hidden" name="method" value="WOWd2d" />
				<input type="hidden" name="type" value="edit" />
				<input type="hidden" name="check_type" value="<?php echo $this->_tpl_vars["IN"]["check_type"];?>">
				<input type="hidden" name="cartIdStr" value="<?php echo $cartIdStr;?>">
				<input id="addressId_current" type="hidden" name="addressId" value="<?php echo $address["addressId"];?>" />
			</form>
		</th>

		</tr>
	</table>
	<div class="default_address fl">
		<span>Using address</span>
	</div>
	<table class="inputAdderssTable1 fl">
		<tbody>
			<tr>
				<td><input id="using_fullName" type="text" disabled="disabled" value="<?php echo $address["fullName"];?>" />
				</td>
			</tr>
			<tr>
				<td><input id="using_address1" type="text" disabled="disabled" value="<?php echo $address["address1"];?>" />
				</td>
			</tr>
			<tr>
				<td><input id="using_address2" type="text" disabled="disabled" value="<?php echo $address["address2"];?>" />
				</td>
			</tr>
		</tbody>
	</table>

	<table class="inputAdderssTable2 fl">
		<tbody>
			<tr>
				<td><input id="using_country" style="margin-top: 10px;" type="text" disabled="disabled" value="<?php echo $address["country"];?>" />
			</tr>
			<tr>
				<td><input id="using_province" type="text" disabled="disabled"
					value="<?php echo $address["province"];?>" />
				</td>
			</tr>
			<tr>
				<td><input id="using_city" type="text" disabled="disabled"
					value="<?php echo $address["city"];?>" /></td>
			</tr>
			<tr>
				<td><input id="using_cellphone" type="text" disabled="disabled"
					value="<?php echo $address["cellphone"];?>" />
				</td>
			</tr>
			<tr>
				<td><input id="using_telephone" type="text" disabled="disabled" value="<?php echo $address["telephone"];?>" />
				</td>
			</tr>
			<tr>
				<td><input id="using_zip" type="text" disabled="disabled" value="<?php echo $address["zipcode"];?>" />
				</td>
			</tr>

		</tbody>
	</table>
	<table class="order_notice">
		<tr>
			<td>
				<p style="margin-top: 10px; color: #b6b6b6;">Shipping your order to
					someone else? By providing a shipping contact phone and email
					address, we may contact the recipient with any questions about
					delivery</p>
				<p style="margin-top: 10px; color: #b6b6b6;">Special note for gift
					givers By including the recipient’s email address, you’re giving us
					permission to send them a confirmation email. If this is a gift,
					there’s a pretty good chance that email will spoil the "surprise"
					of a cool new gift arriving at their door.</p>
				<p style="color: #BAD782; margin-top: 10px;">You’d better provide
					your address in Chinese, if you couldn’t, our customer service will
					help you for the further information about your order later.</p>
			</td>
		</tr>
		</tbody>
	</table>
	<table class="inputAdderssTable3">
			<tr>
				<td><input type="text" class="fl" disabled="disabled" id="using_email" value="<?php echo $address["email"];?>" />
				</td>
			</tr>
		</table>
