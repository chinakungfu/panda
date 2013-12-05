<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<?php

$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["order_id"]));
$carts = runFunc('getOrderCarts',array($order["cartIDstr"]));

?>
<script type="text/javascript">
	$(function(){
		$("#save_order_info").click(function(){
				$("#order_info_form").submit();
			});

		$("#open_items").click(function(){

				$(".order_items").slideDown();
			});
		$("#close_items").click(function(){

			$(".order_items").slideUp();
		});

		$( "#order_problem_box" ).dialog({
			autoOpen: false,
			show: { effect: 'drop', direction: "up" },
			hide: { effect: 'drop', direction: "up" },
			width: 500,
			modal: true
		});

		$("#order_problem_open").click(function(){
			$("#order_problem_box").dialog( "open" );
		});

		$("#close_problem_box").click(function(){
			if(confirm("是否放弃此次提交？")){
			$("#order_problem_box").dialog( "close" );
			}
		});

		$(".submit_order_problem").click(function(){

			$("#order_problem_form").submit();
		});
	});
</script>
	<div id="order_problem_box">
				<div class="order_problem_title">
					<div class="fl">交易问题</div>
					<div id="close_problem_box" class="fr">关闭</div>
					<div class="submit_order_problem fr cp">保存</div>
				</div>
				<form action="index.php" method="post" id="order_problem_form">
				<textarea name="order_problem" id="order_problem" cols="30" rows="10"><?php echo str_replace("<br />","",$order["problem"]);?></textarea>
					<input type="hidden" name="action" value="cms"/>
					<input type="hidden" name="method" value="order_problem_save"/>
					<input type="hidden" name="orderId" value="<?php echo $order["orderID"];?>" />
				</form>
			</div>
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$this->_tpl_vars["IN"]["type"]='orders';

$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
?>

</div>
<div class="cms_right fr">
	<div class="ctrl_bar">
		<div class="title fl">
			团购订单订单 <?php echo $order["OrderNo"];?>  << <?php echo runFunc("getOrderStatusAdmin",array($order["orderStatus"]));?> >>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_1"><a href="#">撰写邮件</a></li>
			<li id="ctrl_4"><a onClick="javascript:return confirm('是否确定删除此订单？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyCart&delete_order='.$this->_tpl_vars["IN"]["order_id"]."&type=orders"));?>">删除订单</a></li>
			<li id="ctrl_2"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyCart&type=orders'));?>">返回订单列表</a></li>
		</ul>
	</div>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">商品信息 <a style="font-size:12px;color:gray;cursor:pointer;" id="open_items" >展开商品</a> <a style="font-size:12px;color:gray;cursor:pointer;" id="close_items" >收起商品</a> </div>
			<?php switch($order["orderStatus"]){
				case 4:
			?>
			<a onClick="javascript:return confirm('您的这个操作将会发送一封邮件提醒买家付款，是否确定进行这个操作？')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderPayRemind&orderId='.$order["orderID"]));?>">
				提醒买家付款
			</a>
			<?php break;
				case 5:?>
			<!--
			<a onClick="javascript:return confirm('您的这个操作将会使这个订单进入已采购状态，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderPurchase&orderId='.$order["orderID"]));?>">
				采购商品
			</a> -->
			<?php break;
				case 6:?>
			<!--<a onClick="javascript:return confirm('您的这个操作将会使这个订单进入已发货状态，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=confirmShipping&orderId='.$order["orderID"]));?>">
				确认发货
			</a>	 -->
			<?php break;
				case 7:?>
			<!-- <a onClick="javascript:return confirm('您的这个操作将会发送一封邮件提醒买家确认收货，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderFinalConfirmRemind&orderId='.$order["orderID"]));?>">
				提醒买家收货
			</a>
			 -->
			 <a class="order_step_submit fr cp" href="<?php echo runFunc('encrypt_url',array('action=cms&method=markOrderReturns&orderId='.$order["orderID"]));?>">
			<?php if($order["order_return"]>0):?>
			取消退货标记
			<?php else:?>
			标记退货订单
			<?php endif;?>

			 </a>
			<?php break;?>
			<?php }?>
			<a id="order_problem_open" style="margin-right:5px;" class="order_step_submit fr cp">
				交易问题记录
			</a>
		</div>
		<div class="order_items <?php if($order["orderStatus"]>6){echo "hide";}?>">
		<?php foreach($carts as $cart):
			$good = runFunc('getMemberGroupBuyItem',array($cart["ItemGoodsID"]));
			$good = $good[0];
		?>
			<div class="black_line"></div>
			<form action="index.php" method="post">
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="orderCartUpdate"/>
			<input type="hidden" name="cartID" value="<?php echo $cart["cartID"];?>"/>
			<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>"/>
			<input type="hidden" name="orderId" value="<?php echo $order["orderID"];?>"/>
			<input type="hidden" name="order_type" value="GROUP BUY"/>
			<table class="order_item_table" >
				<tr>
					<td width="45%">
						<table class="first_info">
							<tr>
								<td style="padding-right:15px;" rowspan=5>
								<img width=100px src="<?php echo $good["goodsImgURL"]."_310x310.jpg";?>" alt=""/>
								<br>
								<center><?php echo $_GLOBAL['group_buy_'.$good["sell_way"]];?>（<?php echo $good["price_rate"]*10?> 折）</center>
								</td>
								<td style="font-weight: bold;">
								<?php echo $good["goodsTitleCN"];?>
								<br />
								<font style="color:#ED5E83">
								（应收单价：<?php echo number_format($good["goodsUnitPrice"], 2, '.', '');?> 应收运费：<?php echo number_format($good["goodsFreight"], 2, '.', '');?>）
								</font>
								</td>
							</tr>
							<tr>
								<td style="color:#777777;"><?php echo str_replace("|","<br>",$cart["props"]);?></td>
							</tr>
							<tr>
								<td>商品状态：
								<?php $purchase_count = runFunc("getAdminGroupPurchasedCount",array($good["id"]));?>
									<?php if($good["group_size"]>$purchase_count[0]["count"] and $good["end_time"]<date("Y-m-d")):?>
										团购失败
										<?php if($order["orderStatus"]>4):?>
										<?php if($good["pay_back_time"]!=""):?>
										已退款
										<?php else:?>

										需退款
										<?php endif;?>
										<?php endif;?>
										<?php elseif($good["group_size"]>$purchase_count[0]["count"] and $good["end_time"]>=date("Y-m-d")):?>
										未成团
										<?php else:?>
										<?php echo $_GLOBAL['item_status_'.$good["order_item_status"]];?>
										<?php endif;?>


								</td>
							</tr>
							<tr>
								<td>团购状态：
								<?php if($good["end_time"]<date("Y-m-d")):?>
									团购结束
									<?php else:?>
									进行中
									<?php endif;?>

								</td>
							</tr>
							<?php if($cart["order_item_status"]>1):?>
							<tr>
								<td style="color:#9a4aaa;">采购时间：<?php echo $cart["order_item_buy_time"];?></td>
							</tr>
							<?php endif;?>
							<?php if($cart["order_item_status"]>2):?>
							<tr>
								<td style="color:#9a4aaa;">发货时间：<?php echo $cart["order_item_shipping_time"];?></td>
							</tr>
							<?php endif;?>
						</table>
					</td>
					<td style="vertical-align:middle;">
						<table class="price_table">
							<tr>
								<th>数量</th>
								<th>实际运费</th>
								<th>实际单价</th>
								<th></th>
							</tr>
							<tr>
						<?php if($order["orderStatus"]<5):?>
								<td><input class="item_modify" name="ItemQTY" style="width:15px;text-align:center" type="text" value="<?php echo $cart["ItemQTY"]?>"/></td>
								<td><input class="item_modify" name="itemFreight" type="text" value="<?php echo number_format($cart["itemFreight"], 2, '.', ',');?>"/></td>
								<td><input class="item_modify" name="itemPrice" type="text" value="<?php echo number_format($cart["itemPrice"], 2, '.', ',');?>"/></td>
								<td><input class="item_update_button" type="submit" value="更新商品"/></td>
							<?php else:?>
								<td><?php echo $cart["ItemQTY"]?></td>
								<td><?php echo number_format($cart["itemFreight"], 2, '.', ',');?></td>
								<td><?php echo number_format($cart["itemPrice"], 2, '.', ',');?></td>
							<?php endif;?>
							</tr>
						</table>
					</td>


					<td style="vertical-align:middle;">

					 <?php if($good["goodsURL"]!=""):?>
                                        <?php if($good["click_url"]!=""){

                                                $click_link = $good["click_url"];
                                        }else{

                                                $click_link = $good["goodsURL"];
                                        }?>
						<a class="pink_link" target="_blank" href="<?php echo $click_link;?>">购买链接</a> |
					<?php endif;?>
					</td>
					<td style="vertical-align:middle;">
					<?php if($good["group_size"]>$purchase_count[0]["count"] and $good["end_time"]<date("Y-m-d") and $order["orderStatus"] > 4):?>
					<a class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupFailed&type=orders&gid='.$good["id"]));?>">处理退款</a>&nbsp;| &nbsp;
					<?php endif;?>
					<?php if($order["orderStatus"]==4 or $order["orderStatus"]==5):?>
						<a onClick="javascript:return confirm('是否要从订单中移除该产品？')" class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderItemDelete&id='.$this->_tpl_vars["IN"]["order_id"].'&all_cart='.$order["cartIDstr"].'&order_type=GROUPBUY&delete_cart='.$cart["cartID"]));?>">删除</a>
					<?php endif;?>
					&nbsp;|&nbsp;
						<?php if($good["group_size"]>$purchase_count[0]["count"] or $good["start_time"]>date("Y-m-d")):?>

						<?php else:?>
						 <?php if($cart["order_item_status"]==1):?>
					 <a onClick="javascript:return confirm('是否确认已经采购了这个商品？')" class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItemStautsGo&status=2&id='.$cart["cartID"].'&order_id='.$this->_tpl_vars["IN"]["order_id"]));?>">采购</a>
					 <?php endif;?>
									<?php endif;?>

					 <?php if($cart["order_item_status"]==2):?>
					  <a onClick="javascript:return confirm('是否确认这个商品已经发货？')" class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItemStautsGo&status=3&id='.$cart["cartID"].'&order_id='.$this->_tpl_vars["IN"]["order_id"]));?>">发货</a>
					  <?php endif;?>
					   <?php if($cart["order_item_status"]==3):?>
					   <a onClick="javascript:return confirm('您的这个操作将会发送一封邮件提醒买家确认收货，请确认您的操作。')" href="" class="pink_link">提醒收货</a>
					    <?php endif;?>
					</td>
				</tr>
				<?php if(trim($cart["itemNotes"])!=""):?>
				<tr>
					<td colspan=2>
						 <div class="item_info_box">
						 <h2>备注信息</h2>
						<?php echo $cart["itemNotes"];?>
						</div>
					</td>
				</tr>
				<?php endif;?>
				<tr>
					<td>

					</td>
					<td colspan=2 style="text-align:right;"><span style="font-weight:bold;">商品总价：</span><?php echo number_format($cart["itemPrice"] * $cart["ItemQTY"], 2, '.', ',');?> </td>
					<td>
						&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;">总价：</span><?php echo number_format($cart["itemPrice"] * $cart["ItemQTY"] + $cart["itemFreight"], 2, '.', ',');?>

					</td>
				</tr>
			</table>
			</form>
		<?php endforeach;?>
		</div>
	</div>
	<form id="order_info_form" action="index.php" method="post">
	<input type="hidden" name="action" value="cms"/>
	<input type="hidden" name="method" value="orderInfoUpdate"/>
	<input type="hidden" name="orderNo" value="<?php echo $order["OrderNo"];?>"/>
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["order_id"];?>"/>
	<input type="hidden" name="order_type" value="GROUP BUY"/>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">订单信息</div>
		</div>
		<table class="order_detail">
			<tr>
				<td style="vertical-align:top" width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">订单号：</th>
							<td style="text-align:center;"><?php echo $order["OrderNo"];?></td>
						</tr>
						<tr>
							<th>商品总金额：</th>
							<td style="text-align:right;padding-right: 5px;"><?php echo $order["order_amount"];?></td>
						</tr>
						<tr>
							<th>卖家总运费：</th>
							<td style="text-align:right;padding-right: 5px;">
							<?php echo $order["order_freight"];?>
							</td>
						</tr>
						<!--
						<tr>
							<th>国内运费：</th>
							<td><input class="table_input" type="text" name="domestic_freight" value="0"/></td>
						</tr>
						<tr>
							<th>国际运费：</th>
							<td><input class="table_input" type="text" name="international_freight" value="0"/></td>
						</tr>
						 -->
 						<tr>
							<th>应收服务费：</th>
							<td style="text-align:right;padding-right: 5px;"><?php echo $order["service_fee"];?></td>
						</tr>
						<tr>
							<th>修改服务费：</th>
							<td>
							<input type="text" <?php if($order["orderStatus"]>5){echo "disabled='disabled'";}?> class="table_input" name="service_fee" value="<?php if($order["changed_service_fee"]<0){echo "";}else{echo $order["changed_service_fee"];}?>"/>
							</td>
						</tr>
						<tr>
							<th>优惠代码：</th>
							<td></td>
						</tr>
						<tr>
							<th>优惠价格：</th>
							<td></td>
						</tr>
					<!--
						<tr>
							<th>其他费用：</th>
							<td><input type="text" class="table_input" name="other_fee" value="0"/></td>
						</tr>
					 -->
					</table>
				</td>
				<td style="vertical-align:top" width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">下单日期：</th>
							<td style="text-align:center;"><?php echo date("Y-m-d H:i:s",$order["orderTime"]);?></td>
						</tr>
						<tr>
							<th>支付日期：</th>
							<td style="text-align:center;"><?php echo $order["payTime"];?></td>
						</tr>
						<tr>
							<th>支付方式：</th>
							<td style="text-align:center;">
							<?php if($order["orderStatus"]>4):?>
							<?php echo runFunc("getOrderPayment",array($order["orderID"]));?>
							<?php endif;?>
							</td>
						</tr>
						<?php if($order["payment"]==1):?>
						<tr>
							<th>paypal支付金额：</th>
							<td style="text-align:center;">
							$ <?php echo $order["paypal_pay"];?>
							</td>
						</tr>
						<?php endif;?>
					</table>
					<table class="order_detail_table">
					<tr>
					<td style="text-align:right" width="30%">交易问题：</td>
					<td style="text-align:left;padding: 5px 5px;">
				<!-- 	<select name="shipping_mode" id="">
						<option value="1">快递</option>
						<option value="2">EMS</option>
						<option value="3">平邮</option>
					</select>
				 -->
				 <?php echo $order["problem"];?>
				 	</td>
				 	</tr>
					</table>
					</td>
			</tr>
		</table>
		<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		<table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">发票：</th>
							<td style="text-align:center;">
								<?php if($order["invoice"]>0){
									echo "需要";
								}else{

									echo "不需要";
								}?>
							</td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">税金：</th>
							<td style="text-align:center;">
							<?php echo $order["tax"];?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		 <table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">采购日期：</th>
							<td style="text-align:center;"><?php echo $order["purchaseTime"];?></td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">发货日期：</th>
							<td style="text-align:center;"><?php echo $order["shippingTime"];?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table> -->
		<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		<table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">总金额：</th>
							<td style="text-align:center;"><?php echo $order["totalAmount"];?></td>
						</tr>
					</table>
				</td>
				<td width="50%">
				<?php if($order["orderStatus"]==4):?>
					<a id="save_order_info" style="display:block;width:80px;height:20px;line-height:20px;margin:auto;text-align:center" class="item_update_button">更新订单信息</a>
				<?php endif;?>
				</td>
			</tr>
		</table>
	</div>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">购买会员信息</div>
		</div>
		<?php
				if(is_numeric($order["orderUser"])){
					$userinfo=runFunc('getStaffInfoById',array($order["orderUser"]));?>

					<table class="order_detail">
			<tr>
			<td width="50%" style="vertical-align:top;">
					<table class="order_detail_table order_member_detail">
						<tr>
							<th width="30%">昵称：</th>
							<td style="text-align:center;"><?php echo $userinfo[0]["staffName"];?></td>
						</tr>
						<tr>
							<th width="30%">姓名：</th>
							<td style="text-align:center;"><?php echo $userinfo[0]["staffNo"]?></td>
						</tr>
						<tr>
							<th width="30%">Email地址：</th>
							<td style="text-align:center;"><?php echo $userinfo[0]["email"]?></td>
						</tr>
					</table>
				</td>
				<td style="vertical-align:top;">
					<table class="order_detail_table">
						<tr>
							<th width="30%">收货人姓名：</th>
							<td style="text-align:center;"><?php echo $order["fullName"];?></td>
						</tr>
						<tr>
							<th width="30%">Email地址：</th>
							<td style="text-align:center;"><?php echo $order["email"];?></td>
						</tr>
						<tr>
							<th width="30%">联系电话：</th>
							<td style="text-align:center;"><?php echo $order["cellphone"];?> , <?php echo $order["telephone"];?></td>
						</tr>
						<tr>
							<th width="30%">地区：</th>
							<td style="text-align:center;"><?php echo $order["country"]." ".$order["province"]." ".$order["city"];?></td>
						</tr>
						<tr>
							<th width="30%">地址：</th>
							<td style="text-align:center;"><?php echo $order["address1"];?> <?php echo $order["address2"];?></td>
						</tr>
						<tr>
							<th width="30%">邮编：</th>
							<td style="text-align:center;"><?php echo $order["zipcode"];?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

					<?php
				}else{
					echo "未注册用户";
				};?>
		<br/><br/><br/><br/>
	</div>
</form>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>