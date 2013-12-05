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

$items = runFunc("getUserCart",array($current_user_id,false,2,$cartIdStr));
$items_count = runFunc("getUserCart",array($current_user_id,true,2,$cartIdStr));
}else{

$items = runFunc("getUserCart",array($current_user_id,false,1,$cartIdStr));
$items_count = runFunc("getUserCart",array($current_user_id,true,1,$cartIdStr));
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
				<!--
				<a  id="<?php echo $item["cartID"];?>" class="add_to_my_list_button">Add to Style List</a><br>


				<?php if($this->_tpl_vars["IN"]["check_type"]=="group_buy"){?>

				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$item["goodsid"]));?>">Add to Shopping Bag</a>
				<?php }else{?>
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item["goodsid"]."&show_type=normal&from=search_url"));?>">Add to Shopping Bag</a>
				<?php }?>
				-->
				<?php if($this->_tpl_vars["method"]!="WOWd2d" && $order["orderStatus"] < 5):?>
					<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify&orderID='.$this->_tpl_vars["IN"]["orderID"]));?>">Modify This Order</a>
				<?php else:	?>
					<?php $check_wish =  runFunc("countWishList",array($this->_tpl_vars["name"],$item["goodsid"]));?>

					<?php if($check_wish>0):?>
						<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>">
						Already in wish list
						</a>
					<?php else:?>
						<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=CartToWishlist&cartID='.$item["cartID"]));?>">		Move to wish list
						</a>
					<?php endif;?>

				<?php endif;?>
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
                <td colspan="5"><span style="color: #444444; float: left;">ORDER INFO</span><br />
                    <p style="text-align: left; word-wrap: break-word; width: 570px;text-align:center;"><?php echo htmlspecialchars_decode($item["itemNotes"]);?></p>
                </td>
            </tr>
            	<?php if($loginUser){	?>
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
									<textarea onkeyup="checkWordLen(this);" name="" class="pick_item_comment" cols="30" rows="10"></textarea>
									<span class="pick_link_comment_limit">300 characters limit</span>
								</div>
								<div class="pick_list_item_ctrls">
									<input item_id="<?php echo $item["cartID"];?>"  goods_id="<?php echo $item["goodsid"];?>" class="pick_list_submit blue_button_sm" type="submit" value="Submit" />
									<a id="<?php echo $item["cartID"];?>" class="pick_list_close">Cancel</a>
								</div>
							</div>
						</div>
                   <?php }?>
			<?php  }?>
		</tbody>
	</table>
</div>
