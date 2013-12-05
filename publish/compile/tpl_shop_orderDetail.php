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
		$(".pageContentSubmit").toggle();
		$(".order_view").click(function(){
			$(".pageContentSubmit").toggle();

		});
	});
</script>
</head>
<body>

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);

	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));

$loginUser = runFunc('readSession',array());
$user_info = runFunc("getStaffInfoById",array($loginUser));
	?>
<?php
	$inc_tpl_file=includeFunc('shop/common/header.tpl');
	include($inc_tpl_file);
	?>
<div class="content" style="width: 916px;">
<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">Order Detail <a style="color:#BAD584;font-size:11px" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">Back to your order history</a>
<?php if($order["orderStatus"]=="4"):?>
<font style="font-size:11px">|</font> <a style="color:#9B2F2F;font-size:11px" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify&orderID='.$this->_tpl_vars["IN"]["orderID"]));?>">Modify This Order</a>
<?php endif;?>
<font style="font-size:11px">|</font>
<a style="color:#9B2F2F;font-size:11px;cursor:pointer;" id="order_print">Print</a>

</h2>
<script type="text/javascript">
	$("#order_print").click(function(){
			$(".pageContentSubmit").show();
			window.print();
			return false;
		});
</script>
<div class="subMitConfirm  fl">
			<div class="order_address fl success_order_address" width="100%">
				<h2>SHIPPING ADDRESS</h2>
				<table>
					<tr>
						<td width=12%>Name:</td>
						<td width="40%"><?php echo $order["fullName"];?></td>
						<td width=12%>Email:</td>
						<td><?php echo $order["email"];?></td>
					</tr>
					<tr>
						<td>Address1:</td>
						<td colspan=3><?php echo $order["address1"];?></td>
					</tr>
					<tr>
						<td>Address2:</td>
						<td colspan=3><?php echo $order["address2"];?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?php echo $order["city"];?></td>
						<td>Province:</td>
						<td><?php echo $order["province"];?></td>
					</tr>
					<tr>
						<td>Country:</td>
						<td><?php echo $order["country"];?></td>
						<td>Zip:</td>
						<td><?php echo $order["zipcode"];?></td>
					</tr>
					<tr>
						<td>Phone1:</td>
						<td><?php echo $order["cellphone"];?></td>
						<td>Phone2:</td>
						<td><?php echo $order["telephone"];?></td>
					</tr>
				</table>
			</div>
			<div class="order_imf">
			<?php if($order["orderStatus"]=="4"):?>
			<span class="imf_title">YOUR ORDER IS WAITING FOR PAYMENT</span>
				<p>
				Payment is not finished, in order to help you to complete the purchase in time, please confirm.
				</p>
			<?php endif;?>
			<?php if($order["orderStatus"]=="5" or $order["orderStatus"]=="6"):?>
				<span class="imf_title">YOUR ORDER PAYMENT IS COMPLETE , THANK YOU</span>
				<p>
				Your order No. is <font style="color:#7c0000;">(<?php echo $order["OrderNo"];?>)</font> ,order confirmation will be emailed to <?php echo $order["email"];?>
			<br />
			Wowshopping Customer Service will check your order, if any problem is occurred, such as: payment failure,unclear delivery address you provided, items you ordered is out of seller's stock, shipping problem... we will inform you as soon as possible by email/telephone.
				</p>
			<?php endif;?>
			<?php if($order["orderStatus"]=="7"):?>
			<span class="imf_title">CONFIRM YOUR ORDER</span>
			<p>
			The item of your order No. <font style="color:#7c0000;">(<?php echo $order["OrderNo"];?>)</font> have been shipped by seller, please check your ORDER REVIEW and CONFIRM.
			<br />After opening your package, you notice any problem (such as damaged goods) please contact us within 3 days, if we don’t hear anything from you within 3 days, we consider the transaction as successful.

			</p>
			<?php endif;?>
			<?php if($order["orderStatus"]=="8"):?>
			<span class="imf_title">YOUR ORDER IS COMPLETE</span>
			<p>
			Thank you for your support of our service. <br />Any further needs or questions,please contact <a style="color:#7C0000;" href="mailto:wowshoppingservice@gmail.com">wowshoppingservice@gmail.com</a>
			</p>
			<?php endif;?>
			</div>
		</div>
		<div class="fr" style="width:300px;position:relative;">
		<div class="submitOrderNo">
		Order <span>(No:<?php echo $order["OrderNo"];?>)</span>
		</div>
		<?php
		// ******************order Review**************************

		$inc_tpl_file=includeFunc(<<<LNMV
shop/paymentInfo.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
		</div>
		<style type="text/css">
			.subMitRight{
				height: 465px;
			}
			.order_view {
				margin-top: 3px;
			}

				.order_imf {
				    height: 286px;
				}
		</style>

			<div class="fl">
			<table class="order_view">
	<tr style="background: #ebebeb;">
		<td style="color: #51555d;"><span id="order_review_span"
			style="color: #51555D; font-size: 14px; font-weight: bold; margin: 20px;">ORDER REVIEW</span></td>
	</tr>
</table>
<?php if($this->_tpl_vars["method"]!="WOWd2d"):

$cart = runFunc("getOrderCartStrByOrderId",array($this->_tpl_vars["IN"]["orderID"]));

$items = runFunc("getOrderItemByCartStr",array($cart["cartIDstr"]));



$items_count =  runFunc("getOrderItemByCartStr",array($cart["cartIDstr"],true));

else:
$loginUser = runFunc('readSession',array());
$tmpUser = runFunc('readCookie',array());
if($loginUser == ""){

	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}

if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){

$items = runFunc("getUserCart",array($current_user_id,false,2));
$items_count = runFunc("getUserCart",array($current_user_id,true,2));
}else{

$items = runFunc("getUserCart",array($current_user_id));
$items_count = runFunc("getUserCart",array($current_user_id,true));
}



endif;?>
<div class="pageContentSubmit fl hide" style="width: 566px;padding: 0 18px 18px;">

	<table>
		<thead>
			<tr>
				<td><?php echo $items_count[0]["qty_count"];?> items in your bag</td>
				<td width="75px" align="center">QTY</td>

				<td width="75px" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FREIGHT</td>
				<td style="text-align: center" width="75px">PRICE</td>

			</tr>
		</thead>
		<tbody>
		<?php foreach ($items as $item){ ?>
		<?php //print_r($item);?>
		<?php if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){

			$group_buy_item = runFunc("getSiteGroupBuyItem",array($item["goodsid"]));
			$item["goodsImgURL"] = $group_buy_item[0]["goodsImgURL"];
			$item["goodsTitleCN"] = $group_buy_item[0]["item_name"];


		}?>
			<tr class="review_table">
				<td class="bagItem" rowspan=3>
					<dl>
						<dt>
							<img src="<?php echo $item["goodsImgURL"]."_310x310.jpg";?>" alt="bagImg" />
						</dt>
						<dd style="width: 130px;padding-left:5px;">
							<strong><?php echo $item["goodsTitleCN"];?> </strong>
							<?php if($this->_tpl_vars["method"]!="WOWd2d"):?>

							<?php  if($item["props"] !=""){
								?><br/><?php

								$props = explode("|",$item["props"]);
											 foreach($props as $prop){
												$prop_arr = explode(":",$prop);
												echo "<span style='color:black;font-weight:bold;'>".ucfirst($prop_arr[0])."</span>:&nbsp;".stripslashes($prop_arr[1])."<br>";
											 }
										}?>
							<?php else:?>
							<?php  if($item["cart_props"] !=""){
								?><br/><?php

								$props = explode("|",$item["cart_props"]);
											 foreach($props as $prop){
												$prop_arr = explode(":",$prop);
												echo "<span style='color:black;font-weight:bold;'>".ucfirst($prop_arr[0])."</span>:&nbsp;".stripslashes($prop_arr[1])."<br>";
											 }
										}?>

							<?php endif;?>

						</dd>
					</dl>
				</td>
				<td><?php echo $item["ItemQTY"]?></td>
				<?php $this->_tpl_vars["subItemPrice"]=number_format($item["itemPrice"], 2, '.', ','); ?>

				<td align="center"><?php if ($item["itemFreight"]<=0){?>NO<?php }else{ ?>
				<?php $this->_tpl_vars["Freight"]=number_format($item["itemFreight"], 2, '.', ','); ?>
				<?php echo $this->_tpl_vars["Freight"];?> <?php } ?></td>
					<td align="center">￥ <?php echo $this->_tpl_vars["subItemPrice"];?>
				</td>
			</tr>
			<tr>
				<td  style="text-align:right;font-size:12px;font-weight:bold;" colspan="3">
				<a  id="<?php echo $item["cartID"];?>" class="add_to_my_list_button">Add to Style List</a><br>


				<?php if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){?>

				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$item["goodsid"]));?>">Buy Again</a>
				<?php }else{?>
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item["goodsid"]."&show_type=normal&from=search_url"));?>">Buy Again</a>
				<?php }?>

				</td>
			</tr>
			<tr>
				<td style="text-align:left;text-align:left;font-size: 14px;color: #777777;" colspan="3">
				<?php if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){
					if($item["group_buy_off"]==1){

						echo "This deal is off.";
					}

					elseif($group_buy_item[0]["sell_way"] == 1){

						echo "service fee ".((1-$group_buy_item[0]["price_rate"])* 100)."% off";
					}else{

						echo "￥ ".number_format($group_buy_item[0]["goodsUnitPrice"], 2, '.', ',')." VALUE";
					}

				}?>

				</td>
			</tr>
								<tr class="order_info">
									<td colspan="5"><?php if($item["ItemType"] != 'ivi'):?>
										<span style="color: #444444; float: left;">ORDER INFO</span><br />

										<p style="text-align: left; word-wrap: break-word; width: 570px;"><?php echo $item["itemNotes"];?></p>
										<?php endif;?>
									</td>
								</tr>
			<div id="add_to_my_list_<?php echo $item["cartID"];?>" class="add_to_my_list_box gray_line_box oh hide">
							<div class="add_to_my_list_box_tite">
								Pick a Style List
							</div>
							<div class="pick_img_message fl">
							<div class="pick_list_img"><img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" /></div>
							<div id="pick_message_<?php echo $item["cartID"];?>" class="pick_message">

							</div>
							</div>
							<div class="pick_list_detail fr">
								<div id="pick_item_title_<?php echo $item["cartID"];?>" class="pick_item_title"><?php echo $item["goodsTitleCN"];?></div>
								<?php $my_lists = runFunc("getShareListByUserId",array($this->_tpl_vars["name"]));?>
								<select name="" class="my_list_select">
									<option class="no_choose" value="">Select list from my style lists</option>
									<?php foreach($my_lists as $my_list):?>
									<option value="<?php echo $my_list["id"]?>"><?php echo $my_list["title"];?></option>
									<?php endforeach;?>
								</select>
								<div class="pick_link_comment">
									<a href="<?php echo runFunc('encrypt_url',array('action=share&method=addList&add_good_id='.$item["ItemGoodsID"]));?>"> Create New Style List</a>
									<textarea onKeyUp="checkWordLen(this);" name="" class="pick_item_comment" cols="30" rows="10"></textarea>
									<span class="pick_link_comment_limit">300 characters limit</span>
								</div>
								<div class="pick_list_item_ctrls">
									<input item_id="<?php echo $item["cartID"];?>"  goods_id="<?php echo $item["goodsid"];?>" class="pick_list_submit blue_button_sm" type="submit" value="Submit" />
									<a id="<?php echo $item["cartID"];?>" class="pick_list_close">Cancel</a>
								</div>
							</div>
						</div>
			<?php  }?>
		</tbody>
	</table>
</div>
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

	function checkWordLen(e){
		var limit = 300 - $(e).val().length;
		var limit_word = "("+ limit +" characters limit)";

		if($(e).val().length >=300){
			$(e).val($(e).val().substring(0, 300));
			limit_word = "(0 words max)";
		}
		$(e).siblings(".pick_link_comment_limit").text(limit_word);
	}

		$(function(){

			var submiting = 0;
			$(".pick_list_submit").click(function(){
					var item_id = $(this).attr("item_id");
					var goods_id = $(this).attr("goods_id");
					var list_id = $(this).parent().siblings(".my_list_select").val();
					var title = $("#pick_item_title_"+item_id).text();
					var comment = $(this).parent().siblings(".pick_link_comment").children(".pick_item_comment").val();

					if(submiting == 0){
						submiting = 1;

					}else{
							return false;
						}
					if(list_id==""){
							alert("Please select your list first!");
							submiting = 0;
							return false;
						}
					$("#pick_message_"+item_id).children().remove();
					$("#pick_message_"+item_id).text("");
					var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
					$("#pick_message_"+item_id).append(loading_icon);
					$.ajax({
						url : 'index.php',
						type : 'POST',
						dataType : "json",
						data:{
							action		: "share",
							method		: "addItemToList",
							list_id 	: list_id,
							title 		: title,
							comment 	: comment,
							goods_id 	: goods_id
						},
						success : function(data)
						{

						},complete: function(){
							$("#pick_message_"+item_id).children().remove();
							submiting = 0;
							$("#pick_message_"+item_id).text("Add successful!");
							$(".pick_list_submit").hide();
							$(".pick_list_close").addClass("pick_list_success_close");
							$(".pick_list_close").text("Close");
						}
					});
				});

			$( ".add_to_my_list_box" ).dialog({
				autoOpen: false,
				show: { effect: 'drop', direction: "up" },
				hide: { effect: 'drop', direction: "up" },
				width: 430,
				modal: true
			});

			$( ".add_to_my_list_button" ).click(function() {
				$(".pick_list_close").removeClass("pick_list_success_close");
				$(".pick_list_close").text("Cancel");
				$(".pick_list_submit").show();
				$(".my_list_select").children(".no_choose").attr("selected","selected");
				$(".pick_item_comment").val("");
				$(".pick_item_comment").siblings(".pick_link_comment_limit").text("300 characters limit");
				var id = $(this).attr("id");
				$("#add_to_my_list_"+id).dialog( "open" );
				return false;
			});

			$(".pick_list_close").click(function(){
					var id = $(this).attr("id");
					$("#add_to_my_list_"+id).dialog( "close" );
					return false;
				});


			});
	</script>
</body>
</html>
		<?php }else{ ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&backaction=website&backmethod=login&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
		<?php } ?>