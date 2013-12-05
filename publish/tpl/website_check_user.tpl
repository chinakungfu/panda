<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:if expr="$method=='CheckUser'">
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
			<script>alert("Sorry,You are waiting for validation of sign up, please go to your mail box and finish all step of validation！");location.href="[$IN.url]"||"index.php[@encrypt_url('action=website&method=login&alertStr=1')]";</script>
		<pp:else/>
		
			<pp:session funcname="writeSession($result.0.staffId)"/>
			<pp:if expr="$method=='CheckUser'">
			
				<pp:if expr="$IN.backUrl!=''">
					<pp:var name="tempUrl" value="$IN.backUrl"/>
				<pp:else/>
					<pp:var name="tempUrl" value="'action=website&method=shopindex'"/>				
				</pp:if>
				
				<script>
				//alert("Log in successfully!");
				location.href="index.php[@encrypt_url($tempUrl)]";</script>
			</pp:if>
		</pp:if>
	<pp:else/>
		<!--<pp:var name="tempUrl" value="'action=website&method=index&closeFlag=&staffNo='.$staffNo"/>-->
		<script>location.href="index.php[@encrypt_url('action=website&method=login&alertStr=1')]"</script>
		
	</pp:if>
</pp:if>
