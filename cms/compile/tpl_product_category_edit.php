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


$item = runFunc("getItemById",array("cms_product_category",$this->_tpl_vars["IN"]["id"]));
$parents = runFunc("getItemList",array("cms_product_category",1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑产品分类
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_category_list&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="id" value="<?php echo $item["id"];?>" />
		<input type="hidden" name="method" value="product_category_save" />
			<table class="admin_edit_table">
				<tr>
					<th>分类名称</th>
					<td><input type="text" name="title" id="title" class="dark_border input_bar_long required" value="<?php echo $item["title"];?>"/></td>
				</tr>
				<tr>
					<th style="vertical-align: top">上级分类</th>
					<td>
					<select name="parent_id" id="parent_id">
					<option value="0">顶层</option>
					<?php foreach ($parents as $parent):?>
					<?php if($parent["id"] == $item["id"])continue;?>
					<option <?php if($item["parent_id"]==$parent["id"]){echo "selected=selected";}?> value="<?php echo $parent["id"]?>"><?php echo $parent["title"]?></option>
					<?php endforeach;?>
					</select>
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