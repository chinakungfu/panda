<?php import('core.util.RunFunc');
$this->_tpl_vars["user_id"]=runFunc('readSession',array());
if($this->_tpl_vars["user_id"]==""){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
}
?>
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
	$.formValidator.initConfig({formID:"addressForm",theme:"address",submitOnce:true,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#firstName").inputValidator({min:2,onError:""});
	
	$("#lastName").inputValidator({min:2,onError:""});
	
	$("#address1").formValidator({onShowText:"Apartment, suite, unit, building,floor, etc."}).inputValidator({min:3,onError:""});

	$("#address2").formValidator({onShowText:"Street address, P.O.box, company name, c/o"}).inputValidator({min:3,onError:""});

	$("#province").regexValidator({regExp:"notempty",dataType:"enum",onError:""});
	
	$("#city").regexValidator({regExp:"notempty",dataType:"enum",onError:""});
	
	$("#country").regexValidator({regExp:"notempty",dataType:"enum",onError:""});
	
	$("#phone1").regexValidator({regExp:"notempty",dataType:"enum",onError:""});
	
});



</script>
</head>
<body>
<div class="box">

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	$countries = runFunc("getShippingCountries");
	?>
<form action="/publish/index.php" method="post" id="addressForm">
    <input type="hidden" name="action" value="website">
    <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars["user_id"]; ?>">
    <input type="hidden" name="method" value="addRegAddressSave">
    <input type="hidden" name="type" value="insert">
    <div class="content">
        <div class="address">
            <div class="addresstitle">
                <h1>WELCOME TO WOWshopping</h1>
                <h3>Make checkout easier and faster - just fill out your default shipping address</h3>
            </div>
            <div class="addresscont">
                <div class="addresstab">
                    <table border="0" width="925px">
                    	<th>Shipping Address</th>
                        <tr>
                        	<td class="placeholder"><label>Mr</label></td>                           
                            <td class="addressRadio"><input type="radio" name="Mr" checked="checked" value="Mr"  /><label>Mrs&nbsp;&nbsp;&nbsp;</label><input type="radio" name="Mr" value="Mrs"  />Miss&nbsp;&nbsp;&nbsp;<input type="radio" name="Mr" value="Miss"  /></td>
							<td></td>
                        </tr>
                        <tr>
                          <td class="placeholder"><label>First Name</label></td>
                          <td>
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
                        <td class="placeholder"><label>City  (current location)</label></td>
                        <td>
						<input type="text" id="city" name="city" value="" />
                       
                        </td>
                   
                        </tr>

                        <tr>
                            <td class="placeholder"><label>Country (current location)</label></td>
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
                            <input id="zipcode" style="color:#333;border:1px solid #C1C1C1;" type="text" name="zip" value="" />
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 1</label></td>
                            <td><input type="text" name="cellphone" id="phone1"  value="" />
                         
                            </td>
                         
                        </tr>
                        <tr>
                        <td class="placeholder"><label>Phone 2 (Optional)</label></td>
                            <td><input type="text" style="color:#333;border:1px solid #C1C1C1;" name="telephone" id="phone2"  value="" />
                            </td>
                            
                        </tr>
                        <tr>
                        <td></td>
                        <td colspan="2" class="addressSubmit">
                         
                        <button type="submit" name="regsubmit" id="address_submit">Save</button>
                       	<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex')); ?>" class="addressSkip">Skip</a>
                        </td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
</form>

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