<pp:if expr="$method=='update'">
	<pp:if expr="$type=='0'">
		{@publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
	<pp:else/>
		{@publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
	</pp:if>
<pp:elseif expr="$method=='publish'">
	<pp:if expr="$type=='0'">
		{@publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
	<pp:else/>
		{@publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
	</pp:if>
<pp:elseif expr="$method=='cancelPublish'">
	<pp:if expr="$type=='0'">
		{@cancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
	<pp:else/>
		{@cancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
	</pp:if>
<pp:elseif expr="$method=='tempCancelPublish'">
	<pp:if expr="$type=='0'">
		{@tempCancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
	<pp:else/>
		{@tempCancelPublish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$extraPublishId,$type)}
		<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
	</pp:if>
<pp:elseif expr="$method=='saveCopy'">
	{@batchCopy($nodeId,$contentModel,$appTableKeyName,$parentId,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>window.opener.location.href='index.php[@encrypt_url($tempUrl)]';top.window.close();</script>
<pp:elseif expr="$method=='saveMove'">
	{@batchMove($nodeId,$contentModel,$appTableKeyName,$parentId,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>window.opener.location.href='index.php[@encrypt_url($tempUrl)]';top.window.close();</script>
<pp:elseif expr="$method=='batchTop'">
	{@batchTop($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$IN.para)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>window.opener.location.href='index.php[@encrypt_url($tempUrl)]';top.window.close();</script>
<pp:elseif expr="$method=='batchBest'">
	{@batchBest($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$IN.para)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>window.opener.location.href='index.php[@encrypt_url($tempUrl)]';top.window.close();</script>
<pp:elseif expr="$method=='batchSort'">
	{@batchSort($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$IN.para)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>window.opener.location.href='index.php[@encrypt_url($tempUrl)]';top.window.close();</script>
<pp:elseif expr="$method=='batchDel'">
	{@batchDel($nodeId,$contentModel,$appTableKeyName,$selectConId,'0')}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='foreverDel'">
	{@foreverDel($nodeId,$contentModel,$appTableKeyName,$selectConId,'1')}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='createVoidLink'">
	{@createVoidLink($contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='createIndexLink'">
	{@createIndexLink($contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='nodeCancelPublish'">
	{@nodeCancelPublish($contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='nodeTempCancelPublish'">
	{@nodeTempCancelPublish($contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='nodeAllRepublish'">
	{@nodeAllRepublish($contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='resume'">
	{@resumeData($nodeId,$contentModel,$appTableKeyName,$selectConId)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-3';</script>
<pp:elseif expr="$method=='flushRec'">
	{@flushRecData($nodeId,$contentModel,$appTableKeyName)}
	<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-3';</script>
</pp:if>