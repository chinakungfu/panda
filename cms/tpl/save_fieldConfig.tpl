<pp:if expr="$method=='saveAddFieldConfig'">
<pp:var name="fieldConfigId" value="@addFieldConfigInfo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listField&fieldConfigId='.$fieldConfigId"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditFieldConfig'">
<pp:memfunc funcname="editFieldConfigInfo($fieldConfigId,$IN.para)"/>
<script>window.history.back();</script>
<pp:elseif expr="$method=='delFieldConfig'">
<pp:memfunc funcname="delFieldConfigInfo($fieldConfigId)"/>
<pp:var name="tempUrl" value="'action=cms&method=listFieldConfig'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>