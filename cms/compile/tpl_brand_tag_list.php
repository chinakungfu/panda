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

<?php $items = runFunc("getAdminBrandtags",array($page,20,false));
$items_count = runFunc("getAdminBrandtags",array(1,20,true));

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
			品牌标签列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="brand_tag">批量删除</a>
			</li>
		</ul>
	</div>
	<div class="search_bar">
		
		</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="40%">标签名称</th>
			<th width="25%">状态</th>
			<th width="10%">操作</th>
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
			<td width="40%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_tag_edit&type=products&id='.$item["id"]));?>"><?php echo $item["name"]?></a></td>
			<td width="25%"><?php echo  $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=brand_tag_edit&type=products&id='.$item["id"]));?>">编辑</a> <a onClick="javascript: return confirm('是否确认删除这个此项？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_delete&delete_type=brand_tag&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],20,"cms","tag_list","products",$page));?>
</div>

</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>