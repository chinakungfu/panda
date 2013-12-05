<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>  
	</head>
	<!--
	<script type="text/javascript">
	
	function checkSubmit()
	{
			if($("#fullNameMsg").html()=='Enter the correct'&&$("#address1Msg").html()=='Enter the correct'&&$("#address2Msg").html()=='Enter the correct'&&$("#countryMsg").html()=='Enter the correct'&&$("#regionMsg").html()=='Enter the correct'&&$("#cityMsg").html()=='Enter the correct'&&$("#zipMsg").html()=='Enter the correct'&&$("#phone1Msg").html()=='Enter the correct'&&$("#emailAddressMsg").html()=='Enter the correct')
			{
				return true;
			}else
			{
				alert("Please complete the address information");
				return false;
			}
	}
	function checkInputData(obj,msgId,msgInfo)
	{
		if(!obj.value)//只处验证不能为空并且只能为英文或者数字或者下划线组成的4-15个字符
		{
			$("#"+msgId).html(msgInfo+" can not be empty");
			alert(msgInfo+" can not be empty");
		}else
		{
			if(msgId=='emailAddressMsg')
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test(obj.value))
				{
					$("#"+msgId).html("Enter the correct");
				}else
				{
					$("#"+msgId).html(msgInfo+" format is not correct");
					alert(msgInfo+" format is not correct");
				}
			}else
			{
				$("#"+msgId).html("Enter the correct");
			}
		}
	}
	function clearInputData()
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
	</script>
	-->
	</head>
	<body onload="window.location.hash = 'here'">
	    <!--最外框-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>		
			<!--content info-->
			<div class="content">	  
			       <pp:include file="common/account_body.tpl" type="tpl"/>	   
			    <div class="youraccountBottom">
	<cms action="sql" return="addressList" query="SELECT * FROM cms_publish_address WHERE userId='{$tmpUser}' and status='1' Order By addressId DESC" />
                    <table class="addressBookYouraccount fl">
		    <a name="here"></a>
                        <tr>
                            <th colspan="2">Address Book&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=add')]" style="color:#5E97ED">Add a new address</a></th>
			    
                        </tr>
			<tr>
			<loop name="addressList.data" var="var" key="key"> 
				<pp:if expr="$key==0">
				
				<td>
					[$var.fullName]<br />
					[$var.address1] <br />
					[$var.address2]<br />
					[$var.city],&nbsp;[$var.province]&nbsp;[$var.zipcode]<br />
					[$var.country]<br />
					Phone: [$var.cellphone]<br />
					<span>
						<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=edit&addressId=' . $var.addressId)]">Edit</a>
						<a href="index.php[@encrypt_url('action=account&method=delAddress&addressId=' . $var.addressId)]">Delete</a></span>
				    </td>
				<pp:elseif expr="$key%2==0">
				<!--将这里的3修改为2，就可以实现一行显示2篇文章，以此类推-->
				</tr>
				<tr>
				<td>
					[$var.fullName]<br />
					[$var.address1] <br />
					[$var.address2]<br />
					[$var.city],&nbsp;[$var.province]&nbsp;[$var.zipcode]<br />
					[$var.country]<br />
					Phone: [$var.cellphone]<br />
					<span>
						<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=edit&addressId=' . $var.addressId)]">Edit</a>
						<a href="index.php[@encrypt_url('action=account&method=delAddress&addressId=' . $var.addressId)]">Delete</a>
					</span>
				    </td>
				<pp:else/>
				<td>
					[$var.fullName]<br />
					[$var.address1] <br />
					[$var.address2]<br />
					[$var.city],&nbsp;[$var.province]&nbsp;[$var.zipcode]<br />
					[$var.country]<br />
					Phone: [$var.cellphone]<br />
					<span>
						<a href="index.php[@encrypt_url('action=account&method=editAddress&editType=edit&addressId=' . $var.addressId)]">Edit</a>
						<a href="index.php[@encrypt_url('action=account&method=delAddress&addressId=' . $var.addressId)]">Delete</a>
					</span>				    </td>
				</if>
			</loop>                       
                        </tr>
                      
                    </table>
		     <pp:if expr="$editType=='edit' or $editType=='add'">
			     <pp:if expr="$IN.alertStr">
				     <span class="passwordE passwordfl">
					    [$IN.alertStr]
				    </span>
			    </pp:if>
			    <form  action="/publish/index.php" method="post" onsubmit="return checkSubmit()">
				    <input type="hidden" name="action" value="account">
				    <pp:if expr="$editType=='edit'">
					<input type="hidden" name="method" value="updateAddress">
					<input type="hidden" name="addressId" value="[$IN.addressId]">
					<pp:var name="AddressNodeId" value="@getGlobalModelVar('AddressNode')"/>
					<pp:var name="AddressNode" value="@getNodeInfoById($AddressNodeId)"/>
					<cms action="content" return="AddressDetail" nodeid="{$AddressNode.0.nodeGuid}" contentid="{$IN.addressId}"/>
					<pp:var name="IN.fullName" value="$AddressDetail.fullName"/>
					<pp:var name="IN.address1" value="$AddressDetail.address1"/>
					<pp:var name="IN.address2" value="$AddressDetail.address2"/>
					<pp:var name="IN.country" value="$AddressDetail.country"/>
					<pp:var name="IN.province" value="$AddressDetail.province"/>
					<pp:var name="IN.city" value="$AddressDetail.city"/>
					<pp:var name="IN.cellphone" value="$AddressDetail.cellphone"/>
				    <pp:elseif expr="$editType=='editOrder'">
					<input type="hidden" name="method" value="updateOrderAddress">
					<input type="hidden" name="addressId" value="[$IN.addressId]">
					<input type="hidden" name="orderID" value="[$IN.orderID]">
					<pp:var name="AddressNodeId" value="@getGlobalModelVar('AddressNode')"/>
					<pp:var name="AddressNode" value="@getNodeInfoById($AddressNodeId)"/>
					<cms action="content" return="AddressDetail" nodeid="{$AddressNode.0.nodeGuid}" contentid="{$IN.addressId}"/>
				    <pp:else/>
					<input type="hidden" name="method" value="addNewAddress">
				    </pp:if>
				    <input type="hidden" name="para[userId]" value="[$name]">
				    <input type="hidden" name="para[status]" value="1">
				    <input type="hidden" name="para[type]" value="user">
				    <input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]&editType=add">
				    <input type="hidden" name="backUrl1" value="action=[$IN.action]&method=[$IN.method]">    
				    <div class="addressBookForm fr">
					    <pp:if expr="$editType=='add' ">
						<span style="color:#5E97ED; font-size:14px;">Add a new address</span>
					    <pp:elseif expr="$editType=='edit'">
						<span style="color:#5E97ED; font-size:14px;">Edit address</span>
					    </pp:if>
					    <br>
					    <span style="color:#700000">You must enter a valid full name and valid Express address</span>
					<ul>
					    <li><label>Full Name<span>*</span></label>
					    <input type="text" name="para[fullName]"  class="addressBookFormText1" value="[$IN.fullName]" id="fullName" onblur="checkInputData(this,'fullNameMsg','Full Name ');"/>
					    <span style="display:none" id="fullNameMsg" ></span>
					    </li>
					    <li><label>Address Line 1<span>*</span></label>
					    <input name="para[address1]"  type="text" class="addressBookFormText1" value="[$IN.address1]" id="address1" onblur="checkInputData(this,'address1Msg','Address Line 1 ');"/>
						<span class="addressBookFormSpan">Street address, P.O. box, company name, c/o</span>
						<span style="display:none" id="address1Msg" ></span>
					    </li>
					    <li><label>Address Line 2<span>*</span>
					    </label><input name="para[address2]"  type="text" class="addressBookFormText1" value="[$IN.address2]" id="address2" onblur="checkInputData(this,'address2Msg','Address Line 2 ');"/>
						<span class="addressBookFormSpan">Apartment, suite, unit, building, floor, etc.</span>
						<span style="display:none" id="address2Msg" ></span>
					    </li>
					    <li><label>Country<span>*</span></label>
					    <input name="para[country]"  type="text" class="addressBookFormText2" value="[$IN.country]" id="country" onblur="checkInputData(this,'countryMsg','Country ');"/>
					    <span style="display:none" id="countryMsg" ></span>
					    </li>
					    <li><label>State/Province/Region<span>*</span></label>
					    <input name="para[province]"  type="text" class="addressBookFormText2" value="[$IN.province]" id="region" onblur="checkInputData(this,'regionMsg','State/Province/Region ');"/>
					    <span style="display:none" id="regionMsg" ></span>
					    </li>
					    <li><label>City<span>*</span></label>
					    <input name="para[city]"  type="text" class="addressBookFormText2" value="[$IN.city]" id="city" onblur="checkInputData(this,'cityMsg','City ');"/><!--<a href="#">please check again</a>-->
					    <span style="display:none" id="cityMsg" ></span>
					    </li>
					    <!--
					    <li><label>Zip<span>*</span></label>
					    <input name="para[zipcode]"  type="text" class="addressBookFormText2" value="[$AddressDetail.zipcode]" id="zip" onblur="checkInputData(this,'zipMsg','Zip ');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');"/>
					    <span style="display:none" id="zipMsg" ></span>
					    </li>-->
					    <li><label>Cell Phone<span>*</span></label>
					    <input name="para[cellphone]"  type="text" class="addressBookFormText2" value="[$IN.cellphone]" id="phone1" onblur="checkInputData(this,'phone1Msg','Cell Phone ');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');"/>
					    <span style="display:none" id="phone1Msg" ></span>
					    </li>
					    <!--
					    <li><label>telephone</label>
					    <input type="text" name="para[telephone]"  class="addressBookFormText2" value="[$AddressDetail.telephone]" id="phone2" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');"/>
					    <span style="display:none" id="phone2Msg" ></span>
					    </li>-->
					   
					    <!--
					    <li><label>Email Address<span>*</span></label>
					    <input type="text" name="para[email]"  class="addressBookFormText3" value="[$AddressDetail.email]" id="emailAddress" onblur="checkInputData(this,'emailAddressMsg','Email Address ');"/>
					    <span style="display:none" id="emailAddressMsg" ></span>
					    </li>-->
					    <input type="hidden" name="para[emailFlag]" value="'0'">
					</ul>
					<input type="submit" value="SAVE" class="contInueChose fr"/><input type="button" value="CLEAR" class="contInueChose mr12 fr" onclick="clearInputData()"/>
				    </div>
			    </form>
		    </pp:if>
                </div>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>
	<pp:include file="common/account_passPara.tpl" type="tpl"/>
</pp:if>