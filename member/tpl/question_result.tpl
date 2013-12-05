<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:var name="result" value="<pp:memfunc funcname="verifySafty($staffNo,$safetyQuestion,$questionResult)"/>"/>
<pp:if expr="$result">
<pp:memfunc funcname="insertIdentify($staffNo)"/>
<pp:var name="MailResult" value="<pp:memfunc funcname="sendMail($staffNo)"/>"/>
<pp:if expr="$MailResult">
<script>location.href="index.php[@encrypt_url('action=member&method=sendTo')]"</script>
<pp:else/>
<script>alert('邮件发送失败，请与我们联系！');location.href="index.php[@encrypt_url('action=member&method=login')]"</script>
</pp:if>
<pp:else/>
<pp:var name="tempUrl" value="'action=member&method=findPassworded&staffNo='.$staffNo"/>
<script>alert("安全问题答案不正确，请重新输入！");location.href="index.php[@encrypt_url($tempUrl)]"</script>
</pp:if>