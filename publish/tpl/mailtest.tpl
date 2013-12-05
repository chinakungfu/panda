<pp:if expr="$method=='signup1'">
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	<pp:if expr="$name!=''">
		<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
		<pp:var name="mailArr.verifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateUser&staffId=' . $name)" />
		<pp:var name="result" value="<pp:memfunc funcname="sendVerifyMail($name,$VerifyLink)"/>"/>	

		<pp:if expr="$result">
			<script>alert('Successfully£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		<pp:else/>
			<script>alert('Fail£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		</pp:if>
	</pp:if>
<pp:elseif expr="$method=='signup'">
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	
	<pp:if expr="$name!=''">
	
		<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
		<pp:var name="mailArr.verifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateUser&staffId=' . $name)" />
		<pp:var name="mailArr.userId" value="$name" />
		<pp:var name="result" value="<pp:memfunc funcname="sendMailTest($mailArr,$method)"/>"/>
		<!--<pp:if expr="$result">
			<script>alert('Successfully£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		<pp:else/>
			<script>alert('Fail£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		</pp:if>-->
	</pp:if>
<pp:elseif expr="$method=='orderSubmit'">
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	
	<pp:if expr="$name!=''">	
		
		<pp:var name="mailArr.orderNo" value="'1336797506-56735'" />
		<pp:var name="mailArr.userId" value="$name" />
		<pp:var name="result" value="<pp:memfunc funcname="sendMailTest($mailArr,$method)"/>"/>
		<!--<pp:if expr="$result">
			<script>alert('Successfully£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		<pp:else/>
			<script>alert('Fail£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		</pp:if>-->
	</pp:if>
<pp:elseif expr="$method=='resetPassword'">
			
		
		<pp:var name="mailArr.userId" value="$IN.userId" />
		<pp:var name="mailArr.newPwd" value="$IN.newPwd" />
		<pp:var name="result" value="<pp:memfunc funcname="sendMailTest($mailArr,$method)"/>"/>
		<!--<pp:if expr="$result">
			<script>alert('Successfully£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		<pp:else/>
			<script>alert('Fail£¡');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		</pp:if>-->
	
</pp:if>