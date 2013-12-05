<pp:var name="AddressNodeId" value="@getGlobalModelVar('AddressNode')"/>
<pp:var name="AddressNode" value="@getNodeInfoById($AddressNodeId)"/>
<pp:var name="AddressContentModel" value="$AddressNode.0.appTableName"/>
<pp:var name="tempUrl" value="'action=account&method=address'"/>
<pp:if expr="$method=='addNewAddress'">
	<pp:var name="checkData" value="<pp:memfunc funcname="checkAddressData($IN.para)"/>"/>
	<pp:if expr="$checkData==1">
		<pp:var name="para.nodeId" value="$AddressNode.0.nodeGuid"/>
		
		<pp:var name="addAddress" value="@addData($AddressNodeId,$AddressContentModel,$para)"/>
		<pp:if expr="$addAddress">
			<pp:var name="publishAddress" value="@publish($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$addAddress,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
			<pp:if expr="$publishAddress">
				
				<script>location.href="[$IN.url]"||"index.php[@encrypt_url($IN.backUrl1)]"</script>						
			<pp:else/>
			1
			</pp:if>
		<pp:else/>
		2
		</pp:if>
	<pp:else/>				
		<pp:var name="backData" value="<pp:memfunc funcname="backAddressData($IN.para,$checkData)"/>"/>		
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>		
	</pp:if>
<pp:elseif expr="$method=='delAddress'">	
	
	<pp:var name="appTableKeyValue" value="$IN.addressId"/>
	<pp:var name="para.addressId" value="$IN.addressId"/>
	<pp:var name="para.status" value="Delete"/>
	
	<pp:memfunc funcname="editData($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$appTableKeyValue,$para)"/>
	<script>location.href="[$IN.url]"||"index.php[@encrypt_url($tempUrl)]"</script>
<pp:elseif expr="$method=='updateAddress'">	
	<pp:var name="checkData" value="<pp:memfunc funcname="checkAddressData($IN.para)"/>"/>
	<pp:if expr="$checkData==1">
		<pp:var name="appTableKeyValue" value="$addressId"/>
		<pp:var name="para.addressId" value="$IN.addressId"/>		
		
		<pp:memfunc funcname="editData($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$appTableKeyValue,$para)"/>
		<script>location.href="[$IN.url]"||"index.php[@encrypt_url($IN.backUrl1)]"</script>
	<pp:else/>
		<!--<?php print_r($this->_tpl_vars["checkData"]);?>
		<br>
		<br>
		-->
		<pp:var name="backData" value="<pp:memfunc funcname="backAddressData($IN.para,$checkData)"/>"/>
		
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>
		
	</pp:if>

<pp:elseif expr="$method=='delOrderAddress'">	
	
	<pp:var name="appTableKeyValue" value="$IN.addressId"/>
	<pp:var name="para.addressId" value="$IN.addressId"/>
	<pp:var name="para.status" value="Delete"/>	

	<pp:memfunc funcname="editData($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$appTableKeyValue,$para)"/>
	<pp:var name="Url" value="'action=shop&method=WOWd2d&orderID' . $IN.orderID"/>
	<script>location.href="index.php[@encrypt_url($Url)]"</script>
<pp:elseif expr="$method=='updateOrderAddress'">	
	
	<pp:var name="appTableKeyValue" value="$addressId"/>
	<pp:var name="para.addressId" value="$IN.addressId"/>
	
	<pp:var name="Url" value="'action=shop&method=WOWd2d&orderID=' . $IN.orderID"/>

	<pp:memfunc funcname="editData($AddressNodeId,$AddressContentModel,$AddressNode.0.appTableKeyName,$appTableKeyValue,$para)"/>
	<script>location.href="index.php[@encrypt_url($Url)]"</script>
</pp:if>
