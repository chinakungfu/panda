<?php ob_start();?>
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
<pp:var name="CookieUser" value="@readCookie()"/>	
	<pp:if expr="$CookieUser">
		<pp:var name="tmpUser" value="$CookieUser"/>
	<pp:else/>
		<pp:var name="tmpUser" value="@getSessionID()"/>
		{@writeCookie($tmpUser)}
	</pp:if>
<pp:else/>
	<pp:var name="tmpUser" value="$name"/>
</pp:if>
<pp:var name="Strtmp" value="urldecode($paraStr)"/>
<pp:var name="paraArr" value="parse_str($Strtmp,$myArray)"/>
<pp:var name="cartNodeId" value="@getGlobalModelVar('cartNode')"/>
<pp:var name="cartNode" value="@getNodeInfoById($cartNodeId)"/>
<pp:var name="cartContentModel" value="$cartNode.0.appTableName"/>

<pp:if expr="$myArray.method=='addWish'">
	<pp:var name="cartPara.nodeId" value="$cartNode.0.nodeGuid"/>
	<pp:var name="cartPara.ItemStatus" value="'New'"/>
	<pp:var name="cartPara.ItemQTY" value="$myArray.para.ItemQTY"/>
	
	<pp:var name="cartPara.UserName" value="$tmpUser"/>
	<pp:var name="cartPara.ItemGoodsID" value="$myArray.para.goodsID"/>	
	<pp:var name="cartPara.itemPrice" value="$myArray.para.itemPrice"/>
	<pp:var name="cartPara.itemFreight" value="$myArray.para.itemFreight"/>
	<pp:if expr="$myArray.para.goodsNotes!='Please input Color, Size here......'">
		<pp:var name="cartPara.itemNotes" value="$myArray.para.goodsNotes"/>
	</pp:if>
	<pp:if expr="$myArray.para.goodsSize!='' and $myArray.para.goodsSize!=1">
		<pp:var name="cartPara.itemSize" value="$myArray.para.goodsSize"/>
	</pp:if>
	<pp:if expr="$myArray.para.goodsColor!='' and $myArray.para.goodsColor!=1">
		<pp:var name="cartPara.itemColor" value="$myArray.para.goodsColor"/>
	</pp:if>
	
	<pp:if expr="$addFlag==1">
		<pp:if expr="$myArray.para.goodsTitleEn!='Input the English name here if you can'">
		<cms action="sql" return="updateGoods" query="UPDATE cms_publish_goods SET goodsTitleEn = '{$myArray.para.goodsTitleEn}' WHERE goodsID = '{$myArray.para.goodsID}' " />
		</pp:if>
		<pp:if expr="updateGoods">	
			<pp:var name="addCartTable" value="@addData($cartNodeId,$cartContentModel,$cartPara)"/>		
			<pp:if expr="addCartTable">
				<!--<pp:var name="publishCartTable" value="@publish($cartNodeId,$cartContentModel,$cartNode.0.appTableKeyName,$addCartTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
				<pp:if expr="publishCartTable">-->
					<!--<cms action="sql" return="cartList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$cartPara.UserName}' and a.ItemStatus = 'New' Order By a.cartid DESC" num="5"/>-->
					<cms action="sql" return="cartList" query="SELECT count(*) as countRows FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$cartPara.UserName}' and a.ItemStatus = 'New' Order By a.cartid DESC"/>
					<!--<pp:var name="returnStr" value="serialize($cartList.Data)"/>-->
					<pp:if expr="updateGoods">
						<pp:return data="$cartList.data.0.countRows"/>
					<pp:else/>
						<pp:return data="'0'"/>
					</pp:if>
				<!--<pp:else/>
					<pp:return data="'-1'"/>
				</pp:if>-->
			<pp:else/>
				<pp:return data="'-1'"/>
			</pp:if>
		<pp:else/>
			<pp:return data="'-1'"/>
		</pp:if>
	<pp:else/>
		<pp:var name="cartPara.UserName" value="$tmpUser"/>
		<cms action="sql" return="cartList" query="SELECT count(*) as countRows FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$cartPara.UserName}' and a.ItemStatus = 'New' Order By a.cartid DESC"/>
		<pp:return data="$cartList.data.0.countRows"/>
	</pp:if>
</pp:if>
<?php ob_end_flush();?>