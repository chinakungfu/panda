<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

?>
<?php


$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	
	$page = 1;
}

$group_buys = runFunc('getFailedGroupBuy',array($page,15,false,$this->_tpl_vars["IN"]["gid"]));

$group_buy_count = runFunc('getFailedGroupBuy',array(1,1,true));
?>
<div class="cms_main_box">
<div class="cms_left fl">
<?php
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
			订单列表
		</div>
	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			
		<!--	<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="orders"/>
			<input type="hidden" name="type" value="orders"/>
			<input type="hidden" name="order_status" value="<?php echo $this->_tpl_vars["IN"]["order_status"];?>"/>
			<select class="fr" name="search_type" id="search_type">
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==1){echo "selected=selected";}?> value="1">用户名</option>
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==2){echo "selected=selected";}?> value="2">订单号</option>
			</select>-->
		</form>
	</div>

	
	<div class="admin_list_box">
		<?php if(count($group_buy_items>0)):
		$i = 1;
		foreach($group_buys as $group_buy):
		
		$goods = runFunc("getAdminGoodsById",array($group_buy["goods_id"]));
	?>
	<table class="order_list pink">
		<tr>
		<td colspan=6 style="background:none repeat scroll 0 0 #C8CCCF;font-weight:bold;"><?php echo $group_buy["item_name"];?></td>
		</tr>
		<tr>
			<td width="15%">价格：￥<?php echo number_format($goods["goodsUnitPrice"], 2, '.', '')?></td>
			<td width="15%">运费：￥<?php echo number_format($goods["goodsFreight"], 2, '.', '')?></td>
			<td width="15%">团购类型：<?php echo $_GLOBAL['group_buy_'.$group_buy["sell_way"]];?><?php echo $group_buy["price_rate"]*10?>折</td>
			<td width="15%">团购规则：满<?php echo $group_buy["group_size"];?>人</td>
			<td width="15%">实际团购人数：<?php echo $group_buy["count"];?></td>
			<td width="20%">结束时间：<?php echo $group_buy["end_time"];?></td>
		</tr>
	</table>
	<?php $carts = runFunc("getGroupBuyCartByGid",array($group_buy['id']));?>
	<table class="group_order_item_table">
		<tr>
			<th width="20%">订单号</th>
			<th width="20%">购买人</th>
			<th width="20%">付款金额</th>
			<th width="20%">退款时间</th>
			<th width="20%">操作</th>
		</tr>
	<?php foreach ($carts as $cart):?>
	<?php $order = runFunc('getOrder',array($cart["order_id"]));?>
		<tr>
			<td><a class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItem&order_id='.$order["orderID"].'&type=orders'));?>"><?php echo $order["OrderNo"];?></a></td>
			<td>
			
	<?php 
				if(is_numeric($cart["UserName"])){
					$userinfo=runFunc('getStaffInfoById',array($cart["UserName"]));
					echo $userinfo[0]["staffName"];
				}else{
					echo "未注册用户";
				};?></td>
			<td><?php
			$settings = runFunc("adminGetGlobalSetting");
			if($group_buy["sell_way"]==1){
					$service_fee = $cart["itemPrice"] * $settings[0]['service_fee'] * $group_buy["price_rate"];

				}else{

					$service_fee = $cart["itemPrice"] * $settings[0]['service_fee'] ;
				}

			if($cart["tax"]==1){
				
				$price = ($cart["itemFreight"] + $cart["itemPrice"] + $service_fee)*(1+$settings[0]["tax_rate"]);
			}else{
				
				$price = ($cart["itemFreight"] + $cart["itemPrice"] + $service_fee);
			}
			 echo "￥ ".number_format($price, 2, '.', '');?>
			 <?php if($cart["tax"]==1){
			 	
			 	echo "(含发票)";
			 }?>
			 </td>
			
			<td>
			<?php if($cart["pay_back_time"]!=""):?>
				<?php echo $cart["pay_back_time"];?>
			<?php else:?>
			
				--
			<?php endif;?>
			</td>
			<td>
			<?php if($cart["pay_back"]==0):?>
			<a class="pink_link" onClick="javascript: return confirm('是否确认退款?')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyPayBack&cart_id='.$cart["cartID"].'&user_id='.$cart["UserName"]));?>">退款</a>
			<?php else:?>
			已退款
			<?php endif;?>
			</td>
		</tr>
	<?php endforeach;?>

	</table>
<?php endforeach;?>
	<?php endif;?>
	</div>
	<?php if($this->_tpl_vars["IN"]["gid"]!=""):?>
	<?php echo runFunc("adminPageNavi",array($group_buy_count[0]["count"],15,"cms","orders","groupFailed",$page));?>
	<?php endif;?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>