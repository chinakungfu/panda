<div id="addressCreate" class="<?php if($list_addresses){echo 'hide';}?>">
<?php $user_info = runFunc("getStaffInfoById",array($userid)); ?>
<form class="address_form " id="addressForm" name="addressForm" action="/publish/index.php" method="post">
<div class="address">
	<div class="addresscont">

                   <table border="0" width="925px" class="addresstab">
                    	<th>Shipping Address</th>
                        <tr>
                        	<td class="placeholder"><label>Mr</label></td>                           
                            <td class="addressRadio"><input type="radio" name="Mr" checked="checked" value="Mr"  /><label>Mrs&nbsp;&nbsp;&nbsp;</label><input type="radio" name="Mr" value="Mrs"  />Miss&nbsp;&nbsp;&nbsp;<input type="radio" name="Mr" value="Miss"  /></td>
							<td></td>
                        </tr>
                        <tr>
                          <td class="placeholder"><label>First Name</label></td>
                          <td style="height:40px; vertical-align:middle; text-align:left; overflow:hidden;">
                            <input type="text" name="firstName" id="firstName"  value="" />&nbsp;&nbsp;<span style="font-size:14px;color:#979595;">Last Name</span>&nbsp;&nbsp;<input type="text" name="lastName" id="lastName"  value="" />
                            </td>
                           	<td class="addressRemark" rowspan="8">
                                <p>•  Signature may be required for delivery.</p>
    
                                <p>•  You can use English to enter your Chinese home address.</p>
                                
                                <p>•  TAOBAO sellers ship directly to your specified address.</p>
                                
                                <p>•  International shipping is available however additional </p>
                                <p>&nbsp;&nbsp;fees will be incurred.</p>
							</td>                    
                        </tr>                        
                        <tr>
                          <td class="placeholder"><label>Address Line 1</label></td>
                          <td style="height:40px; vertical-align:middle; text-align:left; overflow:hidden;width:360px;">

                            <input type="text" class="street" name="address1" id="address1"  value="" />
                            </td>

                        </tr>
                        <tr>
                          <td class="placeholder"><label>Address Line 2</label></td>
                          <td>
                            <input type="text" class="street" name="address2" id="address2"  value="" />
                            </td>
                         
                        </tr>

                        <tr>
                        <td class="placeholder"><label>State/Province/Region</label></td>
                        <td>
                         <input type="text" name="province" id="province"  value="" />
                        </td>
         
                        </tr>

                        <tr>
                        <td class="placeholder"><label>City  (Current location)</label></td>
                        <td>
						<input type="text" id="city" name="city" value="" />
                       
                        </td>
                   
                        </tr>

                        <tr>
                            <td class="placeholder"><label>Country (Current location)</label></td>
                            <td>
                            <select name="country" id="country">
								<?php foreach ($countries as $country):?>
                                <option value="<?php echo $country["country"];?>" <?php if($country["country"] == 'China'){echo 'selected';} ?>>
                                    <?php echo $country["country"];?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="placeholder"><label>Zip (Optional)</label></td>
                            <td>
                            <input id="zipcode" style="color:#000;" type="text" name="zip" value="" />
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 1</label></td>
                            <td><input type="text" name="telephone" id="phone1"  value="" />
                         
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 2 (Optional)</label></td>
                            <td><input type="text" style="color:#000;" name="cellphone" id="phone2"  value="" />
                            </td>
                            
                        </tr>
                        <tr>
                        	<td class="placeholder" style="color:#333;font-weight:bold;"><label>Shipping Notifications</label></td>
                        	<td></td>
                       	</tr>
                        <tr>
                        	<td></td>
                        	<td style="color:#979595;font-size:14px;">Shipment notification emails are sent to the default email address Another recipient email address may be added below.</td>
                        </tr>
                        <tr>
                        	<td class="placeholder"><label>Email Address (Optional)</label></td>
                            <td><input type="text" name="email" id="email"  value="" />
                            </td>
                        </tr> 
                        <tr>
                        	<td align="right"><input type="checkbox" name="isdefault" id="isdefaultCheckBox" checked="checked" value="1" style="width:20px;margin-right:20px;border:none;" /></td>
                            <td style="color:#333;font:normal 14px Arial, Helvetica, sans-serif;">Save as my default shipping information</td>                            
                        </tr>
                    </table>

                <input type="hidden" name="user_id" value="<?php echo $userid;?>">
                <input type="hidden" name="type" id="dataTypeInput" value="insert">
                <input type="hidden" name="addressId" id="addressIdInput" value="">
        </div>
    </div>
    <div class="cartToConfirm">
    
    <button class="cartContinue" type="button" name="cartToConfirm" id="address_submit" onclick="submitAddress();">Save</button>
    <a class="cancelBtn fr" id="addressCancel">Cancel</a>
    </div> 
	</form>
</div>
<div class="clb"></div>

