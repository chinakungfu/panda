<pp:var name="tempUrl" value="'action=shop&method=myCart'"/>
<pp:if expr="$method=='updateCart'">	
	<pp:if expr="$IN.para.goodsTitleEn!='Input the English name here if you can'">
		<cms action="sql" return="updateGoods" query="UPDATE cms_publish_goods SET goodsTitleEn = '{$IN.para.goodsTitleEn}' WHERE goodsID = '{$IN.para.goodsID}' " />
	</pp:if>
	<pp:if expr="$IN.para.goodsNotes=='Please input Color, Size here......'">
		<pp:var name="goodsNotes" value="''"/>
	</pp:if>

	<cms action="sql" return="updateCart" query="UPDATE cms_publish_cart SET ItemQTY = '{$IN.para.ItemQTY}',itemNotes='{$goodsNotes}',itemSize='{$IN.para.goodsSize}' ,itemColor='{$IN.para.goodsColor}' WHERE cartID = '{$IN.cartID}' " />
	
	<pp:if expr="$updateCart">	
		<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
	</pp:if>
</pp:if>