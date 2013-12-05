<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
echo $this->_tpl_vars["IN"]["search_Content"];
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
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
		<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	
	include($inc_tpl_file);
	
if($this->_tpl_vars["IN"]["brand_cat_id"]!=""){
	
	$show_brand_cat = $this->_tpl_vars["IN"]["brand_cat_id"];
}else{
	
	$show_brand_cat = 1;
}

$hot_brand_categories = runFunc("getTaobaoHotBrandCategories");
	?>
	
	<div class="content">
		<?php //echo runFunc("getSiteAdv",array("Brand Street A","brand_street_banner_a"));?>
		<h2 class="shop_page_title">
			Hot Brand
		</h2>
		<table class="taobao_hot_brand_table">
		<?php foreach($hot_brand_categories as $hot_brand_category):?>
		<tr>
			<th>
				<?php echo $hot_brand_category["name"];?>
			</th>
			<td>
				<?php $hot_brands = runFunc("getTaobaoHotBrands",array($hot_brand_category["id"]));?>
				<?php foreach($hot_brands as $hot_brand):?>
				<a target="_blank" class="hot_brand_link fl" href="<?php echo $hot_brand["link"];?>">
					<img src="../cms/brand_logo/hot_brand_<?php echo $hot_brand["id"]?>.<?php echo $hot_brand["img"];?>" alt=""  title="<?php echo $hot_brand["name"]?>"/>
				</a>
				<?php endforeach;?>
			</td>
		</tr>
		<?php endforeach;?>
		</table>
		<?php //echo runFunc("getSiteAdv",array("Brand Street B","brand_street_banner_b"));?>
<!--		<h2 class="shop_page_title" style="margin-top: 50px;">
			Brand of Tmall
		</h2>
		<ul class="brand_list_link">
		<li>
			<a <?php if($show_brand_cat==1){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=1')); ?>">Women’s</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==2){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=2')); ?>">Men's </a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==3){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=3')); ?>">Shoes</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==4){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=4')); ?>">Sports & Outdoors</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==5){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=5')); ?>">Digital  appliances</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==6){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=6')); ?>">Beauty & Jewelry</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==7){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=7')); ?>">Home  Furnishings</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==8){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=8')); ?>">Daily Textiles </a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==9){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=9')); ?>">Luggage & Bags</a>
		</li>
		<li>|</li>
		<li>
			<a <?php if($show_brand_cat==10){echo "class='active'";}?> href="<?php echo runFunc('encrypt_url',array('action=shop&method=tmall_brand&brand_cat_id=10')); ?>">Mother & Childen</a>
		</li>
		</ul>-->
<!--		<div class="brand_list_content oh">
		<?php
		$inc_tpl_file=includeFunc('shop/tmall/brand_list_'.$show_brand_cat.'.tpl');
		//include($inc_tpl_file);
		?>
		</div>-->
	</div>
	
	
	
	
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
	</div>
</body>
</html>

