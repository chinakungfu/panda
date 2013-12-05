<?php
import('core.util.RunFunc'); ?><?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "listCartInfo",
	'query' => "SELECT * FROM `cms_publish_cart` WHERE cartID='{$this->_tpl_vars["IN"]["cartID"]}' limit 1",
);

$this->_tpl_vars['listCartInfo'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
<?php $this->_tpl_vars["listCart"]=$this->_tpl_vars["listCartInfo"]["data"]["0"]; ?>
<?php
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "goodsItem",
	'query' => "SELECT * FROM `cms_publish_goods` WHERE goodsid='{$this->_tpl_vars["IN"]["goodsID"]}' limit 1",
);

$this->_tpl_vars['goodsItem'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
<?php $this->_tpl_vars["listGoods"]=$this->_tpl_vars["goodsItem"]["data"]["0"]; ?>

<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	
<style type="text/css">
.clearfix:after{clear:both;content:".";display:block;font-size:0;height:0;line-height:0;visibility:hidden;}
.clearfix{display:block;zoom:1} ul#thumblist{display:block;}
ul#thumblist li{float:left;margin-right:2px;list-style:none;}
ul#thumblist li a{display:block;border:1px solid #CCC;} ul#thumblist li
a.zoomThumbActive{ border:1px solid red; } .jqzoom{
text-decoration:none; float:left; }
</style>
<script type="text/javascript">
	var goodsPrice = <?php echo $this->_tpl_vars["listGoods"]["goodsUnitPrice"];?>;
	var goodsFreight = <?php echo $this->_tpl_vars["listGoods"]["goodsFreight"];?>;
							
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
		if(($("#ItemQTY").val()=='') || ($("#ItemQTY").val()<=0))
		{
			 $("#ItemQTY").val(1);
		}
	
		var totalPrice = $("#ItemQTY").val()*goodsPrice+goodsFreight;
		
		$("#totallPrice").text("￥"+setCurrency(totalPrice));
	}
	</script>

</head>
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
		<div class="content clb">
			<div class="shopLeft fl">
			<?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='inside'){?>
				<div class="imglist">
					<div class="bigImg">
						<div class="bigImgList">
							<img id="goodsImgURL"
								src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL"];?>"
								alt="<?php echo $this->_tpl_vars["titleCN"];?>" />
						</div>
					</div>
					<ul class="smailThum clb">
						<li><div class="goodsImgSmall">
								<span><img id="goodsImgURL"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL1"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL1"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL1"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL2"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL2"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL2"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL3"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL3"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL3"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>
					</ul>
				</div>

				<?php } elseif ($this->_tpl_vars["listGoods"]["goodsType"]=='outside'){ ?>

				<div class="imglist">
					<div class="bigImg">
						<div class="bigImgList">
							<img id="goodsImgURL"
								src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL"];?>"
								alt="<?php echo $this->_tpl_vars["titleCN"];?>" />
						</div>
					</div>
					<ul class="smailThum clb">
						<li><div class="goodsImgSmall">
								<span><img id="goodsImgURL"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL1"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL1"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL1"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL2"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL2"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL2"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>
							<?php if ($this->_tpl_vars["listGoods"]["goodsImgURL3"]){?>
						<li class="smailThumImg"><div class="goodsImgSmall">
								<span><img id="goodsImgURL3"
									onmousemove="$('#goodsImgURL').attr('src',this.src)"
									src="<?php echo $this->_tpl_vars["listGoods"]["goodsImgURL3"];?>"
									alt="<?php echo $this->_tpl_vars["titleCN"];?>"
									style="cursor: pointer"> </span>
							</div></li>
							<?php } ?>

					</ul>
				</div>
				<?php } ?>
			</div>

			<div class="shopRight fl">

			<?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='outside'){?>
				<ul class="smailNav">
					<li class="first">requirement<?php echo $this->_tpl_vars["IN"]["imgQTY"];?>
					</li>
					<li class="smailNavBj">2. service confirm</li>
					<li class="smailNavBj">3. release order</li>
					<li class="smailNavBj">4. customer confirm</li>
					<li class="last">5. pay offer</li>
				</ul>
				<?php } ?>

				<form name="goodsInfo" id="goodsInfo" action="/publish/index.php"
					method="post">
					<input type="hidden" name="action" value="shop">
					<?php if ($this->_tpl_vars["method"]=='goodsDetail'){?>
					<input type="hidden" name="method" value="addWish">
					<?php } elseif ($this->_tpl_vars["method"]=='editCartItem'){ ?>
					<input type="hidden" name="method" value="updateCart"> <input
						type="hidden" name="cartID"
						value="<?php echo $this->_tpl_vars["IN"]["cartID"];?>">
						<?php } elseif ($this->_tpl_vars["method"]=='editOrderItem'){ ?>
					<input type="hidden" name="method" value="updateOrder"> <input
						type="hidden" name="cartID"
						value="<?php echo $this->_tpl_vars["IN"]["cartID"];?>"> <input
						type="hidden" name="orderID"
						value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
						<?php } elseif ($this->_tpl_vars["method"]=='editOrderDetail'){ ?>
					<input type="hidden" name="method" value="updateOrderDetail"> <input
						type="hidden" name="cartID"
						value="<?php echo $this->_tpl_vars["IN"]["cartID"];?>"> <input
						type="hidden" name="orderID"
						value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
						<?php } ?>
					<input type="hidden" name="para[goodsID]"
						value="<?php echo $this->_tpl_vars["IN"]["goodsID"];?>"> <input
						type="hidden" name="para[goodsAddUser]" id="goodsAddUser"
						value="<?php echo $this->_tpl_vars["tmpUser"];?>">
						<?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='outside'){?>
					<ul class="clothesInfo clb">
						<li style="height: 30px;"><label> Name &amp; Description</label> <span
							style="font-size: 13px; color: #494949;"><?php echo $this->_tpl_vars["listGoods"]["goodsTitleCN"];?>
						</span>
						</li>
						<li><label>The link you input</label> <a style="color: #bad782;"
							href="<?php echo $this->_tpl_vars["listGoods"]["goodsURL"];?>"
							target="_blank"> <?php echo  runFunc('g_substr',array($this->_tpl_vars["listGoods"]["goodsURL"],50)) ;?>
						</a>
						</li>


						<li style="height: 30px;" class="pb5"><label>Price (single)</label>
						<?php $this->_tpl_vars["SinglePrice"]=number_format($this->_tpl_vars["listGoods"]["goodsUnitPrice"], 2, '.', ','); ?>
							<span class="clothesPrice_yuan" style="font-size: 12px;">￥</span>
							<span class="clothesPrice"><?php echo $this->_tpl_vars["SinglePrice"];?>
						</span> <input type="hidden" name="para[itemPrice]"
							value="<?php echo $this->_tpl_vars["listGoods"]["goodsUnitPrice"];?>">

						</li>
						<li class="mb12"><label>Seller Freight</label> <span
							class="clothesPrice_Freight">￥<?php $this->_tpl_vars["Freight"]=number_format($this->_tpl_vars["listGoods"]["goodsFreight"], 2, '.', ','); ?>
							<?php echo $this->_tpl_vars["Freight"];?> </span> <input
							type="hidden" name="para[itemFreight]"
							value="<?php echo $this->_tpl_vars["listGoods"]["goodsFreight"];?>">


							<?php
							$prop_strs = $this->_tpl_vars["listGoods"]["props"];
							if($prop_strs!=":"){
								$i = 1;
								$props = explode("|",$prop_strs);

								foreach($props as $prop_group){
									$prop = explode(":",$prop_group);
									$prop_title = $prop[0];
									$prop_str = $prop[1];
									if($prop_str==""){
										continue;
									}
									echo "<li>";

									$prop_vals = explode(";",$prop_str);
									$title = runFunc('translate',array($prop_title));

									echo "<label>".ucfirst($title)."</label>";
									

									echo "<select name='props[]'>";
									foreach($prop_vals as $prop_val){
										if(strlen($prop_val)>1){
											$val = runFunc('translate',array($prop_val));
										}else{
											$val = $prop_val;
										}
										echo "<option value='".$title.":".$val."'>";
										echo 	$val;
										echo "</option>";
									}
									echo "</select>";

									echo "</li>";

								}
							}
							?>
						
						<li style="display: none;" style="height: 105px;"><label>Infomation</label>
							<textarea name="para[goodsNotes]">
							<?php echo $this->_tpl_vars["listCart"]["itemNotes"];?>
							</textarea>
						</li>
						<li><label>SHARE</label>
							<div class="attentionInfo">
								<span class='st_email_large' displayText='Email'></span> 
								<span class='st_facebook_large' displayText='Facebook'></span> 
								<span class='st_twitter_large' displayText='Tweet'></span> 
								<span class='st_linkedin_large' displayText='LinkedIn'></span>
								<span class='st_pinterest_large' displayText='Pinterest'></span>
								<span class='st_googleplus_large' displayText='Google +'></span>
							</div>
						</li>
					</ul>
					<?php } elseif ($this->_tpl_vars["listGoods"]["goodsType"]=='inside'){ ?>
					<?php echo $this->_tpl_vars["listGoods"]["goodsDesc"];?>
					<input name="para[goodsTitleEn]" type="hidden"
						value="<?php echo $this->_tpl_vars["listGoods"]["goodsTitleEn"];?>" />
					<input name="para[itemFreight]" type="hidden"
						value="<?php echo $this->_tpl_vars["listGoods"]["goodsFreight"];?>" />
					<input name="para[itemPrice]" type="hidden"
						value="<?php echo $this->_tpl_vars["listGoods"]["goodsUnitPrice"];?>" />
					<ul class="clothesInfo clb">
						<li><label>SHARE</label>
							<div class="attentionInfo">
							<?php $this->_tpl_vars["siteNmae"]= runFunc('getGlobalModelVar',array('Site_Domain')); ?>
							<?php $this->_tpl_vars["goodsUrl"]=$this->_tpl_vars["siteNmae"] . '/publish/index.php' . runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["IN"]["goodsID"])); ?>
							<?php $this->_tpl_vars["goodsUrl"]=urlencode($this->_tpl_vars["goodsUrl"]); ?>
							<?php $this->_tpl_vars["pid"]=substr($this->_tpl_vars["listGoods"]["goodsImgURL"],12); ?>
							<?php $this->_tpl_vars["image"]=base64_decode($this->_tpl_vars["pid"]); ?>
							<?php $this->_tpl_vars["imageParams"]=explode('|',$this->_tpl_vars["image"]); ?>
							<?php $this->_tpl_vars["PinImageUrl"]=$this->_tpl_vars["siteNmae"] . '/resource' . $this->_tpl_vars["imageParams"]["1"] . $this->_tpl_vars["imageParams"]["2"]; ?>
							<?php $this->_tpl_vars["PinImageUrl"]=urlencode($this->_tpl_vars["PinImageUrl"]); ?>
								<a
									href="http://pinterest.com/pin/create/button/?url=<?php echo $this->_tpl_vars["goodsUrl"];?>&media=<?php echo $this->_tpl_vars["PinImageUrl"];?>&description=<?php echo $this->_tpl_vars["siteNmae"];?>"
									class="pin-it-button" count-layout="horizontal"><img border="0"
									src="//assets.pinterest.com/images/PinExt.png" title="Pin It" />
								</a>
							</div>
						</li>
					</ul>
					<?php } ?>
					<table class="clothesInfoTable clb">

						<tr>
							<th class="title"><?php if ($this->_tpl_vars["listGoods"]["goodsType"]!='inside'){?>Items
								Available<?php } ?></th>
							<th class="num">Quantity</th>
							<th class="select"><?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='inside'){?>Available
								Sizes/Colors<?php } ?></th>
						</tr>
						<tr>
							<td style="color: #B6D97E; font-size: 12px"></td>
							<td><?php if ($this->_tpl_vars["listCart"]["ItemQTY"]){?> <input
								id="ItemQTY" name="para[ItemQTY]" type="text" class="numtext"
								value="<?php echo $this->_tpl_vars["listCart"]["ItemQTY"];?>"
								onfocus="this.value=''" onblur="javascript:changeItemQTY()" /> <?php }else{ ?>
								<input id="ItemQTY" name="para[ItemQTY]" type="text"
								class="numtext" value="1" onfocus="this.value=''"
								onblur="javascript:changeItemQTY()" /> <?php } ?>
							</td>
							<td><?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='inside' and $this->_tpl_vars["listGoods"]["goodsSize"]!=''){?>
							<?php $this->_tpl_vars["sizeArr"]=explode(';',$this->_tpl_vars["listGoods"]["goodsSize"]); ?>
								<select name="para[goodsSize]" size="1" id="select1"
								class="selectinput">
									<option value="">First, Select Size</option>
									<?php if(!empty($this->_tpl_vars['sizeArr'])){
									 foreach ($this->_tpl_vars['sizeArr'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
									<option
									<?php if ($this->_tpl_vars["var"]==$this->_tpl_vars["listCart"]["itemSize"]){?>
										selected="selected" <?php } ?>
										value="<?php echo $this->_tpl_vars["var"];?>">
										<?php echo $this->_tpl_vars["var"];?>
									</option>
									<?php  }
									} ?>
							</select> <?php } ?>
							</td>

						</tr>
						<tr>
							<td class="price"><?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='inside'){?>
								<strong><?php echo $this->_tpl_vars["listGoods"]["goodsTitleEn"];?>
							</strong> <?php } ?> <br />Price (total) <?php if ($this->_tpl_vars["method"]=='goodsDetail'){?>
							<?php $this->_tpl_vars["totalPrice"]=number_format($this->_tpl_vars["listGoods"]["goodsUnitPrice"]+$this->_tpl_vars["listGoods"]["goodsFreight"], 2, '.', ','); ?>
							<?php }else{ ?> <?php $this->_tpl_vars["totalPrice"]=number_format($this->_tpl_vars["listCart"]["ItemQTY"]*$this->_tpl_vars["listGoods"]["goodsUnitPrice"]+$this->_tpl_vars["listGoods"]["goodsFreight"], 2, '.', ','); ?>
							<?php } ?> <span id="totallPrice">￥<?php echo $this->_tpl_vars["totalPrice"];?>
							</span><br />
							</td>
							<td>&nbsp;</td>
							<td valign="top"><?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='inside' and $this->_tpl_vars["listGoods"]["goodsColor"]!=''){?>
							<?php $this->_tpl_vars["colorArr"]=explode(';',$this->_tpl_vars["listGoods"]["goodsColor"]); ?>
								<select name="para[goodsColor]" size="1" id="select1"
								class="selectinput">
									<option value="">Then, Select Color</option>
									<?php if(!empty($this->_tpl_vars['colorArr'])){
										foreach ($this->_tpl_vars['colorArr'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
									<option
									<?php if ($this->_tpl_vars["var"]==$this->_tpl_vars["listCart"]["itemColor"]){?>
										selected="selected" <?php } ?>
										value="<?php echo $this->_tpl_vars["var"];?>">
										<?php echo $this->_tpl_vars["var"];?>
									</option>
									<?php  }
									} ?>
							</select> <?php } ?>
							</td>
						</tr>
					</table>
					<?php if ($this->_tpl_vars["method"]=='goodsDetail'){?>
					<ul>
						<li class="addtowishlist fl"><a href="javascript:addWish(0);">1</a>
						</li>
						<li class="addtoshoppingbag fr" id="addShoppingBag"><a href="#"
							onclick="addShoppingBag(1);loadCart1();">2</a></li>
					</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editCartItem'){ ?>
					<ul>
						<li class="fr"><a href="javascript:updateCart(0);"><img
								src="../skin/images/updateMyBag.jpg" /> </a></li>
					</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editOrderItem'){ ?>
					<ul>
						<li class="fr"><a href="javascript:updateCart(0);"><img
								src="../skin/images/updateMyBag.jpg" /> </a></li>
					</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editOrderDetail'){ ?>
					<ul>
						<li class="fr"><a href="javascript:updateCart(0);"><img
								src="../skin/images/updateMyBag.jpg" /> </a></li>
					</ul>
					<?php } ?>
					<?php if ($this->_tpl_vars["listGoods"]["goodsType"]=='outside'){?>
					<?php } ?>
				</form>
			</div>
		</div>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>


	</div>
</body>
</html>
