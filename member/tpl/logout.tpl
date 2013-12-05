<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:if expr="$method=='destroy'">
<pp:var name="result" value="<pp:session funcname="readSession()"/>"/>
<pp:memfunc funcname="logoutStaff($result)"/>
<pp:session funcname="destroySession()"/>
	<script language="javascript" type="text/javascript">
	top.opener=null;top.close();
	</script>
<pp:else/>
<!--<pp:memfunc funcname="logoutStaff($result)"/>-->
<pp:session funcname="destroySession()"/>
<script language="javascript" type="text/javascript">
top.opener=null;top.location.href="[$IN.url]"||"../member/index.php[@encrypt_url('action=member&method=login&closeFlag=1')]";
</script>
</pp:if>