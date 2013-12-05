<pp:if expr="$method=='saveAddField'">
<pp:memfunc funcname="addFieldInfo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listField&fieldConfigId='.$IN.para.fieldConfigId"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditField'">
<pp:memfunc funcname="editFieldInfo($fieldId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listField&fieldConfigId='.$IN.para.fieldConfigId"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delField'">
<pp:memfunc funcname="delFieldInfo($fieldId)"/>
<pp:var name="tempUrl" value="'action=cms&method=listField&fieldConfigId='.$fieldConfigId"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>