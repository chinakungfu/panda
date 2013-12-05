<pp:if expr="$method=='saveAddPublishPsn'">
<pp:memfunc funcname="addPublishPsnInfo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=publishPsnSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditPublishPsn'">
<pp:memfunc funcname="editPublishPsnInfo($psnId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=publishPsnSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delPublishPsn'">
<pp:memfunc funcname="delPublishPsnInfo($psnId)"/>
<pp:var name="tempUrl" value="'action=cms&method=publishPsnSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>