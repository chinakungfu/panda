<cms action="sql" return="userInfo" query="SELECT * FROM cms_member_staff where staffNo='{$IN.passwordEmail}'" />
<pp:var name="userCount" value="sizeof($userInfo.data)"/>
<pp:if expr="$IN.passwordEmail!=''">
	<pp:if expr="$userCount>0">
	<!DOCTYPE HTML>
	<html>
		<head>
			<meta charset="utf-8" />
			<title>shop-demo</title>
			<link href="../skin/style/reset.css" rel="stylesheet" type="text/css"/>
			<link href="../skin/style/shop.css" rel="stylesheet" type="text/css"/>
			<link href="../skin/style/base.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript" src="/publish/skin/jsfiles/jquery-1.7.1.min.js"></script>
			<!--<script type="text/javascript">
			function checkSubmit()
			{
				if(!$("#answer").val())
				{
					$("#requestpasswordH3Info").html("Answer can not be empty");
					$("#requestpasswordH3Info").css("display","");
					return false;
				}else
				{
					$("#requestpasswordH3Info").css("display","none");
					return true;
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
				
				
				<!--content info-->
				<form method="POST" action="" onsubmit="return checkSubmit();">
					<input type="hidden" name="userId" value="[$userInfo.data.0.staffId]">
					<input type="hidden" name="safetyQuestion" value="[$userInfo.data.0.safetyQuestion]">
					<input type="hidden" name="action" value="website">
					<input type="hidden" name="method" value="resetPassword">
					<input type="hidden" name="backUrl" value="action=[$IN.action]&method=[$IN.method]&passwordEmail=[$IN.passwordEmail]">
				<div class="content">
				    <div class="requestpassword">
					<h2>Time to shopping and share[$userCount]</h2>
					<!--<h3 class="requestpasswordH3Info" id="requestpasswordH3Info" style="display:none">
						
					</h3>-->
					
					
				<pp:if expr="$IN.alertStr==1">
				<h3 class="requestpasswordH3Info" id="requestpasswordH3Info">
				Safty Answer is incorrect, please try again.
				</h3>
				<pp:elseif expr="$IN.alertStr==2">
				<h3 class="requestpasswordH3Info" id="requestpasswordH3Info">
				Answer can not be empty
				</h3>
				</pp:if>
					
						
					<div class="answerHintEmail">
			       <h3>Step2:Security Question</h3>
				  <p>Please answer the following with the information
				     you provided when originally registering.After 
				     answering correctly, you will receive an e-mail 
				     with your password.
				  </p>
				  <p style="margin-top:14px; margin-left:"><label>Hint:</label><span>[$userInfo.data.0.safetyQuestion]</span></p>
				  <p><label>Answer:</label><input type="text" class="passwordEmail" id="answer" name="answer"/></p>
				  <p><input type="submit" value="SUBMIT" class="submitEmailBtn fr"/></p>
			    </div>
			   
				    </div>   
		    </div>
		    </form>
				<!--foot-->
				<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
				
			</div>
		</body>
	</html>
	<pp:else/>
		<script>alert('Not a valid e-mail address.');location.href="index.php[@encrypt_url('action=website&method=forgetPassword')]"</script>
	</pp:if>
<pp:else/>
	<script>alert('Please input Email address.');location.href="index.php[@encrypt_url('action=website&method=forgetPassword')]"</script>
</pp:if>