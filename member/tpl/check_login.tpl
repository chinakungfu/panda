<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
<script language="javascript" type="text/javascript">
<pp:var name="tempUrl" value="'action=member&method=login&closeFlag=1&url='.$url"/>
top.location.href="../member/index.php[@encrypt_url($tempUrl)]";
</script>
<pp:else/>
<pp:session funcname="writeSession($name)"/>
</pp:if>