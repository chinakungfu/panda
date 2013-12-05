<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array());
$this->_tpl_vars["method"]="orderSubmit";
?>
<?php if ($this->_tpl_vars["name"]){?>
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


//**********address**********
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
$params = array (
	'action' => "sql",
	'return' => "addressInfos",
	'query' => "SELECT * FROM cms_publish_address WHERE  addressId='{$this->_tpl_vars['orderInfo']["data"]["0"]["orderAddress"]}' limit 1",
);
$this->_tpl_vars['addressInfos'] = CMS::CMS_sql($params);
$this->_tpl_vars['PageInfo'] = &$PageInfo;

?>
<?php $this->_tpl_vars["orderDetail"]=$this->_tpl_vars["orderInfo"]["data"]["0"]; ?>
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
		$(".order_view").click(function(){
			$(".pageContentSubmit").toggle();
		});

		$(".numQTY").blur(function(){
			var num =$(this).val();
			if(isNaN(num)){
				num=1;
				$(this).val(num);
			}else{
				if(!isNum(num) || num < 1){
					num=1;
					$(this).val(num);
				}
			}
			var initnum = Number($(this).parent().parent().children().children("#total_price").text());
			var total = Number($(this).parent().parent().children("#publish_price").text()) * num;
			var updatetotal = number_format(total,2,'.',',');
			$(this).parent().parent().children().children("#total_price").text(updatetotal);

		});

	});
	function changeOrderQTY(o,value,cartId,userId,cartType,cartIdStr,orderId)
	{
		if(isNaN(value)){
			alert("Please enter the Numbers");
			value=1;
			$(o).val(value);
		}else{
			if(!isNum(value) || value < 1){
				value=1;
				$(o).val(value);
				alert("Please enter whole number");
			}
		}
		call_tpl('shop','changeOrderQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,orderId,'');
	}

	function backDataItemQTY(response)
	{

		var responseArr = response.split("-");
		var sub_total = document.getElementById("sub_total");
		var freight_total = document.getElementById("freight_total");
		var service_fee = document.getElementById("service_fee");
		var tax_view = document.getElementById("tax_view");
		var order_total_amount = document.getElementById("order_total_amount");

		sub_total.innerHTML = setCurrency(responseArr[0]);
		freight_total.innerHTML = setCurrency(responseArr[1]);
		service_fee.innerHTML = setCurrency(responseArr[2]);
		tax_view.innerHTML = '¥ ' + setCurrency(responseArr[3]);
		order_total_amount.innerHTML = setCurrency(responseArr[4]);

	}
	function removeOrderQTY(cartId,cartType,cartIdStr,orderId){

		var cartids = ","+cartId;
		var s = cartIdStr.indexOf(cartids);
		if(s < 0){
			var cartids2 = cartId+",";
			var newcartIdStr  = cartIdStr.replace(cartids2,"");
			//alert(newcartIdStr);
		}else{
			var newcartIdStr  = cartIdStr.replace(cartids,"");
			//alert(newcartIdStr);
		}
		call_tpl('shop','changeRemoveQTY','backDataRemoveQTY()','return',cartId,cartType,newcartIdStr,orderId,'');

	}
	function backDataRemoveQTY(response)
	{
		var responseArr = response.split("-");
		var sub_total = document.getElementById("sub_total");
		var freight_total = document.getElementById("freight_total");
		var service_fee = document.getElementById("service_fee");
		var tax_view = document.getElementById("tax_view");
		var order_total_amount = document.getElementById("order_total_amount");

		sub_total.innerHTML = setCurrency(responseArr[0]);
		freight_total.innerHTML = setCurrency(responseArr[1]);
		service_fee.innerHTML = setCurrency(responseArr[2]);
		tax_view.innerHTML = '¥ ' + setCurrency(responseArr[3]);
		order_total_amount.innerHTML = setCurrency(responseArr[4]);
		window.location.reload();
	}
function number_format (number, decimals, dec_point, thousands_sep) {

    number = (number + '').replace(/[^0-9+-Ee.]/g, '');

    var n = !isFinite(+number) ? 0 : +number,

        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),

        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,

        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,

        s = '',

        toFixedFix = function (n, prec) {

            var k = Math.pow(10, prec);

            return '' + Math.round(n * k) / k;

        };

    // Fix for IE parseFloat(0.55).toFixed(0) = 0;

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

    if (s[0].length > 3) {

        s[0] = s[0].replace(/B(?=(?:d{3})+(?!d))/g, sep);

    }

    if ((s[1] || '').length < prec) {

        s[1] = s[1] || '';

        s[1] += new Array(prec - s[1].length + 1).join('0');

    }

    return s.join(dec);

}

		function isNum(s){
			var r,reg;
			reg=/\d*/;
			r=s.match(reg);
			if(r==s)
			  return true;
			else
			  return false;
		};

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

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	//订单信息cms_publish_order表中
	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));

	$loginUser = runFunc('readSession',array());
	//用户信息
	$user_info = runFunc("getStaffInfoById",array($loginUser));
	?>
<?php
	$inc_tpl_file=includeFunc('shop/common/header.tpl');
	include($inc_tpl_file);
	?>
<div class="content" style="width: 916px;">
<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">Order Modify<?php //echo $this->_tpl_vars["method"];?>
	<font style="font-size:12px;">Order <span>(No:<?php echo $order["OrderNo"];?>)</span></font>
</h2>

<form id="order_modify_form" action="index.php" method="post" onSubmit="javascript:return confirm('Save your order modify?')">
<input type="hidden" name="order_id" value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>"/>
<input type="hidden" name="action" value="shop" />
<input type="hidden" name="method" value="order_modify_save">


<div class="subMitConfirm  fl">
			<div class="order_address fl success_order_address" width="100%">
				<h2>SHIPPING ADDRESS</h2>

				<table>
					<tr>
						<td width=12%>Name:</td>
						<td width="40%"><input class="modify_order_address_input required" type="text" name="fullName" value="<?php echo $order["fullName"];?>"/></td>
						<td width=12%>Email:</td>
						<td><input class="modify_order_address_input required email" type="text" name="email" value="<?php echo $order["email"];?>"/></td>
					</tr>
					<tr>
						<td>Address1:</td>
						<td colspan=3><input class="modify_order_address_input required" type="text" name="address1" value="<?php echo $order["address1"];?>"/></td>
					</tr>
					<tr>
						<td>Address2:</td>
						<td colspan=3><input class="modify_order_address_input" type="text" name="address2" value="<?php echo $order["address2"];?>"/></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><input class="modify_order_address_input required" type="text" name="city" value="<?php echo $order["city"];?>"/></td>
						<td>Province:</td>
						<td><input class="modify_order_address_input required" type="text" name="province" value="<?php echo $order["province"];?>"/></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><input class="modify_order_address_input" type="text" disabled="disabled" value="<?php echo $order["country"];?>"/></td>
						<td>Zip:</td>
						<td><input class="modify_order_address_input" type="text" name="zipcode" value="<?php echo $order["zipcode"];?>"/></td>
					</tr>
					<tr>
						<td>Phone1:</td>
						<td><input class="modify_order_address_input required" type="text" name="cellphone" value="<?php echo $order["cellphone"];?>"/></td>
						<td>Phone2:</td>
						<td><input class="modify_order_address_input" type="text" name="telephone" value="<?php echo $order["telephone"];?>"/></td>
					</tr>
				</table>
			</div>
			<div class="order_imf" style="height:auto;padding-bottom: 20px;background:none repeat scroll 0 0 #EBEBEB">
			<span class="imf_title" style="margin-bottom: 10px;">ORDER ITEMS</span>
				<div class="order_modify_item_box">
					<?php
					//据据提交的orderId获取订单详情cms_publish_order表
						$cart = runFunc("getOrderCartStrByOrderId",array($this->_tpl_vars["IN"]["orderID"]));
					//根据订单中的商品编号查询对应的商品信息和购物车信息，联合查询cms_publish_goods，cms_publish_cart表。商品价格和运费在cms_publish_cart表中
						$items = runFunc("getOrderItemByCartStr",array($cart["cartIDstr"]));
					?>
					<table class="order_modify_item_table fl">
					<?php foreach ($items as $item):

					if($order["group_buy"]==1){

						$group_buy_item = runFunc("getSiteGroupBuyItem",array($item["goodsid"]));
						$item["goodsImgURL"] = $group_buy_item[0]["goodsImgURL"];
						$item["goodsTitleCN"] = $group_buy_item[0]["item_name"];
						$order_type = "group";
					}else{
						$order_type = "normal";
					}
					?>

					<!--
					<tr>
						<td width="55%">
							<div style="margin-left:5px;" class="fl"><img src="<?php echo $item["goodsImgURL"]."_310x310.jpg";?>" alt="bagImg" /></div>
							<div style="margin-left:5px;text-align:left;width:230px;" class="fl">
								<strong><?php echo $item["goodsTitleCN"];?> </strong>
								<br/><?php
								$props = explode("|",$item["props"]);
											 foreach($props as $prop){
												$prop_arr = explode(":",$prop);
												if($prop_arr[0]!=""){
												echo "".ucfirst($prop_arr[0]).":&nbsp;".stripslashes($prop_arr[1])."<br>";
												}
											 }
										?>
							</div>
						</td>
						<td width="10%">QTY<br/><input class="required" min="1" border="1px solid black" style="width: 20px;border: 1px solid #E6E6E6;" name="qty[<?php echo $item["cartID"]?>]" type="text" value="<?php echo $item["ItemQTY"]?>" /></td>
						<td width="15%">Seller Freight<br/>￥<?php echo number_format($item["itemFreight"], 2, '.', ',');?></td>
						<td width="15%">Total Price<br/>￥<?php echo number_format($item["itemPrice"], 2, '.', ',');?></td>
						<td width="10%"><a style="color: #9A4AAA;cursor:pointer" class="remove_modify_item">Delete</a></td>
					</tr>
					-->
					<tr>

						<td width="15%" rowspan="2">
							<div style="margin-left:5px;" class="fl"><img src="<?php echo $item["goodsImgURL"]."_310x310.jpg";?>" alt="bagImg" /></div>

						</td>

						<td width="40%" rowspan="2">

							<div style="margin-left:5px;text-align:left;" class="fl">
								<strong><?php echo $item["goodsTitleCN"];?> </strong>
								<br/><?php
								$props = explode("|",$item["props"]);
											 foreach($props as $prop){
												$prop_arr = explode(":",$prop);
												if($prop_arr[0]!=""){
												echo "".ucfirst($prop_arr[0]).":&nbsp;".stripslashes($prop_arr[1])."<br>";
												}
											 }
										?>
							</div>
						</td>

						<td width="10%">QTY<br/><input class="required numQTY" min="1" onBlur="changeOrderQTY(this,this.value,'<?php echo $item["cartID"];?>','<?php echo $loginUser; ?>','<?php echo $order_type;?>','<?php echo $cart["cartIDstr"];?>','<?php echo $this->_tpl_vars["IN"]["orderID"];?>');" border="1px solid black" style="width: 20px;border: 1px solid #E6E6E6;" name="qty[<?php echo $item["cartID"]?>]" type="text" value="<?php echo $item["ItemQTY"]?>" /></td>
						<td width="15%">Seller Freight<br/>￥<b id = "seller_freight"><?php echo number_format($item["itemFreight"], 2, '.', ',');?></b></td>
						<td width="15%">Total Price<br/>￥<b id="total_price"><?php $total= $item["itemPrice"]*$item["ItemQTY"]; echo number_format($total, 2, '.', ',');?></b></td>
						<td width="10%"><a style="color: #9A4AAA;cursor:pointer" class="remove_modify_item" cartid = "<?php echo $item["cartID"];?>">Delete</a></td>
						<td class="hide" id="publish_price"><?php echo number_format($item["itemPrice"],2,'.',','); ?></td>
					</tr>

					<tr>

						<?php $check_wish =  runFunc("countWishList",array($this->_tpl_vars["name"],$item["goodsid"]));?>
						<td colspan="4" style="text-align:right;border-top: 0px;fony-color:#9A4AAA;font-weight:bold;">
						<?php if($check_wish>0):?>
							<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>">
							Already in wish list
							</a>
							<?php else:?>
							<!--<a <?php if($this->_tpl_vars["name"]==""){echo "href='".runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr=' . $this->_tpl_vars["paraStr"] ))."'";}else{echo "href='".runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr=' . $this->_tpl_vars["paraStr"] ))."'";}?> >-->

							<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=OrderDetailToWish&cartID='.$item["cartID"].'&orderID='.$this->_tpl_vars["IN"]["orderID"].'&cartIDString='.$cart["cartIDstr"]));?>">
								Move to wish list
							</a>
						<?php endif;?>
						<!--<a style="color: #9A4AAA;cursor:pointer;" class="remove_modify_item">Move to Wish List</a>--></td>

					</tr>
					<!--<tr><td><?php print_r($item);?></td></tr>-->
					<tr>
						<td colspan="5" style="border:0;text-align:left;padding-bottom: 50px;<?php if($item["ItemType"] == "ivi"):?>display:none;<?php endif;?>">

							ORDER INFO ( Please input Color, Size etc…and your request here ) <br>
							<textarea name="order_info[<?php echo $item["cartID"]?>]" style="height: 30px;line-height: 10px; margin-top: 2px;width: 530px;" rows="4" cols="30"><?php echo $item["itemNotes"]?></textarea>

						</td>
					</tr>

					<?php endforeach;?>
					</table>
				</div>
				<input class="order_modify_save_button fr" type="submit" value="SAVE" />
				<a onClick="javascript:return confirm('Back to order detail page without save your change?')" class="order_modify_save_button fr" href="<?php echo runFunc('encrypt_url',array('action=shop&method=payment&orderID='.$this->_tpl_vars["IN"]["orderID"]));?>">BACK</a>
			</div>

			</form>
		</div>
		<div class="fr" style="width:300px;position:relative;">
		<div class="submitOrderNo">
		Order <span>(No:<?php echo $order["OrderNo"];?>)</span>
		</div>
		<?php
		// ******************order Review**************************

		$inc_tpl_file=includeFunc(<<<LNMV
shop/order_modify_paymentInfo.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
		</div>

	</div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

	<script type="text/javascript">
	$(function(){

		$(".remove_modify_item").click(function(){

			if($(".remove_modify_item").length==1){
				//alert("Your have to keep 1 item in order at least.");
				//return false;
				if(confirm('Note: If you want to cancel the last item of the order, this order will be cancelled too.')){
					location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify_save&delstatus=true&orderID=' . $this->_tpl_vars["IN"]["orderID"] ));?>';
				}

			}else{
				if(confirm('Remove this item from order?')){

					$(this).parent().parent().next("tr").remove();
					$(this).parent().parent().next("tr").remove();
					$(this).parent().parent().remove();
					var cartid = $(this).attr('cartid');
					removeOrderQTY(cartid,'<?php echo $order_type;?>','<?php echo $cart["cartIDstr"];?>','<?php echo $this->_tpl_vars["IN"]["orderID"];?>')
				}

			}

		});

		$("#order_modify_form").validate({
		errorPlacement: function(error, element) {
         // console.info(element.parent().prev("th").append(error));
        }
		});
	});
	</script>

</body>
</html>
		<?php }else{ ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&backaction=website&backmethod=login&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
		<?php } ?>