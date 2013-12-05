<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

?>
<?php
if($this->_tpl_vars["IN"]["delete_order"]!=""){
	runFunc("deleteOrder",array($this->_tpl_vars["IN"]["delete_order"]));
}

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	
	$page = 1;
}

$orders = runFunc('adminGetGroupBuyOrders',array($page,15,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));
$orders_count = runFunc('adminGetGroupBuyOrders',array(1,1,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"],true));
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
				<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>">清空搜索条件</a>
			<a class="excel fr" href="">导出</a>
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
	 <div class="filter_bar">
		<!--<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">全部订单</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "-1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=-1&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">已取消</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "4"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=4&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">待付款</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "5"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=5&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">待采购</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "6"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=6&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">待发货</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "7"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=7&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">已发货</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "8"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&order_status=8&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=orders'));?>">已完成</a></li>
		</ul> -->
	</div>
	
	<div class="admin_list_box">
		<?php if(count($orders>0)):
		$i = 1;
		foreach($orders as $order):
	?>
	<table class="order_list pink">
		<tr>
			<td width="15%">订单号：<a href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItem&cart_id='.$group_buy_item["cartID"].'&order_id='.$order["orderID"].'&type=orders'));?>"><?php echo $order["OrderNo"];?></a></td>
			<td width="15%">用户名：<?php 
				if(is_numeric($order["orderUser"])){
					$userinfo=runFunc('getStaffInfoById',array($order["orderUser"]));
					echo $userinfo[0]["staffName"];
				}else{
					echo "未注册用户";
				};?>
			</td>
			<td width="15%">订单状态：<?php echo runFunc("getOrderStatusAdmin",array($order["orderStatus"]));?></td>
			<td width="15%">总金额：￥<?php echo $order["totalAmount"];?></td>
			<td width="20%">下单日期：<?php echo date("Y-m-d H:i:s",$order["orderTime"]);?></td>
		</tr>
	</table>

	<?php $group_buy_items = runFunc("adminGetGroupBuyOrderItems",array($order["cartIDstr"]));?>
		<table class="group_order_item_table">
		<tr>
			<th width="50%">商品名称</th>
			<th width="20%">团购类型</th>
			<th width="10%">发货状态</th>
			<th width="10%">团购状态</th>
			<th width="10%">操作</th>
		</tr>
	<?php foreach($group_buy_items as $group_buy_item):?>
	<?php $group_goods = runFunc("getMemberGroupBuyItem",array($group_buy_item["id"]));?>

		<tr>
			<td ><?php echo $group_buy_item["item_name"];?></td>
			<td ><?php if($group_buy_item["sell_way"]==1){echo "服务费打折";}else{echo "单价打折";}?></td>
			<td ><?php $purchase_count = runFunc("getAdminGroupPurchasedCount",array($group_buy_item["id"]));?>
				<?php if($group_buy_item["group_size"]>$purchase_count[0]["count"] and $group_buy_item["end_time"]<date("Y-m-d")):?>
				团购失败
				<?php if($order["orderStatus"]>4):?>
				<?php if($group_buy_item["pay_back_time"]!=""):?>
				已退款
				<?php else:?>
				
				需退款
				<?php endif;?>
				<?php endif;?>
				<?php elseif($group_buy_item["group_size"]>$purchase_count[0]["count"] and $group_buy_item["end_time"]>=date("Y-m-d")):?>
				未成团
				<?php else:?>
				<?php echo $_GLOBAL['item_status_'.$group_buy_item["order_item_status"]];?>
				<?php endif;?>
			</td>
			<td>
			
				<?php if($group_buy_item["end_time"]<date("Y-m-d")):?>
				团购结束 
				
				<?php else:?>
				进行中
				<?php endif;?>
			</td>
			<td>
			
			<a style="color:#ED5E83" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyOrderItem&cart_id='.$group_buy_item["cartID"].'&order_id='.$order["orderID"].'&type=orders'));?>">处理</a>
			
			</td>
		</tr>
	
	<?php endforeach;?>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($orders_count[0]["count"],15,"cms","orders","orders",$page,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>