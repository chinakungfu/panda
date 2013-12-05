<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:if expr="$method=='refeshIndex'">
<!--	<pp:var name="result" value="@getNodeExtraIndexByNodeId($nodeId)"/>
	<pp:if expr="!empty($result)">-->
		<!--{@publish($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$selectConId,$frameListAction,$frameListMethod,$result.0.extraPublishId,'0')}-->
<!--		<pp:var name="tempUrl" value="'action=cms&method=update&type=0&extraPublishId='.$result.0.extraPublishId .'&nodeId='.$nodeId"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	<pp:else/>
		<script>alert("该结点还未设置首页！");window.close();</script>
	</pp:if>-->
<pp:elseif expr="$method=='viewIndex'">
	<pp:var name="node" value="@getNodeInfoById($nodeId,'')"/>
	<pp:if expr="$node.0.publishMode=='1'">
		<pp:var name="result" value="@getNodeIndexByNodeId($nodeId)"/>
		<script>location.href="[$result.0.indexUrl]";</script>
	<pp:elseif expr="$node.0.publishMode=='2'">
		<pp:var name="urlArray" value="explode('?',$node.0.dynamicIndexUrl)"/>
		<pp:var name="param" value="$urlArray['1'] . '&nodeId=' . $node.0.nodeGuid"/>
		<pp:var name="tempUrl" value="$urlArray[0] . encrypt_url($param)"/>
		<script>location.href="[$tempUrl]";</script>
	</pp:if>
	<!--<pp:var name="result" value="@getNodeExtraIndexByNodeId($nodeId)"/>
	<pp:if expr="$result.0.extraPublishURL">
		<script>location.href="[$result.0.extraPublishURL]";</script>
	<pp:else/>
		<script>alert("该结点还未设置首页！");window.close();</script>
	</pp:if>-->
</pp:if>