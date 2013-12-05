<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<!--<script type="text/javascript">
		function checkSubmit()
		{
			if(!$("#passwordEmail").val())
			{
				$("#requestpasswordH3Info").html("E-mail Address can not be empty");
				$("#requestpasswordH3Info").css("display","");
				return false;
			}else
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test($("#passwordEmail").val()))
				{
					$("#requestpasswordH3Info").css("display","none");
					return true;
				}else
				{
					$("#requestpasswordH3Info").html("E-mail Address format is not correct");
					$("#requestpasswordH3Info").css("display","");
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
				<div class="requestpassword">
					<h2>Time to shopping and share</h2>
					<form  action="/publish/index.php" method="post" onsubmit="return checkSubmit();">
						<input type="hidden" name="action" value="website">
						<input type="hidden" name="method" value="inputAnswer">
						<h3 class="requestpasswordH3Info" id="requestpasswordH3Info" style="display:none"></h3>
						<div class="requestpasswordEmail">
							
							<h3>Step1:E-Mail Address</h3>
							<p>To have your password e-mailed to you,please enter your e-mail address below,then click submit</p>
							<p style="margin-top:14px">E-mail Address:<input type="text" class="passwordEmail" name="passwordEmail" id="passwordEmail"/></p>
							<p><input type="submit" value="SUBMIT" class="submitEmailBtn fr"/></p>
						</div>
					</form>
				</div>   
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>