<?php
import('core.util.RunFunc');
$items = runFunc("getAllInsideGoods",array($this->_tpl_vars["IN"]["page"],5,false,$this->_tpl_vars["IN"]["cat_id"],$this->_tpl_vars["IN"]["tag_id"]));
	
?>

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
			<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[0]['goodsTitleEn']?$items[0]['goodsTitleEn']:$items[0]['goodsTitleCN'];?></a>
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
	<div class="surprise_item_inner_box" style="border-bottom:0">
	<table class="surprise_item_table_inner_table">
		<tr>
			<td style="line-height: 1px;" width="50%"><a href="<?php echo $link;?>"><img width="240" src="<?php echo $items[2]["goodsImgURL"];?>_310x310.jpg" alt="" /></a></td>
			<td style="padding: 20px;font-size: 14px;"><a href="<?php echo $link;?>"><?php echo $items[2]['goodsTitleEn']?$items[2]['goodsTitleEn']:$items[2]['goodsTitleCN'];?></a>
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
	</div>
	
	<?php else:?>
	
	<?php endif;?>
	
	
	
	
	