<!DOCTYPE HTML>
<html>
<head>
	<pp:include file="common/header/common_header.tpl" type="tpl"/> 
	<!--
	<script type="text/javascript">
	function checkSubmit()
	{
		if($("#staffNoMsg").html()=='Enter the correct'&&$("#staffNoedMsg").html()=='Enter the correct'&&$("#passwordMsg").html()=='Enter the correct'&&$("#passwordedMsg").html()=='Enter the correct'&&$("#safetyQuestionMsg").html()=='Enter the correct'&&$("#questionResultMsg").html()=='Enter the correct'&&$("#firstNameMsg").html()=='Enter the correct'&&$("#address1Msg").html()=='Enter the correct'&&$("#address2Msg").html()=='Enter the correct'&&$("#countryMsg").html()=='Enter the correct'&&$("#regionMsg").html()=='Enter the correct'&&$("#cityMsg").html()=='Enter the correct'&&$("#zipMsg").html()=='Enter the correct'&&$("#phone1Msg").html()=='Enter the correct'&&$("#emailAddressMsg").html()=='Enter the correct')
		{
			return true;
		}else
		{
			alert("Please fill out the registration information and try again");
			return false;
		}
	}
	function checkInputData(obj,msgId,msgInfo)
	{
		$("#registerMessage").css("display","");
		var checkMsg = $("#registerMessage").html();
		if(!obj.value)//只处验证不能为空并且只能为英文或者数字或者下划线组成的4-15个字符
		{
			$("#"+msgId).html(msgInfo+" can not be empty");
			checkMsg = msgInfo+" can not be empty<br>";
		}else
		{
			if(msgId=='emailAddressMsg')
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test(obj.value))
				{
					$("#"+msgId).html("Enter the correct");
					checkMsg = "Enter the correct";
				}else
				{
					$("#"+msgId).html(msgInfo+" format is not correct");
					checkMsg = msgInfo+" format is not correct<br>";
				}
			}else if(msgId=='staffNoMsg')
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test(obj.value))
				{
					call_tpl('website','checkUserExist','backDataStaff()','return',obj.value,'');
					//$("#"+msgId).html("Enter the correct");
					//checkMsg = "Enter the correct";
				}else
				{
					$("#"+msgId).html(msgInfo+" format is not correct");
					checkMsg = msgInfo+" format is not correct<br>";
				}
			}else if(msgId=='staffNoedMsg')
			{
				if($("#staffNo").val()==$("#staffNoed").val())
				{
					$("#"+msgId).html("Enter the correct");
					checkMsg = "Enter the correct";
				}else
				{
					$("#"+msgId).html("Retype E-Mail and E-Mail Address are not equal");
					checkMsg = "Retype E-Mail and E-Mail Address are not equal<br>";
				}
			}else if(msgId=='passwordedMsg')
			{
				if($("#password").val()==$("#passworded").val())
				{
					$("#"+msgId).html("Enter the correct");
					checkMsg = "Enter the correct";
				}else
				{
					$("#"+msgId).html("Retype Password and password are not equal");
					checkMsg = "Retype Password and password are not equal<br>";
				}
			}else
			{
				$("#"+msgId).html("Enter the correct");
				checkMsg = "Enter the correct";
			}
		}
		$("#registerMessage").html(checkMsg);
	}
	function backDataStaff(response)
	{
		if(response!='')
		{
			$("#registerMessage").html("The user already exists");
			$("#staffNoMsg").html("The user already exists");
		}else
		{
			$("#registerMessage").html("Enter the correct");
			$("#staffNoMsg").html("Enter the correct");
		}
	}
	</script>
	-->
</head>
<body>
	<!--最外框-->
	<div class="box">
		<!--头部-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>
		
		<!--<form  action="/publish/index.php" method="post" onsubmit="return checkSubmit()">-->
		<form  action="/publish/index.php" method="post">
			<input type="hidden" name="action" value="website">
			<input type="hidden" name="method" value="addUser">
			<input type="hidden" name="backUrl" value="[@url2str($IN)]">
			<input type="hidden" name="signUpType" value="signUp">
			<!--content info-->
			<div class="content">
				<div class="register">
				
				<h2>Time to shopping and share</h2>
				<div class="registerCont">
					<h3>ACCOUNT REGISTRATION[$IN.safetyQuestion]</h3>
					<span style="color:#bbb">Make checkout easier and faster - just fill out the fields below.</span>
					<pp:if expr="$IN.alertStr">
					<span class="passwordE" id="registerMessage">[$IN.alertStr]</span>
					<!--<span class="passwordE" id="registerMessage"><?php print_r($this->_tpl_vars["IN"]);?></span>-->
					</pp:if>
					<div class="accoutInfo">
						<ul>
						
	    			               <li class="accoutInfoTitle" style="margin-top:-3px; margin-bottom:12px;">Account Information&nbsp;(<span>*</span><em>required</em>)</li>
	    			               <li><label>E-Mail Address<span>*</span></label><input type="text" class="accoutInfoText" name="para[staffNo]" value="[$IN.staffNo]"/></li>
	    			               <li><label>Retype E-Mail<span>*</span></label><input type="text" class="accoutInfoText" name="para[reStaffNo]"  value="[$IN.reStaffNo]"/></li>
	    			               <li><label>Password<span>*</span></label><input type="password" name="para[password]" class="accoutInfoTextP" /></li>
	    			               <li><label>Retype Password<span>*</span></label><input type="password" name="para[rePassword]"  class="accoutInfoTextP"/></li>
	    			               <li><label>Security Question<span>*</span></label>
	    			                   <select id="select1" size="1" class="accoutInfoTextA" name="para[safetyQuestion]">
									<pp:include file="common/saftyQuestion.tpl" type="tpl"/>
						</select>
	    			               </li>
	    			               <li><label>Security Answer<span>*</span></label><input type="text" name="para[questionResult]" class="accoutInfoTextP"   value="[$IN.questionResult]"/></li>
	    			               <!--<li id="accoutInfoLink"><a href="#">Click here</a>to manage your e-mail<br />preferences</li>-->
				                </ul>
						<!--
						<ul>
							<li class="accoutInfoTitle" style="margin-top:-3px; margin-bottom:12px;">Account Information&nbsp;(<span>*</span><em>required</em>)</li>
							<li>
							<label>E-Mail Address<span>*</span></label>
							<input type="text" id="staffNo" class="accoutInfoText" name="para[staffNo]" onblur="checkInputData(this,'staffNoMsg','E-Mail Address ');"/><span style="display:none" id="staffNoMsg" ></span></li>
							<li>
							<label>Retype E-Mail<span>*</span></label>
							<input type="text" id="staffNoed" class="accoutInfoText" onblur="checkInputData(this,'staffNoedMsg','Retype E-Mail ');"/><span style="display:none" id="staffNoedMsg" ></span></li>
							<li>
							<label>Password<span>*</span></label>
							<input type="password" id="password" class="accoutInfoTextP" name="para[password]" onblur="checkInputData(this,'passwordMsg','Password ');"/><span style="display:none" id="passwordMsg" ></span></li>
							<li><label>Retype Password<span>*</span></label>
							<input type="password" id="passworded" class="accoutInfoTextP" onblur="checkInputData(this,'passwordedMsg','Retype Password ');"/><span style="display:none" id="passwordedMsg" ></span></li>
							<li><label>Security Question<span>*</span></label>
								<select id="select1" size="1" name="para[safetyQuestion]" onchange="checkInputData(this,'safetyQuestionMsg','Security Question ');" id="safetyQuestion" class="accoutInfoTextA">
									<option value="">Select Your Security Question</option>
									<option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
									<option value="In what city were you born?">In what city were you born?</option>
									<option value="What is your favorite pet's name?">What is your favorite pet's name?</option>
									<option value="Favorite teacher's last name?">Favorite teacher's last name?</option>
									<option value="What grade school did you attend?">What grade school did you attend?</option>
									<option value="Name of your hometown?">Name of your hometown?</option>
									<option value="What was your first job?">What was your first job?</option>
									<option value="Name of your first school?">Name of your first school?</option>
									<option value="What is your lucky number?">What is your lucky number?</option>
									<option value="Name of your best friend?">Name of your best friend?</option>
								</select><span style="display:none" id="safetyQuestionMsg" ></span>
							</li>
							<li>
							<label>Security Answer<span>*</span></label>
							<input type="text" class="accoutInfoTextP" id="questionResult" name="para[questionResult]" onblur="checkInputData(this,'questionResultMsg','Security Answer ');"/>
							<span style="display:none" id="questionResultMsg" ></span>
							</li>-->
							<!--<li id="accoutInfoLink"><a href="#">Click here</a>to manage your e-mail<br />preferences</li>-->
						</ul>
					</div>
					<!--
					<div class="billing fr">
						<ul>
							<li class="accoutInfoTitle" style="margin-top:-3px; margin-bottom:12px;">Billing Information&nbsp;(<span>*</span><em>required</em>)</li>
							<li><label>First Name<span>*</span></label>
							<input type="text" id="firstName" class="billingText" onblur="checkInputData(this,'firstNameMsg','First Name ');"/><span style="display:none" id="firstNameMsg" ></span></li>
							<li><label>Address Line 1<span>*</span></label>
							<input type="text" id="addressLine1" class="billingC" onblur="checkInputData(this,'address1Msg','Address Line 1 ');"/><span style="display:none" id="address1Msg" ></span><br />
								<strong>Street address, P.O. box, company name, c/o</strong>
							</li>
							<li><label>Address Line 2<span>*</span></label>
							<input type="text" id="addressLine2" class="billingC" onblur="checkInputData(this,'address2Msg','Address Line 2 ');"/><span style="display:none" id="address2Msg" ></span><br />
								<strong>Apartment, suite, unit, building, floor, etc.</strong>
							</li>
							<li><label>Country<span>*</span></label>
							<input type="text" id="country" class="billingText" onblur="checkInputData(this,'countryMsg','Country ');"/><span style="display:none" id="countryMsg" ></span></li>
							<li><label>State/Province/Region<span>*</span>
							</label><input type="text" id="region" class="billingText" onblur="checkInputData(this,'regionMsg','State/Province/Region ');"/><span style="display:none" id="regionMsg" ></span></li>
							<li><label>City<span>*</span></label>
							<input type="text" id="city" class="billingText" onblur="checkInputData(this,'cityMsg','City ');"/><span style="display:none" id="cityMsg"></span></li>
							<li><label>Zip<span>*</span></label>
							<input type="text" id="zip" class="billingText" onblur="checkInputData(this,'zipMsg','Zip ');" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');"/><span style="display:none" id="zipMsg"></span><a href="#" style="color:#000; padding-left:2px">please check again</a></li>
							<li><label>Phone 1<span>*</span></label>
							<input type="text" id="phone1" class="billingText" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" onblur="checkInputData(this,'phone1Msg','Phone 1 ');"/><span style="display:none" id="phone1Msg"></span></li>
							<li><label>Phone 2</label>
							<input type="text"  class="billingText" onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" /><span style="display:none" id="phone2Msg"></span></li>
							<li><label>Email Address<span>*</span></label>
							<input type="text" id="emailAddress" class="billingText" onblur="checkInputData(this,'emailAddressMsg','Email Address ');"/>
							<span style="display:none" id="emailAddressMsg"></span></li>
						</ul>
					</div>
					-->
					<div class="acceptable">
						<h3>Acceptable Passwords</h3>
						<ul>
							<li>Are case sensitive.</li>
							<li>Must be at least six characters in length.</li>
							<li>Must contain at least one number (ex.1_togo).</li>
							<li>Cannot contain spaces.</li>
							<li>Cannot contain your e-mail address.</li>
						</ul>
						
					</div>
					
					<input type="submit" value="REGISTER" class="registerBtn registerBtnM"/>
					
				</div>
			</div>
		</form>
		<!--foot-->
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
	</div>
</body>
</html>