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

<script type="text/javascript">
var getAjaxGoodsIndex = 2;
var getAjaxGoodsSize = 5;
var loading = 0;

$(window).scroll(function(){

	//$(".tmallmenu").stop().animate({"marginTop":$(this).scrollTop()});

		if (($(document).height() - $(this).height()) - $(this).scrollTop() < 100){

			if(loading == 0){
				loading = 1;
			getAjaxGoodsIndex++;
			loadMoreHotItems(getAjaxGoodsIndex,getAjaxGoodsSize,'<?php echo $this->_tpl_vars["IN"]["cat_id"];?>','<?php echo $this->_tpl_vars["IN"]["tag_id"];?>');
		}
	}
});



</script>

	</head>
	<body>

<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);

	$items = runFunc("getAllInsideGoods",array($this->_tpl_vars["IN"]["page"],10,false,$this->_tpl_vars["IN"]["cat_id"],$this->_tpl_vars["IN"]["tag_id"]));

	$items_count = runFunc("getAllInsideGoods",array(1,10,true,$this->_tpl_vars["IN"]["cat_id"],$this->_tpl_vars["IN"]["tag_id"]));
	?>

<div class="content">
    <div class="cattitle" style="margin-top:20px;">
    	<span>
			<?php if($this->_tpl_vars["IN"]["cat_id"]!=""):?>
				<?php $cat_current = runFunc("getGoodsCatById",array($this->_tpl_vars["IN"]["cat_id"]));
                echo $cat_current["title"];?>
            <?php else:?>
            	Hot Items
            <?php endif;?>        
        </span>
		<a> Collections (<?php echo $items_count[0]["count"];?>) </a>
    </div>  
    
	<div class="surprise_box_left fl"> 
	<?php
     if($this->_tpl_vars["IN"]["page"]==""){
        $page = 1;
    }else{
        $page = $this->_tpl_vars["IN"]["page"];
    }?>
	<?php if(isset($items[0])):?>
		<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[0]["goodsid"]));
			if(count($group_buy)>0){

				//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
				$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[0]["goodsid"]."&show_type=collections&from=collections_page"));
			}else{

				$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[0]["goodsid"]."&show_type=collections&from=collections_page"));
			}
		?>
		<div class="surprise_items_box_left fl">
			<div class="surprise_item_inner_box">
				<table class="surprise_item_table_inner_table">
					<tr>
						<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[0]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						<td style="padding: 20px;font-size: 14px;">
                        	<a href="<?php echo $link;?>"><?php echo $items[0]['goodsTitleEn']?$items[0]['goodsTitleEn']:$items[0]['goodsTitleCN'];?></a>
						</td>
					</tr>
				</table>
			</div>
			<?php if(isset($items[1])):?>

				<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[1]["goodsid"]));
					if(count($group_buy)>0){

						//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[1]["goodsid"]."&show_type=collections&from=collections_page"));
					}else{

						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[1]["goodsid"]."&show_type=collections&from=collections_page"));
					}
				?>
				<div class="surprise_item_inner_box">
					<table class="surprise_item_table_inner_table">
						<tr>
							<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[1]['goodsTitleEn']?$items[1]['goodsTitleEn']:$items[1]['goodsTitleCN'];?></a>
							</td>
							<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[1]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						</tr>
					</table>
				</div>
			<?php endif;?>
			<?php if(isset($items[2])):?>
				<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[2]["goodsid"]));
					if(count($group_buy)>0){

						//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[2]["goodsid"]."&show_type=collections&from=collections_page"));
					}else{

						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[2]["goodsid"]."&show_type=collections&from=collections_page"));
					}
				?>
			<div class="surprise_item_inner_box">
				<table class="surprise_item_table_inner_table">
					<tr>
						<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[2]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[2]['goodsTitleEn']?$items[2]['goodsTitleEn']:$items[2]['goodsTitleCN'];?></a>
						</td>
					</tr>
				</table>
			</div>
			<?php endif;?>
			<?php if(isset($items[5])):?>
				<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[5]["goodsid"]));
					if(count($group_buy)>0){

						//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[5]["goodsid"]."&show_type=collections&from=collections_page"));
					}else{

						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[5]["goodsid"]."&show_type=collections&from=collections_page"));
					}
				?>
			<div class="surprise_item_inner_box">
				<table class="surprise_item_table_inner_table">
					<tr>
						<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[5]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[5]['goodsTitleEn']?$items[5]['goodsTitleEn']:$items[5]['goodsTitleCN'];?></a>
						</td>
					</tr>
				</table>
			</div>
			<?php endif;?>
			<?php if(isset($items[6])):?>
				<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[6]["goodsid"]));
					if(count($group_buy)>0){

						//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[6]["goodsid"]."&show_type=collections&from=collections_page"));
					}else{

						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[6]["goodsid"]."&show_type=collections&from=collections_page"));
					}
				?>
				<div class="surprise_item_inner_box">
				<table class="surprise_item_table_inner_table">
					<tr>
						<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[6]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[6]['goodsTitleEn']?$items[6]['goodsTitleEn']:$items[6]['goodsTitleCN'];?></a>
						</td>
					</tr>
				</table>
				</div>
			<?php endif;?>
			<?php if(isset($items[7])):?>
				<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[7]["goodsid"]));
					if(count($group_buy)>0){

						//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[7]["goodsid"]."&show_type=collections&from=collections_page"));
					}else{

						$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[7]["goodsid"]."&show_type=collections&from=collections_page"));
					}
				?>
				<div class="surprise_item_inner_box" style="border-bottom:0">
				<table class="surprise_item_table_inner_table">
					<tr>
						<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[7]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
						<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[7]['goodsTitleEn']?$items[7]['goodsTitleEn']:$items[7]['goodsTitleCN'];?></a>
						</td>
					</tr>
				</table>
				</div>
			<?php endif;?>
	</div>

	<div class="surprise_items_box_right fl">
		<?php if(isset($items[3])):?>
			<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[3]["goodsid"]));
				if(count($group_buy)>0){

					//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[3]["goodsid"]."&show_type=collections&from=collections_page"));
				}else{

					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[3]["goodsid"]."&show_type=collections&from=collections_page"));
				}
			?>
			<div class="surprise_list_row_div">
				<a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[3]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
				<div class="surprist_list_item_title">
					<a href="<?php echo $link;?>"><?php echo $items[3]['goodsTitleEn']?$items[3]['goodsTitleEn']:$items[3]['goodsTitleCN'];?></a>
				</div>
			</div>
		<?php endif;?>
		<?php if(isset($items[4])):?>
			<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[4]["goodsid"]));
				if(count($group_buy)>0){

					//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[4]["goodsid"]."&show_type=collections&from=collections_page"));
				}else{

					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[4]["goodsid"]."&show_type=collections&from=collections_page"));
				}
			?>
			 <div class="surprise_list_row_div" style="border-bottom:0">
				<a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[4]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
				<div class="surprist_list_item_title">
					<a href="<?php echo $link;?>"><?php echo $items[4]['goodsTitleEn']?$items[4]['goodsTitleEn']:$items[4]['goodsTitleCN'];?></a>
				</div>
			 </div>
		<?php endif;?>
		<?php if(isset($items[8])):?>
			<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[8]["goodsid"]));
				if(count($group_buy)>0){

					//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[8]["goodsid"]."&show_type=collections&from=collections_page"));
				}else{

					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[8]["goodsid"]."&show_type=collections&from=collections_page"));
				}
			?>
			 <div class="surprise_list_row_div" style="border-bottom:0">
				<a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[8]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
				<div class="surprist_list_item_title">
					<a href="<?php echo $link;?>"><?php echo $items[8]['goodsTitleEn']?$items[8]['goodsTitleEn']:$items[8]['goodsTitleCN'];?></a>
				</div>
			 </div>
		<?php endif;?>
		<?php if(isset($items[9])):?>
			<?php $group_buy = runFunc("checkCollectionGroupBuy",array($items[9]["goodsid"]));
				if(count($group_buy)>0){

					//$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[9]["goodsid"]."&show_type=collections&from=collections_page"));
				}else{

					$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$items[9]["goodsid"]."&show_type=collections&from=collections_page"));
				}
			?>
			 <div class="surprise_list_row_div" style="border-bottom:0">
				<a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[9]["goodsImgURL"];?>_310x310.jpg" alt="" /></a>
				<div class="surprist_list_item_title">
					<a href="<?php echo $link;?>"><?php echo $items[9]['goodsTitleEn']?$items[9]['goodsTitleEn']:$items[9]['goodsTitleCN'];?></a>
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


	//echo runFunc("pageSurpriseNavi",array($items_count[0]["count"],5,"surprise","surpriseindex",$page,$this->_tpl_vars["IN"]["cat_id"],$this->_tpl_vars["IN"]["tag_id"]));
	?>
	</div>
	<?php $cats = runFunc("getAllGoodsCat",array(false));?>
	<div class="surprise_box_right fr">
		<div class="surprise_small_item_box">
			<div class="surprise_small_item_box_title">
				Category
			</div>
			<div class="surprise_small_item_box_content oh">
			<a class="surprise_small_item fl <?php if($this->_tpl_vars["IN"]["cat_id"] == ""){echo "active_small_item";}?>" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex'));?>">
			All
			</a>
			<?php foreach ($cats as $cat):?>
			<a class="surprise_small_item fl <?php if($this->_tpl_vars["IN"]["cat_id"] == $cat[id]){echo "active_small_item";}?>" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex&cat_id='.$cat[id]));?>">
			<?php echo $cat["title"];?>
			</a>
			<?php endforeach;?>
			</div>
		</div>
			<?php $tags_cats = runFunc("getGoodsCatFront");?>
	<?php foreach ($tags_cats as $tags_cat):?>
		<div class="surprise_small_item_box">
			<div class="surprise_small_item_box_title">
				<?php echo $tags_cat["title"];?>
			</div>
			<?php $tags = runFunc("getGoodsTagByCat",array($tags_cat["id"]));?>
			<div class="surprise_small_item_box_content oh">
			<?php foreach ($tags as $tag):?>
			<?php $tag_item_count = runFunc("getAllInsideGoods",array(1,5,true,$this->_tpl_vars["IN"]["cat_id"],$tag[id]));?>
			<?php if($tag_item_count[0]["count"]<1)continue;?>
			<a class="surprise_small_item fl <?php if($this->_tpl_vars["IN"]["tag_id"] == $tag[id]){echo "active_small_item";}?>" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex&cat_id='.$this->_tpl_vars["IN"]["cat_id"].'&tag_id='.$tag[id]));?>">
			<?php echo $tag["title"];?>
			</a>
			<?php endforeach;?>
			</div>
		</div>

	<?php endforeach;?>
	</div>


</div>


	<?php
$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
include($inc_tpl_file);
?>
</div>
<img id="back-top" class="back-top" src="../skin/images/back_to_top.png" alt=""/>
</body>
</html>