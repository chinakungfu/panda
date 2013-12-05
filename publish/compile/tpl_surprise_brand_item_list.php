<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	</head>
	<body>
	    
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	
	$items = runFunc("getGoodsByBrand",array($this->_tpl_vars["IN"]["page"],5,false,$this->_tpl_vars["IN"]["brand_id"]));
	
	
	$items_count = runFunc("getGoodsByBrand",array(1,5,true,$this->_tpl_vars["IN"]["brand_id"]));
	$brand = runFunc("getBrandById",array($this->_tpl_vars["IN"]["brand_id"]));
	
	if($this->_tpl_vars["IN"]["page"]==""){
						
		$page = 1;
	}else{
		
		$page = $this->_tpl_vars["IN"]["page"];
	}
	?>

<div class="content">
    <div class="cattitle" style="margin-top:20px;">
    	<span><?php echo $brand["title"];?></span>
		<a> Collections (<?php echo $items_count[0]["count"];?>) </a>
		<?php echo runFunc("pageBrandListNavi",array($items_count[0]["count"],5,"surprise","surprise_brand_item_list",$page,$this->_tpl_vars["IN"]["brand_id"],true));?>
    </div>  
	<div class="surprise_box_left fl">

	<?php if(isset($items[0])):?>
	<div class="surprise_items_box_left fl">
	<div class="surprise_item_inner_box">
	<table class="surprise_item_table_inner_table">
		<tr>
			<td style="line-height: 1px;" width="50%"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[0]["goodsid"]."&show_type=collections&from=collections_page"));?>"><img width="240" src="<?php echo $items[0]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
			<td style="padding: 20px;font-size: 14px;"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[0]["goodsid"]."&show_type=collections&from=collections_page"));?>"><?php echo $items[0]["goodsTitleCN"]?></a></td>
		</tr>
	</table>
	</div>
	<?php if(isset($items[1])):?>
	<div class="surprise_item_inner_box">
	<table class="surprise_item_table_inner_table">
		<tr>
			<td style="padding: 20px;font-size: 14px;"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[1]["goodsid"]."&show_type=collections&from=collections_page"));?>"><?php echo $items[1]["goodsTitleCN"]?></a></td>
			<td style="line-height: 1px;" width="50%"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[1]["goodsid"]."&show_type=collections&from=collections_page"));?>"><img width="240" src="<?php echo $items[1]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
		</tr>
	</table>
	</div>
	<?php endif;?>
	<?php if(isset($items[2])):?>
	<div class="surprise_item_inner_box" style="border-bottom:0">
	<table class="surprise_item_table_inner_table">
		<tr>
			<td style="line-height: 1px;" width="50%"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[2]["goodsid"]."&show_type=collections&from=collections_page"));?>"><img width="240" src="<?php echo $items[2]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
			<td style="padding: 20px;font-size: 14px;"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[2]["goodsid"]."&show_type=collections&from=collections_page"));?>"><?php echo $items[2]["goodsTitleCN"]?></a></td>
		</tr>
	</table>
	</div>
	<?php endif;?>
	</div>
	
	<div class="surprise_items_box_right fl">
	<?php if(isset($items[3])):?>
		<div class="surprise_list_row_div">
			<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[3]["goodsid"]."&show_type=collections&from=collections_page"));?>"><img width="240" src="<?php echo $items[3]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
			<div class="surprist_list_item_title">
			<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[3]["goodsid"]."&show_type=collections&from=collections_page"));?>"><?php echo $items[3]["goodsTitleCN"];?></a>
		</div>
		</div>
	<?php endif;?>
	<?php if(isset($items[4])):?>
		<div class="surprise_list_row_div" style="border-bottom:0">
			<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[4]["goodsid"]."&show_type=collections&from=collections_page"));?>"><img width="240" src="<?php echo $items[4]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
			<div class="surprist_list_item_title">
			<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[4]["goodsid"]."&show_type=collections&from=collections_page"));?>"><?php echo $items[4]["goodsTitleCN"];?></a>
			</div>
		</div>
	<?php endif;?>
	</div>
	
	<?php else:?>
	
	<div class="no_item_notice">
		Temporarily no items.
	</div>
	
		<?php endif;?>
	
	<?php 

	echo runFunc("pageBrandListNavi",array($items_count[0]["count"],5,"surprise","surprise_brand_item_list",$page,$this->_tpl_vars["IN"]["brand_id"]));
	?>
	
	
	</div>

	<div class="surprise_box_right fr">
	<?php $brand = runFunc("getGoodsBrandById",array($this->_tpl_vars["IN"]["brand_id"]));?>
		<div class="brand_info_box oh">
		<?php $logo = "../cms/brand_logo/brand_".$brand["id"].".".$brand["file_type"];?>
		
		<div class="brand_img_box">
			<img src="<?php echo $logo;?>" alt="" width="178px" height="117px" />
		</div>
		<?php if($brand["owner"]!=""):?>
		<div class="brand_owner_info fl">
			Owner: <span style="color: #ffcc33;"><?php echo $brand["owner"];?></span>
		</div>
		<?php endif;?>
		<?php if($brand["link"]!=""):?>
		<div class="visit_shop_box fr">
			<a target="_blank" href="<?php echo $brand["link"];?>" class="visit_shop_link fr" href="">Visit Shop</a>
		</div>
		<?php endif;?>
		</div>
		<div class="brand_description">
			<?php echo $brand["description"];?>
		</div>
	</div>

	
</div>


	<?php
$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
include($inc_tpl_file);
?>
</div>
</body>
</html>