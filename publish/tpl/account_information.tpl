<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<!--
		<script type="text/javascript">
		function checkSubmit(value)
		{
			if(value=='0')
			{
				if($("#staffNoMsg").html()=='Enter the correct'&&$("#newNameRepeatMsg").html()=='Enter the correct'&&$("#staffNameMsg").html()=='Enter the correct'&&$("#questionResult1Msg").html()=='Enter the correct')
				{
					return true;
				}else
				{
					alert("You fill out the user information is incomplete");
					return false;
				}
				
			}else if(value=='1')
			{
				if($("#oldPasswordMsg").html()=='Enter the correct'&&$("#newPasswordMsg").html()=='Enter the correct'&&$("#repeatPasswordMsg").html()=='Enter the correct'&&$("#questionResult2Msg").html()=='Enter the correct')
				{
					return true;
				}else
				{
					alert("You fill out the password information is incomplete");
					return false;
				}
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
				if(msgId=='staffNoMsg')
				{
					reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
					if(reg.test(obj.value))
					{
						call_tpl('website','checkUserExist','backDataStaff()','return',obj.value,'');
						//$("#"+msgId).html("Enter the correct");
					}else
					{
						$("#"+msgId).html(msgInfo+" format is not correct");
						alert(msgInfo+" format is not correct");
					}
				}else if(msgId=='newNameRepeatMsg')
				{
					if($("#staffNo").val()==$("#newNameRepeat").val())
					{
						$("#"+msgId).html("Enter the correct");
					}else
					{
						$("#"+msgId).html("New E-mail address and Confirm E-mail address are not equal");
						alert("New E-mail address and Confirm E-mail address are not equal");
					}
				}else if(msgId=='repeatPasswordMsg')
				{
					if($("#newPassword").val()==$("#repeatPassword").val())
					{
						$("#"+msgId).html("Enter the correct");
					}else
					{
						$("#"+msgId).html("New Password and Confirm Password are not equal");
						alert("New Password and Confirm Password are not equal");
					}
				}else
				{
					$("#"+msgId).html("Enter the correct");
				}
			}
		}
		function backDataStaff(response)
		{
			if(response!='')
			{
				alert("The user already exists");
				$("#staffNoMsg").html("The user already exists");
			}else
			{
				$("#staffNoMsg").html("Enter the correct");
			}
		}
		function clearData(value)
		{
			if(value==0)
			{
				$("#staffNo").val('');
				$("#newNameRepeat").val('');
				$("#staffName").val('');
				$("#questionResult1").val('');
			}else if(value==1)
			{
				$("#oldPassword").val('');
				$("#newPassword").val('');
				$("#repeatPassword").val('');
				$("#questionResult2").val('');
			}
		}
		</script>
		-->
		<script type="text/javascript">
		function clearData(value)
		{
			if(value==0)
			{
				$("#staffNo").val('');
				$("#reStaffNo").val('');				
				$("#questionResult").val('');
			}else if(value==1)
			{
				$("#oldPassword").val('');
				$("#newPassword").val('');
				$("#rePassword").val('');
				$("#questionResult1").val('');
			}else if(value==2)
			{
				$("#nickName").val('');	
				$("#questionResult2").val('');
			}
		}

		</script>
	</head>
	<body onload="window.location.hash = 'here'">
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			
			<div class="content">
			    
			        <pp:include file="common/account_body.tpl" type="tpl"/>
				
			   <!--
			    <div class="youraccountBottom">
		<form action="/publish/index.php" method="post" onsubmit="return checkSubmit(0)">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updateUser">
			<input type="hidden" name="ChangeStaffId" value="[$userInfo.0.staffId]">
                    <div class="answerHintEmailAccunt">
		    <a name="here"></a>
                       <h3>Account Information</h3>
                          <p>
                              <strong>PLEASE NOTE:</strong>We will send all web order updates to this<br />e-mail address.Any changes made to the e-mail address will affect <br />your login.
                          </p>
			  
                          <ul>
                              <li><label>Current E-mail  address:</label><strong>[$userInfo.0.staffNo]</strong></li>
                              <li><label>New E-mail  address:</label>
                              <input name="para[staffNo]" id="staffNo" type="text" class="passwordEmailC" onblur="checkInputData(this,'staffNoMsg','New E-mail  address ');"/>
                              <span style="display:none" id="staffNoMsg" ></span>
                              </li>
                              <li><label>Confirm E-mail  address:</label>
                              <input name="newNameRepeat" id="newNameRepeat"  type="text" class="passwordEmailC" onblur="checkInputData(this,'newNameRepeatMsg','Confirm E-mail  address ');"/>
                              <span style="display:none" id="newNameRepeatMsg" ></span>
                              </li>
			      			  <li><label>Change Your Nickname:</label>
			      			  <input type="text"  name="para[staffName]" id="staffName"  class="passwordEmailC" value="[$userInfo.0.staffName]" onblur="checkInputData(this,'staffNameMsg','Change Your Nickname ');"/>
			      			  <span style="display:none" id="staffNameMsg" ></span>
			      			  </li>
                          </ul>
                          <p style="margin:13px 0 0 41px"><strong>Secutity Question:&nbsp;[$userInfo.0.safetyQuestion]</strong></p>
                          <ul>
                              <li><label>Secutity Answer:<span>*</span></label>
                              <input  name="para[questionResult]" id="questionResult1" type="text" class="passwordEmailC" onblur="checkInputData(this,'questionResult1Msg','Secutity Answer ');"/>
                              <span style="display:none" id="questionResult1Msg" ></span>
                              </li>
                          </ul>
                          <ul id="answerHintEmailAccuntUl">
                              Yes, send me NeimanMarcus.com e-mail,including
                              <li>The latest trends, designer, and must-have items.</li>
                              <li>Special sales announcements and online only offers.</li>
                          </ul>
                          <input type="button" value="CLEAR" onclick="clearData(0)" class="clearInput marginLR"/><input type="submit" value="SAVE" class="saveInput"/>
                    </div>
		    </form>
		    <form action="/publish/index.php" method="post" onsubmit="return checkSubmit(1)">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updatePassword">
			<input type="hidden" name="memberId" value="[$userInfo.0.staffId]">
                    <div class="answerHintEmailAccunt">
                       <h3>Change Your Password</h3>
                       <ul>
						  <li><label>Current Password:</label>
						  <input type="password" name="oldPassword" id="oldPassword" class="passwordEmailC" onblur="checkInputData(this,'oldPasswordMsg','Current Password ');"/>
						  <span style="display:none" id="oldPasswordMsg" ></span>
						  </li>
                          <li><label>New Password:</label>
                          <input type="password" name="newPassword" id="newPassword"  class="passwordEmailC" onblur="checkInputData(this,'newPasswordMsg','New Password ');"/>
                          <span style="display:none" id="newPasswordMsg" ></span>
                          </li>
                          <li><label>Confirm Password:</label>
                          <input type="password" name="repeatPassword" id="repeatPassword"  class="passwordEmailC" onblur="checkInputData(this,'repeatPasswordMsg','Confirm Password ');"/>
                          <span style="display:none" id="repeatPasswordMsg" ></span>
                          </li>
                       </ul>
                       <p><strong style="margin:13px 0 0 41px">Secutity Question:what is your mother's maiden name?</strong></p>
                       <ul style="margin-bottom:20px;">
                          <li><label>Security Ansewr:<span>*</span>
                          </label><input name="questionResult" id="questionResult2" type="text" class="passwordEmailC" onblur="checkInputData(this,'questionResult2Msg','Security Ansewr ');"/>
                          <span style="display:none" id="questionResult2Msg" ></span>
                          </li>
                       </ul>
                       <input type="button" value="CLEAR" onclick="clearData(1)" class="clearInput marginLR"/><input type="submit" value="SAVE" class="saveInput"/>
                    </div>
		    </form>
                </div>
            </div>
	    -->
	    
	     <div class="youraccountBottom">
	     <a name="here"></a>
	    <!--
	     <form action="/publish/index.php" method="post" class="formAdd">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updateUser">			
			<input type="hidden" name="para[staffId]" value="[$userInfo.0.staffId]">
			<input type="hidden" name="para[safetyQuestion]" value="[$userInfo.0.safetyQuestion]">
			<input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]">
                    <div class="answerHintEmailAccunt">
                       <h3>Account Information</h3>
		       
                          <p>
                              <strong>PLEASE NOTE:</strong>We will send all web order updates to this<br />e-mail address.Any changes made to the e-mail address will affect <br />your login.
                          </p>
                          <ul>
                              <li><label>Current E-mail  address:</label><strong>[$userInfo.0.staffNo]</strong></li>
                              <li><label>New E-mail  address:</label><input  name="para[staffNo]"  id="staffNo" type="text" class="passwordEmailC" value="[$IN.staffNo]"/></li>
                              <li><label>Confirm E-mail  address:</label><input  name="para[reStaffNo]"  id="reStaffNo" type="text" class="passwordEmailC" value="[$IN.reStaffNo]"/></li>
                          </ul>
                          <p style="margin:13px 0 0 38px;"><strong>Security Question:[$userInfo.0.safetyQuestion]</strong></p>
                          <ul>
                              <li><label>Security Answer:<span>*</span></label><input type="text"  id="questionResult" class="passwordEmailC"  name="para[questionResult]"   value="[$IN.questionResult1]"/></li>                              
                          </ul>-->
			<!--		  
                          <ul id="answerHintEmailAccuntUl">
                              Yes, send me NeimanMarcus.com e-mail,including
                              <li>The latest trends, designer, and must-have items.</li>
                              <li>Special sales announcements and online only offers.</li>
                          </ul>
			-->
			<!--
                          <input type="button" value="CLEAR" onclick="clearData(0)"  class="clearInput marginLR"/><input type="submit" value="SAVE" class="saveInput"/>
                    </div>
		    <pp:if expr="$IN.alertStr">
                    <span class="passwordE passwordEPost">
		    
                        [$IN.alertStr]
                    </span>
		    </pp:if>
		    </form>
		    -->
		     <form action="/publish/index.php" method="post" class="formAdd">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updatePassword">			
			<input type="hidden" name="para[staffId]" value="[$userInfo.0.staffId]">
			<input type="hidden" name="para[staffNo]" value="[$userInfo.0.staffNo]">
			<input type="hidden" name="para[safetyQuestion]" value="[$userInfo.0.safetyQuestion]">
			<input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]">
                    <div class="answerHintEmailAccunt">
                       <h3>Change Your Password</h3>
                       <ul>
                          <li><label>Old Password:</label><input type="password"  id="oldPassword" class="passwordEmailC"  name="para[oldPassword]" /></li>
                          <li><label>New Password:</label><input type="password" id="newPassword"  class="passwordEmailC" name="para[newPassword]" /></li>
                          <li><label>Confirm Password:</label><input type="password"  id="rePassword" class="passwordEmailC" name="para[rePassword]" /></li>
                       </ul>
                       <p><strong style="margin:13px 0 0 38px;">Security Question:[$userInfo.0.safetyQuestion]</strong></p>
                       <ul style="margin-bottom:20px;">
                          <li><label>Security Answer:<span>*</span></label><input type="text"  id="questionResult1" class="passwordEmailC" name="para[questionResult]"   value="[$IN.questionResult2]"/></li>
                       </ul>
                       <input type="button" value="CLEAR" onclick="clearData(1)"  class="clearInput marginLR"/><input type="submit" value="SAVE" class="saveInput"/>
                    </div>
		     <pp:if expr="$IN.alertStr1">
                    <span class="passwordE passwordEPost1">
		    
                        [$IN.alertStr1]
                    </span>
		    </pp:if>
			</form>
		<form action="/publish/index.php" method="post"  class="formAdd">
			<input type="hidden" name="action" value="account">
			<input type="hidden" name="method" value="updateNickname">			
			<input type="hidden" name="para[staffId]" value="[$userInfo.0.staffId]">			
			<input type="hidden" name="para[safetyQuestion]" value="[$userInfo.0.safetyQuestion]">
			<input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]">
		<div class="answerHintEmailAccunt">
                       <h3>Change Your Nickname</h3>
                       <ul>
                          <li><label>Current Nickname:</label><strong>[$userInfo.0.staffName]</strong></li>
                          <li><label>New Nickname:</label><input type="text"  id="nickName" class="passwordEmailC" name="para[staffName]" value="[$IN.staffName]"/></li>                          
                       </ul>
                       <p><strong style="margin:13px 0 0 38px;">Security Question:[$userInfo.0.safetyQuestion]</strong></p>
                       <ul style="margin-bottom:20px;">
                          <li><label>Security Answer:<span>*</span></label><input type="text"  id="questionResult2" class="passwordEmailC" name="para[questionResult]" value="[$IN.questionResult3]"/></li>
                       </ul>
                       <input type="button" value="CLEAR" class="clearInput marginLR" onclick="clearData(2)" /><input type="submit" value="SAVE" class="saveInput"/>
                    </div>
                    
		    <pp:if expr="$IN.alertStr2">
                    <span class="passwordE passwordEPost2">
			
                        [$IN.alertStr2]
                    </span>
		    </pp:if>
                </div>
		</form>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>
	<pp:include file="common/account_passPara.tpl" type="tpl"/>
</pp:if>