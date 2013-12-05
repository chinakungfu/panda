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
$item = runFunc("getItemById",array("cms_product_prop",$this->_tpl_vars["IN"]["id"]));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑属性
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=prop_list&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="prop_save" />
		<input type="hidden" name="id" value="<?php echo $item["id"];?>" />
			<table class="admin_edit_table">
				<tr>
					<th>属性名称</th>
					<td><input type="text" name="title" id="title" class="dark_border input_bar_long required" value="<?php echo $item["title"];?>"/></td>
				</tr>
				<tr>
					<th style="vertical-align: top">属性参数</th>
					<td>
						<?php $values = runFunc("getPropValues",array($this->_tpl_vars["IN"]["id"]));?>
						<?php if(count($values)>0):?>
						<?php foreach ($values as $value):?>
						<div class="add_input"><input type="text" value="<?php echo $value["value"];?>" name="attr[]" class="dark_border input_bar_long"/> <a onClick="add_attr(this)" class="add_attr cp">添加</a> | <a onClick="del_attr(this)" class="del_attr cp">删除</a></div>
						<?php endforeach;?>
						<?php else:?>
						<div class="add_input"><input type="text" name="attr[]" class="dark_border input_bar_long"/> <a onClick="add_attr(this)" class="add_attr cp">添加</a></div>
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input <?php if($item["published"] == 1){echo 'checked="checked"';}?> id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input <?php if($item["published"] == 0){echo 'checked="checked"';}?> id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
			</table>
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