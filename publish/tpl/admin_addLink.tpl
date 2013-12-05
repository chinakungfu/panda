<pp:var name="backUrl" value="'action=admin&method=taobaoLink'"/>
<pp:if expr="$method=='addLink'">	
				
	<pp:var name="nodeId" value="90"/>
	<pp:var name="node" value="@getNodeInfoById($nodeId)"/>

	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="para.nodeId" value="$node.0.nodeGuid"/>	

	<pp:var name="addGoodsTable" value="@addData($nodeId,$contentModel,$para)"/>	
	<pp:if expr="$addGoodsTable">		
		<script>
			alert("Add successfully!");			
			location.href='index.php[@encrypt_url($backUrl)]'
		</script>		
	<pp:else/>
		<script>alert("Add failed, try again.");location.href='index.php[@encrypt_url($backUrl)]'</script>
	</pp:if>			
<pp:elseif expr="$method=='updateLink'">
	<pp:var name="nodeId" value="90"/>
	<pp:var name="node" value="@getNodeInfoById($nodeId)"/>

	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="para.nodeId" value="$node.0.nodeGuid"/>
	
	<pp:var name="appTableKeyValue" value="$IN.linkId"/>
	<pp:var name="para.linkId" value="$IN.linkId"/>
	
		
	<pp:memfunc funcname="editData($nodeId,$contentModel,$node.0.appTableKeyName,$appTableKeyValue,$para)"/>
	
	<script>location.href='index.php[@encrypt_url($backUrl)]'</script>		
	

<pp:elseif expr="$method=='delLink'">
	<cms action="sql" return="delItem" query="DELETE FROM  `cms_publish_link` WHERE linkId='{$IN.linkId}' "  />
	<pp:if expr="$delItem">		
		<script>
			alert("Del successfully!");			
			location.href='index.php[@encrypt_url($backUrl)]'
		</script>		
	<pp:else/>
		<script>alert("Del failed, try again.");location.href='index.php[@encrypt_url($backUrl)]'</script>
	</pp:if>

</pp:if>