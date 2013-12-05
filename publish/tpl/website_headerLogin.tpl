<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:if expr="$method=='headerLogin'">
	<pp:if expr="$staffNo!='' and $password!=''">
		<pp:var name="staffExist" value="<pp:memfunc funcname="StaffIsExists($staffNo)"/>"/>
		<pp:if expr="$staffExist">	
			<pp:var name="result" value="<pp:memfunc funcname="checkLogin($staffNo,$password)"/>"/>		
			<pp:if expr="$result">			
				<pp:var name="CookieUser" value="@readCookie()"/>
				<pp:if expr="$CookieUser">		
					<cms action="sql" return="updateCart" query="update cms_publish_cart SET UserName= '{$result.0.staffId}' WHERE `UserName`= '{$CookieUser}'"/>
					<cms action="sql" return="updateOrder" query="update cms_publish_order SET orderUser= '{$result.0.staffId}' WHERE orderUser= '{$CookieUser}'"/>								
					<cms action="sql" return="updateAddressUser" query="update cms_publish_address SET userId= '{$result.0.staffId}',email='{$result.0.staffNo}' WHERE userId= '{$CookieUser}'"/>
					<pp:var name="clearCookie" value="@deleteCookie()"/>					
				</pp:if>	
				<pp:if expr="$result.0.groupName=='NoValidation'">
					<script>alert("Sorry,You are waiting for validation of sign up, please go to your mail box and finish all steps of verification");history.back()</script>
				<pp:else/>
					<pp:session funcname="writeSession($result.0.staffId)"/>
					<pp:if expr="$method=='headerLogin'">
					
					<script>
					//alert("Log in successfully!");
					location.href="[$IN.url]"||"index.php[@encrypt_url($IN.backUrl)]";</script>
					</pp:if>
				</pp:if>
			<pp:else/>				
				<script>alert("Password is incorrect. Please input again.");history.back()</script>	
			</pp:if>
		<pp:else/>
			<script>alert("Not a valid e-mail address.");history.back()</script>
		</pp:if>
	<pp:else/>		
		<script>alert("Please input E-mail and Password.");history.back()</script>		
	</pp:if>
</pp:if>
