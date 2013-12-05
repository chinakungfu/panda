<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
		<pp:var name="tmpUser" value="@readCookie()"/>		
<pp:else/>
	<pp:var name="tmpUser" value="$name"/>
</pp:if>
<pp:var name="orderNodeId" value="@getGlobalModelVar('orderNode')"/>
<pp:var name="orderNode" value="@getNodeInfoById($orderNodeId)"/>
<pp:var name="tempUrl" value="'action=wow&method=myCart&nodeId=GWCGLHat1'"/>

<cms action="content" return="listOrder" nodeid="{$orderNode.0.nodeGuid}" contentid="{$IN.para.orderID}"/>
<pp:if expr="$listOrder.orderStatus==1">
	<pp:if expr="$method=='updateAddress' and $listOrder.orderUser==$tmpUser">

		<pp:var name="orderContentModel" value="$orderNode.0.appTableName"/>
		<pp:var name="orderappTableKeyName" value="$orderNode.0.appTableKeyName"/>
		<pp:var name="orderappTableKeyValue" value="$IN.para.orderID"/>

		<pp:if expr="$IN.para.orderAddress">	
			<cms action="sql" return="editOrderTable" query="UPDATE a0222211743.cms_publish_order SET orderAddress = '{$IN.para.orderAddress}',orderStatus='2' WHERE orderID = '{$IN.para.orderID}' " />
			<!--<pp:var name="editOrderTable" value="@editData($orderNodeId,$orderContentModel,$appTableKeyName,$appTableKeyValue,$para)"/>-->
			<pp:if expr="$editOrderTable">		
				<pp:var name="tempUrl" value="'action=shop&method=orderConfirm&orderID=' . $IN.para.orderID"/>	
			
				<script>location.href='index.php[@encrypt_url($tempUrl)] '</script>
			</pp:if>
		<pp:else/>
			<pp:var name="checkData" value="<pp:memfunc funcname="checkAddressData($IN.addressPara)"/>"/>
			<pp:if expr="$checkData==1">
				<pp:var name="AddressNodeId" value="@getGlobalModelVar('AddressNode')"/>
				<pp:var name="AddressNode" value="@getNodeInfoById($AddressNodeId)"/>
				<pp:var name="AddressContentModel" value="$AddressNode.0.appTableName"/>

				<pp:var name="addressPara.nodeId" value="$AddressNode.0.nodeGuid"/>
				<pp:var name="addressPara.userId" value="$tmpUser"/>
				<pp:var name="addressPara.status" value="1"/>
				<pp:var name="addressPara.type" value="user"/>
			
				<pp:var name="addAddress" value="@addData($AddressNodeId,$AddressContentModel,$addressPara)"/>
				<pp:if expr="$addAddress">
					<pp:var name="publishAddress" value="@publish($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$addAddress,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
					<pp:if expr="$publishAddress">
						<cms action="sql" return="editOrderTable" query="UPDATE a0222211743.cms_publish_order SET orderAddress = '{$addAddress}',orderStatus='2' WHERE orderID = '{$IN.para.orderID}' " />
						<!--<pp:var name="editOrderTable" value="@editData($orderNodeId,$orderContentModel,$appTableKeyName,$appTableKeyValue,$para)"/>-->
						<pp:if expr="$editOrderTable">		
							<pp:var name="Url" value="'action=shop&method=orderConfirm&orderID=' . $IN.para.orderID"/>
							<script>location.href="index.php[@encrypt_url($Url)]"</script>
						</pp:if>										
					<pp:else/>
					1
					</pp:if>
				<pp:else/>
				2
				</pp:if>
			<pp:else/>	
				<!--<?php print_r($this->_tpl_vars["checkData"]);?>
				<br>
				<br>
				-->
				
				<pp:var name="backData" value="<pp:memfunc funcname="backAddressData($IN.addressPara,$checkData)"/>"/>	
				<!--<?php print_r($this->_tpl_vars["backData"]);?>
				<br>
				<br>-->
				
				<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>	
			</pp:if>

		</pp:if>
	<pp:else/>
		<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
	</pp:if>
<pp:else/>
	<script>alert("This order has been fixed.");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
</pp:if>
