<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); 
?>

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
	
	$friends = runFunc("getAllFriend",array($user_id)); 
	
	?>
		<div class="content">
			<div class="full_width_box oh">
				
			<div class="member_event_box oh fl">
				<div style="width:675px;" class="my_home_page_top_bar oh">
					<h2 style="text-indent: 0;width:auto" class="my_home_page_title_left fl">Friends (<?php echo count($friends);?>)</h2>
				</div>
				<div class="friend_box oh">
					<?php foreach($friends as $friend):?>
					<?php if($friend["member_one"] == $user_id){
						
						$friend_id = $friend["member_two"];
					}else{
						
						$friend_id = $friend["member_one"];
					}?>
					
					<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($friend_id));?>
					<div class="circle_member_box oh">
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$friend_id));?>">
						
						<?php $avatar = "../publish/avatar/".$friend_id."_thumb.".$user_info[0]["headImageUrl"];?>
							<?php if(file_exists($avatar)){?>
								<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
							<?php }else{?>
								<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
							<?php }?>
						</a>	
							<div class="circle_member_name fl">
							<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$friend_id));?>">
										<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
											<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
										<?php elseif($user_info[0]["show_nick"]==1):?>
											<?php echo $user_info["0"]["staffName"];?>
										<?php else:?>
											<?php echo $user_info["0"]["staffNo"];?>
										<?php endif;?>
								</a>
							</div>
							<div class="friend_ctrl fl">
								<?php $d_name = ""; if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
											<?php if($user_info[0]["first_name"]!=""){$d_name .= $user_info[0]["first_name"]."&nbsp;";} $d_name .= trim($user_info[0]["last_name"]);?>
										<?php elseif($user_info[0]["show_nick"]==1):?>
											<?php $d_name .= $user_info["0"]["staffName"];?>
										<?php else:?>
											<?php $d_name .= $user_info["0"]["staffNo"];?>
										<?php endif;?>
							<?php if($user_id == $this->_tpl_vars["name"]):?>
								<a href="<?php echo runFunc('encrypt_url',array('action=share&method=deleteFriend&friend_id='.$friend_id));?>" onClick="javascript: return confirm('Remove <?php echo $d_name;?> as a friend?')" href=""><img src="../skin/images/unfriend.png" alt="" /></a>
							<?php endif;?>
							</div>
							
						</div>
					
					<?php endforeach;?>	
				</div>
			</div>
		</div>
		</div>
</div>
<?php $inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
?>
<style type="text/css">
	.main_page_nav{
		margin-top: 10px;
	}
</style>
</body>
</html>