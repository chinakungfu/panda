<pp:if expr="$method=='saveAddSeo'">
<pp:memfunc funcname="addSeo($IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=seoSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditSeo'">
<pp:memfunc funcname="editSeo($seoId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=seoSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delSeo'">
<pp:memfunc funcname="delSeo($seoId)"/>
<pp:var name="tempUrl" value="'action=cms&method=seoSet'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>