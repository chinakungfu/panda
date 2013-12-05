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

$items = runFunc("getManagerPermission",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"]));
	
$count = runFunc("getManagerPermission",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"]));
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
			权限列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="manager_permission">批量删除</a>
			</li>
		</ul>
	</div>

	<div class="filter_bar">
		
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="25%">权限名称</th>
			<th width="40%">操作权限</th>
			<th width="15%">创建时间</th>
			<th width="15%">操作</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="25%"><?php echo $item["name"]?></td>
			<td width="40%">
				<?php $permission_array = json_decode($item["permission"]);?>
				<?php foreach($permission_array as $permission):?>
				
				<?php echo $_GLOBAL['permission_'.$permission];?>
				<?php endforeach;?>
			</td>
			<td width="15%"><?php echo $item["created"];?></td>
			<td width="15%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=manager_permission_edit&id='.$item["id"].'&type=main'));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除该管理员')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=manager_permission_delete&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","manager_permission_list",'users',$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
