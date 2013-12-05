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

$items = runFunc("adminGetCircleCategories",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["status"]));
	
$count = runFunc("adminGetCircleCategories",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["status"]));


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
			商店分类列表
		</div>
		<ul class="fr ctrl_link">
			
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="circle_category">批量删除</a>
			</li>
		</ul>
	</div>
<div class="search_bar">

	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category&type=share'));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category&type=share&status=1'));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category&type=share&status=2'));?>">不发布</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="55%">名称</th>
			<th width="30%">状态</th>
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
			<td style="text-align:left;padding:0 10px;" width="55%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category_edit&id='.$item["id"].'&type=share'));?>"><?php echo $item["title"];?></a></td>
			<td width="30%"><?php echo $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category_edit&id='.$item["id"].'&type=share'));?>">查看</a> | <a onClick="javascript:return confirm('是否确认删除该分类？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_category_delete&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","circle_category",'share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
