<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:var name="isCode" value="<pp:memfunc funcname="isCode($IN.code)"/>"/>
<pp:if expr="$isCode!='1'">
	<pp:var name="tempUrl" value="'action=member&method=login&closeFlag=&staffNo='.$staffNo"/>
	<script>alert("验证码不正确！");history.back();<!-- window.location.href="index.php[@encrypt_url($tempUrl)]"; --></script>
</pp:if>
<pp:if expr="$method=='logined'">
<pp:var name="result" value="<pp:memfunc funcname="checkLogin($staffNo,$password)"/>"/>
<pp:if expr="$result">
	<pp:session funcname="writeSession($staffNo)"/>
	<script>/*alert("登录成功！");*/location.href="[$IN.url]"||"../cms/index.php[@encrypt_url('action=cms&method=main')]";</script>
<pp:else/>
	<pp:var name="tempUrl" value="'action=member&method=login&closeFlag=&staffNo='.$staffNo"/>
	<script>alert("用户名和密码不正确!");history.back()<!-- location.href="index.php[@encrypt_url($tempUrl)]" --></script>
<pp:display file="login.tpl"/>
</pp:if>
</pp:if>
