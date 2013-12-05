<pp:var name="tempUrl" value="'action=shop&method=orderConfirm&orderID=' . $IN.orderID"/>
<pp:var name="Urltemp" value="'action=shop&method=orderDetail&orderID=' . $IN.orderID"/>
<pp:if expr="$method=='updateOrder'">	
	<pp:if expr="$IN.para.goodsTitleEn!='Input the English name here if you can'">
		<cms action="sql" return="updateGoods" query="UPDATE cms_publish_goods SET goodsTitleEn = '{$IN.para.goodsTitleEn}' WHERE goodsID = '{$IN.para.goodsID}' " />
	</pp:if>
	<pp:if expr="$IN.para.goodsNotes=='Please input Color, Size here......'">
		<pp:var name="goodsNotes" value="''"/>
	</pp:if>
	
	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemQTY = '{$IN.para.ItemQTY}',itemNotes='{$goodsNotes}',itemSize='{$IN.para.goodsSize}' ,itemColor='{$IN.para.goodsColor}' WHERE cartID = '{$IN.cartID}' " />
	
	<pp:if expr="updateCart">	
		<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
		
	</pp:if>
<pp:elseif expr="$method=='delOrder'">	
	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$IN.cartID}' " />
	<pp:if expr="$updateCart">			
		<pp:var name="NewcartIdStr" value="@delSpecialWord($cartIDString,$cartID)"/>	
		<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET cartIDstr = '{$NewcartIdStr}' WHERE orderID = '{$IN.orderID}' " />
		<pp:if expr="updateOrder">
			<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
		</pp:if>
	</pp:if>	
<pp:elseif expr="$method=='OrderToWish'">
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	<pp:if expr="$name">
		<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$IN.cartID}' " />
		<pp:if expr="$updateCart">			
			<pp:var name="NewcartIdStr" value="@delSpecialWord($cartIDString,$cartID)"/>	
			<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET cartIDstr = '{$NewcartIdStr}' WHERE orderID = '{$IN.orderID}' " />
			<pp:if expr="updateOrder">
				<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
			</pp:if>
		</pp:if>
	<pp:else/>
		<pp:var name="paraArr.backAction" value="shop"/>
		<pp:var name="paraArr.backMethod" value="orderConfirm"/>	
		<pp:var name="paraArr.orderID" value="$IN.orderID"/>	

		<pp:var name="paraStr" value="serialize($paraArr)"/>

		<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=OrderToWish&paraStr=' . $paraStr )]'</script>
	</pp:if>
<pp:elseif expr="$method=='cancelOrder'">
	<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
	<pp:if expr="$name">
		<pp:var name="Url" value="'action=shop&method=myCart'"/>
		<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET orderStatus = '-1' WHERE orderID = '{$IN.orderID}' " />
		<pp:var name="tempUrl" value="'action=shop&method=myCart&orderID=' . $IN.orderID"/>
		<pp:if expr="$cancelType=='move'">	
			<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$IN.cartID}' " />
			<pp:if expr="$updateCart">			
				<pp:var name="NewcartIdStr" value="@delSpecialWord($cartIDString,$cartID)"/>	
				<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET cartIDstr = '{$NewcartIdStr}' WHERE orderID = '{$IN.orderID}' " />
				<pp:if expr="updateOrder">
					<script>location.href='index.php[@encrypt_url($Url)]'</script>
				</pp:if>
			</pp:if>
		<pp:elseif expr="$cancelType=='del'">
			<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$IN.cartID}' " />
			<pp:if expr="$updateCart">
					<script>location.href='index.php[@encrypt_url($Url)]'</script>			
			</pp:if>
		</pp:if>	
	<pp:else/>
		<pp:var name="paraArr.backAction" value="shop"/>
		<pp:var name="paraArr.backMethod" value="orderConfirm"/>				
		<pp:var name="paraArr.orderID" value="$IN.orderID"/>

		<pp:var name="paraStr" value="serialize($paraArr)"/>

		<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=cancelOrder&paraStr=' . $paraStr )]'</script>
	</pp:if>
<pp:elseif expr="$method=='updateOrderDetail'">
	<cms action="sql" return="updateOrder" query="UPDATE cms_publish_cart SET ItemQTY = '{$IN.para.ItemQTY}',itemNotes='{$IN.para.goodsNotes}' WHERE cartID = '{$IN.cartID}' " />
	<pp:if expr="$updateOrder">	
		<script>location.href='index.php[@encrypt_url($Urltemp)]'</script>
		
	</pp:if>
<pp:elseif expr="$method=='delOrderDetail'">	
	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$IN.cartID}' " />
	<pp:if expr="$updateCart">			
		<pp:var name="NewcartIdStr" value="@delSpecialWord($cartIDString,$cartID)"/>	
		<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET cartIDstr = '{$NewcartIdStr}' WHERE orderID = '{$IN.orderID}' " />
		<pp:if expr="updateOrder">
			<script>location.href='index.php[@encrypt_url($Urltemp)]'</script>
		</pp:if>
	</pp:if>	
<pp:elseif expr="$method=='OrderDetailToWish'">
	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$IN.cartID}' " />
	<pp:if expr="$updateCart">			
		<pp:var name="NewcartIdStr" value="@delSpecialWord($cartIDString,$cartID)"/>	
		<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET cartIDstr = '{$NewcartIdStr}' WHERE orderID = '{$IN.orderID}' " />
		<pp:if expr="updateOrder">
			<script>location.href='index.php[@encrypt_url($Urltemp)]'</script>
		</pp:if>
	</pp:if>
<pp:elseif expr="$method=='cancelOrderDetail'">
	<pp:var name="Url" value="'action=shop&method=myCart'"/>
	<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET orderStatus = '-1' WHERE orderID = '{$IN.orderID}' " />	
	<pp:if expr="$cancelType=='move'">	
		<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$IN.cartID}' " />
		<pp:if expr="$updateCart">
				<script>location.href='index.php[@encrypt_url($Url)]'</script>			
		</pp:if>
	<pp:elseif expr="$cancelType=='del'">
		<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$IN.cartID}' " />
		<pp:if expr="$updateCart">
				<script>location.href='index.php[@encrypt_url($Url)]'</script>			
		</pp:if>
	</pp:if>	
<pp:elseif expr="$method=='submitOrder'">
	<pp:var name="Url" value="'action=shop&method=orderSubmit&orderID=' . $IN.orderID"/>
	<cms action="sql" return="getCartIDstr" query="select * from  cms_publish_order where  orderID = '{$IN.orderID}' " />
	<pp:if expr="$getCartIDstr.data.0.orderStatus==2">
		<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemStatus = 'Order' WHERE cartID in ({$getCartIDstr.data.0.cartIDstr}) " />
		<pp:if expr="updateCart">
			<cms action="sql" return="insertDetail" query="Insert into cms_publish_orderdetail(orderGoodsId, goodsPrices, goodsFreight, orderId) select b.goodsid,b.goodsunitprice,b.goodsfreight,{$IN.orderID} from cms_publish_cart a,cms_publish_goods b  WHERE a.cartID in ({$getCartIDstr.data.0.cartIDstr}) and a.itemgoodsid=b.goodsid " />
			
			<cms action="sql" return="updateOrder" query="UPDATE cms_publish_order SET orderStatus = '3' WHERE orderID = '{$IN.orderID}' " />		
			<pp:if expr="updateOrder">
				<cms action="sql" return="addressInfo" query="SELECT * FROM cms_publish_address WHERE addressID='{$getCartIDstr.data.0.orderAddress}' limit 1" />
				<pp:var name="mailArr.email" value="$addressInfo.data.0.email" />
				<pp:var name="mailArr.userId" value="$addressInfo.data.0.userId" />
				<pp:var name="mailArr.orderNo" value="$getCartIDstr.data.0.OrderNo" />
				<pp:var name="Mailresult" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>
				<pp:if expr="resultMail">
					<script>location.href='index.php[@encrypt_url($Url)]'</script>
				<pp:else/>
					<script>alert('Mail Fail');location.href="index.php[@encrypt_url($IN.backUrl)]"</script>
				</pp:if>

							
			</pp:if>
		</pp:if>
	<pp:else/>
		<script>alert("This order has been fixed.");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
	</pp:if>
</pp:if>