<pp:var name="userName" value="<pp:session funcname="readSession()"/>"/>

<pp:if expr="$userName==''">			
<pp:var name="CookieUser" value="@readCookie()"/>	
	<pp:if expr="$CookieUser">
		<pp:var name="tmpUser" value="$CookieUser"/>
	<pp:else/>
		<pp:var name="tmpUser" value="@getSessionID()"/>
		{@writeCookie($tmpUser)}
	</pp:if>
<pp:else/>
	<pp:var name="tmpUser" value="$userName"/>
</pp:if>

<cms action="sql" return="cartList" query="SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC"/>

<cms action="sql" return="cartInfo" query="SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC" />

<pp:var name="SubTotalPrice" value="0"/>			
<pp:var name="cartListNum" value="5"/>
<pp:var name="SubTotalPrice" value="number_format($cartInfo.data.0.totalPrice, 2, '.', ',')"/>
<div class="viewShoppingBag">
	<h2 class="viewShoppingBagHead">
	 View shopping bag
	 <a href="#" class="close fr textHide mr12" id="close" onclick="$('.popupLayer').hide();">close</a>
	 <span>Subtotal: [$SubTotalPrice]</span>
	</h2>
	<div class="viewShoppingBagCont" id="loadStr1">
	   <span class="loading"><img src="/skin/images/loading.gif" alt="loading"></span>
	   <span class="viewShoppingBagContp">LOADING SHOPPING BAG</span>
	</div>
	<div class="viewShoppingBagCont" id="dataStr1" style="display:none">
	   <p>Note: Items and promotional pricing not reserved until checkout is completed</p>
	   <span>[$cartInfo.data.0.ItemQTY] items in your bag</span>
	   <loop name="cartList.data" var="var" key="key">   
	   
	   <pp:if expr="$cartIDstr_tmp">
		<pp:var name="cartIDstr_tmp" value="$cartIDstr_tmp . ',' . $var.cartID"/>
		<pp:else/>
			<pp:var name="cartIDstr_tmp" value="$var.cartID"/>
		</pp:if>
	
	   <pp:if expr="$key<$cartListNum">
	   <dl>
	       <dt class="fl">
	       
	       <pp:if expr="$var.goodsType=='inside'">		    
		    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="小图1" style="width:75px;height:93px" border="0">
		<pp:elseif expr="$var.goodsType=='outside'">
		    <img src="[$var.goodsImgURL]" alt="小图1" style="width:75px;height:93px" border="0">
		</pp:if>
	       </dt>
	       <pp:if expr="$var.goodsTitleCN">
						<dd><strong>[$var.goodsTitleCN]</strong></dd>
						</pp:if>
						<pp:if expr="$var.goodsTitleEn">
						<dd><strong>[$var.goodsTitleEn] </strong></dd>
						</pp:if>
	       <!--<dd>Item: BGS12_B1LLD</dd>-->
	       <pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
	       <dd>Price:￥ [$SinglePrice]</dd>
	       <dd>Qty: [$var.ItemQTY]</dd>
	      <dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if>
	      <pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
		<pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd></pp:if>
	       <dd>Seller Freit : <pp:if expr="$var.goodsFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.goodsFreight, 2, '.', ',')"/>[$Freight]</pp:if></dd>
	   </dl><br>
	   </pp:if>
	   </loop>
	   </div>
	   <form action="/publish/index.php" method="post" id="actionForm">
		<input type="hidden" name="action" value="shop">
		<input type="hidden" name="method" value="releaseOrder">
		<input type="hidden" name="para[cartIDstr]" value="[$cartIDstr_tmp]">
		<input type="hidden" name="para[orderUser]" value="[$tmpUser]">
		<div class="viewShoppingBagfoot">
			<a href="index.php[@encrypt_url('action=website&method=shopindex')]" class="btn fl buyMore">Buy More</a>
			<!--<a href="javascript:javascript:void(0)" onclick="$('#actionForm').submit();" class="btn fl checkout">Checkout</a>-->
			<a href="index.php[@encrypt_url('action=shop&method=myCart')]" class="btn fl checkout">Checkout</a>
	   </div>
		</form>
	</div>
</div>