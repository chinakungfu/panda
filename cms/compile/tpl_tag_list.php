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

<?php $items = runFunc("getItemList",array("cms_product_tag",$page,20,false,$this->_tpl_vars["IN"]["search_filter"]));
$items_count = runFunc("getItemList",array("cms_product_tag",1,20,true,$this->_tpl_vars["IN"]["search_filter"]));

?>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$filters = runFunc("getItemList",array("cms_product_tag_category",1,10000));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			标签列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="tag" onclick="javascript:return confirm('是否确定删除这些品牌？')">批量删除</a>
			</li>
		</ul>
	</div>
	<div class="search_bar">
			<form class="admin_filter_form" method="post" action="index.php">
				<select id="search_filter" class="fr" name="search_filter">
					<option value="">分类</option>
					<?php foreach ($filters as $filter):?>
					<option <?php if($this->_tpl_vars["IN"]["search_filter"] == "cat_id:".$filter["id"]){echo "selected=selected";}?> value="cat_id:<?php echo $filter["id"]?>"><?php echo $filter["title"]?></option>
					<?php endforeach;?>
				</select>
				<label for="search_type" class="fr">筛选：</label>
				<input type="hidden" name="action" value="<?php echo $this->_tpl_vars["action"];?>" />
				<input type="hidden" name="method" value="<?php echo $this->_tpl_vars["method"];?>" />
				<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>" />
			</form>
		</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="25%">标签名称</th>
			<th width="20%">分类</th>
			<th width="25%">状态</th>
			<th width="20%">操作</th>
		</tr>
	</tbody>
</table>
<form action="index.php" method="post" id="admin_batch_form">
<?php 
$i = 1;
foreach($items as $key=>$item):?>
<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
	<tbody>
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="25%"><?php echo $item["title"]?></td>
			<td width="20%"><?php $cat = runFunc("getItemById",array("cms_product_tag_category",$item["cat_id"]));echo $cat["title"];?></td>
			<td width="25%"><?php echo  $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=tag_edit&type=products&id='.$item["id"]));?>">编辑</a> <a onClick="javascript: return confirm('是否确认删除这个此项？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_delete&delete_type=tag&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],20,"cms","tag_list","products&search_filter=".$this->_tpl_vars["IN"]["search_filter"],$page));?>
</div>

</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>