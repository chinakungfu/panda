<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
?>

<?php

$items = runFunc("getGoodsList",array("outside",$page,40,false,'desc','goodsid',$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["product_category"],$this->_tpl_vars["IN"]["brand_id"],$this->_tpl_vars["IN"]["search_goodID"]));
$items_count = runFunc("getGoodsList",array("outside",1,40,true,'desc','goodsid',$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["product_category"],$this->_tpl_vars["IN"]["brand_id"],$this->_tpl_vars["IN"]["search_goodID"]));
$cats = runFunc("getItemList",array("cms_product_category",1,10000));

$brands = runFunc("getBrandList",array(1,100000));

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
<script language="javascript">
$(function(){
	$(".batch_update").click(function(){
		if(confirm("你确定要批量更新吗?会等很久哦!")){
			var del_vals = new Array();
			$(".admin_form_check_box:checked").each(function(){
				del_vals.push($(this).val());
			});
			if(del_vals.length == 0){
				alert("请选择至少选择一项！");
				return false;
			}
			$(".admin_ajaxjump_box").dialog("open");
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: "cms",
					method	: "product_update_outside",
					dataType : "batch",
					id : del_vals.join(),
				},
				success: function(json){
					if(json.status == 1){
						alert("更新成功");
					}else{
						alert("更新失败");
					}
				},
				complete: function(){
					location.reload();
				}
			});
		}
	});
})
</script>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			产品列表
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3">
            	<a href="#" class="batch_update" delete="goods" >批量更新</a>

			</li>
			<li id="ctrl_4">

				<a href="#" class="batch_delete" delete="goods" >批量删除</a>
			</li>

		</ul>
</div>
<div class="search_bar">
			<form class="admin_filter_form" method="post" action="index.php">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products'));?>">清空搜索条件</a>
				<input class="fr button_link" type="submit" value="搜索"/>
				<select name="product_category" id="product_category" class="select_filter fr">
					<option value="">商品分类</option>
					<option <?php if($this->_tpl_vars["IN"]["product_category"]==-1)echo "selected='selected'";?> value="-1">未分类</option>
					<?php foreach ($cats as $cat):?>
						<option <?php if($cat["id"]==$this->_tpl_vars["IN"]["product_category"])echo "selected='selected'";?> value="<?php echo $cat["id"]?>"><?php echo $cat["title"]?></option>
						<?php endforeach;?>
				</select>
				<select name="brand_id" id="brand_id" class="select_filter fr">
					<option value="">商品品牌</option>

					<?php foreach ($brands as $brand):?>
						<option <?php if($brand["id"]==$this->_tpl_vars["IN"]["brand_id"])echo "selected='selected'";?> value="<?php echo $brand["id"]?>"><?php echo $brand["title"]?></option>
						<?php endforeach;?>
				</select>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
				<label for="search_type" class="fr">商品名称：</label>
			<input class="input fr" id="search_goodID" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_goodID"];?>" name="search_goodID"/>
				<label for="search_type" class="fr">商品ID：</label>
				<input type="hidden" name="action" value="<?php echo $this->_tpl_vars["action"];?>" />
				<input type="hidden" name="method" value="<?php echo $this->_tpl_vars["method"];?>" />
				<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>" />
			</form>
		</div>
		<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&product_category='.$this->_tpl_vars["IN"]["product_category"]."&brand_id=".$this->_tpl_vars["IN"]["brand_id"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&product_category='.$this->_tpl_vars["IN"]["product_category"]."&brand_id=".$this->_tpl_vars["IN"]["brand_id"]));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&product_category='.$this->_tpl_vars["IN"]["product_category"]."&brand_id=".$this->_tpl_vars["IN"]["brand_id"]));?>">不发布</a></li>
		</ul>
	</div>
<table class="order_list_title">
	<tbody>
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="8%">商品ID</th>
			<th width="32%">商品名称</th>
			<th width="8%">商品分类</th>
			<th width="10%">商店ID</th>
			<?php $price_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="goodsUnitPrice" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $price_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="goodsUnitPrice" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $price_sort = "desc";?>
			<?php endif;?>
			<th width="7%">商品原价</th>
			<th width="10%">商品价格 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=product_list_outside&type=products&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$price_sort.'&key=goodsUnitPrice'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&product_category='.$this->_tpl_vars["IN"]["product_category"]."&brand_id=".$this->_tpl_vars["IN"]["brand_id"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="goodsUnitPrice" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="goodsUnitPrice" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="6%">状态</th>
			<th width="14%">操作</th>
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
			<td width="5%"><input value="<?php echo $item["goodsid"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="8%"><?php echo $item["goodsid"];?></td>
			<td width="32%" style="text-align:left;padding:0 10px;" width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_edit_outside&type=products&id='.$item["goodsid"].'&page='.$page));?>"><?php echo $item["goodsTitleCN"];?></a></td>
			<td width="8%"><?php if($item["cat_id"]==""){echo "未分类";}else{$cat = runFunc("getItemById",array("cms_product_category",$item["cat_id"]));echo $cat["title"];}?></td>
			<td width="10%"><?php if($item["goodsShopId"]==""){echo "没有";}else{echo $item["goodsShopId"];}?></td>
			<td width="7%"><?php if($item["goodsOriginalPrice"]>0){ echo number_format($item["goodsOriginalPrice"], 2, '.', ',');}else{echo "无";}?></td>
			<td width="10%"><?php echo number_format($item["goodsUnitPrice"], 2, '.', ',');?></td>
			<td width="6%"><?php echo  $_GLOBAL['published_'.$item["published"]];?></td>
			<td width="14%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_edit_outside&type=products&id='.$item["goodsid"].'&page='.$page));?>">编辑</a> <a onClick="javascript: return confirm('是否确认删除这个此项？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_delete_outside&delete_type=goods&id='.$item["goodsid"].'&page='.$page));?>">删除</a> <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_update_outside&type=products&dataType=one&id='.$item["goodsid"].'&page='.$page));?>">更新</a>
			 <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=product_update_surprise&type=products&dataType=one&backType=outside&id='.$item["goodsid"].'&page='.$page));?>">抓取</a>
			</td>
		</tr>
	</tbody>
</table>
<?php endforeach;?>
</form>
<?php echo runFunc("adminPageNavi2",array($items_count[0]["count"],40,"cms","product_list_outside",'products&status='.$this->_tpl_vars["IN"]["coupon_status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&product_category='.$this->_tpl_vars["IN"]["product_category"]."&brand_id=".$this->_tpl_vars["IN"]["brand_id"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
