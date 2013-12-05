<?php import('core.util.RunFunc'); 
 $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc("common/header/common_header.tpl");
if($this->_tpl_vars["IN"]["sort"] == ""){
	
	$sort = "id";
}else{
	
	$sort = $this->_tpl_vars["IN"]["sort"];
}

include($inc_tpl_file);



?>

</head>
<body onload="window.location.hash = 'here'">
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$inc_tpl_file=includeFunc("share/common/header.tpl");
	include($inc_tpl_file);
	
	$cart_items = runFunc("getGroupBuyJoinedList",array($user_id,$this->_tpl_vars["IN"]["page"],6,false));
	$count = runFunc("getGroupBuyJoinedList",array($user_id,$this->_tpl_vars["IN"]["page"],15,true));
	?>
	<div class="content">
	<div class="content_top_bar oh" style="width: 662px;">
	
	<h2 class="cp_title fl">Group Buy I Joined</h2>
			
	</div>
	<div class="group_buy_main_box">
	<?php foreach($cart_items as $cart_item):?>
	<?php $items = runFunc("getSiteGroupBuyItem",array($cart_item["ItemGoodsID"]));
	if(count($items)<1){
		
		continue;
	}
						$item = $items[0];
				?>
		<div class="group_buy_item_box oh">
			<div class="price_message fl">
				<?php if($item["sell_way"]==1):?>
				<div style="background:#bad782;" class="group_buy_price">20% off</div>
				<div class="goods_price">Service <br />fee</div>
				<?php else:?>
				<div class="group_buy_price">￥<?php echo number_format($item["goodsUnitPrice"]*$item["price_rate"], 2, '.', ',');?></div>
				<div class="goods_price">￥<?php echo number_format($item["goodsUnitPrice"], 2, '.', ',');?><br />value</div>
				<?php endif;?>
			</div>
			<div class="fl oh group_buy_img_box">
			<img height="90px" src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" />
			</div>
			<div class="group_buy_detail fl">
				<div class="group_buy_title">
					<?php if(strlen($item["item_name"])> 22){	
					echo mb_substr($item["item_name"],0,22,'utf-8')."...";
					}else{
						echo $item["item_name"];
					}?>
				</div>
				<div class="group_buy_desc">
				<?php if(strlen(strip_tags($item["description"]))> 150){	
					echo mb_substr(strip_tags($item["description"]),0,150,'utf-8')."...";
					}else{
						echo strip_tags($item["description"]);
					}?>
				</div>
			</div>
			<div class="group_buy_status fr">
			<?php $purchase_count = runFunc("getGroupPurchasedCount",array($item["id"]));
			?>
			<?php if($item["end_time"]<date("Y-m-d")):?>
				<div class="off_div">
					The deal is off !
				</div>
			<?php elseif($item["group_size"]>$purchase_count[0]["count"] or $item["start_time"]>date("Y-m-d")):?>
			<div class="pending_div">
				+ <font style="color:#ff9090"><?php echo $purchase_count[0]["count"];?></font> Pending!
			</div>
			<?php elseif($item["start_time"]!="" and $item["end_time"]>=date("Y-m-d")):?>
				<div class="starting_div">
				
					Over <font style="color:#ff9090"><?php echo $purchase_count[0]["count"];?></font> bought
				</div>
				<?php endif;?>
				<a style="margin-right:11px;" class="little_blue_button fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$item["id"]));?>">View</a>
			</div>
		</div>
	<?php endforeach;?>
	</div>
		<style type="text/css">
		
		.main_page_nav {
			margin-top: 20px;
		}
		
		.main_page_nav a  {
			margin-left: 0;
			margin-right: 5px;
		}
	
	</style>
	<?php 
	if($this->_tpl_vars["IN"]["page"]==""){
					
		$page = 1;
	}else{
		
		$page = $this->_tpl_vars["IN"]["page"];
	}
	
	echo runFunc("pageNavi",array($count[0]["count"],6,"share","memberGroupBuyJoined&user_id=".$user_id,$page));?>
	
	</div>
	<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>
<script type="text/javascript">
	$(function(){
			
			$(".group_buy_filter").change(function(){
				$("#main_page_ctr_form").submit();
			});
		})

</script>
</body>
</html>