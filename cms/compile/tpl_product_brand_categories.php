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

$items = runFunc("getAdminBrandCategories",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["status"]));
	
$count = runFunc("getAdminBrandCategories",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["status"]));
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
			品牌分类列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="brand_category">批量删除</a>
			</li>
		</ul>
	</div>
	<div class="search_bar">
		
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products'));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products&status=1'));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products&status=2'));?>">未发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products&status=3'));?>">推荐</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "4"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products&status=4'));?>">不推荐</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="35%">分类名称</th>
			<th width="15%">发布状态</th>
			<th width="10%">推荐</th>
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
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="35%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_category_edit&id='.$item["id"].'&type=products'));?>"><?php echo $item["name"];?></a></td>
			<td width="15%"><?php echo $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="10%"><?php echo  $_GLOBAL['special_'.$item["special"]];?></td>
			<td width="25%"><?php echo $item["created"];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_category_edit&id='.$item["id"].'&type=products'));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除该分类')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_category_delete&id='.$item["id"].'&type=products'));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","brand_categories","products&status=".$this->_tpl_vars["IN"]["status"],$page,$this->_tpl_vars["IN"]["order_status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["search_type"]));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>