<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("getManagerPermissionById",array($this->_tpl_vars["IN"]["id"]));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑管理员权限
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=manager_permission_list&type=main'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="manager_permission_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>权限信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>权限名称：</th>
					<td><input type="text" name="name" class="dark_border input_bar_long required" value="<?php echo $item[0]["name"];?>"/></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		   <legend>权限详情</legend>
		  	<table class="admin_edit_table">
				<tr>
					<th style="vertical-align:top">操作权限：</th>
					<td>
					<?php $permission_array = json_decode($item[0]["permission"]);?>
						<input type="checkbox" name="permission[]" <?php if(in_array("map", $permission_array)){echo 'checked="checked"';}?>  id="main_permission" value="map"/> <label for="main_permission">全局管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("up", $permission_array)){echo 'checked="checked"';}?>" id="user_permission" value="up" /> <label for="user_permission">会员管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("op", $permission_array)){echo 'checked="checked"';}?> id="order_permission" value="op" /> <label for="order_permission">订单管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("ip", $permission_array)){echo 'checked="checked"';}?> id="item_permission"  value="ip" /> <label for="item_permission">商品管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("sp", $permission_array)){echo 'checked="checked"';}?> id="share_permission" value="sp" /> <label for="share_permission">分享管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("mp", $permission_array)){echo 'checked="checked"';}?> id="media_permission" value="mp" /> <label for="media_permission">媒体管理</label>
						<br /><br />
						<input type="checkbox" name="permission[]" <?php if(in_array("tp", $permission_array)){echo 'checked="checked"';}?> id="total_permission" value="tp" /> <label for="total_permission">统计报表</label>
					</td>
				</tr>	
			</table>
		  </fieldset>
		</form>
	</div>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>