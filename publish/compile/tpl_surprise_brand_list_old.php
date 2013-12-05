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

$brands = runFunc("getAllBrands");
//print_r($brands);
?>
<div class="content">
	<div class="full_width_box oh">
		<div class="surprise_box_left fl">
			<div class="box_title_bar oh">
				<h2 class="cp_title fl surprise_title">
					Shops
				</h2>
				<div class="title_bar_msg fl">
					Collections (<?php echo count($brands);?>)
				</div>
			</div>
			<div class="brand_list_box oh">		
			<?php foreach($brands as $brand):?>
			<?php $logo = "../cms/brand_logo/brand_".$brand["id"].".".$brand["file_type"];?>
			<?php // if(file_exists($logo)):?>
			<div class="brand_logo_box fl">
			<div class="brand_logo_img_box">
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$brand["id"]));?>"><img src="<?php echo $logo;?>" alt="" /></a>
			</div>
			<a style="color:#777777;" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$brand["id"]));?>"><?php echo $brand["title"];?></a>
			</div>
			<?php //endif;?>
			
			
			<?php endforeach;?>
			</div>
		
		</div>
			<div class="surprise_box_adv_right fr">
			<?php echo runFunc("getSiteAdv",array("Shops","shops_adv"));?>
		</div>
	</div>
</div>




	<?php
$inc_tpl_file=includeFunc('common/footer/shop_footer.tpl');
include($inc_tpl_file);
?>


</div>
</body>
</html>
