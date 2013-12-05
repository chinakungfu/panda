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

<?php 
$brand =  runFunc("getBrandById",array($this->_tpl_vars["IN"]["id"]));
$tags = runFunc("getAdminBrandtags",array(1,10000,false,"asc"));
$categories = runFunc("getAdminBrandCategories",array(1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑品牌
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="id" value="<?php echo $brand["id"];?>" />
		<input type="hidden" name="method" value="brand_save" />
			<table class="admin_edit_table">
				<tr>
					<th>品牌或专卖店名称</th>
					<td><input type="text" name="title" id="title" class="dark_border input_bar_long required" value="<?php echo $brand["title"];?>"/></td>
				</tr>
				<tr>
					<th>设计师或店主</th>
					<td><input type="text" name="owner" id="owner" class="dark_border input_bar_long" value="<?php echo $brand["owner"];?>"/></td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input <?php if($brand["published"] == 1){echo 'checked="checked"';}?> id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input <?php if($brand["published"] == 0){echo 'checked="checked"';}?> id="unpublish" type="radio" value="0" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>推荐</th>
					<td>
						<input <?php if($brand["special"]==1)echo 'checked="checked"';?> id="special" type="radio" value="1" name="special"/>
						<label for="special">推荐</label>
						&nbsp;&nbsp;
						<input  <?php if($brand["special"]==0)echo 'checked="checked"';?> id="unspecial" type="radio" value="0" name="special"/>
						<label for="unspecial">不推荐</label>
						&nbsp;&nbsp;
						<input <?php if($brand["special"]==2)echo 'checked="checked"';?> id="specialindex" type="radio" value="2" name="special"/>
						<label for="specialindex">首页推荐</label>                       
					</td>
				</tr>
				<tr>
					<th>发布类型</th>
					<td>
						<input <?php if($brand["publish_type"] == 1){echo 'checked="checked"';}?> id="publish_type_1" type="radio" value="1" name="publish_type"/>
						<label for="publish_type_1">普通品牌</label>
						&nbsp;&nbsp;
						<input <?php if($brand["publish_type"] == 2){echo 'checked="checked"';}?> id="publish_type_2" type="radio" value="2" name="publish_type"/>
						<label for="publish_type_2">品牌店</label>
					</td>
				</tr>
				<tr>
					<th>品牌店分类</th>
					<td>
					<select name="category_id" id="category_id">
						<option value="0">无分类</option>
						<?php foreach($categories as $category):?>
						<option <?php if($category["id"] == $brand["category_id"]){echo "selected='selected'";}?> value="<?php echo $category["id"];?>"><?php echo $category["name"];?><?php if($category["published"]==0){echo "(不发布)";}?></option>
						<?php endforeach;?>
					</select>
					
					</td>
				</tr>
				<tr>
					<th>标签</th>
					<td>
						<div class="tag_add_box oh">
							<?php $goods_tags =  runFunc("getBrandTags",array($brand["id"]));?>
							<?php foreach ($goods_tags as $goods_tag):?>
							<div id="<?php echo $goods_tag["id"]?>" class="ex_tag_item add_item_sm_box fl">
							<?php echo $goods_tag["name"];?>
							<input type="hidden" value="<?php echo $goods_tag["id"]?>" name="tags[]">
							</div>
							<?php endforeach;?>
						</div>	
					</td>
				</tr>
				<tr>
					<th style="vertical-align: top;">选择标签</th>
					<td>
					<div class="tag_select_box" style="margin-top:0">
						<?php foreach ($tags as $tag):?>
						<div id="<?php echo $tag["id"]?>" class="tag_item add_item_sm_box fl">
							<?php echo $tag["name"];?>
						</div>
						<?php endforeach;?>
					</div>
					</td>
				</tr>
				<tr>
					<th>自定义标签</th>
					<td><input id="new_brand_tag_title" class="dark_border input_bar_long" style="width: 100px;" type="text"> <a class="cp" id="add_brand_tag_ajax">添加</a></td>
				</tr>
				<tr>
					<th>网址</th>
					<td><input type="text" name="link" id="link" class="dark_border input_bar_long" value="<?php echo $brand["link"];?>"/></td>
				</tr>
				<tr>
					<th>LOGO</th>
					<td><input type="file" name="brand_logo" /></td>
				</tr>
				<tr>
					<th></th>
					<td>
						
						<?php $logo = "brand_logo/brand_".$brand["id"].".".$brand["file_type"];?>
						<?php if(file_exists($logo)):?>
						<img style="border: 1px solid gray;" src="<?php echo $logo;?>" alt="" />	
						<input type="hidden" name="file_type" value="<?php echo $brand["file_type"];?>" />
						<?php else:?>
						还未上传图片
						<?php endif;?>
					</td>
				</tr>
				<tr>
					<th>品牌简介</th>
					<td>
						<textarea class="dark_border textarea_bar_md" style="height: 130px"  name="intro"  cols="30" rows="10"><?php echo $brand["intro"];?></textarea>
					</td>
				</tr>
				<tr>
					<th>品牌描述</th>
					<td>
						<textarea class="dark_border textarea_bar_md" name="description"  cols="30" rows="10"><?php echo $brand["description"];?></textarea>
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
