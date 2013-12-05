<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
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

	$inc_tpl_file=includeFunc("account/common/header.tpl");

	include($inc_tpl_file);
	
	if($this->_tpl_vars["IN"]["page"]==""){
							
				$page = 1;
			}else{
				
				$page = $this->_tpl_vars["IN"]["page"];
			}
	
	?>
		<div class="content">
			<div class="full_width_box oh">
				<?php $member =  runFunc("getStaffInfoById",array($this->_tpl_vars["name"]));?>
				<?php $messages = runFunc("getMemberMessageByToId",array($this->_tpl_vars["name"],$page,15,false));?>
				<div class="my_home_page_top_bar oh">
					<h2 class="my_home_page_title_left">Activity Stream <a onClick="javascript: return confirm('Do you confirm to ignore all message?')" style="color: #5E97ED;font: 11px/40px Verdana,Arial;margin-top:27px;margin-left:5px;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=ignore_all_message'));?>">Ignore all message</a></h2>
				</div>
				<div class="member_message_box oh">
					<div class="my_home_page_message_contain">
					<?php if(count($messages)>0):?>
					<?php foreach($messages as $message):?>
						<div class="my_home_page_message_box oh ">
						<form class="read_message_form" action="index.php" method="post">
						<?php $avatar = "../publish/avatar/".$message["from"]."_thumb.".$message["from_avatar_ext"];?>
						<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$message["from"]));?>">
							<?php if(file_exists($avatar)){?>
							<img class="fl" id="userimg" src="<?php echo $avatar."_40.".$message["from_avatar_ext"];?>" alt="userInfo" id="userHeaderImg" />
								<?php }else{ ?>
							<img class="fl" id="userimg" src="../skin/images/pic.jpg" alt="userInfo" />
							<?php } ?>
						</a>
							<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$message["from"]));?>" class="my_home_page_message_from fl">
								<?php echo $message["from_name"];?>
							</a>
							<div class="my_home_page_message_content fl">
								<?php echo $message["content"];?>
								<?php if($message["message_type"]=="FRIEND REQUEST" and $message["readed"] == 0):?>
							, you can <a href='<?php echo runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=confirm&message_id='.$message["id"].'&user_id='.$message["from"]));?>'>confirm</a> or <a href='<?php echo runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=refuse&message_id='.$message["id"].'&user_id='.$message["from"]));?>'>refuse</a>
							
							<?php endif;?>
								<?php if($message["message_content"]!=""):?>
								<br/>Message:
								<?php echo $message["message_content"];?>
								<?php endif;?>
							</div>
						<input type="hidden" name="action" value="website"/>
						<input type="hidden" name="method" value="readMessage"/>
						<input type="hidden" name="id" value="<?php echo $message["id"];?>" />
						<input type="hidden" name="link" value="<?php echo $message["link"];?>"/>
						</form>
						<?php if($message["readed"]==0){?>
						<img class="fr" src="../skin/images/unread.png" title="unread" alt="" />
						<?php }?>
						</div>
					<?php endforeach;?>
					<?php 
					$messages_count = runFunc("getMemberMessageCount",array($this->_tpl_vars["name"]));
					
					echo runFunc("pageNavi",array($messages_count[0]["count"],15,"share","messageAll",$page));
					?>
					<?php else:?>
					<div class="home_page_no_message">
						No Activity Stream Temporarily <br />
						<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=friendInvite'));?>">Invite Friends</a>
					</div>
					<?php endif;?>	
					</div>
				</div>
			</div>
			</div>	
		<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>

<script type="text/javascript">
	$(function(){

		$(".read_message").click(function(){

			$(this).parent().parent(".read_message_form").submit();
		});
	
		});
</script>
<style type="text/css">
	.main_page_nav{
		margin-top: 10px;
	}
</style>
</body>
</html>
<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc("common/account_passPara.tpl");
		include($inc_tpl_file);
		?>

<?php } ?>