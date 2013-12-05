<?php import('core.util.RunFunc'); ?>
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

<script type="text/javascript">
	$(function(){
		//$("#submit_form").submit();	
	});
		
	function changeItemQTY(value,cartId,userId,cartType,cartIdStr)
	{
		call_tpl('shop','changeItemQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,'');
	}
	function backDataItemQTY(response)
	{
		var responseArr = response.split("-");
		var subTotalPriceObj = document.getElementById("subTotalPrice");
		var subTotalPrice1Obj = document.getElementById("subTotalPrice1");
		var totalItemsObj = document.getElementById("totalItems");

		var wowDeliveryObj = document.getElementById("wowDelivery");
		var serviceFreeObj = document.getElementById("serviceFree");
		var totalPriceObj = document.getElementById("totalPrice");

		//totalItemsObj.innerHTML =responseArr[0];
		subTotalPriceObj.innerHTML = setCurrency(responseArr[1]);
		subTotalPrice1Obj.innerHTML = setCurrency(responseArr[1]);
		var serviceFree = parseInt(responseArr[1])*0.1;
		if(serviceFree<20)
		{
			serviceFree = 20;
		}
		serviceFreeObj.innerHTML = setCurrency(serviceFree);
		if(wowDeliveryObj==null)
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(serviceFree));
		}else
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(wowDeliveryObj.innerHTML)+parseFloat(serviceFree));
		}
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

	<div class="box">

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "orderInfo",
	'query' => "SELECT * FROM cms_publish_order WHERE  orderID='{$this->_tpl_vars["IN"]["orderID"]}' limit 1",
	);
	$this->_tpl_vars['orderInfo'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
	<?php $this->_tpl_vars["orderDetail"]=$this->_tpl_vars["orderInfo"]["data"]["0"]; ?>
	<?php if ($this->_tpl_vars["orderDetail"]=='-1'){?>
	<?php } ?>
		<div class="contentCentSubmit">
			<div class="subMitBelow">
				<h2>
					Please confirm the order list below: <span>Orderlist<em>No:<?php echo $this->_tpl_vars["orderDetail"]["OrderNo"];?>
					</em> </span>
				</h2>
			</div>
			<?php
			import('core.apprun.cmsware.CmswareNode');
			import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			$params = array (
				'action' => "sql",
				'return' => "orderList",
				'query' => "SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.cartID in ({$this->_tpl_vars["orderDetail"]["cartIDstr"]}) Order By a.cartid DESC",
			);
			$this->_tpl_vars['orderList'] = CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;?>
			<?php $this->_tpl_vars["goodsNum"]=sizeof($this->_tpl_vars["orderList"]["data"]); ?>

			<div class="pageContentSubmit fl">


			<?php $this->_tpl_vars["SubTotalPrice"]=0; ?>
			<?php if ($this->_tpl_vars["orderDetail"]["serviceName"]=='1'){?>
			<?php $this->_tpl_vars["serviceStr"]='WOW Express'; ?>
			<?php } elseif ($this->_tpl_vars["orderDetail"]["serviceName"]=='2'){ ?>
			<?php $this->_tpl_vars["serviceStr"]='WOW Collect&go'; ?>
			<?php } elseif ($this->_tpl_vars["orderDetail"]["serviceName"]=='3'){ ?>
			<?php $this->_tpl_vars["serviceStr"]='WOW Premium Service'; ?>
			<?php } ?>
				<h2>
					YOUR SHOPPING BAG<span>You are choosing <em><?php echo $this->_tpl_vars["serviceStr"];?>
					</em> </span>
				</h2>
				<h3>
				<?php echo $this->_tpl_vars["goodsNum"];?>
				<?php if ($this->_tpl_vars["goodsNum"]==1){?>
					item
					<?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?>
					items
					<?php } ?>
				</h3>
				<table>
					<thead>
						<tr>
							<td><?php echo $this->_tpl_vars["goodsNum"];?> <?php if ($this->_tpl_vars["goodsNum"]==1){?>item
							<?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?> items <?php } ?>
								in your bag</td>
							<td width="75px" align="center">QTY</td>
							<td width="75px" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRICE</td>
							<td style="text-align: center" width="75px">FREIGHT</td>
							<td width="100px">&nbsp;</td>
						</tr>
					</thead>
					<tbody>
					<?php if(!empty($this->_tpl_vars["orderList"]["data"])){
						foreach ($this->_tpl_vars["orderList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
						<tr>
							<td class="bagItem">
								<dl>
									<dt>
									<?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?>
										<img
											src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>"
											alt="bagImg" />
											<?php } elseif ($this->_tpl_vars["var"]["goodsType"]=='outside'){ ?>
										<img
											src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>"
											alt="bagImg" />
											<?php } ?>
									</dt>
									<?php if ($this->_tpl_vars["var"]["goodsTitleCN"]){?>
									<dd>
										<strong><?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?>
										</strong>
									</dd>
									<?php } ?>
									<?php if ($this->_tpl_vars["var"]["goodsTitleEn"]){?>
									<dd>
										<strong><?php echo $this->_tpl_vars["var"]["goodsTitleEn"];?>
										</strong>
									</dd>
									<?php } ?>

									<dd>
									<?php if ($this->_tpl_vars["var"]["itemSize"]){?>
										Size: 
										<?php echo $this->_tpl_vars["var"]["itemSize"];?>
										<?php } ?>
										<?php if ($this->_tpl_vars["var"]["itemColor"]){?>
										<span class="pageContentColor">Color:<?php echo $this->_tpl_vars["var"]["itemColor"];?>
										</span>
										<?php } ?>
									</dd>

								</dl>
							</td>
							<td><input type="text"
								value="<?php echo $this->_tpl_vars["var"]["ItemQTY"];?>"
								class="numtextBag"
								id="itemQTY<?php echo $this->_tpl_vars["key"];?>"
								onblur="changeItemQTY(this.value,'<?php echo $this->_tpl_vars["var"]["cartID"];?>','<?php echo $this->_tpl_vars["tmpUser"];?>','Order','<?php echo $this->_tpl_vars["orderDetail"]["cartIDstr"];?>');">
							</td>
							<?php $this->_tpl_vars["subItemPrice"]=number_format($this->_tpl_vars["var"]["itemPrice"], 2, '.', ','); ?>
							<td align="center">￥ <?php echo $this->_tpl_vars["subItemPrice"];?>
							</td>
							<td align="center"><?php if ($this->_tpl_vars["var"]["itemFreight"]<=0){?>NO<?php }else{ ?>
							<?php $this->_tpl_vars["Freight"]=number_format($this->_tpl_vars["var"]["itemFreight"], 2, '.', ','); ?>
							<?php echo $this->_tpl_vars["Freight"];?> <?php } ?></td>
							<td class="bagEdit">
								<dl>
									<dd>
										<a
											href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=editOrderItem&goodsID=' . $this->_tpl_vars["var"]["ItemGoodsID"] . '&cartID=' . $this->_tpl_vars["var"]["cartID"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"]));?>">Edit
											Item</a>
									</dd>
									<dd>
									<?php if ($this->_tpl_vars["goodsNum"]>'1'){?>
										<a
											href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=delOrder&cartID=' . $this->_tpl_vars["var"]["cartID"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"] . '&cartIDString=' . $this->_tpl_vars["orderDetail"]["cartIDstr"]));?>">Delete</a>
											<?php } elseif ($this->_tpl_vars["goodsNum"]=='1'){ ?>
										<a
											href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=cancelOrder&cancelType=del&cartID=' . $this->_tpl_vars["var"]["cartID"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"]));?>">Delete</a>
											<?php } ?>
									</dd>
									<dd>
									<?php if ($this->_tpl_vars["goodsNum"]>'1'){?>
										<a
											href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=OrderToWish&cartID=' . $this->_tpl_vars["var"]["cartID"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"] . '&cartIDString=' . $this->_tpl_vars["orderDetail"]["cartIDstr"]));?>">Move
											to Wish</a>
											<?php } elseif ($this->_tpl_vars["goodsNum"]=='1'){ ?>
										<a
											href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=cancelOrder&cancelType=move&cartID=' . $this->_tpl_vars["var"]["cartID"] . '&orderID=' . $this->_tpl_vars["IN"]["orderID"]));?>">Move
											to Wish</a>
											<?php } ?>
								
								</dl>
							</td>
						</tr>

						<?php $this->_tpl_vars["SubTotalPrice"]=$this->_tpl_vars["SubTotalPrice"]+$this->_tpl_vars["var"]["ItemQTY"]*$this->_tpl_vars["var"]["itemPrice"]+$this->_tpl_vars["var"]["itemFreight"]; ?>


						<?php  }
					} ?>
					<?php $this->_tpl_vars["tempSubTotalPrice"]=$this->_tpl_vars["SubTotalPrice"]; ?>
					<?php $this->_tpl_vars["SubTotalPriceF"]=number_format($this->_tpl_vars["SubTotalPrice"], 2, '.', ','); ?>
					</tbody>

					<tfoot>
						<tr>
							<td colspan="2" align="right" style="font-weight: bold">Subtotal
								(<span id="totalItems"><?php echo $this->_tpl_vars["goodsNum"];?>
							</span> <?php if ($this->_tpl_vars["goodsNum"]==1){?>item <?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?>
								items <?php } ?> ):</td>
							<td align="center">￥<span id="subTotalPrice"><?php echo $this->_tpl_vars["SubTotalPriceF"];?>
							</span></td>
							<td colspan="2"
								style="font-size: 9px; font-weight: bold; text-align: center">(
								service fee are not included here )</td>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="subMitRight fr">
			<?php $this->_tpl_vars["AddressNodeId"]=runFunc('getGlobalModelVar',array('AddressNode')); ?>
			<?php $this->_tpl_vars["AddressNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["AddressNodeId"])); ?>
			<?php
			import('core.apprun.cmsware.CmswareNode');
			import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			$params = array (
				'action' => "content",
				'return' => "addressDetail",
				'nodeid' => "{$this->_tpl_vars["AddressNode"]["0"]["nodeGuid"]}",
				'contentid' => "{$this->_tpl_vars["orderDetail"]["orderAddress"]}",
			);

			$this->_tpl_vars['addressDetail'] = CMS::CMS_content($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;
			?>
				<table class="subMitNameInfo">
					<tr>
						<td width="55">Name:</td>
						<td><?php echo $this->_tpl_vars["addressDetail"]["fullName"];?></td>
					</tr>
					<tr>
						<td style="vertical-align: top">Address:</td>
						<td style="padding-bottom: 5px; vertical-align: top"><?php echo $this->_tpl_vars["addressDetail"]["address1"];?>
							<br> <?php echo $this->_tpl_vars["addressDetail"]["address2"];?><br />
							<?php echo $this->_tpl_vars["addressDetail"]["city"];?>, <?php echo $this->_tpl_vars["addressDetail"]["province"];?>&nbsp;&nbsp;<?php echo $this->_tpl_vars["addressDetail"]["zipcode"];?><br>
							<?php echo $this->_tpl_vars["addressDetail"]["country"];?><br />
							Phone: <?php echo $this->_tpl_vars["addressDetail"]["cellphone"];?>
						</td>
					</tr>
					<tr>
						<td style="padding-bottom: 45px;">Email:</td>
						<td valign="top"><?php if ($this->_tpl_vars["name"]){?> <?php echo $this->_tpl_vars["userInfo"]["0"]["staffNo"];?>
						<?php }else{ ?> <?php echo $this->_tpl_vars["addressDetail"]["email"];?>
						<?php } ?>
						</td>
					</tr>
				</table>

				<table class="subMitNameSubTotal">
					<tr>
						<td style="padding-bottom: 45px;" width="133">Subtotal (<?php echo $this->_tpl_vars["goodsNum"];?>
						<?php if ($this->_tpl_vars["goodsNum"]==1){?>item <?php } elseif ($this->_tpl_vars["goodsNum"]>1){ ?>
							items <?php } ?> ):</td>
						<td valign="top" width="133" align="right">￥<span
							id="subTotalPrice1"><?php echo $this->_tpl_vars["SubTotalPriceF"];?>
						</span></td>
					</tr>
				</table>



				<table class="subMitNameSubTotal">
					<tr>
						<td>Delivery and Processing</td>
						<td></td>
					</tr>
				</table>


				<table class="subMitNameSubTotal">
				<?php if ($this->_tpl_vars["serviceFee"]*0.1<20){?>
				<?php $this->_tpl_vars["serviceFee"]=20; ?>
				<?php }else{ ?>
				<?php $this->_tpl_vars["serviceFee"]=$this->_tpl_vars["SubTotalPrice"]*0.1; ?>
				<?php } ?>
				<?php $this->_tpl_vars["serviceFee"]=number_format($this->_tpl_vars["serviceFee"], 2, '.', ','); ?>
					<tr>
						<td width="133">Service Fee:</td>
						<td width="133" align="right">￥<span id="serviceFree"><?php echo $this->_tpl_vars["serviceFee"];?>
						</span></td>
					</tr>
					<tr>
						<td style="padding-bottom: 23px;" colspan="2"
							class="subMitNameInfoText"></td>
					</tr>
					<tr>
						<td colspan="2" style="padding-bottom: 12px;"
							class="subMitNameInfoText"></td>
					</tr>
				</table>

				<table class="subMitNameSubTotal" style="border-bottom: 0 none">
					<tr>
						<td width="133" style="padding-bottom: 23px;">TOTAL</td>
						<td width="133" align="right" valign="top">￥<span id="totalPrice"><?php echo $this->_tpl_vars["totalCharge"];?>
						</span></td>
					</tr>
				</table>
				<form id="submit_form" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="shop"> <input
						type="hidden" name="method" value="submitOrder"> <input
						type="hidden" name="orderID"
						value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
					<div style="height: 22px">
						<input type="submit" value="SUBMIT" class="contInueChose fr"
							style="margin-top: -10px; margin-right: 12px;" />
					</div>
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
<script type="text/javascript">
var subTotalPrice = '<?php echo $this->_tpl_vars["tempSubTotalPrice"];?>';
var wowDeliveryObj = document.getElementById("wowDelivery");
var serviceFreeObj = document.getElementById("serviceFree");
var totalPriceObj = document.getElementById("totalPrice");
var totlaPrice = 0.00;
if(wowDeliveryObj==null)
{
	totlaPrice= parseFloat(subTotalPrice)+parseFloat(serviceFreeObj.innerHTML);
}else
{
	totlaPrice= parseFloat(subTotalPrice)+parseFloat(wowDeliveryObj.innerHTML)+parseFloat(serviceFreeObj.innerHTML);
}
totalPriceObj.innerHTML = setCurrency(totlaPrice);
</script>
</html>
