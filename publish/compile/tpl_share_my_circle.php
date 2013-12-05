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
<body onLoad="window.location.hash = 'here'">
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$circle = runFunc("getCircleByUserId",array($this->_tpl_vars["name"]));
	$check = runFunc("checkJoin",array($circle[0]["user_id"],$this->_tpl_vars["name"]));
	
	$posts = runFunc("getCircleMyJoinPost",array($this->_tpl_vars["name"],1,5));
	
	$posts_count = runFunc("getCircleMyJoinPost",array($this->_tpl_vars["name"],1,5,true));
	$member_count = runFunc("getCircleMember",array($circle[0]["id"],10,true));
	
	$last_comment = runFunc("getCircleLastActivity",array($circle[0]["id"]));
	getCircleMyJoinPost
	?>
	
<div class="content">
<?php 

	$inc_tpl_file=includeFunc("account/common/header.tpl");
	
	include($inc_tpl_file);
?>
<div class="circle_page_content">
	<div class="circle_page_left fl">
	<div class="circle_page_content_bar">
		Joined Shop
	</div>
	<div class="circle_page_members">
		<?php $circle_joins = runFunc("getCircleMyJoin",array($this->_tpl_vars["name"]));?>
		<?php foreach($circle_joins as $circle_join):?>
		<div class="circle_member_box oh">
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle_join["id"]));?>">
				<img id="userimg" class="fl" src="../circles_img/<?php echo $circle_join["user_id"];?>/thumb_<?php echo $circle_join["img"];?>" alt="" />
				</a>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle_join["id"]));?>" class="circle_member_name fl">
				<?php if(strlen($circle_join["name"])> 10){	
					echo mb_substr($circle_join["name"],0,10,'utf-8')."...";
				}else{
					echo $circle_join["name"];
				}?>
				</a>
				<a class="circle_my_box_post_quick fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle_join["id"]));?>">+post</a>
			</div>
		<?php endforeach;?>
	</div>
	</div>
	<div class="circle_page_center fl">
		<div class="circle_page_content_bar oh" style="margin-bottom: 14px;">
			<?php if($circle[0]["user_id"]==$this->_tpl_vars["name"]):?>
			<a style="color:#777777;padding:0 5px;font-size:11px;" class="gray_line_box fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=circleEdit&id='.$circle[0]["id"]));?>">Edit Shop</a>
			<a style="color:#777777; padding:0 5px;width: auto; margin-left: 5px;" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));?>" class="circle_post_button gray_line_box fl">Enter my Shop</a>
			<?php endif;?>
			<?php if(count($circle)>0):?>
				<a style="color:#777777;" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle[0]["id"]));?>" class="circle_post_button gray_line_box fr">
					New Post
				</a>
			<?php else:?>
			<a style="color:#777777;width: 110px;" href="<?php echo runFunc('encrypt_url',array('action=share&method=circleCreate'));?>" class="circle_post_button gray_line_box fr">
				Create a Shop
			</a>
			
			<?php endif;?>
		</div>
		<div class="circle_page_post_main_box">
		<?php if(count($posts)>0):?>
		<?php foreach ($posts as $post):?>
		<?php $imgs = runFunc("getPostImg",array($post["id"],3));?>
		<div class="circle_page_post_box">
		<div class="circle_page_post_box_top oh">
			<div class="circle_page_post_title_box fl">
				<a class="circle_post_title" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$post["circle_id"]));?>"><?php echo $post["title"];?></a>
			</div>
			<?php if($this->_tpl_vars["name"] == $post["user_id"]):?>
			<div class="post_ctrl_bar fr">
				<a class="post_ctrl_bar_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostEdit&id='.$post["id"].'&circle_id='.$post["circle_id"]));?>"></a>
				<a id="<?php echo $post["id"];?>" onClick="delete_post(this)" class="post_ctrl_bar_delete"></a>
			</div>
			<?php endif;?>
		</div>		
	<?php if(count($imgs)>0):?>
			<div class="circle_post_content">
			<table class="">
	 				<tr>
	 					<?php foreach($imgs as $img):?>
	 					<td>
	 					<a href='<?php echo runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$post["circle_id"]));?>' class="img_in_circle_post">
	 					<img src="../circle_post_img/<?php echo $post["user_id"];?>/<?php echo "thumb_".$img["img"];?>" alt="" />
	 					</a>
	 					</td>
	 					<?php endforeach;?>
	 				</tr>
	 			</table>
			</div>
			<?php else:?>
			<div class="circle_post_content circle_only_text">
	 			<?php if(strlen($post["comment"])> 250){	
					echo mb_substr($post["comment"],0,250,'utf-8')."...";
				}else{
					echo $post["comment"];
				}?>
	 		</div>
	 		<?php endif;?>
	 		<div class="circle_post_footer oh">
				<div class="post_created fl">
					From: <a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$post["circle_id"]));?>">
						<?php if(strlen($post["name"])> 20){	
								echo mb_substr($post["name"],0,20,'utf-8')."...";
							}else{
								echo $post["name"];
							}?>
					</a>
				&nbsp;	&nbsp;	&nbsp;
				Post by: <a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$post["user_id"]));?>">
						<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($post["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?></a>
				</div>
				
				<div class="post_comment_count fr">
				<?php $comment_count = runFunc("getComment",array($post["id"],"CIRCLE POST",true));?>
					<?php echo $comment_count[0]["count"];?> Comments
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<?php else:?>
		<div class="no_posts_word">
		The quick brown fox jumps over the lazy dog ^_^
		</div>
		<?php endif;?>
		</div>
		<?php if(count($posts_count)>5):?>
		<div class="show_more_circle">
			<a class="more_circle_post_link">More <img src="../skin/images/double_arrow_right.png" alt="" /></a>
		</div>
		<?php endif;?>
	</div>
	<div class="circle_page_right fl">
		
	</div>
</div>
<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</div>
<script type="text/javascript">

	function delete_post(el){

		if(!confirm('Confirm to delete your post?')){
			return false;
		}
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl");
			var id = $(el).attr("id");
			var delete_post_box = $(el).parent().parent().parent(".circle_page_post_box");
			var post_created = $(el).parent().parent().parent(".circle_page_post_box").children(".circle_post_footer").children(".post_created");
			loading_icon.insertAfter(post_created);
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: "share",
					method	: "circlePostDelete",
					id: id
				},
				success : function(json)
				{
						if(json.result == true){
		
								$(delete_post_box).remove();
								loading_icon.remove();
							}
				}
			});
		}

	$(function(){

		var page = 1;
		var more_pending = 0;
		
		$(".more_circle_post_link").click(function(){
			if(more_pending == 0){
				more_pending = 1;
				page = page + 1;
			}else{
				return false;
			}
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl");
			$(".show_more_circle").append(loading_icon);
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "text",
					data:{
						action	: "share",
						method	: "myCirclePostMore",
						page: page
					},
					success : function(data)
					{
						if(data==0){
							$(".show_more_circle").remove();
						}else{
						more_pending = 0;
						$(".circle_page_post_main_box").append(data);
						loading_icon.remove();
						}
					}
				});
			});

		});
</script>
</body>
</html>
