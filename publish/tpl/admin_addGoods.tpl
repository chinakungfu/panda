<pp:if expr="$method=='addGoods'">
	
	<pp:var name="backUrl" value="'action=website&method=shopindex&grapRst=alert'"/>
			
	<pp:var name="nodeId" value="$IN.para.nodeId"/>
	<pp:var name="node" value="@getNodeInfoById($nodeId)"/>

	<pp:var name="contentModel" value="$node.0.appTableName"/>
	<pp:var name="para.nodeId" value="$node.0.nodeGuid"/>
	
	<pp:var name="para.goodsStatus" value="'Open'"/>
	<pp:var name="para.goodsType" value="'inside'"/>
	
	
	<pp:var name="addGoodsTable" value="@addData($nodeId,$contentModel,$para)"/>	
	<pp:if expr="$addGoodsTable">
		<pp:var name="publishGoods" value="@publish($nodeId,$contentModel,$node.0.appTableKeyName,$addGoodsTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
		<pp:if expr="$publishGoods">
			<script>
			alert("Add successfully!");			
			location.href='index.php[@encrypt_url('action=admin&method=goodsDetail&goodsID=' . $addGoodsTable)]'
			</script>
		<pp:else/>
			<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php[@encrypt_url($backUrl)]'</script>
		</pp:if>
	<pp:else/>
		<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php[@encrypt_url($backUrl)]'</script>
	</pp:if>			
			
	
</pp:if>