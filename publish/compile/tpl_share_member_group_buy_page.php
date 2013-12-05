<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>

<!DOCTYPE HTML>
<html>
<head>


<?php

$inc_tpl_file=includeFunc("common/header/common_header.tpl");


include($inc_tpl_file);
?>
<script type="text/javascript" src="/publish/skin/jsfiles/date.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.counter.js"></script>
</head>
<body onLoad="window.location.hash = 'here'">
	<div class="box">
	<?php 
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	?>

	<?php 
	
	if($this->_tpl_vars["IN"]["user_id"] && $this->_tpl_vars["IN"]["user_id"] == $this->_tpl_vars["name"]){
		$inc_tpl_file=includeFunc("account/common/header.tpl");
	}else{
		$inc_tpl_file=includeFunc("share/common/header.tpl");
	}
	include($inc_tpl_file);
	$checkFriend = runFunc("checkFriend",array($user_id,$this->_tpl_vars["name"]));
	if($checkFriend >0 or $this->_tpl_vars["name"] == $user_id){
		
		$items = runFunc("getMyGroupBuyItemsByUserId",array($user_id,$this->_tpl_vars["IN"]["page"],15,false,true));
		$items_count = runFunc("getMyGroupBuyItemsByUserId",array($user_id,$this->_tpl_vars["IN"]["page"],15,true,true));
	}else{
		
		$items = runFunc("getMyGroupBuyItemsByUserId",array($user_id,$this->_tpl_vars["IN"]["page"],15));
		$items_count = runFunc("getMyGroupBuyItemsByUserId",array($user_id,$this->_tpl_vars["IN"]["page"],15,true));
	}
	
	
	$setting = runFunc("getGlobalSetting");
	?>
	<div class="content">
		<div class="group_buy_top_bar oh">
			<h2 class="fl" style="width: 760px;">
				Wellcome to Join My Group Buy
				<?php if($user_id==$this->_tpl_vars["name"]):?>
				<a style="margin-top:27px;margin-left:5px;line-height: 10px;display:inline;" class="gray_link" href="<?php echo runFunc('encrypt_url',array('action=share&method=add_group_buy'));?>">Create a group buy</a>
				<?php endif;?>
			</h2>
			
			<h2 class="fl">
				Deals I join
			</h2>
			<?php 
			$count = runFunc("getGroupBuyJoinedList",array($user_id,$this->_tpl_vars["IN"]["page"],15,true));
			if($count[0]["count"]>5):?>
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberGroupBuyJoined&user_id='.$user_id));?>" style="color:#795881; margin-right: 9px; margin-top: 6px;" class="fr">View All</a>
			<?php endif;?>
		</div>
		<div class="full_width_box oh">
		<div id="group_buy_first_item_box" class="fl">
		<?php if(count($items)>0):?>
		<?php foreach($items as $item):?>
		
		<div class="group_buy_item_box oh">
			<div class="price_message fl">
				<?php if($item["sell_way"]==1):?>
				<div style="background:#bad782;" class="group_buy_price"><?php echo (1 - $item["price_rate"]) * 100;?>% off</div>
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

			<?php if($item["end_time"]<date("Y-m-d")):?>
				<div class="off_div">
					The deal is off !
				</div>
			<?php elseif($item["group_size"]>$item["count"] or $item["start_time"]>date("Y-m-d")):?>
			<div class="pending_div">
				+ <font style="color:#ff9090"><?php echo $item["count"];?></font> Pending!
			</div>
			<?php elseif($item["start_time"]!="" and $item["end_time"]>=date("Y-m-d")):?>
				<div class="starting_div">
				
					Over <font style="color:#ff9090"><?php echo $purchase_count[0]["count"];?></font> bought
				</div>
				<?php endif;?>
				<a style="margin-right:11px;" class="little_blue_button fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$item["id"]));?>">View</a>
			</div>
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
		<?php endforeach;?>
		
		<?php else:?>
		<div class="no_posts_word" style="text-align:center; margin-top: 111px;">
		The quick brown fox jumps over the lazy dog ^_^
		</div>	
		<?php endif;?>
			<?php 
			
	if($this->_tpl_vars["IN"]["page"]==""){
					
		$page = 1;
	}else{
		
		$page = $this->_tpl_vars["IN"]["page"];
	}

	echo runFunc("pageNavi",array($items_count[0]["count"],15,"share","memberGroupBuy&user_id=".$user_id,$page));?>
	
		</div>
		<div id="group_buy_hot_deals_box" class="fr">
		<?php $joined_items = runFunc("getGroupBuyJoined",array($user_id));?>
		
		<?php foreach($joined_items as $key=>$joined_item):?>
		<?php $hot_items = runFunc("getSiteGroupBuyItem",array($joined_item["ItemGoodsID"]));
				$hot_item = $hot_items[0];
		?>
		<div class="group_buy_hot_deal_single_box">
		<div class="hot_deal_title">
		<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$hot_item["id"]));?>"><?php echo $hot_item["item_name"];?></a>
		</div>
		<div class="hot_deal_intro">
		<?php echo $hot_item["description"];?>
		</div>
		<div class="hot_deal_timer oh">
		<?php if($hot_item["end_time"]<date("Y-m-d")):?>
				<div class="off_div" style="margin-bottom:10px;">
					The deal is off !
				</div>
		<?php elseif($hot_item["group_size"]>$hot_item["count"] or $hot_item["start_time"]>date("Y-m-d")):?>
	<div class="pending_div" style="margin-bottom:0;margin-right:0">
		+ <font style="color:#ff9090"><?php echo $hot_item["count"];?></font> Pending!
	</div>
	<?php elseif($hot_item["start_time"]!="" and $hot_item["end_time"]>=date("Y-m-d")):?>
		<div class="starting_div" style="margin-bottom:0;">
		
			Over <font style="color:#ff9090"><?php echo $hot_item["count"];?></font> bought
		</div>
		<?php endif;?>
		</div>
		<?php if($key==0):?>
		<div class="hot_deal_detail oh">
		<div class="price_message fl">
		<?php if($hot_item["sell_way"]==1):?>
		<div style="background:#bad782;" class="group_buy_price">20% off</div>
		<div class="goods_price">Service <br />fee</div>
		<?php else:?>
		<div class="group_buy_price">￥<?php echo number_format($hot_item["goodsUnitPrice"]*$hot_item["price_rate"], 2, '.', ',');?></div>
		<div class="goods_price">￥<?php echo number_format($hot_item["goodsUnitPrice"], 2, '.', ',');?><br />value</div>
		<?php endif;?>
		</div>
		<img class="hot_deal_img" src="<?php echo $hot_item["goodsImgURL"]?>_310x310.jpg" alt="" />
		</div>
		<?php endif;?>
		<div class="hot_deal_link_box oh"><a class="fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$hot_item["id"]));?>"><img src="../skin/images/link_arraw.png" alt="" /></a></div>
		
		
		</div>
		<?php endforeach;?>				
		</div>
				
				
				</div>
	<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</div>
</body>
</html>

