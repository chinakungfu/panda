<?php import('core.util.RunFunc'); 

import('core.datasource.DataAccess');
import('core.datasource.TStaticQuery');
?>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$page = 1;
if($this->_tpl_vars["IN"]["page"] != ""){
	$page = $this->_tpl_vars["IN"]["page"];
}
?>



<?php $brands = runFunc("getBrandList",array($page,20,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["category"]));
$brands_count = runFunc("getBrandList",array(1,20,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["category"]));
?>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$categories = runFunc("getAdminBrandCategories",array(1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			品牌列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="brand_batch">批量删除</a>
			</li>
		</ul>
	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<select name="category" class="select_filter fr" id="category">
				<option value="">全部分类品牌</option>
				<option <?php if($this->_tpl_vars["IN"]["category"]==0 and $this->_tpl_vars["IN"]["category"]!=""){echo "selected='selected'";}?> value="0">无分类</option>
				<?php foreach($categories as $category):?>
				<option <?php if($category["id"] == $this->_tpl_vars["IN"]["category"]){echo "selected='selected'";}?> value="<?php echo $category["id"];?>"><?php echo $category["name"];?><?php if($category["published"]==0){echo "(不发布)";}?></option>
				<?php endforeach;?>
			</select>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">品牌或专卖店名称：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="brands"/>
			<input type="hidden" name="type" value="products"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&category='.$this->_tpl_vars["IN"]["category"]));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&category='.$this->_tpl_vars["IN"]["category"]));?>">未发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products&status=3&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&category='.$this->_tpl_vars["IN"]["category"]));?>">推荐</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "4"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products&status=4&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&category='.$this->_tpl_vars["IN"]["category"]));?>">不推荐</a></li>
		</ul>
	</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="25%">品牌或专卖店名称</th>
			<th width="15%">分类</th>
			<th width="15%">设计师和店主</th>
			<th width="10%">状态</th>
			<th width="10%">推荐</th>
			<th width="10%">类型</th>
			<th width="10%">操作</th>
		</tr>
	</tbody>
</table>
<form action="index.php" method="post" id="admin_batch_form">
<?php 
$i = 1;
foreach($brands as $key=>$brand):?>
<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
	<tbody>
		<tr>
			<td width="5%"><input file="<?php echo $brand["file_type"];?>" value="<?php echo $brand["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="25%"><?php echo $brand["title"]?></td>
			<td width="15%"><?php echo $brand["cname"]?></td>
			<td width="15%"><?php echo $brand["owner"];?></td>
			<td width="10%"><?php echo  $_GLOBAL['published_'.$brand["published"]];?></td>
			<td width="10%"><?php echo  $_GLOBAL['special_'.$brand["special"]];?></td>
			<td width="10%"><?php echo $_GLOBAL['brand_publish_type_'.$brand["publish_type"]];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_edit&type=products&id='.$brand["id"]));?>">编辑</a> <a onClick="javascript: return confirm('是否确认删除这个品牌？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_delete&delete_type=brand&file_type='.$brand["file_type"].'&id='.$brand["id"]));?>">删除</a></td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi",array($brands_count[0]["count"],20,"cms","brands",'products&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&category='.$this->_tpl_vars["IN"]["category"],$page));?>
</div>

</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>