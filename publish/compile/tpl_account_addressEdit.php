<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
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
<script src="/skin/js/formValidator/formValidator-4.1.3.js"></script>
<script src="/skin/js/formValidator/formValidatorRegex.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$.formValidator.initConfig({formID:"addressForm",theme:"address",submitOnce:false,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#firstName").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});
	
	$("#lastName").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});
	
	$("#address1").formValidator({onShowText:"Apartment, suite, unit, building,floor, etc."}).inputValidator({min:3,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});

	$("#address2").formValidator({onShowText:"Street address, P.O.box, company name, c/o"}).inputValidator({min:3,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});

	$("#province").regexValidator({regExp:"notempty",dataType:"enum",onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});
	
	$("#city").regexValidator({regExp:"notempty",dataType:"enum",onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});
	
	$("#country").regexValidator({regExp:"notempty",dataType:"enum",onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#phone1").regexValidator({regExp:"notempty",dataType:"enum",onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	

	//是否选中默认
	$("#isdefaultCheckBox").click(function (){
		if($(this).val() == 0){
			$(this).attr("checked","checked");
			$(this).val("1");
		}else{
		   $(this).removeAttr("checked");
		   $(this).val("0");
		}
	});
});

//提交添加地址
function submitAddress(){
	var validator = $.formValidator.pageIsValid();
	if(validator){
		$("#addressForm").submit();
	}
}

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
	$countries = runFunc("getShippingCountries");
	//获取用户的所有地址
	$addressId = $this->_tpl_vars["IN"]["addressID"];
	$list_addresses = runFunc("getUserAddressByAddressId",array($this->_tpl_vars["name"],$addressId));	
?>			
 			
<div class="content">
        <div class="notic_content">
            <div class="notic_header">
                <h1>Update Shipping Address</h1>
                <h2>Choose a shipping address and modify</h2>
                <div id="cartTwoTitleAll" style="float:right;">
                <a class="newAddress" href="<?php echo "/publish/index.php".runFunc('encrypt_url',array("action=account&method=address"));?>">Address List</a>
           	    </div>
            </div>
        </div> 
		<div class="address_manage">
		<?php if($list_addresses):?>

            <form class="address_form " id="addressForm" name="addressForm" action="/publish/index.php" method="post">
            <div class="address">
                <div class="addresscont">
            
                   <table border="0" width="925px" class="addresstab">
                        <th>Shipping Address</th>
                        <tr>
                            <td class="placeholder"><label>Mr</label></td>                           
                            <td class="addressRadio">
                            	<input type="radio" name="Mr" <?php if($list_addresses[0]["Mr"] == "Mr"):?>checked="checked"<?php endif;?> value="Mr"  />
                                <label>Mrs&nbsp;&nbsp;&nbsp;</label><input type="radio" name="Mr" <?php if($list_addresses[0]["Mr"] == "Mrs"):?>checked="checked"<?php endif;?> value="Mrs"  />Miss&nbsp;&nbsp;&nbsp;<input type="radio" name="Mr" value="Miss" <?php if($list_addresses[0]["Mr"] == "Miss"):?>checked="checked"<?php endif;?>  />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                          <td class="placeholder"><label>First Name</label></td>
                          <td>
                            <input type="text" name="firstName" id="firstName"  value="<?php echo $list_addresses[0]["firstName"];?>" />&nbsp;&nbsp;<span style="font-size:14px;color:#979595;">Last Name</span>&nbsp;&nbsp;<input type="text" name="lastName" id="lastName"  value="<?php echo $list_addresses[0]["lastName"];?>" />
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

                            <input type="text" class="street" name="address1" id="address1"  value="<?php echo $list_addresses[0]["address1"];?>" />
                            </td>

                        </tr>
                        <tr>
                          <td class="placeholder"><label>Address Line 2</label></td>
                          <td>
                            <input type="text" class="street" name="address2" id="address2"  value="<?php echo $list_addresses[0]["address2"];?>" />
                            </td>
                         
                        </tr>

                        <tr>
                        <td class="placeholder"><label>State/Province/Region</label></td>
                        <td>
                         <input type="text" name="province" id="province"  value="<?php echo $list_addresses[0]["province"];?>" />
                        </td>
         
                        </tr>

                        <tr>
                        <td class="placeholder"><label>City  (Current location)</label></td>
                        <td>
                        <input type="text" id="city" name="city" value="<?php echo $list_addresses[0]["city"];?>" />
                       
                        </td>
                   
                        </tr>

                        <tr>
                            <td class="placeholder"><label>Country (Current location)</label></td>
                            <td>
                            <select name="country" id="country">
                                <?php foreach ($countries as $country):?>
                                <option value="<?php echo $country["country"];?>" <?php if($country["country"] == $list_addresses[0]["country"]){echo 'selected';} ?>>
                                    <?php echo $country["country"];?>
                                </option>
                                <?php endforeach;?>
                            </select>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="placeholder"><label>Zip (Optional)</label></td>
                            <td>
                            <input id="zipcode" type="text" name="zip" value="<?php echo $list_addresses[0]["zipcode"];?>" />
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 1</label></td>
                            <td><input type="text" name="telephone" id="phone1"  value="<?php echo $list_addresses[0]["telephone"];?>" />
                         
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 2 (Optional)</label></td>
                            <td><input type="text" name="cellphone" id="phone2"  value="<?php echo $list_addresses[0]["cellphone"];?>" />
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
                            <td><input type="text" name="email" id="email"  value="<?php echo $list_addresses[0]["email"];?>" />
                            </td>
                        </tr> 
                        <tr>
                            <td align="right"><input type="checkbox" name="isdefault" id="isdefaultCheckBox" <?php if($list_addresses[0]["set_default"]):?>checked="checked"<?php endif;?> value="<?php echo $list_addresses[0]["set_default"];?>" style="width:20px;margin-right:20px;" /></td>
                            <td style="color:#333;font:normal 14px Arial, Helvetica, sans-serif;">Save as my default shipping information</td>                            
                        </tr>
                    </table>
            
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="action" value="account">
                    <input type="hidden" name="method" value="addressSave">
                    <input type="hidden" name="addressId" value="<?php echo $addressId;?>">
                </div>
            </div>
            <div class="cartToConfirm">
            <button class="Continue" type="button" name="saveAddress" id="address_submit" onclick="submitAddress();">Save</button>
            </div> 
            </form>
            <div class="clb"></div>
        <?php endif;?>
			<div style="width:976px;height:150px;"></div>		  
		</div>
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

			
		</div>
	</body>
</html>
<?php }else{ ?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>