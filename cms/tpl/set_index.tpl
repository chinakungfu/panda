<pp:if expr="$method=='setIndex'">
	<pp:memfunc funcname="modifyIndexFlag($nodeId,$extraPublishId,$isIndex)"/>
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
</pp:if>