<pp:var name="result" value="<pp:memfunc funcname="checkLogin($staffNo,$password)"/>"/>
<pp:if expr="$result">
	<pp:var name="CookieUser" value="@readCookie()"/>
	<pp:if expr="$CookieUser">		
		<cms action="sql" return="updateCart" query="update a0222211743.cms_publish_cart SET UserName= '{$result.0.staffId}' WHERE `UserName`= '{$CookieUser}'"/>	
		<pp:if expr="$updateCart">			
			<pp:var name="clearCookie" value="@deleteCookie()"/>
		</pp:if>
	</pp:if>
	<pp:session funcname="writeSession($result.0.staffId)"/>
	<pp:return data="$result.0.staffId . '|' . $result.0.staffName"/>
<pp:else/>
	<pp:return data="'0'"/>
</pp:if>
