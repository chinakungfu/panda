
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>
<pp:var name="conPlanInfo" value="@getContentPlanInfoById($node.0.contentPlanId)"/>
<loop name="actParam"  var="var" key="key">
	<pp:var name="actParamStr" value="$actParamStr . '&' .$key . '=' . $var"/>
</loop>
<pp:var name="ContentModel" value="$node.0.appTableName"/>
<pp:var name="tempUrl" value="@getGlobalModelVar('Site_Domain') . 'publish/index.php?LCMSPID=BDUFbwRyVG5XPlA%2BVmwNcFc3X3YAdlE%2BVzYPdAAxBztTZwk9VBUAO1E4AG9WIg9gB1pSaVFiVTIEaQV8W2c%3D'"/>
[$IN.para.OrderNo]
<pp:if expr="$method=='addOrder'">
	<pp:if expr="$conPlanInfo.0.savePre!=''">
		<pp:include file="{$conPlanInfo.0.savePre}" type="tpl" saveType="0"/>
	</pp:if>	
	<pp:var name="addOrderTable" value="@addData($nodeId,$contentModel,$IN.para)"/>		
	{@publish($nodeId,$contentModel,$node.0.appTableKeyName,$addOrderTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)}	
	
	
	<pp:if expr="$conPlanInfo.0.saveNext!=''">
		<pp:include file="{$conPlanInfo.0.saveNext}" type="tpl" saveType="0"/>
	</pp:if>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	
<pp:elseif expr="$method=='WishToCart'">

	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="appTableKeyName" value="$node.0.appTableKeyName"/>
	<pp:var name="appTableKeyValue" value="$cartID"/>
	<pp:var name="para.cartID" value="$cartID"/>
	<pp:var name="para.ItemStatus" value="'New'"/>

	<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>
	
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	
<pp:elseif expr="$method=='CartToWish'">	
	
	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="appTableKeyName" value="$node.0.appTableKeyName"/>
	<pp:var name="appTableKeyValue" value="$cartID"/>
	<pp:var name="para.cartID" value="$cartID"/>
	<pp:var name="para.ItemStatus" value="'Wish'"/>

	<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>
	
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	
	
<pp:elseif expr="$method=='DeleteData'">
	

	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="appTableKeyName" value="$node.0.appTableKeyName"/>
	<pp:var name="appTableKeyValue" value="$cartID"/>
	<pp:var name="para.cartID" value="$cartID"/>
	<pp:var name="para.ItemStatus" value="'Delete'"/>
	
	<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>

	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>