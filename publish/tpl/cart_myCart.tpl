
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Cart</title>
	<link rel="stylesheet" href="[@getGlobalModelVar('Site_Domain')]skin/css/style.css"/>
	<script type="text/javascript" src="[@getGlobalModelVar('Site_Domain')]skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="[@getGlobalModelVar('Site_Domain')]skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){ 
				$(document).pngFix(); 
			}); 
	</script>
</head>
<body>
	<pp:include file="common/header/red_header.tpl" type="tpl"/>

	<div class="wow-body">
		<div class="wow-body-contain">
			<pp:include file="common/header/top_guide.tpl" type="tpl"/>
			<pp:include file="common/wow_left.tpl" type="tpl"/>
			<div class="line2-full left">
				<h3 class="wow-module-title">
					SHOPPING CART
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center">Price</th>
						<th width="16%" align="center">Quantity</th>
					</tr>
				<pp:var name="SubTotalPrice" value="0"/>				
				 <cms action="sql" return="cartList" query="SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$name1}' and a.ItemStatus = 'New'" OrderBy="i.publishDate DESC" />
            			 <pp:var name="goodsIDstr_tmp" value="''"/>
				 <loop name="cartList.data" var="var" key="key">
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>							
							<img class="left item-view-s" src="[$var.goodsImgURL]" alt=""/>
							<span class="left item-name">[$var.goodsTitleEn]</span>
						</td>
						<td>
							<a class="ce" href="[@getGlobalModelVar('Site_Domain')]publish/index.php[@encrypt_url('action=wow&method=DeleteData&nodeId=71&cartID=' .$var.cartID)]">delete</a> 
							<a class="ce" href="[@getGlobalModelVar('Site_Domain')]publish/index.php[@encrypt_url('action=wow&method=CartToWish&nodeId=71&cartID=' .$var.cartID)]" >save as wish</a>
						</td>
						<td align="center">RMB [$var.goodsUnitPrice]</td>
						<td align="center">
							<span class="qcb">-</span> <input type="text" class="iq" value="[$var.ItemQTY]"/> <span class="qcb">+</span>
						</td>
					</tr>
				<pp:var name="SubTotalPrice" value="$SubTotalPrice+$var.ItemQTY*$var.goodsUnitPrice"/>
				<pp:if expr="$goodsIDstr_tmp">
				<pp:var name="goodsIDstr_tmp" value="$goodsIDstr_tmp . ',' . $var.ItemGoodsID"/>
				<pp:else/>
				<pp:var name="goodsIDstr_tmp" value="$var.ItemGoodsID"/>
				</pp:if>
				</loop>					

					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td align="right" colspan=2>Subtotal ([$var_CartNum.cnum] items ):</td>
					
						<td align="center">RMB [$SubTotalPrice]</td>
						<td align="center">
						<pp:var name="orderNo" value="strtotime(date("Y-m-d H:i:s",time())) . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT)"/>
						<form name="form" action="[@getGlobalModelVar('Site_Domain')]publish/index.php" method="post">
						<input type="hidden" name="action" value="wow">
						<input type="hidden" name="method" value="addOrder">
						<input type="hidden" name="nodeId" value="[@getGlobalModelVar('orderNode')]">
						<input type="hidden" name="para[goodsIDstr]" value="[$goodsIDstr_tmp]">
						<input type="hidden" name="para[OrderNo]" value="[$orderNo]">
						<input id="ocheck" type="submit" class="button-link" value="Checkout"/>
						<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
						<pp:if expr="$name">
							<input type="hidden" name="para[goodsAddUser]" value="[$name]">	
							<input type="hidden" name="isLogin" value="1">	
						<pp:else/>	
							<input type="hidden" name="isLogin" value="0">
							<input type="hidden" name="para[goodsAddUser]" value="[@getSessionID()]">
						</pp:if>
						</form>
						
						</td>

						
					</tr>
				</table>
				<h3 id="wl-title" class="wow-module-title sec-title">
					WISH LIST
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center"></th>
						<th width="16%" align="center"></th>
					</tr>
					
					 <cms action="sql" return="WishList" query="SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$name1}' and a.ItemStatus = 'Wish'" OrderBy="i.publishDate DESC" num="3"/>
					<loop name="WishList.data" var="var" key="key">
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<img class="left item-view-s" src="[$var.goodsImgURL]" alt=""/>
							<span class="left item-name">[$var.goodsTitleEn]</span>
						</td>
						<td>
							<a class="ce" href="[@getGlobalModelVar('Site_Domain')]publish/index.php[@encrypt_url('action=wow&method=DeleteData&nodeId=71&cartID=' .$var.cartID)]">delete</a> 
							<a class="ce" href="[@getGlobalModelVar('Site_Domain')]publish/index.php[@encrypt_url('action=wow&method=WishToCart&nodeId=71&cartID=' .$var.cartID)]" >move to cart</a>
						</td>
						<td align="center">RMB [$var.goodsUnitPrice]</td>
						<td align="center">
							
						</td>
					</tr>
					</loop>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<pp:include file="common/footer/red_footer.tpl" type="tpl"/>
</body>
</html>