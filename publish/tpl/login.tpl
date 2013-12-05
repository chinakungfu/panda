<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<!--
		<script type="text/javascript">
		function checkSubmit()
		{
			if($("#staffNo").val()=="")
			{
				$("#showLoginMessage").css("display","");
				$("#showLoginMessage").html("Your input is incorrect, please check again.");
				return false;
			}else if($("#password").val()=="")
			{
				$("#showLoginMessage").css("display","");
				$("#showLoginMessage").html("Your input is incorrect, please check again.");
				return false;
			}else
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test($("#staffNo").val()))
				{
					$("#showLoginMessage").css("display","none");
					//$("#showLoginMessage").html("Log in successfully!");
					return true;
				}else
				{
					$("#showLoginMessage").css("display","");
					$("#showLoginMessage").html("Your input is incorrect, please check again.");
					return false;
				}
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
			<div class="content">
			    <div class="register">
			        <h2>Time to shopping and share</h2>
			        <div class="signup2">
					<pp:if expr="$IN.alertStr">
			        		<h3 id="showLoginMessage">Your input is incorrect, please check again.</h3>
					</pp:if>
			        	<div class="signupInfo">
						<form action="/publish/index.php" method="post" onsubmit="return checkSubmit();">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="CheckUser">
							<pp:if expr="$IN.loginType=='normal'">								
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]">
							<pp:elseif expr="$IN.loginType=='CartToWish'">								
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]">
							<pp:elseif expr="$IN.loginType=='addWish'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&ItemQTY=[$paraUrl.ItemQTY]&ItemGoodsID=[$paraUrl.ItemGoodsID]&itemPrice=[$paraUrl.itemPrice]&itemFreight=[$paraUrl.itemFreight]&loginType=addWish">
							<pp:elseif expr="$IN.loginType=='OrderToWish'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&orderID=[$paraUrl.orderID]">
							<pp:elseif expr="$IN.loginType=='cancelOrder'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&orderID=[$paraUrl.orderID]">
							<pp:elseif expr="$IN.loginType=='addFriend'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&shareID=[$paraUrl.shareID]&userId=[$paraUrl.userId]">
							<pp:elseif expr="$IN.loginType=='addShareWish'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&ItemQTY=[$paraUrl.ItemQTY]&ItemGoodsID=[$paraUrl.ItemGoodsID]&shareID=[$paraUrl.shareID]&itemPrice=[$paraUrl.itemPrice]&itemFreight=[$paraUrl.itemFreight]&loginType=addShareWish">
							<pp:elseif expr="$IN.loginType=='addFavorite'">
								<pp:var name="paraUrl" value="unserialize($paraStr)"/>
								<input type="hidden" name="backUrl" value="action=[$paraUrl.backAction]&method=[$paraUrl.backMethod]&shareID=[$paraUrl.shareID]">

							</pp:if>
							<div class="welcomeBack fl">
								<h4 style="padding-bottom:8px">Welcome Back</h4>
								<p>Please enter your e-mail address and password,then click the SIGN IN button</p>
								<label>Your E-mail Address :</label><input type="text" name="staffNo" id="staffNo"  class="welcomeBackText"/><br />
								<label>Password :</label><input type="password" name="password" id="password" class="welcomeBackText"/>
								<span class="welcomeBackInfo">* Can't recall your password?<br/> Click for <a href="/publish/index.php[@encrypt_url('action=website&method=forgetPassword')]">Password Assistance.</a></span>
								<input type="submit" value="SIGN IN" class="signup2Btn fr"/>
							</div>
						</form>
						<form action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="registerUser">
							<div class="forFaster fr">
								<h4>For Faster, Easier Checkout, Register Now</h4>
								Register with us to:
								<ul>
									<li>Save your shipping and billing information - you won't ever need to re-enter your information</li>
									<li>Access your order status and order history online.</li>
								</ul>
								Just click the button below.
								<input type="submit" value="REGISTER NOW" class="signup2Btn fr" style="margin-top:35px; margin-bottom:10px"/>
							</div>
						</form>
			        	</div>
			       	</div>
			        
			        
			    </div>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>