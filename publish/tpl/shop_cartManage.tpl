<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:var name="cartNodeId" value="@getGlobalModelVar('cartNode')"/>
<pp:var name="cartNode" value="@getNodeInfoById($cartNodeId)"/>
<pp:var name="cartContentModel" value="$cartNode.0.appTableName"/>

<pp:var name="wishNodeId" value="@getGlobalModelVar('WishListNode')"/>
<pp:var name="wishNode" value="@getNodeInfoById($wishNodeId)"/>
<pp:var name="wishContentModel" value="$wishNode.0.appTableName"/>

<pp:var name="tempUrl" value="'action=shop&method=myCart'"/>

<pp:if expr="$method=='WishToCart'">

	<pp:var name="contentModel" value="$cartNode.0.appTableName"/>
	<pp:var name="appTableKeyName" value="$cartNode.0.appTableKeyName"/>
	<pp:var name="appTableKeyValue" value="$cartID"/>
	<pp:var name="para.cartID" value="$cartID"/>
	<pp:var name="para.ItemStatus" value="'New'"/>
	<pp:var name="para.nodeId" value="$cartNode.0.nodeGuid"/>

	<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>
	
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	
<pp:elseif expr="$method=='CartToWish'">	
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	<pp:if expr="$name">
		<pp:var name="contentModel" value="$cartNode.0.appTableName"/>
		<pp:var name="appTableKeyName" value="$cartNode.0.appTableKeyName"/>
		<pp:var name="appTableKeyValue" value="$cartID"/>
		<pp:var name="para.cartID" value="$cartID"/>
		<pp:var name="para.ItemStatus" value="'Wish'"/>
		<pp:var name="para.nodeId" value="$wishNode.0.nodeGuid"/>
		
		<cms action="sql" return="wishCount" query="select count(cartID) as qty from cms_publish_cart where cartID='{$IN.$cartID}' and UserName='{$name}'"/>
		<pp:if expr="$wishCount.data.0.qty==0">
			<pp:memfunc funcname="editData($nodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>			
			<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
		<pp:else/>
			<script>alert("This item has already in your Wish List, please don't add it repeatedly.");location.href="index.php[@encrypt_url($tempUrl)]"</script>
		</pp:if>
	<pp:else/>
		<pp:var name="paraArr.backAction" value="shop"/>
		<pp:var name="paraArr.backMethod" value="myCart"/>		

		<pp:var name="paraStr" value="serialize($paraArr)"/>

		<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=CartToWish&paraStr=' . $paraStr )]'</script>
	</pp:if>
	
<pp:elseif expr="$method=='DeleteData'">
	

	<pp:var name="contentModel" value="$cartNode.0.appTableName"/>
	<pp:var name="appTableKeyName" value="$cartNode.0.appTableKeyName"/>
	<pp:var name="appTableKeyValue" value="$cartID"/>
	<pp:var name="para.cartID" value="$cartID"/>
	<pp:var name="para.ItemStatus" value="'Delete'"/>
	
	<pp:memfunc funcname="editData($cartNodeId,$contentModel,$appTableKeyName,$appTableKeyValue,$para)"/>

	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>