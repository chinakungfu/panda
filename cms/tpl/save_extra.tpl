<pp:if expr="$method=='saveAddExtData'">
	<pp:var name="result" value="@addExtData($nodeId,$IN.para)"/>
	<pp:if expr="$result">
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
	<pp:else/>
		<script>alert('附加发布标识已存在，请更改后保存！');window.history.back();</script>
	</pp:if>
<pp:elseif expr="$method=='saveEditExtData'">
	<pp:memfunc funcname="editExtData($nodeId,$extraPublishId,$IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
<pp:elseif expr="$method=='delExtData'">
	<pp:memfunc funcname="delExtData($extraPublishId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
</pp:if>