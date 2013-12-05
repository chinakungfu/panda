<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
//************************select country***************************************
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); 
?>
<?php if ($this->_tpl_vars["name"]){?>

<!DOCTYPE HTML>
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
<body onload="window.location.hash = 'here'">
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
	$inc_tpl_file=includeFunc("share/common/header.tpl");
	include($inc_tpl_file);
	
	
	$lists = runFunc('getMemberWishList',array($user_id,$this->_tpl_vars["IN"]["page"],8));
	$lists_count = runFunc('getMemberWishList',array($user_id,$this->_tpl_vars["IN"]["page"],4,true));
	?>
	
		<div class="content">
		<div class="full_width_box oh">
			<div class="box_inner_left fl">
				<div class="box_inner_bar oh">
					<h2 class="full_box_title fl">My Wish List (<?php echo $lists_count[0]["count"];?>)</h2>
				</div>
				<div class="member_list_box oh" style="border: 0;">
				<?php if(count($lists)>0):?>
				<?php foreach($lists as $list):?>
				<div class="member_wish_list_box oh">
					<div class="member_wish_list_box_img  fl">
						<img width="50px" src="<?php echo $list["goodsImgURL"]?>_310x310.jpg" alt="" />
					</div>
					<div class="member_wish_list_detail fl">
						<div class="member_wish_list_title">
							<?php echo $list["goodsTitleCN"];?>
						</div>
						<div class="member_wish_list_price">
							￥<?php echo number_format($list["goodsUnitPrice"], 2, '.', ',')?>
						</div>
						<?php $group_buy = runFunc("checkItemGroupBuy",array($list["goodsid"]));?>
						<?php if(count($group_buy)>0):?>
						<div class="member_wish_list_group_buy">
							Group Buy
						</div>
						<?php endif;?>
					</div>
					
					<?php
							if(count($group_buy)>0){
								
								$link = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$group_buy[0]["id"]));
							}else{
								
								$link = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$list["goodsid"]."&show_type=collections&from=collections_page"));
							}
						?>
					<a class="little_blue_button fr member_wish_list_view" href="<?php echo $link;?>">View</a>
				</div>
				
				<?php endforeach;?>
					<?php 
			
						if($this->_tpl_vars["IN"]["page"]==""){
										
							$page = 1;
						}else{
							
							$page = $this->_tpl_vars["IN"]["page"];
						}
					
						echo runFunc("pageNavi",array($lists_count[0]["count"],8,"share","myWishList&user_id=".$user_id,$page));?>
						<style type="text/css">
							
							.main_page_nav {
								margin-top: 20px;
							}
							
							.main_page_nav a  {
								margin-left: 0;
								margin-right: 5px;
							}
						
						</style>
						
				<?php else:?>
				
				<div class="no_posts_word" style="text-align:center; margin-top: 111px;">
				The quick brown fox jumps over the lazy dog ^_^
				</div>			
				<?php endif;?>
				</div>
			</div>
			<div class="list_love_page box_inner_right fr">
				
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
<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc("common/account_passPara.tpl");
		include($inc_tpl_file);
		?>

<?php } ?>