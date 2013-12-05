<pp:var name="result" value="@executeCleanCache($appPath)"/>
<pp:if expr="$result">
	<pp:var name="tempUrl" value="'action=cms&method=cleanCache'"/>
	<script>alert('您已成功清除缓存！');location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:else/>
	<pp:var name="tempUrl" value="'action=cms&method=cleanCache'"/>
	<script>alert('您已清除缓存失败！')location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>