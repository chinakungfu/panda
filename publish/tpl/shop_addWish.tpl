<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
	<pp:var name="wishNodeId" value="@getGlobalModelVar('WishListNode')"/>
	<pp:var name="wishNode" value="@getNodeInfoById($wishNodeId)"/>	

	

	<pp:if expr="$method=='addWish'">

		<pp:var name="wishPara.nodeId" value="$wishNode.0.nodeGuid"/>
		<pp:var name="wishPara.ItemStatus" value="'Wish'"/>
		
		<pp:if expr="$IN.loginType=='addWish'">	
			

			<pp:var name="wishPara.ItemQTY" value="$IN.ItemQTY"/>
			<pp:var name="wishPara.UserName" value="$name"/>
			<pp:var name="wishPara.ItemGoodsID" value="$IN.ItemGoodsID"/>
			<pp:var name="wishPara.itemPrice" value="$IN.itemPrice"/>
			<pp:var name="wishPara.itemFreight" value="$IN.itemFreight"/>
			<pp:var name="tempUrl" value="'action=shop&method=goodsDetail&goodsID=' . $IN.ItemGoodsID"/>
			<cms action="sql" return="wishCount" query="select count(cartID) as qty from cms_publish_cart where ItemGoodsID='{$IN.ItemGoodsID}' and UserName='{$name}' and ItemStatus='Wish'"/>
			<!--
			商品的英文名字和notes未保存在cart表中
			-->

			<?php print_r( $this->_tpl_vars["wishPara"]);?>
		<pp:else/>
			<pp:var name="tempUrl" value="'action=shop&method=goodsDetail&goodsID=' . $IN.para.goodsID"/>
			<pp:var name="wishPara.ItemQTY" value="$IN.para.ItemQTY"/>
			<pp:var name="wishPara.UserName" value="$name"/>
			<pp:var name="wishPara.ItemGoodsID" value="$IN.para.goodsID"/>	
			<pp:var name="wishPara.itemPrice" value="$IN.para.itemPrice"/>
			<pp:var name="wishPara.itemFreight" value="$IN.para.itemFreight"/>
			<cms action="sql" return="wishCount" query="select count(cartID) as qty from cms_publish_cart where ItemGoodsID='{$IN.para.goodsID}' and UserName='{$name}' and ItemStatus='Wish'"/>
		</pp:if>	
			<!--<?php print_r( $this->_tpl_vars["wishCount"]);?>-->
			
			<pp:if expr="$wishCount.data.0.qty==0">	
				<pp:var name="addCartTable" value="@addData($wishNodeId,$wishNode.0.appTableName,$wishPara)"/>		
				<!--{@publish($wishNodeId,$wishNode.0.appTableName,$wishNode.0.appTableKeyName,$addCartTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)}-->
							
				<script>alert("Add Successfully!");location.href="index.php[@encrypt_url($tempUrl)]"</script>
			<pp:else/>
				<script>alert("This item has already in your Wish List, please don't add it repeatedly.");location.href="index.php[@encrypt_url($tempUrl)]"</script>
			</pp:if>
		
	</pp:if>
<pp:else/>
	<pp:var name="paraArr.backAction" value="shop"/>
	<pp:var name="paraArr.backMethod" value="addWish"/>
	<pp:var name="paraArr.ItemQTY" value="$IN.para.ItemQTY"/>
	<pp:var name="paraArr.ItemGoodsID" value="$IN.para.goodsID"/>
	<pp:var name="paraArr.itemPrice" value="$IN.para.itemPrice"/>
	<pp:var name="paraArr.itemFreight" value="$IN.para.itemFreight"/>

	<pp:var name="paraStr" value="serialize($paraArr)"/>

	<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=addWish&paraStr=' . $paraStr )]'</script>
</pp:if>




