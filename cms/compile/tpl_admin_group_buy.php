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

$items = runFunc("getAdminGroupBuyItems",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["status"]));
	
$count = runFunc("getAdminGroupBuyItems",array($this->_tpl_vars["IN"]["page"],15,true));
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
			官方团购列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_5"><a href="">回收站</a></li>
		</ul>
	</div>
	<div class="search_bar">
		<!-- <form action="index.php" method="post">
				<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orders&type=orders'));?>">清空搜索条件</a>
			<a class="excel fr" href="">导出</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="orders"/>
			<input type="hidden" name="type" value="orders"/>
			<input type="hidden" name="order_status" value="<?php echo $this->_tpl_vars["IN"]["order_status"];?>"/>
			<select class="fr" name="search_type" id="search_type">
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==1){echo "selected=selected";}?> value="1">用户名</option>
				<option <?php if($this->_tpl_vars["IN"]["search_type"]==2){echo "selected=selected";}?> value="2">订单号</option>
			</select>
		</form> -->
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuy&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=share'));?>">全部团购</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuy&status=2&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=share'));?>">进行中</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuy&status=3&search_word='.$this->_tpl_vars["IN"]["search_word"].'&search_type='.$this->_tpl_vars["IN"]["search_type"].'&type=share'));?>">已结束</a></li>
			<li>|</li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="30%">团购产品</th>
			<th width="15%">状态</th>
			<th width="10%">团购结果</th>
			<th width="10%">参团人数</th>
			<th width="10%">开始日期</th>
			<th width="10%">结束日期</th>
			<th width="15%">操作</th>
		</tr>
	</table>

	
		<?php if(count($items>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="30%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuyEdit&id='.$item["id"].'&type=share'));?>">
				<?php if(strlen($item["item_name"])> 20){	
					echo mb_substr($item["item_name"],0,20,'utf-8')."...";
					}else{
						echo $item["item_name"];
					}?></a></td>
			
			<td width="15%">
			<?php if($item["published"]==0){echo "阻止发布";}
					elseif($item["start_time"]==""){echo "待审核";}
					elseif($item["end_time"]<date("Y-m-d")){echo "已结束";}
					elseif($item["end_time"]>=date("Y-m-d")){echo "进行中";}
			?>
			</td>
			
			<td width="10%"><?php if($item["count"] < $item["group_size"]){echo "未成团";}else{ echo "团购成功";}?></td>
			<td width="10%"><?php echo $item["count"];?></td>
			<td width="10%"><?php echo $item["start_time"];?></td>
			<td width="10%"><?php echo $item["end_time"];?></td>
			<td width="15%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuyEdit&id='.$item["id"].'&type=share'));?>"><?php if($item["start_time"]!="" and strtotime($item["end_time"])>time()){echo "编辑";}elseif($item["start_time"]==""){echo "审核";}elseif(strtotime($item["end_time"])<time()){echo "编辑";}?></a> | <a onClick="javascript:return confirm('是否确认删除该团购')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupBuyDelete&id='.$item["id"]));?>">删除</a><?php if($item["start_time"]!="" and $item["end_time"]<date("Y-m-d") and $item["count"] < $item["group_size"] and $item["count"]>0):?> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=groupFailed&type=orders&gid='.$item["id"]));?>">退款</a><?php endif;?></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminGroupBuyPageNavi",array($count[0]["count"],15,"cms","adminGroupBuy","share",$page,$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>