<pp:var name="name" value="@readSession()"/>
<pp:if expr="$name==''">
<script language="javascript" type="text/javascript">
top.location.href="../member/index.php[@encrypt_url('action=member&method=login')]";
</script>
<pp:else/>
<pp:session funcname="writeSession($name)"/>
</pp:if>