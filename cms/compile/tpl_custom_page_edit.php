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

$CKEditor->config['toolbar'] = "Full";
$CKEditor->config['height'] = "800";

$item = runFunc("getCustomPage",array($this->_tpl_vars["IN"]["id"]));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑活动页
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="custom_page_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>基本信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>名称：</th>
					<td>
						<input type="text" name="title" class="dark_border input_bar_long required" value="<?php echo $item[0]["title"];?>"/>
					</td>
				<tr>
				<tr>
					<th>活动页位置：</th>
					<td> 
						<select name="position" id="position" class="required">
							<option value="">请选择</option>
							<option <?php if($item[0]["position"] == 1){echo "selected='selected'";}?> value="1">SHOPPING</option>
							<option <?php if($item[0]["position"] == 2){echo "selected='selected'";}?> value="2">COLLECTION</option>
						</select>
					</td>
				</tr>
				<tr>
				<th>状态：</th>
					<td>
						<input type="radio" <?php if($item[0]["publish"] == 1){echo "checked='checked'";}?> value="1" name="publish" id="publish_1"/> <label class="cp" for="publish_1">发布</label>
						&nbsp;&nbsp;&nbsp;
						<input type="radio" <?php if($item[0]["publish"] == 0){echo "checked='checked'";}?> value="0" name="publish" id="publish_2"/> <label class="cp" for="publish_2">不发布</label>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset id="adv_type_2_box" class="admin_fieldset">
		<legend>页面内容</legend>
		<?php $CKEditor->editor("content",$item[0]["content"]);?>
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