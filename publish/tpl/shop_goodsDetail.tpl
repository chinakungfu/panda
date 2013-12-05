<cms action="sql" return="listCartInfo" query="SELECT * FROM `cms_publish_cart` WHERE cartID='{$IN.cartID}' limit 1"  />
<pp:var name="listCart" value="$listCartInfo.data.0"/>
<cms action="sql" return="goodsItem" query="SELECT * FROM `cms_publish_goods` WHERE goodsid='{$IN.goodsID}' limit 1"  />
<pp:var name="listGoods" value="$goodsItem.data.0"/>

<!DOCTYPE HTML>
<html>
<head>	
	<pp:include file="common/header/common_header.tpl" type="tpl"/>
	<style type"text/css">
	.clearfix:after{clear:both;content:".";display:block;font-size:0;height:0;line-height:0;visibility:hidden;}
	.clearfix{display:block;zoom:1}
	ul#thumblist{display:block;}
	ul#thumblist li{float:left;margin-right:2px;list-style:none;}
	ul#thumblist li a{display:block;border:1px solid #CCC;}
	ul#thumblist li a.zoomThumbActive{
	    border:1px solid red;
	}
	.jqzoom{
		text-decoration:none;
		float:left;
	}
	</style>
	<script type="text/javascript">
	var goodsPrice = [$listGoods.goodsUnitPrice];
	var goodsFreight = [$listGoods.goodsFreight];
							
	$(document).ready(function() {
		$('.jqzoom').jqzoom({
	            zoomType: 'standard',
	            lens:true,
	            preloadImages: false,
	            alwaysOn:false
	        });
		
	});
	
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
	function changeItemQTY()
	{
		if($("#ItemQTY").val()=='')
		{
			$("#ItemQTY").val(1);
		}
		var totalPrice = $("#ItemQTY").val()*goodsPrice+goodsFreight;
		$("#totalPrice").html("￥"+setCurrency(totalPrice));
	}
	</script>
</head>
<body>

	<!--最外框-->
	<div class="box">
		<!--头部-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>	
		<!--content info-->
		<div class="content clb">
			<!--<h2>See Our <span>Lela Rose</span> Collection</h2>-->
			<!--shopLeft-->
			<div class="shopLeft fl">
				<!--imglist-->
				
				<!--四张全部保存
				<div class="imglist">
					<div class="bigImg">
						<div class="bigImgList">
							<img id="goodsImgURL" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" />
						</div>				
					</div>					
					<ul class="smailThum clb">						
						<li><img id="goodsImgURL" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>			
						<pp:if expr="$listGoods.goodsImgURL1">
						<li class="smailThumImg"><img id="goodsImgURL1" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL1]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
						</if>
						<pp:if expr="$listGoods.goodsImgURL2">					
						<li class="smailThumImg"><img id="goodsImgURL2" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL2]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
						</if>
						<pp:if expr="$listGoods.goodsImgURL3">					
						<li class="smailThumImg"><img id="goodsImgURL3" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL3]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
						</if>   
					
					</ul>
				</div>-->
				<!--
				<div class="imglist">
					<div class="bigImg">
						<div class="bigImgList">
						<pp:if expr="$IN.imgQTY==0">						
							<img id="goodsImgURL" src="[$listGoods.goodsImgURL]" alt="[$titleCN]" />
						<pp:else/>
							<img id="goodsImgURL" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" />
						</pp:if>
						</div>				
					</div>					
					<ul class="smailThum clb">
						<pp:if expr="$IN.imgQTY<1">
							<li><img id="goodsImgURL" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>	
						<pp:else/>
							<li><img id="goodsImgURL" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
						</pp:if>

						<pp:if expr="$listGoods.goodsImgURL1">
							<pp:if expr="$IN.imgQTY<2">
								<li class="smailThumImg"><img id="goodsImgURL1" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL1]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							<pp:else/>
								<li class="smailThumImg"><img id="goodsImgURL1" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL1]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</pp:if>
						</if>
						<pp:if expr="$listGoods.goodsImgURL2">					
							<pp:if expr="$IN.imgQTY<3">
								<li class="smailThumImg"><img id="goodsImgURL2" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL2]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							<pp:else/>
								<li class="smailThumImg"><img id="goodsImgURL2" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL2]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</pp:if>
						</if>
						<pp:if expr="$listGoods.goodsImgURL3">					
							<pp:if expr="$IN.imgQTY<4">
								<li class="smailThumImg"><img id="goodsImgURL3" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL3]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							<pp:else/>
								<li class="smailThumImg"><img id="goodsImgURL3" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL3]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</pp:if>
						</if>   
					
					</ul>
				</div>	
				-->
				<pp:if expr="$listGoods.goodsType=='inside'">
					<div class="imglist">
						<div class="bigImg">
							<div class="bigImgList">
								<img id="goodsImgURL" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" />
							</div>				
						</div>					
						<ul class="smailThum clb">						
							<li><img id="goodsImgURL" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>			
							<pp:if expr="$listGoods.goodsImgURL1">
							<li class="smailThumImg"><img id="goodsImgURL1" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL1]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>
							<pp:if expr="$listGoods.goodsImgURL2">					
							<li class="smailThumImg"><img id="goodsImgURL2" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL2]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>
							<pp:if expr="$listGoods.goodsImgURL3">					
							<li class="smailThumImg"><img id="goodsImgURL3" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="../web-inf/lib/coreconfig/[$listGoods.goodsImgURL3]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>   
						
						</ul>
					</div>
				<pp:elseif expr="$listGoods.goodsType=='outside'">
					<div class="imglist">
						<div class="bigImg">
							<div class="bigImgList">
								<img id="goodsImgURL" src="[$listGoods.goodsImgURL]" alt="[$titleCN]" />
							</div>				
						</div>					
						<ul class="smailThum clb">						
							<li><img id="goodsImgURL" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>			
							<pp:if expr="$listGoods.goodsImgURL1">
							<li class="smailThumImg"><img id="goodsImgURL1" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL1]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>
							<pp:if expr="$listGoods.goodsImgURL2">					
							<li class="smailThumImg"><img id="goodsImgURL2" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL2]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>
							<pp:if expr="$listGoods.goodsImgURL3">					
							<li class="smailThumImg"><img id="goodsImgURL3" onmousemove="$('#goodsImgURL').attr('src',this.src)" src="[$listGoods.goodsImgURL3]" alt="[$titleCN]" width="73" height="91" style="cursor:pointer"></li>
							</if>   
						
						</ul>
					</div>
				</if>
				
			</div>
			<!--shopRight-->
			<div class="shopRight fl">
				<!--smailNav-->
				<pp:if expr="$listGoods.goodsType=='outside'">
				<ul class="smailNav">
					<li class="first">requirement[$IN.imgQTY]</li>
					<li class="smailNavBj">2. service confirm</li>
					<li class="smailNavBj">3. release order</li>
					<li class="smailNavBj">4. customer confirm</li>
					<li class="last">5. pay offer</li>
				</ul>
				</pp:if>
				<!--clothesInfo-->
				<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="shop">
					<pp:if expr="$method=='goodsDetail'">
						<input type="hidden" name="method" value="addWish">
					<pp:elseif expr="$method=='editCartItem'">
						<input type="hidden" name="method" value="updateCart">
						<input type="hidden" name="cartID" value="[$IN.cartID]">
					<pp:elseif expr="$method=='editOrderItem'">
						<input type="hidden" name="method" value="updateOrder">
						<input type="hidden" name="cartID" value="[$IN.cartID]">
						<input type="hidden" name="orderID" value="[$IN.orderID]">
					<pp:elseif expr="$method=='editOrderDetail'">
						<input type="hidden" name="method" value="updateOrderDetail">
						<input type="hidden" name="cartID" value="[$IN.cartID]">
						<input type="hidden" name="orderID" value="[$IN.orderID]">
					</pp:if>			
					<input type="hidden" name="para[goodsID]" value="[$IN.goodsID]">			
					<input type="hidden" name="para[goodsAddUser]" id="goodsAddUser" value="[$tmpUser]">

					<pp:if expr="$listGoods.goodsType=='outside'">
						<ul class="clothesInfo clb">
							<li>
								<label>The link you input</label>
								<input readonly name="para[goodsURL]" type="text" class="text1" value="[$listGoods.goodsURL]"/><span class="more"><a href="[$listGoods.goodsURL]" target="_blank">More details</a></span>
								<span class="text1Span">Succeed to grab the page you want to buy, please fill the form bellow</span>
							</li>
							<li>
								<label> Name  &amp; Description</label>
								<input readonly name="para[goodsTitleCn]" type="text" class="text2" value="[$listGoods.goodsTitleCN]"/><br />
								<pp:if expr="$listGoods.goodsTitleEn">
									<input  name="para[goodsTitleEn]" type="text" class="text4" value="[$listGoods.goodsTitleEn]"/>
								<pp:else/>
									<input  name="para[goodsTitleEn]" type="text" class="text4" value="Input the English name here if you can" onfocus="this.value=''" onblur="javascript:if(this.value==''){this.value='Input the English name here if you can'}"/>
									
								</pp:if>
							</li>
							<li class="pb5">
								<label>Price (single)</label>
								<pp:var name="SinglePrice" value="number_format($listGoods.goodsUnitPrice, 2, '.', ',')"/>
								<input readonly  type="text" class="text3" value="[$SinglePrice]"/>
								<input type="hidden" name="para[itemPrice]" value="[$listGoods.goodsUnitPrice]">
								<span class="rmb">RMB</span>
							</li>
							<li class="mb12">
								<label>Freight</label>
								<pp:var name="Freight" value="number_format($listGoods.goodsFreight, 2, '.', ',')"/>
								<input readonly  type="text" class="text3" value="[$Freight]"/>
								<input type="hidden" name="para[itemFreight]" value="[$listGoods.goodsFreight]">
								<span class="rmb">RMB</span>
							</li>
							<li>
								<label>Infomation</label>
								<pp:if expr="$listCart.itemNotes">
									<textarea name="para[goodsNotes]">[$listCart.itemNotes]</textarea></li> 
								<pp:else/>
									<textarea name="para[goodsNotes]" onfocus="this.value=''" onblur="javascript:if(this.value==''){this.value='Please input Color, Size here......'}">Please input Color, Size here......</textarea></li> 
									
								</pp:if>
							</li>
							<li>
								<label>SHARE</label>
								<div class="attentionInfo">
									<!--<span class="email"><a href="#">app</a></span>
									<span class="facebook"><a href="#">app</a></span>
									<span class="sns"><a href="#">app</a></span>
									<span class="google"><a href="#">app</a></span>-->

									<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
									<pp:var name="goodsUrl" value="$siteNmae . '/publish/index.php' . @encrypt_url('action=shop&method=goodsDetail&goodsID=' . $IN.goodsID)" />
									
									<pp:var name="goodsUrl" value="urlencode($goodsUrl)"/>
									
									<pp:var name="PinImageUrl" value="urlencode($listGoods.goodsImgURL)"/>
									<a href="http://pinterest.com/pin/create/button/?url=[$goodsUrl]&media=[$PinImageUrl]&description=[$siteNmae]" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
								</div> 
							</li>
						</ul>
					<pp:elseif expr="$listGoods.goodsType=='inside'">							
							
						[$listGoods.goodsDesc]
						<!--<input name="para[goodsTitleCn]" type="hidden" value="[$listGoods.goodsTitleCN]"/>-->
						<input name="para[goodsTitleEn]" type="hidden" value="[$listGoods.goodsTitleEn]"/>
						<input name="para[itemFreight]" type="hidden" value="[$listGoods.goodsFreight]"/>
						<input name="para[itemPrice]" type="hidden" value="[$listGoods.goodsUnitPrice]"/>
						<ul class="clothesInfo clb">
							<li>
								<label>SHARE</label>
								<div class="attentionInfo">
									<!--<span class="email"><a href="#">app</a></span>
									<span class="facebook"><a href="#">app</a></span>
									<span class="sns"><a href="#">app</a></span>
									<span class="google"><a href="#">app</a></span>-->
									<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
									<pp:var name="goodsUrl" value="$siteNmae . '/publish/index.php' . @encrypt_url('action=shop&method=goodsDetail&goodsID=' . $IN.goodsID)" />
									
									<pp:var name="goodsUrl" value="urlencode($goodsUrl)"/>
									<pp:var name="pid" value="substr($listGoods.goodsImgURL,12)" />
									<pp:var name="image" value="base64_decode($pid)"/>
									<pp:var name="imageParams" value="explode('|',$image)"/>
									<pp:var name="PinImageUrl" value="$siteNmae . '/resource' . $imageParams.1 . $imageParams.2"/>
									
									<pp:var name="PinImageUrl" value="urlencode($PinImageUrl)"/>
									<a href="http://pinterest.com/pin/create/button/?url=[$goodsUrl]&media=[$PinImageUrl]&description=[$siteNmae]" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
								</div> 
							</li>
						</ul>
						</pp:if>

					<!--clothesform-->
					
					<table class="clothesInfoTable clb">
						<tr>
						
							<th class="title"><pp:if expr="$listGoods.goodsType=='inside'">Items Available</pp:if></th>
							<th class="num">Quantity</th>
							<th class="select"><pp:if expr="$listGoods.goodsType=='inside'">Available Sizes/Colors</pp:if></th>
						</tr>
						<tr>
							<td style="color:#B6D97E; font-size:12px"><!--<pp:if expr="$listGoods.goodsType=='inside'">Items Available</pp:if>--></td>
							<td>
								<pp:if expr="$listCart.ItemQTY">
									<input id="ItemQTY" name="para[ItemQTY]" type="text" class="numtext" value="[$listCart.ItemQTY]" onfocus="this.value=''" onblur="javascript:changeItemQTY()"/>
								<pp:else/>
									<input id="ItemQTY" name="para[ItemQTY]" type="text" class="numtext" value="1" onfocus="this.value=''" onblur="javascript:changeItemQTY()"/>
								</pp:if>
							</td>
							<td>
								<pp:if expr="$listGoods.goodsType=='inside' and $listGoods.goodsSize!=''">
								<pp:var name="sizeArr" value="explode(';',$listGoods.goodsSize)"/>
								<select name="para[goodsSize]" size="1" id="select1" class="selectinput"> 
									<option value="">First, Select Size</option>
									<loop name="sizeArr" var="var" key="key">
										<option <pp:if expr="$var==$listCart.itemSize"> selected="selected" </pp:if>value="[$var]">[$var]</option>
									</loop>
								</select>
								</pp:if>
							</td>
						
						</tr>
						<tr>
							<td class="price">
								<pp:if expr="$listGoods.goodsType=='inside'">							
									<strong>[$listGoods.goodsTitleEn]</strong>
								</pp:if>
								<br />Price (total)
								<pp:if expr="$method=='goodsDetail'">								 
									<pp:var name="totalPrice" value="number_format($listGoods.goodsUnitPrice+$listGoods.goodsFreight, 2, '.', ',')"/>
								<pp:else/>
									<pp:var name="totalPrice" value="number_format($listCart.ItemQTY*$listGoods.goodsUnitPrice+$listGoods.goodsFreight, 2, '.', ',')"/>	
								</pp:if>
								<span id="totallPrice">￥[$totalPrice]</span><br />
								
								<!--<span style="color:#76746F; margin-left:0">BGS12_B1LLD</span>-->
							</td>
							<td>&nbsp;</td>
							<td valign="top">
								<pp:if expr="$listGoods.goodsType=='inside' and $listGoods.goodsColor!=''">
									<pp:var name="colorArr" value="explode(';',$listGoods.goodsColor)"/>
									<select name="para[goodsColor]" size="1" id="select1" class="selectinput">
										<option value="">Then, Select Color</option>
										<loop name="colorArr" var="var" key="key">
											<option <pp:if expr="$var==$listCart.itemColor"> selected="selected" </pp:if> value="[$var]">[$var]</option>
										</loop>
									</select>
								</pp:if>
							</td>    
						</tr>         
					</table>

					<!--addtowishlist-->
					<pp:if expr="$method=='goodsDetail'">
						<ul>
							<li class="addtowishlist fl"><a href="javascript:addWish(0);">1</a></li>
							<li class="addtoshoppingbag fr" id="addShoppingBag"><a href="#" onclick="addShoppingBag(1);loadCart1();">2</a></li>
						</ul>
					<pp:elseif expr="$method=='editCartItem'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<pp:elseif expr="$method=='editOrderItem'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<pp:elseif expr="$method=='editOrderDetail'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					</pp:if>

					<!--help-->
					<div class="helpRight">
						<div class="help">
							<h2>Need Help?</h2>
							<p>Call 400 823 823<br />E-mail Us<br />Online Chat<br />Shipping Information<br />Return Policy</p>
						</div>
					</div>
					<!--
					<div class="error">
					Grab failed,may be the link is wrong. Just tell us what you need.<br /><a href="#" class="link">CLICK HERE</a> we will find for you
					<a href="#" class="errorClose fr">close</a>
					</div>
					-->
					<pp:if expr="$listGoods.goodsType=='outside'">
					<div class="rmbI">
						<p>One seller only charge freight once per order usually,<br />
						sometimes customer service will contact you when <br />
						freight needs to be modified according to some <br />
						special issues like package overweight etc<br />
						</p>
					</div>
					</pp:if>
				</form>
			</div>
		</div>

		<!--foot-->
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>

	</div>
</body>
</html>