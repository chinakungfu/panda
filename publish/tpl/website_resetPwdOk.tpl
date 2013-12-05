<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/> 
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			<pp:var name="result" value="<pp:memfunc funcname="getStaffInfoByNo($IN.staffId)"/>"/>
			<!--content info-->
			<div class="content">
			    <div class="requestpassword">
			        <h2>Time to shopping and share</h2>
			        <table class="passwordemailed" width="10%">
			        	<tr>
			               <td height="20" style="background-color:#454544; color:#fff; padding-left:6px">Password Reset</td>    
			            </tr>
			            <tr>
			                <td height="150" valign="middle">
			                    <p>Passwords mailed. Please go to your mailbox to get your new password.</p>
			                </td>
			            </tr>
			            <a href="index.php[@encrypt_url('action=website&method=shopindex')]" class="closeBtn fr">Close</a>
                    </table>
			    </div>   
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>