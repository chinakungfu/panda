<pp:if expr="$method=='saveAddModelVar'">
<pp:memfunc funcname="addModelVarInfo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=modelVarSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditModelVar'">
<pp:memfunc funcname="editModelVarInfo($varId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=modelVarSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delModelVar'">
<pp:memfunc funcname="delModelVarInfo($varId)"/>
<pp:var name="tempUrl" value="'action=cms&method=modelVarSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>