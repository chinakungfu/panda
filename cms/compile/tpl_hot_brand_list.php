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

$items = runFunc("getAdminHotBrands",array($this->_tpl_vars["IN"]["page"],15));
	
$count = runFunc("getAdminHotBrands",array($this->_tpl_vars["IN"]["page"],15,true));
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
			热门品牌列表
		</div>

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
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="20%">品牌名称</th>
			<th width="20%">所属分类</th>
			<th width="25%">发布状态</th>
			<th width="25%">创建日期</th>
			<th width="10%">操作</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_edit&id='.$item["id"].'&type=products'));?>"><?php echo $item["name"];?></a></td>
			<td width="20%"><?php $category = runFunc("getAdminHotBrandCategory",array($item["cat_id"]));echo $category[0]["name"];?></td>
			<td width="25%"><?php echo $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="25%"><?php echo $item["created"];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_edit&id='.$item["id"].'&type=products'));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除该分类')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_delete&id='.$item["id"].'&type=products'));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","hot_brand_list","products",$page,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
