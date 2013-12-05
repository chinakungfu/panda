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

<?php $items = runFunc("getItemList",array("cms_product_category",$page,20,false));
$items_count = runFunc("getItemList",array("cms_product_category",1,20,true));

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
			分类列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="product_category">批量删除</a>
			</li>
		</ul>
	</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="30%">分类名称</th>
			<th width="20%">上层分类</th>
			<th width="10%">状态</th>
			<th width="35%">操作</th>
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
			<td width="30%"><?php echo $item["title"]?></td>
			<td width="20%"><?php if($item["parent_id"] == 0){echo "最上层";}else{$parent = runFunc("getItemById",array("cms_product_category",$item["parent_id"]));echo $parent["title"];}?></td>
			<td width="10%"><?php echo  $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="35%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_category_edit&type=products&id='.$item["id"]));?>">编辑</a> <a onClick="javascript: return confirm('是否确认删除这个此项？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_delete&delete_type=product_category&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],20,"cms","prop_list","products",$page));?>
</div>

</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>