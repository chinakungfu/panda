<?php import('core.util.RunFunc');
$this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
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
	
	$circles = runFunc("getCircles",array(1,100000,$this->_tpl_vars["IN"]["id"]));
	?>
	
<div class="content">
	<div class="content_top_bar oh">
		<h2 class="cp_title fl">
			WOW Bazaar
		</h2>
	</div>
	<div class="circle_top_box">
		<div class="circle_top_box_title">
			
		</div>
		<div class="circle_top_box_content oh">
			<?php $my_circle =  runFunc("getCircleByUserId",array($this->_tpl_vars["name"]));?>
			<div class="circle_top_box_left fl">
			<?php if(count($my_circle)>0):?>
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$my_circle[0]["id"]));?>" >
				<img class="circle_box_img fl" src="../circles_img/<?php echo $my_circle[0]["user_id"];?>/<?php echo $my_circle[0]["img"];?>" alt="" class="circle_box_img" />
			</a>
				<div class="my_circle_detail fl">
				<div class="my_circle_detail_box_top">
					<h2 class="my_circle_title">
					<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$my_circle[0]["id"]));?>" >
						<?php echo $my_circle[0]["name"];?>
					</a>
					</h2>
					<?php 
						$member_count = runFunc("getCircleMember",array($my_circle[0]["id"],10,true));
						$last_comment = runFunc("getCircleLastActivity",array($my_circle[0]["id"]));
					?>
					<div class="my_circle_detail_1">
						<span><?php echo $member_count[0]["count"];?> members</span> <br />
						<?php if(count($last_comment)>0):?>
						<span>Latest Activity: <?php echo date("M d",strtotime($last_comment[0]["created"]));?></span>
						<?php endif;?>
					</div>
				</div>
	
				</div>
			<?php else:?>
			
			<a class="create_circle_link_big" href="<?php echo runFunc('encrypt_url',array('action=share&method=circleCreate'));?>">Open your own shop now</a>
			
			<?php endif;?>
			</div>
			<div class="circle_top_box_right fr">
				<div class="circle_top_box_right_title">
				<a class="<?php if($this->_tpl_vars["IN"]["id"] == ""){echo "circle_about_active";}?> circle_about_filter_button" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlesMain'));?>">
					All Shops
				</a>
				</div>
				<div class="circle_top_box_right_content">
				<?php $tags =  runFunc("getCircleTags");?>
				<?php foreach ($tags as $tag):?>
					<a class="<?php if($this->_tpl_vars["IN"]["id"] == $tag["id"]){echo "circle_about_active";}?> circle_about_filter_button" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlesMain&id='.$tag["id"]));?>"><?php echo $tag["title"];?></a>
				<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<div class="circle_box_main">
	<?php if(count($circles)>0):?>
	<?php foreach($circles as $circle):
	$member_count = runFunc("getCircleMember",array($circle["id"],10,true));
	$last_comment = runFunc("getCircleLastActivity",array($circle["id"]));
	if($circle["user_id"]==$this->_tpl_vars["name"]){
		
		//continue;	
	}
	?>
	<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle["id"]));?>" class="circle_single_box fl">
			<img class="circle_box_img fl" src="../circles_img/<?php echo $circle["user_id"];?>/<?php echo $circle["img"];?>" alt="" class="circle_box_img" />
			<div class="circle_single_info_box fl">
				<h2 class="circle_single_info_title">
				<?php if(strlen($circle["name"])> 30){	
					echo mb_substr($circle["name"],0,30,'utf-8')."...";
					}else{
						echo $circle["name"];
					}?>
				</h2>
				<div class="circle_single_detail">
					<span>Created by 
					 <?php $user_info = runFunc("getShareMemberInfoAllInOne",array($circle["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?>
					</span> <br />
					<span><?php echo $member_count[0]["count"];?> members</span> <br />
					<?php if(count($last_comment)>0):?>
					<span>Latest Activity: <?php echo date("M d",strtotime($last_comment[0]["created"]));?></span>
					<?php endif;?>
				</div>
				<div class="circle_single_intro">
					<?php if(strlen($circle["introduction"])> 100){	
					echo mb_substr($circle["introduction"],0,100,'utf-8')."...";
					}else{
						echo $circle["introduction"];
					}?>
				</div>
			</div>
		</a>
	<?php endforeach;?>
	<?php else:?>
	
	<div style="color:#D0D0D0;margin-top:120px;text-align:center;font-size:16px;">No This Kind Circles Temporarily</div>
	<?php endif;?>
	</div>
</div>
	
	</div>
<?php $inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
?>
</body>
</html>2012/12/18