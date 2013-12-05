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

$categories = runFunc("getAllShopsBrandCategory");
//print_r($brands);
?>
<div class="content">
	<div class="full_width_box oh">
		<div id="cont" class="fl">
		<?php if($this->_tpl_vars["IN"]["category_id"]!=""):?>
		<?php $items = runFunc("getAllShopsBrandByCategoryId",array($this->_tpl_vars["IN"]["category_id"],false));?>
		<?php if(count($items)<1){continue;}?>
		<?php $category = runFunc("getAllShopsBrandCategoryById",array($this->_tpl_vars["IN"]["category_id"]));?>
		
			<div id="catcont">
				<div class="cattitle">
				<span><?php echo $category[0]["name"];?></span>
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new'));?>">Show All Shops</a>
				</div>
				<div class="catpost">
				
				<ul class="b_image_box">
				<?php foreach($items as $item):?>
				<?php $logo = "../cms/brand_logo/brand_".$item["id"].".".$item["file_type"];?>
					<li id="shop_item_<?php echo $item["id"]?>">
					<?php  $items_count = runFunc("getGoodsByBrand",array(1,5,true,$item["id"]));?>
					<?php if($items_count[0]["count"]>0){
						$link = "<a href='".runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$item["id"]))."'>";
					}else{
						$link = "<a target='_blank' href='".$item["link"]."'>";
					}
					
					?>
					<?php echo $link;?>
					<img height="90" width="180" src="<?php echo $logo;?>">
					</a>
					 <div id="intro_box_<?php echo $item["id"];?>" class="hidden"><?php echo $item["intro"];?></div>
					</li>
					<?php if($item["intro"]!=""):?>
					<script type="text/javascript">
							$(function(){
									$("#shop_item_<?php echo $item["id"]?>").qtip({
										   	content: $("#intro_box_<?php echo $item["id"];?>").text(),
											show: 'mouseover',
										    position: {
											  corner: {
												 target: 'rightMiddle',
												 tooltip: 'leftMiddle'
											  }
										   },
										   style: { 
											      name: 'cream'
											   }
										 
										});
								});
						</script>
						<?php endif;?>
				<?php endforeach;?>
				    
				</ul>
				</div>
				</div>	
		<?php elseif($this->_tpl_vars["IN"]["tag_id"]!=""):?>
		<?php $items = runFunc("getAllShopsBrandByTagId",array($this->_tpl_vars["IN"]["tag_id"]));?>
		<?php $tag = runFunc("getShopBrandTagById",array($this->_tpl_vars["IN"]["tag_id"]));?>
			<div id="catcont">
				<div class="cattitle">
				<span><?php echo $tag[0]["name"];?></span>
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new'));?>">Show All Shops</a>
				</div>
				<div class="catpost">
				
				<ul class="b_image_box">
				<?php foreach($items as $item):?>
				<?php $logo = "../cms/brand_logo/brand_".$item["id"].".".$item["file_type"];?>
					<li id="shop_item_<?php echo $item["id"]?>">
					<?php  $items_count = runFunc("getGoodsByBrand",array(1,5,true,$item["id"]));?>
					<?php if($items_count[0]["count"]>0){
						$link = "<a href='".runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$item["id"]))."'>";
					}else{
						$link = "<a target='_blank' href='".$item["link"]."'>";
					}
					
					?>
					<?php echo $link;?>
					<img height="90" width="180" src="<?php echo $logo;?>">
					</a>
					 <div id="intro_box_<?php echo $item["id"];?>" class="hidden"><?php echo $item["intro"];?></div>
					</li>
					<?php if($item["intro"]!=""):?>
					<script type="text/javascript">
							$(function(){
									$("#shop_item_<?php echo $item["id"]?>").qtip({
										   	content: $("#intro_box_<?php echo $item["id"];?>").text(),
											show: 'mouseover',
										    position: {
											  corner: {
												 target: 'rightMiddle',
												 tooltip: 'leftMiddle'
											  }
										   },
										   style: { 
											      name: 'cream'
											   }
										 
										});
								});
						</script>
						<?php endif;?>
				<?php endforeach;?>
				    
				</ul>
				</div>
				</div>	

		<?php else:?>
		<?php foreach($categories as $category):?>
		<?php $items = runFunc("getAllShopsBrandByCategoryId",array($category["id"],true));?>
		<?php if(count($items)<1){continue;}?>
			<div id="catcont">
				<div class="cattitle">
				<span><?php echo $category["name"];?></span>
				<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new&category_id='.$category["id"]));?>">Show More</a>
				</div>
				<div class="catpost">
				
				<ul class="b_image_box">
				<?php foreach($items as $item):?>
				<?php $logo = "../cms/brand_logo/brand_".$item["id"].".".$item["file_type"];?>
					<li id="shop_item_<?php echo $item["id"]?>">
					<?php  $items_count = runFunc("getGoodsByBrand",array(1,5,true,$item["id"]));?>
					<?php //echo $items_count[0]["count"];?>
					<?php if($items_count[0]["count"]>0){
						$link = "<a href='".runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$item["id"]))."'>";
					}else{
						$link = "<a target='_blank' href='".$item["link"]."'>";
					}
					
					?>
					<?php echo $link;?>
					<img height="90" width="180" src="<?php echo $logo;?>">
					</a>
					<div id="intro_box_<?php echo $item["id"];?>" class="hidden"><?php echo $item["intro"];?></div>
					</li>
					
					<?php if($item["intro"]!=""):?>
					<script type="text/javascript">
							$(function(){
									$("#shop_item_<?php echo $item["id"]?>").qtip({
										   content: $("#intro_box_<?php echo $item["id"];?>").text(),
										   show: 'mouseover',
										    position: {
											  corner: {
												 target: 'rightMiddle',
												 tooltip: 'leftMiddle'
											  }
										   },
										   style: { 
											      name: 'cream'
											   }
										 
										});
								});
						</script>
						<?php endif;?>
				<?php endforeach;?>
				    
				</ul>
				</div>
				</div>
				<?php endforeach;?>
				<?php endif;?>
		</div>
		<div id="brand_list_right_select" class="fr">
			<div id="sidebarnav">
				<div class="menu-c-container">
				
					<ul class="brand_list_menu" id="menu-c">
					
						<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-7535" id="menu-item-7535"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new'));?>">All Shops</a></li>
					<?php foreach($categories as $category):?>
						<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-7528" id="menu-item-7528"><a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new&category_id='.$category["id"]));?>"><?php echo $category["name"];?></a></li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
			<div id="brand_list_tag">
			<?php $tags = runFunc("getAllShopBrandTags");
				foreach($tags as $tag):
			?>
			<a style="font-size: 8pt;" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=brand_list_new&tag_id='.$tag["id"]));?>"><?php echo $tag["name"];?></a>	
			<?php endforeach;?>
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
