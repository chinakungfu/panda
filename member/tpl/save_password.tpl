<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:var name="url" value="<pp:memfunc funcname="encodeFrameRightURL('index.php?action=member&method=modifyPassword')"/>"/>
<pp:if expr="$identify==''">
<pp:var name="result" value="<pp:memfunc funcname="changePassword($staffId,$oldpassword,$newpassword,$identify)"/>"/>
<pp:if expr="$result">
<script language="JavaScript">alert("密码修改成功，请记住新密码！");location.href="index.php[@encrypt_url('action=member&method=modifyPassword')]";</script>
<pp:else/>
<script>alert("密码修改失败，旧密码不正确！");location.href="index.php[@encrypt_url('action=member&method=modifyPassword')]"</script>
</pp:if>
<pp:else/>
<pp:var name="result" value="<pp:memfunc funcname="findPassword($staffId,$newpassword,$identify)"/>"/>
<pp:if expr="$result">
<script>alert("密码修改成功，请记住新密码！");location.href="index.php[@encrypt_url('action=member&method=modifyPassword')]"</script>
<pp:else/>
<script>alert("密码修改失败，修改密码时间过期，请申请找回密码！");location.href="index.php[@encrypt_url('action=member&method=login')]"</script>
</pp:if>
</pp:if>