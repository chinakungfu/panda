<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
		<pp:var name="tmpUser" value="@readCookie()"/>		
<pp:else/>
	<pp:var name="tmpUser" value="$name"/>
</pp:if>
<pp:if expr="$method=='releaseOrder' and $IN.para.orderUser==$tmpUser">
	<pp:var name="orderNodeId" value="@getGlobalModelVar('orderNode')"/>
	<pp:var name="orderNode" value="@getNodeInfoById($orderNodeId)"/>
	<pp:var name="orderContentModel" value="$orderNode.0.appTableName"/>

	<pp:var name="para.orderStatus" value="'0'"/>
	<pp:var name="para.orderNo" value="strtotime(date("Y-m-d H:i:s",time())) . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT)"/>
	<pp:var name="para.nodeId" value="$orderNode.0.nodeGuid"/>
	<pp:var name="para.orderTime" value="strtotime(date('Y-m-d H:i:s',time()))"/>

	<pp:var name="addorderTable" value="@addData($orderNodeId,$orderContentModel,$para)"/>	
	<!--<cms action="sql" return="updateCart" query="UPDATE a0222211743.cms_publish_cart SET ItemStatus = 'Order' WHERE cartID in ({$para.cartIDstr}) " />-->
	<pp:if expr="addorderTable">
	
		<!--<pp:var name="publishorderTable" value="@publish($orderNodeId,$orderContentModel,$orderNode.0.appTableKeyName,$addorderTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
		<pp:if expr="publishorderTable">	-->	
			<pp:var name="tempUrl" value="'action=shop&method=addService&orderID=' .$addorderTable"/>
			<!--<pp:var name="tempUrl" value="'action=shop&method=addService&orderID=' . $addorderTable"/>-->
			
			<script>location.href="index.php[@encrypt_url($tempUrl)]"</script>					
		<!--</pp:if>	-->	
	</pp:if>
<pp:else/>
	<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
</pp:if>