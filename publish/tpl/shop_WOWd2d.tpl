<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>    
	</head>
	<script type="text/javascript">
	
	function clickRadio()
	{
		$("#fullName").val('');
		$("#address1").val('');
		$("#address2").val('');
		$("#country").val('');
		$("#region").val('');
		$("#city").val('');
		$("#zip").val('');
		$("#phone1").val('');
		$("#phone2").val('');
		$("#emailAddress").val('');
	}
	function cancelRadioCheck(name)
	{
		$("input:radio").each(function()
		{
		  this.checked = false;
		}); 
	}	
	</script>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			<pp:var name="SubTotalPrice" value="0"/>
			
			<cms action="sql" return="orderDetail" query="SELECT * FROM a0222211743.cms_publish_order WHERE orderID='{$IN.orderID}' limit 1" />

			<pp:if expr="$orderDetail.data.0.serviceName=='1'">
				<pp:var name="serviceStr" value="'WOW Express'"/>
			<pp:elseif expr="$orderDetail.data.0.serviceName=='2'">
				<pp:var name="serviceStr" value="'WOW Collect&go'"/>
			<pp:elseif expr="$orderDetail.data.0.serviceName=='3'">
				<pp:var name="serviceStr" value="'WOW Premium Service'"/>
			</pp:if>

			<!--content info-->
			<form action="/publish/index.php" method="post" onsubmit="return checkRadio('para[orderAddress]')">
			
			<input type="hidden" name="action" value="shop">
			<input type="hidden" name="method" value="updateAddress">
			<input type="hidden" name="para[orderID]" value="[$IN.orderID]">
			<input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]&orderID=[$IN.orderID]">

			<div class="content">
			    <div class="inputAdderss">
			    <cms action="sql" return="addressList" query="SELECT * FROM a0222211743.cms_publish_address WHERE userId='{$tmpUser}' and status='1' Order By addressId DESC" />
			    <pp:var name="addressNum" value="sizeof($addressList.data)"/>
			        <h2>You are choosing <span>[$serviceStr]</span> WOW arranges transport</h2>		
				<pp:if expr="$name">
				<pp:if expr="$addressNum>0">
					<p>
					    <span class="addressBook">Address Book</span><span class="addressSelect">Select a shipping address</span>
					    <span class="addressBelow">Is the address you'd like to use displayed below? </span>
					</p>
				</pp:if>				
								
					<div class="inputAdderssDl">   
					<loop name="addressList.data" var="var" key="key">
					<pp:if expr="$key==0">
						<dl>
							<dt><input type="radio" name="para[orderAddress]" value="[$var.addressId]" onclick="clickRadio()"/></dt>
							 <dd class="inputAdderssAdd">[$var.fullName]<br />[$var.address1] <br />[$var.address2]<br />[$var.city], [$var.province]&nbsp;&nbsp;[$var.zipcode] <br />[$var.country] <br />Phone: [$var.cellphone]</dd>
							<dd class="inputAdderssText">
							<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=editOrder&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Edit</a>
							<a href="index.php[@encrypt_url('action=account&method=delOrderAddress&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Delete</a></span>
							</dd>
						</dl>	
					<pp:elseif expr="$key%3==0">
					</div>
					<div class="inputAdderssDl">
						<dl>
							<dt><input type="radio" name="para[orderAddress]" value="[$var.addressId]" onclick="clickRadio()"/></dt>
							 <dd class="inputAdderssAdd">[$var.fullName]<br />[$var.address1] <br />[$var.address2]<br />[$var.city], [$var.province]&nbsp;&nbsp;[$var.zipcode] <br />[$var.country] <br />Phone: [$var.cellphone]</dd>
							<dd class="inputAdderssText">
							<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=editOrder&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Edit</a>
							<a href="index.php[@encrypt_url('action=account&method=delOrderAddress&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Delete</a></span>
							</dd>
						</dl>					
					<pp:else/>
						<dl>
							<dt><input type="radio" name="para[orderAddress]" value="[$var.addressId]" onclick="clickRadio()"/></dt>
							 <dd class="inputAdderssAdd">[$var.fullName]<br />[$var.address1] <br />[$var.address2]<br />[$var.city], [$var.province]&nbsp;&nbsp;[$var.zipcode] <br />[$var.country] <br />Phone: [$var.cellphone]</dd>
							<dd class="inputAdderssText">
							<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=editOrder&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Edit</a>
							<a href="index.php[@encrypt_url('action=account&method=delOrderAddress&addressId=' . $var.addressId . '&orderID=' . $IN.orderID)]">Delete</a></span>
							</dd>
						</dl>
					</if>
				</loop>	
					</div>
				</if>
			    </div>
                <table class="inputAdderssTable">
                    <thead>
                        <tr>
                            <th>Enter a new shipping address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label>Full Name </label><input type="text" class="nameText" name="addressPara[fullName]" id="fullName" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'fullNameMsg','Full name ');"  value="[$IN.fullName]" /><span id="fullNameMsg">*</span></td>
                        </tr>
                        <tr>
                            <td><label>Address Line 1 </label><input type="text"  class="nameText" name="addressPara[address1]" id="address1" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'address1Msg','Address Line 1 ');" value="[$IN.address1]" /><span id="address1Msg">*</span><em>Street address, P.O. box, company name, c/o</em></td>
                        </tr>
                        <tr>
                            <td><label>Address Line 2</label><input type="text"  class="nameText" name="addressPara[address2]" id="address2" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'address2Msg','Address Line 2 ');" value="[$IN.address2]" /><span id="address2Msg">*</span><em>Apartment, suite, unit, building, floor, etc.</em></td>
                        </tr>
                        <tr>
                            <td><label>Country </label><input type="text" class="nameTextC" name="addressPara[country]" id="country" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'countryMsg','Country ');" value="[$IN.country]" /><span id="countryMsg">*</span></td>
                        </tr>
                        <tr>
                            <td><label>State/Province/Region  </label><input type="text" class="nameTextC" name="addressPara[province]" id="region" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'regionMsg','State/Province/Region ');" value="[$IN.province]" /><span id="regionMsg">*</span></td>
                        </tr>
                        <tr>
                            <td><label>City </label><input type="text" class="nameTextC" name="addressPara[city]" id="city" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'cityMsg','City ');" value="[$IN.city]" /><span id="cityMsg">*</span></td>
                        </tr>
			<!--
                        <tr>
                            <td><label>Zip *</label><input type="text" class="nameTextC" name="addressPara[zipcode]" id="zip" onfocus="cancelRadioCheck('para[address]');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" onblur="checkFullName(this,'zipMsg','Zip ');"/><span id="zipMsg">*</span>please check again</td>
                        </tr>
			-->
                        <tr>
                            <td><label>Cell Phone  </label><input type="text" class="nameTextC" name="addressPara[cellphone]" id="phone1" onfocus="cancelRadioCheck('para[address]');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" onblur="checkFullName(this,'phone1Msg','Phone 1 ');" value="[$IN.cellphone]" /><span id="phone1Msg">*</span></td>
                        </tr>
			<!--
                        <tr>
                            <td><label>Phone 2</label><input type="text" class="nameTextC" name="addressPara[cellphone]" id="phone2" onfocus="cancelRadioCheck('para[address]');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');"/><span id="phone2Msg"></span></td>
                        </tr>
			-->
			<pp:if expr="$name">
				<input type="hidden" name="addressPara[emailFlag]" value="0">
				<input type="hidden" name="addressPara[email]" value="[$userInfo.0.staffNo]">
			<pp:else/>
				<input type="hidden" name="addressPara[emailFlag]" value="1">
				<tr>
				    <td><label>Email Address</label><input type="text" class="nameTextE" name="addressPara[email]" id="emailAddress" onfocus="cancelRadioCheck('para[address]');" onblur="checkFullName(this,'emailAddressMsg','Email Address ');" value="[$IN.email]" /><span id="emailAddressMsg">*</span><em>This will be the username you use to log in.</em></td>
				</tr>
			</if>
			
                        <tr>
                            <td>
			    <p style="color:#BAD782; margin-top:10px;">Shop seller arranges home delivery directly. <br />You’d better provide your address in Chinese, if you couldn’t, our customer service will contact you for the further information about your order later.</p></td>
                        </tr>
			<!--
                        <tr>
                            <td><p>Special note for gift givers<br />By including the recipient’s email address, you’re giving us permission to send<br />them a confirmation email.  If this is a gift, there’s a pretty good chance that email<br />will spoil the "surprise" of a cool new gift arriving at their door.</p></td>
                        </tr>
			-->
                    </tbody>
                    <tfoot style="margin-top:-2px;">
                        <tr>
                            <td style="padding-left:261px"><a href="#" class="fl">Delivery &amp; Processing Rates</a><!--<input type="button" value="BACK" class="contInueChose mr12 fl"/>--><input type="submit" value="CONTINUE" class="contInueChose fl"/></td>
                        </tr>
                    </tfoot>
                </table>
		<pp:if expr="$IN.alertStr">
		     <span id="registerMessage" class="passwordE passwordEPostr">
			    [$IN.alertStr]
		    </span>
		</pp:if>
		
            </div>
            </form>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>