<!DOCTYPE HTML>
<html>
<head>
	<pp:include file="common/header/common_header.tpl" type="tpl"/>     
	<script type="text/javascript">
	function changeItemQTY(value,cartId,userId,cartType,cartIdStr)
	{
		call_tpl('shop','changeItemQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,'');
	}
	function backDataItemQTY(response)
	{
		var responseArr = response.split("-");
		var subTotalPriceObj = document.getElementById("subTotalPrice");
		var totalItemsObj = document.getElementById("totalItems");
		//totalItemsObj.innerHTML =responseArr[0];
		subTotalPriceObj.innerHTML = setCurrency(responseArr[1]);
	}
	//四舍五入保留两位小数
	function changeTwoDecimal(x)
	{
		var f_x = parseFloat(x);
		if (isNaN(f_x))
		{
			alert('function:changeTwoDecimal->parameter error');
			return false;
		}
		var f_x = Math.round(x*100)/100;
		return f_x;
	}
	function setCurrency(s){
		s = String(s);
		if(s.indexOf('-')==0){
			//计算负数
			s= s.substring(1,s.lenght);
			alert("ddddd"+s);
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return '-'+s.replace(/^\./,"0.")
		}else{
			//计算正数
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return s.replace(/^\./,"0.")
		}
	}
	</script>
</head>
<body>
	<!--最外框-->
	<div class="box">
		<!--头部-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>	
		<cms action="sql" return="cartList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC" />
		
		<cms action="sql" return="OrderQty" query="SELECT count(`orderID`) as qty FROM cms_publish_order WHERE orderUser='{$tmpUser}' and orderStatus>=3" />
		
		<pp:var name="cartIDstr_tmp" value="''"/>
		<pp:var name="cartNum" value="sizeof($cartList.data)"/>
		<loop name="cartList.data" var="var" key="key">
			<pp:if expr="$cartIDstr_tmp">
				<pp:var name="cartIDstr_tmp" value="$cartIDstr_tmp . ',' . $var.cartID"/>
			<pp:else/>
				<pp:var name="cartIDstr_tmp" value="$var.cartID"/>
			</pp:if>
		</loop>	
		<cms action="sql" return="WishList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'Wish'"/>
				<pp:var name="wishNum" value="sizeof($WishList.data)"/>
		<!--content info-->

		<div class="contentBag clb">
			<pp:if expr="$name==''">
				<div class="contentRLeft fl">
					<h2>Registered Customers</h2>
					<ul>
						<form action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="CheckUser">
							<input type="hidden" name="url" value="index.php[@encrypt_url('action=shop&method=myCart')]">
							<li><label>YOUR E-MAIL</label><input type="text" class="reglistText" name="staffNo" /></li>
							<li><label>PASSWORD</label><input class="reglistText" type="password" id="password" name="password" /></li>
							<li id="reglistBtn"><input type="submit" value="SIGN IN &amp; CHECKOUT" /><a href="/publish/index.php[@encrypt_url('action=website&method=forgetPassword')]">FORGOT YOUR PASSWORD?</a></li>
						</form>
					</ul>
					<pp:if expr="$cartNum>0">
						<h2>New Customers &amp; Guests</h2>
						<p>
							After Checkout you will have the opportunity
							to register and save your information. In the 
							future you can checkout faster, access your 
							order status and view order history.
						</p>
						<form action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="shop">
							<input type="hidden" name="method" value="releaseOrder">
							<input type="hidden" name="para[cartIDstr]" value="[$cartIDstr_tmp]">
							<input type="hidden" name="para[orderUser]" value="[$tmpUser]">
							<input type="submit" value="CHECKOUT" class="reglistOut" />
						</form>
					</pp:if>
				</div>
			<pp:else/>
				<div class="contentR fl">
					<div class="contentRLeft">
						<form action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="shop">
							<input type="hidden" name="method" value="releaseOrder">
							<input type="hidden" name="para[cartIDstr]" value="[$cartIDstr_tmp]">
							<input type="hidden" name="para[orderUser]" value="[$tmpUser]">
							<dl class="userInfo">
								<dt><a href="index.php[@encrypt_url('action=website&method=account')]">
								<pp:if expr="$userInfo.0.headImageUrl">
								<img src="../web-inf/lib/coreconfig/[$userInfo.0.headImageUrl]" width="50" height="50" align="logo">
								<pp:else/>
								<img src="../skin/images/pic.jpg" width="50" height="50" align="logo">
								</pp:if>
								</a></dt>
								<dd id="welcomeBack">Welcome Back</dd>
								<dd>[$userInfo.0.staffName]</dd>
								<dd id="userEmail"><!--[$userInfo.0.staffNo]--></dd>
							</dl>
							<ul id="userInfoList">
								<pp:var name="formatCartNum" value="str_pad($cartNum,2, '0',STR_PAD_LEFT)"/>
								<pp:var name="formatOrderNum" value="str_pad($OrderQty.data.0.qty,2, '0',STR_PAD_LEFT)"/>
								<pp:var name="formatWishNum" value="str_pad($wishNum,2, '0',STR_PAD_LEFT)"/>
								<li><a href="index.php[@encrypt_url('action=shop&method=myCart')]">Shopping Bag<em>([$formatCartNum])</em></a></li>
								<li><a href="index.php[@encrypt_url('action=account&method=order')]">Order<em>([$formatOrderNum])</em></a></li>
								<!--<li><a href="#">Package<em>(01)</em></a></li>
								<li><a href="#">Status</a></li>-->
								<li><a href="index.php[@encrypt_url('action=account&method=wishlist')]">Wish List<em>([$formatWishNum])</em></a></li>
								<li><a href="index.php[@encrypt_url('action=account&method=information')]">My Profile</a></li>
							</ul>
							<pp:if expr="$cartIDstr_tmp">
								<input type="submit" value="CHECKOUT" class="reglistOut" />
							</pp:if>
						</form>
					</div>

					<!--<div class="memberAccount">
						<h2>Your Member Account</h2>
						<table>
							<tr>
								<td width="86">Balance</td><td width="40">RMB</td><td>100.00</td>
							</tr>
						</table>
						<input type="submit" value="RECHARGE" class="reglistOut" />
						<table>
							<tr>
								<td colspan="2"  width="120">Credits</td><td>10000</td>
							</tr>
						</table>
					</div>-->
				</div>
			</pp:if>
			<pp:var name="SubTotalPrice" value="0"/>	
			<!--
			<pp:if expr="$IN.cartListNum==''">
				<pp:var name="cartListNum" value="5"/>
			<pp:else/>
				<pp:var name="cartListNum" value="$IN.cartListNum"/>
			</pp:if>	
			-->
			<div class="contentCent fl">
				<div class="pageContent fl">
					<h2>YOUR SHOPPING BAG<span>Note: Items and promotional pricing not reserved until checkout is completed</span></h2>
					<h3><!--<a href="index.php[@encrypt_url('action=shop&method=myCart&cartListNum=' . $cartNum)]">View all</a> / <pp:if expr="$cartNum>=$cartListNum">[$cartListNum]<pp:else/>[$cartNum]</pp:if>--><pp:if expr="$cartNum>0"> [$cartNum]</pp:if> <pp:if expr="$cartNum==1">item <pp:elseif expr="$cartNum>1"> items </pp:if> </h3>
					<div class="pageContentTable">
						<table>
							<thead>
								<tr>
									<td>[$cartNum] <pp:if expr="$cartNum<=1">item <pp:elseif expr="$cartNum>1"> items </pp:if>in your bag</td>
									<td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRICE</td><td style="text-align:right" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
								</tr>
							</thead>
							<tbody>
								<loop name="cartList.data" var="var" key="key">   
									
										<tr>
											<td class="bagItem">
												<dl>
													<dt>
													<pp:if expr="$var.goodsType=='inside'">
													    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" />
													<pp:elseif expr="$var.goodsType=='outside'">
													    <img src="[$var.goodsImgURL]" alt="bagImg" />
													</pp:if>
													</dt>
													<!--<dt><img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" /></dt>-->
													<pp:if expr="$var.goodsTitleCN">
													<dd><strong>[$var.goodsTitleCN]</strong></dd>
													</pp:if>
													<pp:if expr="$var.goodsTitleEn">
													<dd><strong>[$var.goodsTitleEn]</strong></dd>
													</pp:if>
													<!--
													<dd>Item: [$cartListNum]</dd>-->
													<dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if><pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
													<pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd>
													</pp:if>
												</dl>
											</td>
											<td><input type="text" value="[$var.ItemQTY]" class="numtextBag" id="itemQTY[$key]" onblur="changeItemQTY(this.value,'[$var.cartID]','[$tmpUser]','New','');"></td>
											<pp:var name="SinglePrice" value="number_format($var.itemPrice, 2, '.', ',')"/>
											<td class="yuanRmb">￥ [$SinglePrice]</td>
											<td class="yuanRmb"><pp:if expr="$var.itemFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.itemFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
											<td class="bagEdit">
												<dl>
													<dd><a href="index.php[@encrypt_url('action=shop&method=editCartItem&goodsID=' . $var.ItemGoodsID . '&cartID=' . $var.cartID)]">Edit Item</a></dd>
													<dd><a href="index.php[@encrypt_url('action=shop&method=DeleteData&cartID=' . $var.cartID)]">Delete</a></dd>
													<dd><a href="index.php[@encrypt_url('action=shop&method=CartToWish&cartID=' . $var.cartID)]">Move to Wish</a></dd>
												</dl>
											</td>
										</tr>
									
									<pp:var name="SubTotalPrice" value="$SubTotalPrice+$var.ItemQTY*$var.itemPrice+$var.itemFreight"/>
								</loop>	
								<pp:var name="SubTotalPrice" value="number_format($SubTotalPrice, 2, '.', ',')"/>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" align="right" style="font-weight:bold" id="cartTotalInfo">Subtotal (<span id="totalItems">[$cartNum] </span>items ):</td><td align="center">￥<span id="subTotalPrice">[$SubTotalPrice]</span></td><td colspan="2" style="font-size:9px; font-weight:bold; text-align:center">( service fee are not included here )</td> 
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="guanggao fr">
					<ul>
						<li><img src="/skin/images/guanggao1.png" alt="guanggao1"></li>
						<li><img src="/skin/images/guanggao2.png" alt="guanggao2"></li>
						<li><img src="/skin/images/guanggao3.jpg" alt="guanggao3"></li>
					</ul>
				</div>
				<div class="viewContent fl">
					<table>
						<thead>
							<tr>
								<td width="264px">THESE ITEMS ARE SAVING IN YOUR WISH LIST</td><td width="50px" valign="bottom">QTY</td><td width="91px" style="text-indent:30px; text-align:center">PRICE</td><td style="text-align:right">FREIGHT</td><td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="5" id="noteBag">Note: Items and promotional pricing not reserved until checkout is completed</td>
							</tr>
						</thead>
						<tbody>
							<cms action="sql" return="WishList" query="SELECT * FROM cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'Wish'" OrderBy="i.publishDate DESC" num="3"/>
							<loop name="WishList.data" var="var" key="key">
								<tr>
									<td class="bagItem">
										<dl>
											<dt>
												<pp:if expr="$var.goodsType=='inside'">
												    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" />
												<pp:elseif expr="$var.goodsType=='outside'">
												    <img src="[$var.goodsImgURL]" alt="bagImg" />
												</pp:if>
											</dt>
											<pp:if expr="$var.goodsTitleCN">
											<dd><strong>[$var.goodsTitleCN]</strong></dd>
											</pp:if>
											<pp:if expr="$var.goodsTitleEn">
											<dd><strong>[$var.goodsTitleEn]</strong></dd>
											</pp:if>
											<!--
											<dd>Item: BGS12_T4CTF</dd>-->
											<dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if><pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
													<pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd>
													</pp:if>
										</dl>
									</td>
									<td><input type="text" value="[$var.ItemQTY]" class="numtextBag"></td>
									<pp:var name="SinglePrice" value="number_format($var.itemPrice, 2, '.', ',')"/>
									<td class="yuanRmb">￥ [$SinglePrice]</td>
									<td class="yuanRmb"><pp:if expr="$var.itemFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.itemFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
									<td class="bagEdit">
										<dl>
											<dd><a href="index.php[@encrypt_url('action=shop&method=editCartItem&goodsID=' . $var.ItemGoodsID . '&cartID=' . $var.cartID)]">Edit Item</a></dd>
											<dd><a href="index.php[@encrypt_url('action=shop&method=DeleteData&cartID=' . $var.cartID)]">Delete</a></dd>
											<dd><a href="index.php[@encrypt_url('action=shop&method=WishToCart&cartID=' . $var.cartID)]">Add to Bag</a></dd>
										</dl>
									</td>
								</tr>
							</loop>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5"><h3 style="height:31px; line-height:40px"><a href="index.php[@encrypt_url('action=account&method=wishlist')]">View all</a> </h3></td> 
							</tr>
						</tfoot>
					</table>
				</div>
				<!--
				<div class="mayLike clb">
					YOU MAY LIKE
				<ul>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
					<li><img src="/skin/images/bagImg.png" alt="bagImg"></li>
				</ul>
				</div>
				-->
			</div>
		</div>
		<!--foot-->
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
	</div>
</body>
</html>