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

	$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["delete_order"]));
	$uid=runFunc('readSession',array());
	runFunc("makeAdminLog",array("删除ivision订单 ".$order["OrderNo"],$uid));

	runFunc("deleteOrder",array($this->_tpl_vars["IN"]["delete_order"]));
}

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}

$orders = runFunc('wowOrderList',array($page,15,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"],false,$this->_tpl_vars["IN"]["month"],$this->_tpl_vars["IN"]["year"]));
$orders_count = runFunc('wowOrderList',array(1,1,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"],true,$this->_tpl_vars["IN"]["month"],$this->_tpl_vars["IN"]["year"]));
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
				<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&type=orders_wow'));?>">清空搜索条件</a>
			<a class="excel fr" href="">导出</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="orders_wow"/>
			<input type="hidden" name="type" value="orders_wow"/>
			<input type="hidden" name="order_status" value="<?php echo $this->_tpl_vars["IN"]["order_status"];?>"/>
			<select class="select_filter fr" name="search_type" id="search_type">
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==1){echo "selected=selected";}?> value="1">用户名</option>
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==2){echo "selected=selected";}?> value="2">订单号</option>
			</select>
			<select id="month" class="select_filter fr" name="month">
				<option value="">选择月份</option>
				<?php for($i=1;$i<=12;$i++):?>
				<option <?php if($this->_tpl_vars["IN"]["month"] == $i){echo "selected=selected";}?> value="<?php echo $i?>"><?php echo $i;?>月</option>
				<?php endfor;?>
			</select>
			<select id="year" class="select_filter fr" name="year">
				<option value="">选择年份</option>
				<?php for($y=2012;$y<=date("Y");$y++):?>
				<option <?php if($this->_tpl_vars["IN"]["year"] == $y){echo "selected=selected";}?> value="<?php echo $y?>"><?php echo $y;?>年</option>
				<?php endfor;?>
			</select>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">全部订单</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "-1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=-1&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">已取消</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "4"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=4&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">待付款</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "5"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=5&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">待采购</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "6"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=6&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">待发货</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "7"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=7&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">已发货</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "7.1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=7.1&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">已送达</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "8"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=8&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">已完成</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["order_status"] == "99"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders_wow&order_status=99&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&month='.$this->_tpl_vars["IN"]["month"].'&year='.$this->_tpl_vars["IN"]["year"].'&type=orders_wow'));?>">有退款</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="15%">订单号</th>
			<th width="20%">用户名</th>
			<th width="15%">订单状态</th>
			<th width="10%">总金额</th>
			<th width="15%">下单日期</th>
			<th width="15%">发货日期</th>
			<th width="10%">有退款</th>
		</tr>
	</table>

		<?php if(count($orders>0)):
		$i = 1;
		foreach($orders as $order):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>

			<td width="15%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=order&id='.$order["orderID"].'&type=orders_wow&page='.$page));?>"><?php echo $order["OrderNo"];?></a></td>
			<td width="20%" style="font-size:11px;">
			<a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$order["orderUser"].'&type=users'));?>">
			<?php
				if(is_numeric($order["orderUser"])){
					$userinfo=runFunc('getStaffInfoById',array($order["orderUser"]));
					echo $userinfo[0]["staffName"];
				}else{
					echo "未注册用户";
				};?>
				</a>
			</td>
			<td width="15%"><?php echo runFunc("getOrderStatusAdmin",array($order["orderStatus"]));?></td>
			<td width="10%">￥<?php echo $order["totalAmount"];?></td>
			<td width="15%"><?php echo date("Y-m-d H:i:s",$order["orderTime"]);?></td>
			<td width="15%"><?php echo $order["shippingTime"];?></td>
			<td width="10%"><?php if($order["order_return"]>0){echo "<font style='font-weight:bold;color:red'>是</font>";}else{echo "否";}?></td>
		</tr>
	</table>


	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($orders_count[0]["count"],15,"cms","orders","orders&month=".$this->_tpl_vars["IN"]["month"]."&year=".$this->_tpl_vars["IN"]["year"],$page,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>