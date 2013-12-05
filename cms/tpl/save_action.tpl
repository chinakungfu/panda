<pp:if expr="$method=='saveAddAction'">
<pp:memfunc funcname="addActionInfo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listAction'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditAction'">
<pp:memfunc funcname="editActionInfo($actionId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listAction'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delAction'">
<pp:memfunc funcname="delActionInfo($actionId)"/>
<pp:var name="tempUrl" value="'action=cms&method=listAction'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>