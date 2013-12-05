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

$item = runFunc("getAdminHotBrand",array($this->_tpl_vars["IN"]["id"]));

$cats = runFunc("getAdminHotBrandCategories",array(1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑热门品牌
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=hot_brand_list&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="hot_brand_save" />
		<input type="hidden" name="id" value="<?php echo $item[0]["id"];?>"/>
			<table class="admin_edit_table">
				<tr>
					<th>热门品牌名称</th>
					<td><input type="text" name="name" id="name" class="dark_border input_bar_long required" value="<?php echo $item[0]["name"]?>"/></td>
				</tr>
				<tr>
					<th>所属分类</th>
					<td>
					<select name="cat_id" id="cat_id">
					<?php foreach($cats as $cat):?>
						<option <?php if($cat["id"]==$item[0]["cat_id"])echo "selected='selected'"?> value="<?php echo $cat["id"]?>"><?php echo $cat["name"]?><?php if($cat["published"]==0)echo"(未发布)";?></option>
					<?php endforeach;?>
					</select>
				</td>
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
					<th>网址</th>
					<td><input type="text" name="link" id="link" class="dark_border input_bar_long required" value="<?php echo $item[0]["link"]?>"/></td>
				</tr>
				<tr>
					<th>LOGO</th>
					<td><input type="file" name="brand_logo" /></td>
				</tr>
				<tr>
					<td></td>
					<td><img src="brand_logo/hot_brand_<?php echo $item[0]["id"]?>.<?php echo $item[0]["img"]?>" alt="" />
					<input type="hidden" name="file_type" value="<?php echo $item[0]["img"]?>"/></td>
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