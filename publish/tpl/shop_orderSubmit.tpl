<cms action="sql" return="orderInfo" query="SELECT * FROM cms_publish_order WHERE orderID='{$IN.orderID}' limit 1" />

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
			
			<!--content info-->
			<div class="content">
			    <div class="subMitConfirm">
			        <h2>Congratulations !</h2>
			        <p>
			            Order <span>(No:[$orderInfo.data.0.OrderNo])</span> submitted successfully, our service agents will contact you in 24 hours, please wait. <br />Any questions, contact <em>6577143@qq.com</em> or mobile 13962177512<br />After we finish process, you can visit  your account page to view your order history and confirm payment

			        </p>
				
			        <span class="fr"><a href="index.php[@encrypt_url('action=website&method=shopindex')]" class="contInueChoseLink">MORE</a>
				<a href="index.php[@encrypt_url('action=website&method=account')]" class="contInueChoseLink01">YOUR ACCOUNT</a></span>
			    </div>
				 <pp:if expr="$name==''">
			    <form  action="/publish/index.php" method="post">
			<input type="hidden" name="action" value="website">
			<input type="hidden" name="method" value="addUser">
			<input type="hidden" name="signUpType" value="order">
			<input type="hidden" name="backUrl" value="[@url2str($IN)]">
			<input type="hidden" name="orderId" value="[$IN.orderID]">
			    <pp:if expr="$IN.alertStr">
					<span class="passwordE" id="registerMessage">[$IN.alertStr]</span>
					
			</pp:if>
			    <cms action="sql" return="addressInfo" query="SELECT * FROM cms_publish_address WHERE addressID='{$orderInfo.data.0.orderAddress}' limit 1" />
			    <div class="subMitConfirmInput">
			        <h2>SAVE MY INFORMATION</h2>
			        <h3>Checking out is fast and easy when we save your addresses and oredr history</h3>
			        <table>
			            <tr>
			                <td colspan="2"><label>USER NAME</label><input readonly type="text" value="[$addressInfo.data.0.email]"  name="para[staffNo]"/><br><span>This will be the username you use to log in.</span></td>
					
					<input type="hidden" name="para[reStaffNo]" value="[$addressInfo.data.0.email]">
			            </tr>
			            <tr>
			                <td><label>PASSWORD</label><input  type="password" name="para[password]"/></td><td><label>RETYPE<br >PASSWORD</label><input  type="password" name="para[rePassword]"/></td>
			            </tr>
			            <tr>
                            <td colspan="2" style="padding-left:101px">Password must be at least 6 characters in length and contain at least 1 number.</td>
                        </tr>
                        <tr>
                            <td><label>SECURITY<br />QUESTION</label>
                                <select  size="1" name="para[safetyQuestion]">
                                    <pp:include file="common/saftyQuestion.tpl" type="tpl"/>
                                </select>
                            </td><td><label>ANSWER</label><input type="text"  name="para[questionResult]" value="[$IN.questionResult]"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h5 style="font-size:12px; line-height:25px; color:#BBD783; padding-top:20px">Acceptable Passwords</h5>
                                <ul class="sensitive">
                                    <li>Are case sensitive.</li>
                                    <li>Must be at least six characters in length.</li>
                                    <li>Must contain at least one number (ex.1_togo).</li>
                                    <li>Cannot contain spaces.</li>
                                    <li>Cannot contain your e-mail address.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" id="saverBtn" style="margin-right:50px"/></td>
                        </tr>
			        </table>
			    </div>
				</form>
			    </pp:if>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>