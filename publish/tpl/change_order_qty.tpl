<!--<pp:appfunc app="publish" file="./appfunc/cart" return="updateCart" funcname="changeCartQtyById($cartId,$itemQTY)"/>
<pp:appfunc app="publish" file="./appfunc/cart" return="cartInfo" funcname="getCartInfoById($cartId)"/>-->

<cms action="sql" return="updateCart" query="update cms_publish_cart set ItemQTY='{$itemQTY}' where cartID='{$cartID}'" />
<pp:if expr="$cartType=='New'">
<cms action="sql" return="cartInfo" query="SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$userId}' and a.ItemStatus = '{$cartType}' Order By a.cartid DESC" />
<pp:else/>
<cms action="sql" return="cartInfo" query="SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$userId}' and a.cartID in ({$cartIdStr}) Order By a.cartid DESC" />
</pp:if>
<pp:return data="$cartInfo.data.0.ItemQTY . '-' . $cartInfo.data.0.totalPrice"/>