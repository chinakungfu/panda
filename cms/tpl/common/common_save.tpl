<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>
<pp:var name="conPlanInfo" value="@getContentPlanInfoById($node.0.contentPlanId)"/>
<loop name="actParam"  var="var" key="key">
	<pp:var name="actParamStr" value="$actParamStr . '&' .$key . '=' . $var"/>
</loop>
<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId=' . $nodeId . $actParamStr"/>
<pp:if expr="$method=='saveAddData'">
	<pp:if expr="$conPlanInfo.0.savePre!=''">
		<pp:include file="{$conPlanInfo.0.savePre}" type="tpl" saveType="0"/>
	</pp:if>
	
	<pp:var name="addDataResult" value="@addData($nodeId,$contentModel,$IN.para)"/>
	
	<pp:if expr="$conPlanInfo.0.saveNext!=''">
		<pp:include file="{$conPlanInfo.0.saveNext}" type="tpl" saveType="0"/>
	</pp:if>
	
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='saveEditData'">
	<pp:var name="editDataResult" value="@getDataByCon($contentModel,$appTableKeyName,$appTableKeyValue);"/>
	<pp:if expr="$conPlanInfo.0.savePre!=''">
		<pp:include file="{$conPlanInfo.0.savePre}" type="tpl" saveType="1"/>
	</pp:if>
	
	<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$IN.para)"/>
	
	<pp:if expr="$conPlanInfo.0.saveNext!=''">
		<pp:include file="{$conPlanInfo.0.saveNext}" type="tpl" saveType="1"/>
	</pp:if>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='delData'">
	<pp:if expr="$conPlanInfo.0.delPre!=''">
		<pp:include file="{$conPlanInfo.0.delPre}" type="tpl"/>
	</pp:if>
	
	<pp:memfunc funcname="delCommonData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue)"/>
	<pp:if expr="$conPlanInfo.0.delNext!=''">
		<pp:include file="{$conPlanInfo.0.delNext}" type="tpl"/>
	</pp:if>
	<script>location.href='index.php[@encrypt_url($tempUrl)]';</script>
<pp:elseif expr="$method=='saveNodeAuth'">
	<pp:memfunc funcname="saveNodeAuth($nodeId,$group,$user)"/>
	<pp:var name="tempUrl" value="'action=cms&method=editNode&nodeId=' .$nodeId"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]#tabs-2'</script>
</pp:if>