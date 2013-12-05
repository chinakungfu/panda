<pp:var name="shareNodeId" value="@getGlobalModelVar('shareNode')"/>
<pp:var name="shareNode" value="@getNodeInfoById($shareNodeId)"/>
<pp:var name="shareContentModel" value="$shareNode.0.appTableName"/>
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
	<script>alert("Sorry, you are not login!");location.href="index.php[@encrypt_url('action=website&method=shareindex')]"</script>
</pp:if>
<pp:if expr="empty($sharePara.shareComment)">
	<script>alert("Sorry, you need input 1 character at least.");location.href="index.php[@encrypt_url('action=share&method=order')]"</script>
<pp:else/>
	<pp:if expr="$method=='addShare'">

		<pp:var name="sharePara.goodsId" value="$IN.goodsID"/>
		<pp:var name="sharePara.nodeId" value="$shareNode.0.nodeGuid"/>
		<pp:var name="sharePara.userId" value="$name"/>
		<pp:var name="sharePara.shareStatus" value="'1'"/>
		
		<?php date_default_timezone_set("prc");?>
		<pp:var name="sharePara.shareTime" value="strtotime(date('Y-m-d H:i:s',time()))"/>
		
		<pp:var name="addshareTable" value="@addData($shareNodeId,$shareContentModel,$sharePara)"/>		
		<pp:if expr="addshareTable">
		
			<pp:var name="publishshareTable" value="@publish($shareNodeId,$shareContentModel,$shareNode.0.appTableKeyName,$addshareTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
			<pp:if expr="publishshareTable">
				<script>location.href="index.php[@encrypt_url('action=website&method=shareindex')]"</script>
			</pp:if>
		</pp:if>
	</pp:if>
</pp:if>