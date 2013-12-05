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
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			添加品牌
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="brand_save" />
			<table class="admin_edit_table">
				<tr>
					<th>品牌或专卖店名称</th>
					<td><input type="text" name="title" id="title" class="dark_border input_bar_long"/></td>
				</tr>
				<tr>
					<th>设计师或店主</th>
					<td><input type="text" name="owner" id="owner" class="dark_border input_bar_long"/></td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input checked="checked" id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>发布类型</th>
					<td>
						<input checked="checked" id="publish_type_1" type="radio" value="1" name="publish_type"/>
						<label for="publish_type_1">普通品牌</label>
						&nbsp;&nbsp;
						<input id="publish_type_2" type="radio" value="2" name="publish_type"/>
						<label for="publish_type_2">品牌店</label>
					</td>
				</tr>
				<tr>
					<th>网址</th>
					<td><input type="text" name="link" id="link" class="dark_border input_bar_long"/></td>
				</tr>
				<tr>
					<th>LOGO</th>
					<td><input type="file" name="brand_logo" /></td>
				</tr>
				<tr>
					<th>品牌描述</th>
					<td>
						<textarea class="dark_border textarea_bar_md" name="description"  cols="30" rows="10"></textarea>
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