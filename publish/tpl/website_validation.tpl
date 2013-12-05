<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<pp:if expr="$method=='Validation'">
<pp:var name="result" value="<pp:memfunc funcname="checkLogin($staffNo,$password)"/>"/>
<pp:if expr="$result">
	
	<pp:if expr="$result.0.groupName=='NoValidation'">
		<script>alert("Sorry,You are waiting for validation of sign up, please go to your mail box and finish all step of validation！");</script>
	<pp:else/>
	<pp:session funcname="writeSession($staffNo)"/>
	
	<script>alert("Log in successfully!");location.href="[$IN.url]"||"../cms/index.php[@encrypt_url('action=website&method=index')]";</script>
	</pp:if>
<pp:else/>
	<pp:var name="tempUrl" value="'action=website&method=index&closeFlag=&staffNo='.$staffNo"/>
	<script>alert("用户名和密码不正确!");history.back()<!-- location.href="index.php[@encrypt_url($tempUrl)]" --></script>
<pp:display file="login.tpl"/>
</pp:if>
</pp:if>