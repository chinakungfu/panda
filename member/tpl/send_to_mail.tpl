<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:var name="result" value="<pp:memfunc funcname="sendMail($staffNo)"/>"/>
<pp:if expr="$result">
<script>location.href="index.php?action=member&method=sendTo"</script>
<pp:else/>
<script>alert('邮件发送失败，请与我们联系！');location.href="index.php?action=member&method=login"</script>
</pp:if>