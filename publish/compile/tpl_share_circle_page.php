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
	
	$circle = runFunc("getCircleById",array($this->_tpl_vars["IN"]["id"]));
	$check = runFunc("checkJoin",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"]));
	
	$posts = runFunc("getCirclePostByCircleId",array($this->_tpl_vars["IN"]["id"],5,1));
	$posts_count = runFunc("getCirclePostByCircleId",array($this->_tpl_vars["IN"]["id"],5,1,true));
	$member_count = runFunc("getCircleMember",array($this->_tpl_vars["IN"]["id"],10,true));
	
	$last_comment = runFunc("getCircleLastActivity",array($this->_tpl_vars["IN"]["id"]));
	
	
	
	?>
	
<div class="content">

	<div class="content_top_bar oh">
		<h2 class="cp_title fl">
			WOW Bazaar 
		</h2>
	</div>
	<div class="circle_top_box oh" style="padding-bottom: 3px">
		<div class="circle_top_box_title">
			
		</div>
		<div class="circle_top_box_content oh">
			<div class="circle_top_box_left fl">
				<img class="circle_box_img fl" src="../circles_img/<?php echo $circle[0]["user_id"];?>/<?php echo $circle[0]["img"];?>" alt="" class="circle_box_img" />
				<div class="my_circle_detail fl">
					<div class="my_circle_detail_box_top">
					<span class="circle_page_created">Created by </span><a class="circle_page_create_link" href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$circle[0]["user_id"]));?>">
			   <?php $user_info = runFunc("getShareMemberInfoAllInOne",array($circle[0]["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?></a>
					<h2 class="my_circle_title">
						<?php echo $circle[0]["name"];?>
					</h2>
					<?php if(count($check)>0 and $this->_tpl_vars["name"]!=$circle[0]["user_id"]):?>
					<div class="oh">
					<a onClick="javascript: return confirm('Confirm to give up this circle?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$this->_tpl_vars["IN"]["id"]));?>" class="circle_quit_link fl">Give up</a>
					</div>
					<?php endif;?>
					<div class="my_circle_detail_1">
						<span class="my_circle_member_count"><?php echo $member_count[0]["count"];?> members</span> <br />
						<?php if(count($last_comment)>0):?>
						<span>Latest Activity: <?php echo date("M d",strtotime($last_comment[0]["created"]));?></span>
						<?php endif;?>
					</div>
					</div>
					<div class="my_circle_detail_2">
						<table>
							<tr>
								<td>
								<?php if($this->_tpl_vars["name"]):?>
								<?php if(count($check)<1):?>
									<div id="circle_join_button" class="blue_button_large">Join</div>
								<?php endif;?>
								<?php else:?>
										<?php 
											$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
											$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
											$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
											$this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]);
										?>
									<div id="circle_login_msg"><a href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=event_page&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">Login</a> to join </div>
								<?php endif;?>
								</td>
							</tr>
						</table>					    
					</div>
				</div>
			</div>
			<div class="circle_top_box_right_inner fr">
				<div class="circle_page_intro gray_line_box">
					<div style="padding:10px;">
					<?php echo $circle[0]["introduction"];?>
					</div>
				</div>	
			</div>
	</div>
		
		<?php if($this->_tpl_vars["name"]!=""):?>
				<select name="" id="quick_back" style="float: right; margin-left: 0px; margin-right: 14px; margin-top: 14px;position:static">
					<option value="">My Pages</option>
					<option value="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&user_id='.$this->_tpl_vars["name"]));?>">Home Page</option>
					<option value="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList'));?>">Style Lists</option>
					<option value="">Polls</option>
					<option value="">Group Buy</option>
					<option value="<?php echo runFunc('encrypt_url',array('action=share&method=myCircle'));?>">WOW Bazaar</option>
					<option value="">Live Events</option>
					<option value="">Friends</option>
				</select>
		<?php else:?>
		<div style="height:16px;">&nbsp;</div>	
		<?php endif;?>
		
				<script type="text/javascript">
					$(function(){
							$("#quick_back").change(function(){
								if($(this).val()!=""){
				
									window.location.href=$(this).val();
									}
								});
						});
				</script>
</div>

<div class="circle_page_content oh" style="min-height: 400px;">
	<div class="circle_page_left fl">
		<div class="circle_page_content_bar">
			This shop's owner
		</div>
		<div class="circle_member_box oh">

			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$user_info[0]["user_id"]));?>">
			<?php $avatar = "../publish/avatar/".$user_info[0]["user_id"]."_thumb.".$user_info[0]["headImageUrl"];?>
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
			</a>	
				<div class="circle_member_name fl">
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$user_info[0]["user_id"]));?>">
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?>
					</a>
				</div>
				
		</div>
		<div class="circle_page_content_bar">
			Members In This Shop
		</div>
		<div class="circle_page_members">
		<?php $members = runFunc("getCircleMember",array($this->_tpl_vars["IN"]["id"],100));?>
		<?php foreach($members as $member):?>
			<?php if($member["user_id"] == $user_info[0]["user_id"] or $member[staffName]=="")continue;?>
			<div class="circle_member_box oh">
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$member["user_id"]));?>">
			<?php $avatar = "../publish/avatar/".$member["user_id"]."_thumb.".$member["headImageUrl"];?>
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
			</a>	
				<div class="circle_member_name fl">
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$member["user_id"]));?>">
					<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($member["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?>
					</a>
				</div>
				
			</div>
		<?php endforeach;?>
		<?php if(count($members)>10000):?>
		<div class="show_more_member">
			More <img src="../skin/images/double_arrow_right.png" alt="" />
		</div>
		<?php endif;?>
		</div>
	</div>
	<div class="circle_page_center fl">
		<div class="circle_page_content_bar oh" style="margin-bottom: 14px;">
			<?php if($circle[0]["user_id"]==$this->_tpl_vars["name"]):?>
			<a style="color:#777777;padding:0 5px" class="gray_line_box fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=circleEdit&id='.$circle[0]["id"]));?>">Edit shop</a>
			<?php endif;?>
			<?php if(count($check)>0):?>
				<a style="color:#777777;" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle[0]["id"]));?>" class="circle_post_button gray_line_box fr">
					New Post
				</a>	
				
				<a id="showQucikBox" class="circle_post_button gray_line_box fr">Shout box</a>
			<?php else:?>
				<a class="no_login_or_join fr">
					Please login and join this shop to post or buy !
				</a>		
			<?php endif;?>
		</div>
		<div class="quick_post_box hide">
			<textarea name="quick_post_send" id="quick_post_send" cols="30" rows="10"></textarea>
			<div id="quick_post_box_bottom_box" class="oh" style="background:#FEFCF8">
				<span id="qucik_post_msg_box" class="fl" style="margin-left:5px;">
					Maximum of 250 characters
				</span>
				<a class="quick_post_cancel_link">Cancel</a>
				<a class="quick_post_send_link">Post</a>
			</div>
		</div>
		<div class="circle_page_post_main_box">
		<?php if(count($posts)>0):?>
		<?php foreach ($posts as $post):?>
		<?php $imgs = runFunc("getPostImg",array($post["id"],3));?>
		<div class="circle_page_post_box">
		<div class="circle_page_post_box_top oh">
			<div class="circle_page_post_title_box fl">
				<a class="circle_post_title" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"]));?>"><?php echo $post["title"];?></a>
			</div>
			<?php if($this->_tpl_vars["name"] == $post["user_id"]):?>
			<div class="post_ctrl_bar fr">
				<a class="post_ctrl_bar_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostEdit&id='.$post["id"].'&circle_id='.$circle[0]["id"]));?>"></a>
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
	 					<a href='<?php echo runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$post["id"].'&circle_id='.$circle[0]["id"]));?>' class="img_in_circle_post">
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
					echo mb_substr(stripslashes($post["comment"]),0,250,'utf-8')."...";
				}else{
					echo stripslashes($post["comment"]);
				}?>
	 		</div>
	 		<?php endif;?>
	 		<div class="circle_post_footer oh">
				<div class="post_created fl">
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
		<?php if($posts_count[0]["count"]>5):?>
		<div class="show_more_circle">
			<a class="more_circle_post_link">More <img src="../skin/images/double_arrow_right.png" alt="" /></a>
		</div>
		<?php endif;?>
	</div>
	<?php $events =  runFunc("getEventByCircleId",array($this->_tpl_vars["IN"]["id"],1,6));?>
	<?php $events_count =  runFunc("getEventByCircleId",array($this->_tpl_vars["IN"]["id"],1,6,true));?>
	<div class="circle_page_right fl">
		<div class="circle_page_content_bar oh" style="margin-bottom: 14px;font-size: 12px;">
			<div style="margin-right:5px;display:inline;" class="fl">Event of This Shop</div>
			
			<a id="create_event_button" style="color:#777777;font-size:11px;width: 70px;" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventCreate&circle_id='.$this->_tpl_vars["IN"]["id"]));?>" class="<?php if(count($check)<1){echo "hide";}?> circle_post_button gray_line_box fr">
				Create new
			</a>
		</div>
		<?php foreach ($events as $event):?>
		<div class="circle_event_box">
			<a class="circle_event_box_title" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">
				<?php if(strlen($event["name"])> 55){	
					echo mb_substr($event["name"],0,55,'utf-8')."...";
					}else{
						echo $event["name"];
					}?>
			</a>
			<div class="circle_event_box_detail oh">
				<div class="circle_event_img fl">
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">
					<img width="148px" src="../circle_event_img/<?php echo $event["user_id"]?>/<?php echo $event["img"]?>"/>
				</a>
				</div>
				<div class="circle_event_msg fl">
				<?php $event_time = runFunc("getEventTime",array($event["id"]));?>
				<?php echo date("Y.m.d",strtotime($event_time[0]["start_date"]));?>
				<br />
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event["id"]));?>">Join(<?php echo $event["member_count"];?>)</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
		<?php if($events_count[0]["count"] > 6):?>
		<div class="list_nav cicle_event_list_nav" style="margin-bottom: 0;width: 100%;">
			<a class="prev fl">Prev</a>
			<a class="next fr">Next</a>
		</div>
		<?php endif;?>
		<?php echo runFunc("getSiteAdv",array("Discovery Circles","discovery_circles_adv"));?>
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


		var searching = 0;
		var page = 1;
		$(".list_nav .next").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetEvents",<?php echo $this->_tpl_vars["IN"]["id"];?>,"next");
		});

		$(".list_nav .prev").click(function(){
			if(searching == 1){
				return false;
			}
			get_item_list("share","ajaxGetEvents",<?php echo $this->_tpl_vars["IN"]["id"];?>,"prev");
		});


		function get_item_list(action,method,event_id,type){
			if(searching == 0){
				searching = 1;
				}else{
						return false;
					}
			if(type=="next"){
				page = page + 1;
			}else{
				page = page - 1;
				}
			if(page < 1){
					page = 1;
					searching = 0;
					return false;
				}
			$(".the_end_message").remove();
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl loading_list_now");
			loading_icon.insertBefore($(".next"));
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: action,
					method	: method,
					event_id : event_id,
					page: page,
					size: 6
				},
				success : function(json)
				{
					if(json == null || json.length ==0){
						page = page -1;
						loading_icon.remove();
						var the_end = $(document.createElement("span")).text("The end!").addClass("the_end_message");
						the_end.insertBefore($(".next"));
						searching = 0;
						return false;
					}
					$(".circle_event_box").remove();
					var event = "";
					for(var i=0;i<json.length;i++)
					{
						event += '<div class="circle_event_box">';
						event += '<a class="circle_event_box_title" href="'+json[i].event_link+'">'+json[i].name+'</a>';
						event += '<div class="circle_event_box_detail oh">';
						event += '<div class="circle_event_img fl">';
						event += '<a href="'+json[i].event_link+'">';
						event += '<img width="148px" src="../circle_event_img/'+json[i].user_id+'/'+json[i].img+'">';
						event += '</a>';
						event += '</div>';
						event += '<div class="circle_event_msg fl">';
						event += json[i].start_to_end;
						event += '<br>';
						event += '<a href="'+json[i].event_link+'">Join('+json[i].member_count+')</a>';
						event += '</div></div></div>';
					}

					$(event).insertAfter(".circle_page_right .circle_page_content_bar");
					
				},complete: function(){
					loading_icon.remove();
					searching = 0;
					}
			});
			}

		
		

		$("#quick_post_send").keyup(function(){
			var limit = 250 - $(this).val().length;
			var limit_word = "Maximum of "+ limit +" characters";

			if($(this).val().length >=250){
				$(this).val($(this).val().substring(0, 250));
				limit_word = "Maximum of 0 characters";
			}
			$("#qucik_post_msg_box").text(limit_word);
		});
<?php if($this->_tpl_vars["name"]!=""):?>
		$(".quick_post_send_link").click(function(){
			$(".error_qucik_box").remove();
			var post_content = $("#quick_post_send").val();
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm fl");
			var error_quick_post = 	$(document.createElement("span")).addClass("error_qucik_box fl").text("Please input your post.");
				loading_icon.insertAfter("#qucik_post_msg_box");
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "text",
					data:{
						action	: "share",
						method	: "quickPost",
						circle_id: <?php echo $this->_tpl_vars["IN"]["id"];?>,
						post_user_id: <?php echo $this->_tpl_vars["name"];?>,
						comment: post_content
					},
					success : function(data)
					{
						if(data == "empty"){
							loading_icon.remove();
							error_quick_post.insertAfter("#qucik_post_msg_box");
							$("#quick_post_send").val("");
							return false;
							}
						
						$(".circle_page_post_main_box").prepend(data);
						loading_icon.remove();
						$("#quick_post_send").val("");
						$(".quick_post_box").slideUp();
						$(".no_posts_word").remove();
					}
				});
				
			
			});

		$(".quick_post_cancel_link").click(function(){
				$(".quick_post_box").slideUp();
			});
		
		$("#showQucikBox").click(function(){
				$(".quick_post_box").slideDown();
			});
		<?php endif;?>
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
						method	: "circlePostMore",
						id: <?php echo $this->_tpl_vars["IN"]["id"];?>,
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

		
var joining = 0;
		$("#circle_join_button").click(function(){

			if(joining == 0){
				joining =1
				}
			else{

				return false;
				}
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
				$("#circle_join_button").removeClass("blue_button_large");
				$("#circle_join_button").text("");
				$("#circle_join_button").append(loading_icon);
			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: "share",
					method	: "circleJoin",
					id: <?php echo $this->_tpl_vars["IN"]["id"];?>
				},
				success : function(json)
				{
					$(".my_circle_member_count").text(json.count + " members");
					$(loading_icon).remove();
					$("#circle_join_button").text("Join success!");
					var quit_link = "<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$this->_tpl_vars['IN']['id']));?>";
					var quit_button = $(document.createElement("a")).attr("href",quit_link).addClass("circle_quit_link").text('Give up').attr("onClick","javascript: return confirm('Confirm to give up this circle?')");
					$(quit_button).insertAfter($(".my_circle_title"));
					var post_link = "<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle[0]["id"]));?>";
					var post_button = '<a style="color:#777777;" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle[0]["id"]));?>" class="circle_post_button gray_line_box fr">New Post</a>';
					$(".circle_page_center .circle_page_content_bar").append(post_button);
					var quick_post_link = $(document.createElement("a")).attr("id","showQucikBox").addClass("circle_post_button gray_line_box fr").text("Shout box");
					$(".circle_page_center .circle_page_content_bar").append(quick_post_link);
					quick_post_link.click(function(){
						$(".quick_post_box").slideDown();
							});
					$(".no_login_or_join").remove();
					$("#create_event_button").removeClass("hide");
					$(".circle_page_members").children().remove();
					$(".circle_page_members").append(json.members_html);
				}
			});
			});
		});
</script>
</body>
</html>