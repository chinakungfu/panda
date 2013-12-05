<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
	<script>location.href='index.php[@encrypt_url('action=website&method=login')]'</script>	
<pp:else/>
	<pp:var name="userInfo" value="@getStaffInfoById($name)"/>
	<pp:if expr="$userInfo.0.groupName!='administrator'">
		<script>location.href='index.php[@encrypt_url('action=website&method=login')]'</script>	
	</pp:if>
</pp:if>

<pp:var name="tempUrl" value="'action=admin&method=orderDetail&orderID=' . $IN.orderID"/>
<pp:var name="Urltemp" value="'action=admin&method=orderDetail&orderID=' . $IN.orderID"/>
<pp:if expr="$method=='updateOrder'">	
	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemQTY = '{$IN.para.ItemQTY}',itemPrice='{$IN.para.goodsUnitPrice}', itemFreight='{$IN.para.Freight}' WHERE cartID = '{$IN.cartID}' " />
	<!--<cms action="sql" return="updateOrder" query="UPDATE cms_publish_orderdetail SET goodsPrices='{$IN.para.goodsUnitPrice}', goodsFreight='{$IN.para.Freight}' WHERE orderId = '{$IN.orderID}' and orderGoodsId='{$IN.goodsid}'" />
	<pp:if expr="$updateOrder and $updateCart">	-->
	<pp:if expr="$updateCart">
		<script>alert('Edit Successfully. If you finished order edit, please click the confirm button!');location.href='index.php[@encrypt_url($tempUrl)]'</script>		
	</pp:if>
<pp:elseif expr="$method=='confirmOrder'">
	<pp:var name="Url" value="'action=admin&method=orderDetail&orderID=' . $IN.orderID"/>
	<cms action="sql" return="getCartIDstr" query="select * from  cms_publish_order where  orderID = '{$IN.orderID}' " />
	<pp:if expr="$getCartIDstr.data.0.orderStatus==3">
		<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET orderStatus = '4' WHERE orderID = '{$IN.orderID}' " />		
		<pp:if expr="updateOrder">
			<cms action="sql" return="addressInfo" query="SELECT * FROM cms_publish_address WHERE addressID='{$getCartIDstr.data.0.orderAddress}' limit 1" />
			<pp:var name="mailArr.email" value="$addressInfo.data.0.email" />
			<pp:var name="mailArr.userId" value="$addressInfo.data.0.userId" />
			<pp:var name="mailArr.orderNo" value="$getCartIDstr.data.0.OrderNo" />
			<pp:var name="Mailresult" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>
			<pp:if expr="resultMail">
				<script>alert('Update Successfully');location.href='index.php[@encrypt_url($Url)]'</script>
			<pp:else/>
				<script>alert('Mail Fail');location.href="index.php[@encrypt_url($IN.backUrl)]"</script>
			</pp:if>					
		</pp:if>		
	<pp:else/>
		<script>alert("This order has been fixed.");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
	</pp:if>
</pp:if>