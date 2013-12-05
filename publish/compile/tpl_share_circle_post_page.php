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
	
	$circle = runFunc("getCircleById",array($this->_tpl_vars["IN"]["circle_id"]));

	$check = runFunc("checkJoin",array($this->_tpl_vars["IN"]["circle_id"],$this->_tpl_vars["name"]));
	
	$post = runFunc("getCirclePost",array($this->_tpl_vars["IN"]["id"]));
	
	$check_love = runFunc("checkMemberLove",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"],"CIRCLE POST"));
	
	$love_count = runFunc("getShareListLoveCount",array($this->_tpl_vars["IN"]["id"],"CIRCLE POST"));
	
	$imgs = runFunc("getCirclePostImg",array($this->_tpl_vars["IN"]["id"]));
	
	$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"CIRCLE POST"));
	
	$member_count = runFunc("getCircleMember",array($this->_tpl_vars["IN"]["circle_id"],10,true));
	
	$last_comment = runFunc("getCircleLastActivity",array($this->_tpl_vars["IN"]["circle_id"]));
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
			<div class="circle_top_box_left fl">
			
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$this->_tpl_vars["IN"]["circle_id"]));?>">
				<img class="circle_box_img fl" src="../circles_img/<?php echo $circle[0]["user_id"];?>/<?php echo $circle[0]["img"];?>" alt="" class="circle_box_img" />
			</a>
				<div class="my_circle_detail fl">
					<div class="my_circle_detail_box_top">
					<span class="circle_page_created">Created by </span><a class="circle_page_create_link" href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$circle[0]["user_id"]));?>"><?php $user_info = runFunc("getShareMemberInfoAllInOne",array($circle[0]["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?></a>
					<h2 class="my_circle_title">
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$this->_tpl_vars["IN"]["circle_id"]));?>"><?php echo $circle[0]["name"];?></a>
					</h2>
					<?php if(count($check)>0 and $this->_tpl_vars["name"]!=$circle[0]["user_id"]):?>
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$this->_tpl_vars['IN']['circle_id']));?>" onClick="javascript: return confirm('Confirm to give up this circle?')" class="circle_quit_link">Give up!</a>
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
									<div id="circle_login_msg"><a href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=circle_page&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">Login</a> to join !</div>
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
</div>
<div class="circle_page_content">
	<div class="circle_post_page_bar">
		<div class="circle_post_page_title">
			<?php echo $post["title"];?>
		</div>
	</div>
	<div class="circle_post_page_content">
		<div class="circle_post_page_info oh">
			<div class="post_creater_info fl">
				<?php $avatar = "../publish/avatar/".$post["user_id"]."_thumb.".$post["headImageUrl"];?>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$post["user_id"]));?>">
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
				</a>
				<div class="post_create_detail fl">
					Posted by <a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$post["user_id"]));?>"><?php echo $post["staffName"];?></a> <br />
					<?php echo $post["created"];?>
				</div>
			</div>

			<a class="list_show_list_love fr <?php if($check_love["count"] > 0){echo 'disable_love';}?> <?php if(count($check)<1){echo "hide";}?>">
			<?php if($check_love["count"] > 0):?>
						<img src="../skin/images/disable_heart_circle.png" alt="" />
					<?php else:?>
						<img src="../skin/images/heart_circle.png" alt="" />
					<?php endif;?>
						<br />
						<span class='love_count'><?php if($check_love["count"] > 0):?>Loved<?php else:?>Love<?php endif;?> (<?php echo $love_count["count"];?>)</span>
			</a>

		</div>
		<div class="circle_post_page_inner_box gray_line_box">
			<?php if(count($imgs)>0):?>
			<div class="post_page_img_nav">
			<div class="item_img_next"></div>
			<div class="item_img_prev"></div>
				<div class="circle_post_page_img_box">
					<img src="../circle_post_img/<?php echo $post["user_id"];?>/<?php echo $imgs[0]["img"];?>" alt="" />
				</div>
			</div>
			<?php endif;?>
			<div class="circle_post_page_img_title">
				<?php echo stripslashes($imgs[0]["title"]);?>
			</div>
			<div class="circle_post_page_inner_content">
				<?php echo $post["comment"];?>
			</div>
			<div style="width:550px;margin:auto" class="oh">
				<div class="attentionInfo" style="float: right; width: 127px;">
					<span class='st_email_large' displayText='Email'></span> 
					<span class='st_facebook_large' displayText='Facebook'></span> 
					<span class='st_twitter_large' displayText='Tweet'></span> 
					<span class='st_linkedin_large' displayText='LinkedIn'></span>
					<span class='st_pinterest_large' displayText='Pinterest'></span>
					<span class='st_googleplus_large' displayText='Google +'></span>
				</div>
			</div>
		</div>
		<div class="comment_box">
					<h2 class="gray_line_title">Comments <span id="comment_count">(<?php echo count($comments);?>)</span></h2>
					<div class="comment_main_box gray_line_box oh">
					<?php if(count($comments)):?>
					<?php foreach($comments as $key=>$comment):?>
					<?php if($key==1):?>
							<div class="other_comment_bar"></div>
						<?php endif;?>
					<div id="comment_box_<?php echo $comment["id"];?>" class="comment_talk_box">
							<div class="comment_msg">
								<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$comment["user_id"]));?>">
								<span><?php echo $comment["staffName"];?></span></a>&nbsp;&nbsp;&nbsp;
								<span class="create_time">at <?php echo $comment["created"];?></span>
							</div>
							<div class="comment_content oh">
								<div class="comment_creater fl">
									<div class="comment_creater_box">
										<?php $avatar = "../publish/avatar/".$comment["user_id"]."_thumb.".$comment["headImageUrl"]."_40.jpg";?>
										<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$comment["user_id"]));?>">
										<?php if(file_exists($avatar)){?>
											<img src="<?php echo $avatar;?>" alt="" />
										<?php }else{?>
											<img src="../skin/images/pic.jpg" />
										<?php }?>
										</a>
									</div>
									<a href="">+ Friend</a>
								</div>
								<div class="comment_detail fl">
									<div class="comment_detail_top">
										<p>
										<?php if($comment["reply_to"]>0){
											
											$reply = runFunc("getCommentById",array($comment["reply_to"],"CIRCLE POST"));
											?>
									<span style="color:#5E97ED"><?php echo "@".$reply[0]["staffName"];?></span>		
									<?php
										}?>
										
										<?php echo $comment["comment"];?>
										</p>
									</div>
									<div class="comment_detail_bottom">
									<?php if($comment["user_id"] != $this->_tpl_vars["name"]):?>
										<a class="reply_button" created="<?php echo $comment["staffName"];?>" id="<?php echo $comment["id"]?>">reply</a>
										<a class="report_spam" id="<?php echo $comment["id"]?>">report spam</a>
									<?php else:?>
										<a onClick="delete_comment(this,<?php echo $this->_tpl_vars["IN"]["id"];?>)" id="<?php echo $comment["id"];?>" class="delete_comment">delete</a>
									<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<?php if($key==0):?>
							<div class="comment_post_box">
							<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text <?php if(count($check)<1){echo 'hide';}?>"></textarea>
							<div id="comment_limit" class="<?php if(count($check)<1){echo 'hide';}?>">250 characters remaining</div>
							<?php if(count($check)<1):?>
							<div class="comment_box_login_msg">
							If you want to post comment, please <a class="up_to_join">join</a> this circle!
							</div>
							<?php endif;?>
							<?php else:?>
							<div class="comment_box_login_msg">
							<?php 
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
								$this->_tpl_vars["paraArr"]["circle_id"] = $this->_tpl_vars["IN"]["circle_id"];
							?>
							<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
							If you want to post comment, please <a style="color:#7B5A83" href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=circlePost&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">login</a> first!
							</div>
							<?php endif;?>
							</div>
							<div class="oh">
							<div id="reply_who" class="fl">
							</div>
							<input class="fr submit_commt <?php if($this->_tpl_vars["name"]=="" or count($check)<1){echo "hide";}?>" type="button" id="submit_commt" value="POST COMMENT" />
							</div>
							<?php if(count($comments)<2):?>
							<div class="other_comment_bar hide"></div>
							<?php endif;?>
							<?php endif;?>
					<?php endforeach;?>
					<?php else:?>
					<div class="comment_post_box">
						<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text <?php if(count($check)<1){echo 'hide';}?>"></textarea>
							<div id="comment_limit" class="<?php if(count($check)<1){echo 'hide';}?>">250 characters remaining</div>
							<?php if(count($check)<1):?>
							<div class="comment_box_login_msg">
							If you want to post comment, please join this circle!
							</div>
							<?php endif;?>
						<?php else:?>
						<div class="comment_box_login_msg">
							<?php 
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
								$this->_tpl_vars["paraArr"]["show_type"] = $this->_tpl_vars["IN"]["show_type"];
								$this->_tpl_vars["paraArr"]["from"] = $this->_tpl_vars["IN"]["from"];
							?>
							<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
							If you want to post comment, please <a style="color:#7B5A83" href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">login</a> first!
							</div>
							<?php endif;?>
							</div>
							<div class="oh">
							<div id="reply_who" class="fl">
							</div>
							<input class="fr submit_commt <?php if($this->_tpl_vars["name"]=="" or count($check)<1){echo "hide";}?>" type="button" id="submit_commt" value="POST COMMENT" />
							</div>
					<div class="other_comment_bar hide"></div>
					<?php endif;?>
					</div>
					</div>
	
</div>
</div>
<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
<script type="text/javascript">

function delete_comment(el,about_id){

	if(!confirm("Delete your comment?")){
			return false;
		}
	var comment_id = $(el).attr("id");
	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : "json",
		data:{
			action	: "website",
			method	: "commentDelete",
			id : comment_id,
			about_id : about_id,
			type : "CIRCLE POST"
		
		},success : function(json){

			$("#comment_box_"+comment_id).remove();
			$("#comment_count").text("("+ json.count +")");
			$("#item_comment_show_link").text("+Comments ("+ json.count_comment +")");
			$(".comment_main_box").prepend($(".comment_talk_box:first"));
			if(json.count < 2){
				$(".other_comment_bar").hide();
				}
		},complete : function(){

		}
});
		
}


	$(function(){

		var reply = "0";
		var sending = 0;
		var member_id = <?php echo $this->_tpl_vars["name"];?>


		$(".reply_button").click(function(){

			
			$("#comment_post_text").focus();
			$("#reply_who").children().remove();
			
			$("#reply_who").text("");
			reply = $(this).attr("id");
			var close = $(document.createElement("span")).attr("id","close_reply").text("cancel");
			var reply_msg = "reply to <span style='color:#5E97ED'>"+$(this).attr("created")+"</span> ";
			
				
			close.click(function(){

				$("#reply_who").children().remove();
				
				$("#reply_who").text("");

				reply = 0;
				});
			$("#reply_who").append(reply_msg);
			$("#reply_who").append(close);


			 $('html, body').animate({
		         scrollTop: $(".comment_box").offset().top
		     }, 1000);
							
			
		});

		
		$("#submit_commt").click(function(){
			if(sending == 0){
				sending = 1;
				}else{
						return false;
					}
				
			
			var comment = $(".comment_post_text").val();

			if(comment == ""){


				alert("Please input your comment !");
				sending = 0;
					return false;
				}
			
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
			$("#reply_who").children().remove();
			$("#reply_who").text("");
			$("#reply_who").append(loading_icon);
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "website",
						method	: "commentSave",
						comment : comment,
						type : "CIRCLE POST",
						reply: reply,
						id : <?php echo $this->_tpl_vars["IN"]["id"];?>
					
					},
					success : function(json){

						var new_comment = '<div id="comment_box_'+ json.id +'" class="comment_talk_box">';
						new_comment += '<div class="comment_msg">';
						var show_user_name ="";
						if(json.real_name == 1 && json.first_name !="" && json.last_name !=""){
							if(json.first_name !=""){show_user_name = json.first_name + "&nbsp;" + json.last_name;}							
						}			
						else if(json.show_nick == 1){
							
							show_user_name = json.staffName;
						}
						else{
							
							show_user_name = json.staffNo;
						}
						new_comment += '<a href="'+ json.avatar_link +'">';
						new_comment += '<span>'+ show_user_name +'</span>&nbsp;&nbsp;&nbsp;<span class="create_time">'+json.created+'</span>';
						new_comment += '</a>';
						new_comment += '</div>';
						new_comment += '<div class="comment_content oh">';
						new_comment += '<div class="comment_creater fl">';
						new_comment += '<div class="comment_creater_box">';
						new_comment += '<a href="'+ json.avatar_link +'">';
						new_comment += '<img alt="" src="'+ json.avatar +'">';
						new_comment += '</a>';
						new_comment += '</div>';
						new_comment += '<a href="">+ Friend</a>';																
						new_comment += '</div>';			
						new_comment += '<div class="comment_detail fl">';			
						new_comment += '<div class="comment_detail_top">';		
						if(json.reply_to>0){
							new_comment += '<p><span style="color:#5E97ED">@'+ json.reply.staffName +'</span> '+ json.comment +'</p>';		
							}else{
							new_comment += '<p>'+ json.comment +'</p>';		
							}
						new_comment += '</div>';	
						new_comment += '<div class="comment_detail_bottom">';	
						if(member_id == json.user_id){
							new_comment += '<a id="'+ json.id +'" class="delete_comment" onclick="delete_comment(this,'+ json.about_id +')">delete</a>';	
							}											
						new_comment += '</div></div></div></div>';	

						$(".comment_talk_box:first").insertAfter(".other_comment_bar");
						$(".comment_main_box").prepend(new_comment);
						$("#comment_count").text("("+ json.count_comment +")");
						$("#item_comment_show_link").text("+Comments ("+ json.count_comment +")");
						if(json.count_comment>1){
							$(".other_comment_bar").show();
						}

						reply = 0;
						
					},complete : function(){
						loading_icon.remove();
						$("#reply_who").text("Post comment success!");
						$(".comment_post_text").val("");
						sending = 0;
						$("#comment_limit").text('250 characters remaining');
					}

		});

		});

		function checkWordLen(e){
			var limit = 250 - $(e).val().length;
			var limit_word = limit +" characters remaining";
		
			if($(e).val().length >=250){
				$(e).val($(e).val().substring(0, 250));
				limit_word = "0 characters remaining";
			}
			$("#comment_limit").text(limit_word);
		}

		$("#comment_post_text").keyup(function(){		
			
				checkWordLen(this);
		});
<?php if($this->_tpl_vars["name"]!=""):?>
				$(".list_show_list_love").click(function(){
					if(loving == 1){
							return false;
						}else{
							makeLove(<?php echo $this->_tpl_vars["IN"]["id"];?>,<?php echo $this->_tpl_vars["name"];?>,"CIRCLE POST",$(this),"heart_circle.png",false);
						}
					});
<?php endif;?>
<?php if(count($imgs)>0):?>
				
				var item_imgs = new Array();
			<?php foreach($imgs as $key=>$img):?>
			var item_img = new Object();
			item_img.img = '<?php echo $img["img"];?>';
			item_img.title = '<?php echo stripslashes($img["title"]);?>';
			item_imgs.push(item_img);
			<?php endforeach;?>

			var img_num = 0;

			if(item_imgs.length <2){
				$(".item_img_next").hide();
				$(".item_img_prev").hide();
				}
			$(".item_img_next").click(function(){
	
					if((img_num+2) >item_imgs.length){
							img_num = 0;
						}else{
							img_num = img_num + 1;
							}
					$(".circle_post_page_img_box img").attr("src","../circle_post_img/<?php echo $post["user_id"];?>/"+item_imgs[img_num].img);
					$(".circle_post_page_img_title").text(item_imgs[img_num].title);
				});
			
			$(".item_img_prev").click(function(){
				img_num = img_num - 1;
				if(img_num < 0){
						img_num = item_imgs.length - 1;
					}
				$(".circle_post_page_img_box img").attr("src","../circle_post_img/<?php echo $post["user_id"];?>/"+item_imgs[img_num].img);
				(".circle_post_page_img_title").text(item_imgs[img_num].title);
			});
		<?php endif;?>		

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
					id: <?php echo $this->_tpl_vars["IN"]["circle_id"];?>
				},
				success : function(json)
				{
					$(".my_circle_member_count").text(json.count + " members");
					$(loading_icon).remove();
					$("#circle_join_button").text("Join success!");
					var quit_link = "<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$this->_tpl_vars['IN']['circle_id']));?>";
					var quit_button = $(document.createElement("a")).attr("href",quit_link).addClass("circle_quit_link").text('Give up!').attr("onClick","javascript: return confirm('Confirm to give up this circle?')");
					$(quit_button).insertAfter($(".my_circle_title"));
					$(".comment_box_login_msg").remove();
					$("#comment_post_text").removeClass("hide");
					$("#comment_limit").removeClass("hide");
					$(".list_show_list_love").removeClass("hide");
					$(".submit_commt").removeClass("hide");
				}
			});
			});

		$(".up_to_join").click(function(){
				$('html, body').animate({
			         scrollTop: $(".circle_top_box").offset().top
			     }, 1000);
			});
		});
</script>
</body>
</html>
