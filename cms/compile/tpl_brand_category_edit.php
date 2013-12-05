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

$item = runFunc("getAdminBrandCategory",array($this->_tpl_vars["IN"]["id"]));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑品牌分类
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_categories&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="brand_category_save" />
		<input type="hidden" name="id" value="<?php echo $item[0]["id"];?>"/>
			<table class="admin_edit_table">
				<tr>
					<th>分类名称</th>
					<td><input type="text" name="name" id="name" class="dark_border input_bar_long required" value="<?php echo $item[0]["name"]?>"/></td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input <?php if($item[0]["published"]==1)echo 'checked="checked"';?>  id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input <?php if($item[0]["published"]==0)echo 'checked="checked"';?> id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>推荐</th>
					<td>
						<input <?php if($item[0]["special"]==1)echo 'checked="checked"';?> id="special" type="radio" value="1" name="special"/>
						<label for="special">推荐</label>
						&nbsp;&nbsp;
						<input <?php if($item[0]["special"]==0)echo 'checked="checked"';?> id="unspecial" type="radio" value="0" name="special"/>
						<label for="unspecial">不推荐</label>
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