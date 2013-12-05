<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
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
<style type="text/css">

	.main_page_nav a{
		margin-left: 0;
		margin-right: 5px;
	}
</style>

</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$event = runFunc("getEvent",array($this->_tpl_vars["IN"]["id"]));
	$check_love = runFunc("checkMemberLove",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"],"EVENT"));
	$love_count = runFunc("getShareListLoveCount",array($this->_tpl_vars["IN"]["id"],"EVENT"));
	$member_count = runFunc("getEventMember",array($this->_tpl_vars["IN"]["id"],true));
	$members = runFunc("getEventMember",array($this->_tpl_vars["IN"]["id"]));
	$check = runFunc("checkEventBooking",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"]));
	$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"EVENT"));

	?>
	<div class="content">
		<div class="content_top_bar oh">
            <div class="cattitle" style="margin-top:20px;">
            <span>Live Events</span>
            </div>     
			<div class="circle_top_box oh" style="padding-bottom: 20px">
				<img class="event_show_img fl" width="325px" height="175px" src="../circle_event_img/<?php echo $event[0]["user_id"];?>/<?php echo $event[0]["img"];?>" alt="" />
				<table class="event_show_message fr">
					<tr>
						<td colspan=2>
							<h2 class="event_show_title"><?php echo $event[0]["name"];?></h2>
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<tr>
									<th>Share</th>
									<td>
										<div class="oh" style="height: 16px;">
											<div class="attentionInfo" style="float: left; width: 127px;">
												<span class='st_email_large' displayText='Email'></span>
												<span class='st_facebook_large' displayText='Facebook'></span>
												<span class='st_twitter_large' displayText='Tweet'></span>
												<span class='st_linkedin_large' displayText='LinkedIn'></span>
												<span class='st_pinterest_large' displayText='Pinterest'></span>
												<span class='st_googleplus_large' displayText='Google +'></span>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<th>Location:</th>
									<td><?php echo $event[0]["location"];?></td>
								</tr>
								<tr>
									<th>Address:</th>
									<td><div style="width:340px;word-wrap:break-word;"><?php echo $event[0]["address"];?></div></td>
								</tr>
								<tr>
									<th>Organizers:</th>
									<td><?php echo $event[0]["organizers"];?></td>
								</tr>

									<?php if($event[0]["group_id"]>0):?>
									<?php $item = runFunc("getSiteGroupBuyItem",array($event[0]["group_id"]));?>
									<?php if($item[0]["sell_way"]==2){

										$price = number_format($item[0]["goodsUnitPrice"] * $item[0]["price_rate"], 2, '.', ',');

									}else{

										$price = number_format($item[0]["goodsUnitPrice"], 2, '.', ',');
									}?>
									<tr>
										<th>Cost:</th>

									<td style="color:#a81528">￥<?php echo $price;?></td>
									</tr>
									<?php else:?>
									<?php if($event[0]["event_pay"]>0):?>
									<tr>
										<th>Cost:</th>


										<td style="color:#a81528">￥<?php echo $event[0]["event_pay"];?></td>


									</tr>
									<?php endif;?>
									<?php endif;?>

<!--							<tr>
									<th>Circle:</th>
									<?php $circle = runFunc("getCircleById",array($event[0]["circle_id"]));?>
									<td><a style="color:#5E97ED" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));?>"><?php echo $circle["0"]["name"]?></a></td>
								</tr>-->

							</table>
						</td>
						<td style="vertical-align: top;" width="160px">
						<?php if($event[0]["status"]!=2):?>
						<?php if($event[0]["user_id"] != $this->_tpl_vars["name"]):?>
						<?php if($this->_tpl_vars["name"]!=""):?>
						<?php if(count($check)<1):?>
							<a id="event_book_button" <?php if($event[0]["group_id"]>0)echo "href='".runFunc('encrypt_url',array('action=share&method=groupBuyShow&event_id='.$event[0]["id"].'&id='.$event[0]["group_id"]))."'";?> class="blue_button_large fr">Book Now</a>
						<?php endif;?>
							<a style="margin:0" class="list_show_list_love fr <?php if($check_love["count"] > 0){echo 'disable_love';}?>">
							<?php if($check_love["count"] > 0):?>
										<img src="../skin/images/disable_heart_circle.png" alt="" />
									<?php else:?>
										<img src="../skin/images/heart_circle.png" alt="" />
									<?php endif;?>
							</a>

						<?php else:?>
						<?php
							$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
							$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
							$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
							$this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]);
						?>
						<div id="circle_login_msg"><a href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=circle_page&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">Login</a> to book </div>
					<?php endif;?>
							<?php endif;?>

						<?php else:?>

						<span style="color:#a81528;">Closed By Organizers</span>
						<?php endif;?>
						</td>
					</tr>
					<tr>
						<td id="event_ctrl_td" colspan=2 style="text-align: right;padding-top:10px;">
						&nbsp;
							<?php if(count($check)>0):?>
							<a class="event_show_links" onClick="javascript: return confirm('Confirm to give up this event?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventQuit&id='.$this->_tpl_vars["IN"]["id"]));?>">Give up</a>
							<?php endif;?>
							<?php if(count($check)>0 or $event[0]["user_id"] == $this->_tpl_vars["name"] ):?>
							<?php $event_time = runFunc("getEventTime",array($event[0]["id"]));?>
							<?php if($event[0]["event_time_type"]==4):?>


							<?php $kk = count($event_time)-1;
							$start_time = date("His",strtotime($event_time[0]["start_time"]));
							$end_time = date("His",strtotime($event_time[$kk]["end_time"]));

							?>
							<?php else:

							$start_time = date("His",strtotime($event_time[0]["start_time"]));
							$end_time = date("His",strtotime($event_time[0]["end_time"]));
							endif;?>

							<?php $site_name = runFunc('getGlobalModelVar',array('Site_Domain'));?>
							<?php $event_page_link = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));?>
							<?php $cal_link = "http://www.google.com/calendar/event?action=TEMPLATE&text=WOWSHOPPING event:".$event[0]["name"]."&dates=".date("Ymd",strtotime($event_time[0]["start_date"]))."T".$start_time."/".date("Ymd",strtotime($event_time[0]["end_date"]))."T".$end_time."&details=".$event_page_link."&location=".$event[0]["address"]."&trp=false&sprop=www.wowshopping.com.cn&sprop=name:WOWSHOPPING"?>


							&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $cal_link;?>" class="event_show_links" target="_blank">Add to Google Calander</a>

							<?php endif;?>
							<?php if($event[0]["user_id"] == $this->_tpl_vars["name"]):?>
							&nbsp;&nbsp;&nbsp;&nbsp;<a class="event_show_links" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventEdit&id='.$this->_tpl_vars["IN"]["id"]));?>">Edit</a>
							<?php if($event[0]["status"]!=2):?>
							&nbsp;&nbsp;&nbsp;&nbsp;<a class="event_show_links" onClick="javascript: return confirm('Confirm to close this event?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventClose&id='.$this->_tpl_vars["IN"]["id"]));?>">Close</a>

							<?php else:?>

							&nbsp;&nbsp;&nbsp;&nbsp;<a class="event_show_links" onClick="javascript: return confirm('Confirm to open this event?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventOpen&id='.$this->_tpl_vars["IN"]["id"]));?>">Open</a>
							<?php endif;?>
							&nbsp;&nbsp;&nbsp;&nbsp;<a class="event_show_links" onClick="javascript: return confirm('Confirm to Delete this event?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventDelete&id='.$this->_tpl_vars["IN"]["id"]));?>">Delete</a>
							<?php endif;?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="event_content oh">
			<div class="fl" id="event_content_left">
				<div class="event_content_box">
					<h2>Event Time</h2>
					<div class="event_content_inner">
					<?php $event_time = runFunc("getEventTime",array($event[0]["id"]));?>

						<?php switch ($event[0]["event_time_type"]){

							case 1:

								echo date("Y-m-d",strtotime($event_time[0]["start_date"]));
								echo "&nbsp;&nbsp;&nbsp;".$event_time[0]["start_time"]."-".$event_time[0]["end_time"];
								break;

							case 2:

								echo "Date: From ".date("Y-m-d",strtotime($event_time[0]["start_date"]))." To ".date("Y-m-d",strtotime($event_time[0]["end_date"]));
								echo "<br>";
								echo "Time: ".$event_time[0]["start_time"]." - ".$event_time[0]["end_time"];
								break;

							case 3:
								echo "<table class='event_time_table'>";
								echo "<tr><th>Date: </th><td>From ".date("Y-m-d",strtotime($event_time[0]["start_date"]))." To ".date("Y-m-d",strtotime($event_time[0]["end_date"]))."</td></tr>";
								echo "<tr><th>Week Days: </th><td>".$event_time[0]["week_day"]."</td></tr>";
								echo "<tr><th>Time: </th><td>".$event_time[0]["start_time"]." - ".$event_time[0]["end_time"]."</td></tr>";
								echo "</table>";

								break;

							case 4:

								foreach ($event_time as $e_time){

									echo date("Y-m-d",strtotime($e_time["start_date"]));
									echo "&nbsp;&nbsp;&nbsp;".$e_time["start_time"]." - ".$e_time["end_time"];
									echo "<br/>";
								}

								break;

						}?>


					</div>

				</div>


				<div class="event_content_box">
					<h2>Details</h2>
					<p>
					<?php echo $event[0]["introduction"];?>
					</p>
				</div>
				<div class="event_content_box">
					<h2>Contact</h2>
					<p>
						<?php if($event[0]["phone"]!=""):?>
						Phone:&nbsp;&nbsp;&nbsp;<?php echo $event[0]["phone"];?>
						<?php endif;?>
						<br />
						Email:&nbsp;&nbsp;&nbsp;<?php echo $event[0]["email"];?>
					</p>
				</div>
				<div class="event_content_box">
				<h2>Address</h2>
				<p><?php echo $event[0]["address"];?></p>
				</div>
				<?php if($event[0]["map"]!=""):?>
				<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAYGKhMRRehPoF4WNV65-9NsSEHdj9O1i0&sensor=false&libraries=places"></script>
				<script type="text/javascript">
					$(function(){

							var myLatlng = new google.maps.LatLng(<?php echo $event[0]["map"]?>);

							var mapOptions = {
								center: myLatlng,
								zoom: 15,
								language: "EN",
								mapTypeId: google.maps.MapTypeId.ROADMAP
							};
							var map = new google.maps.Map($("#map_canvas").get(0),mapOptions);

							 var marker = new google.maps.Marker({
								 position: myLatlng,
								 map: map,
								 title: 'Event Location'
								 });
					});
					</script>

				<div class="event_content_box">
					<h2>Maps</h2>
					<div id="map_canvas" style="height:150px;width:515px;margin:auto;"></div>
				</div>
				<?php endif;?>

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
								<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$comment["user_id"]));?>">
								<span><?php echo $comment["staffName"];?></span></a>&nbsp;&nbsp;&nbsp;
								<span class="create_time">at <?php echo $comment["created"];?></span>
							</div>
							<div class="comment_content oh">
								<div class="comment_creater fl">
									<div class="comment_creater_box">
										<?php $avatar = "../publish/avatar/".$comment["user_id"]."_thumb.".$comment["headImageUrl"]."_40.jpg";?>
										<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$comment["user_id"]));?>">
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

											$reply = runFunc("getCommentById",array($comment["reply_to"],"EVENT"));
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
							<textarea id="comment_post_text" class="comment_post_text <?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]){echo 'hide';}?>"></textarea>
							<div id="comment_limit" class="<?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]){echo 'hide';}?>">250 characters remaining</div>
							<?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]):?>
							<div class="comment_box_login_msg">
							If you want to post comment, please <a class="up_to_join">book</a> this event!
							</div>
							<?php endif;?>
							<?php else:?>
							<div class="comment_box_login_msg">
							<?php
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
							?>
							<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
							If you want to post comment, please <a style="color:#7B5A83" href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=circlePost&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">login</a> first!
							</div>
							<?php endif;?>
							</div>
							<div class="oh">
							<div id="reply_who" class="fl">
							</div>
							<input class="submit_commt fr <?php if($this->_tpl_vars["name"]=="" or (count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"])){echo "hide";}?>" type="button" id="submit_commt" value="POST COMMENT" />
							</div>
							<?php if(count($comments)<2):?>
							<div class="other_comment_bar hide"></div>
							<?php endif;?>
							<?php endif;?>
					<?php endforeach;?>
					<?php else:?>
					<div class="comment_post_box">
						<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text <?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]){echo 'hide';}?>"></textarea>
							<div id="comment_limit" class="<?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]){echo 'hide';}?>">250 characters remaining</div>
							<?php if(count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"]):?>
							<div class="comment_box_login_msg">
							If you want to post comment, please <a class="up_to_join">book</a> this event!
							</div>
							<?php endif;?>
						<?php else:?>
						<div class="comment_box_login_msg">
							<?php
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
							?>
							<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
							If you want to post comment, please <a style="color:#7B5A83" href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=circlePost&paraStr=' . $this->_tpl_vars["paraStr"] ));?>">login</a> first!
							</div>
							<?php endif;?>
							</div>
							<div class="oh">
							<div id="reply_who" class="fl">
							</div>
							<input class="submit_commt fr <?php if($this->_tpl_vars["name"]=="" or (count($check)<1 and $event[0]["user_id"] != $this->_tpl_vars["name"])){echo "hide";}?>" type="button" id="submit_commt" value="POST COMMENT" />
							</div>
					<div class="other_comment_bar hide"></div>
					<?php endif;?>
					</div>
					</div>
			</div>
			<div class="fr" id="event_content_right">
			<div class="event_right_box oh">
				<h2>Creater</h2>
				<?php $avatar = "../publish/avatar/".$event[0]["user_id"]."_thumb.".$event[0]["headImageUrl"];?>
<!--				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$event[0]["user_id"]));?>">-->
				<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($event[0]["user_id"]));?>
				<?php $title = "";?>
				<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
					<?php if($user_info[0]["first_name"]!=""){$title .= $user_info[0]["first_name"]."&nbsp;";} $title .= trim($user_info[0]["last_name"]);?>
				<?php elseif($user_info[0]["show_nick"]==1):?>
					<?php $title .= $user_info["0"]["staffName"];?>
				<?php else:?>
					<?php $title .= $user_info["0"]["staffNo"];?>
				<?php endif;?>
				<?php if(file_exists($avatar)){?>
				<img class="fl" id="userimg" src="<?php echo $avatar."_40.".$event[0]["headImageUrl"];?>" alt="userInfo" title="<?php echo $title;?>" id="userHeaderImg" />
					<?php }else{ ?>
				<img class="fl" id="userimg" src="../skin/images/pic.jpg" alt="userInfo" title="<?php echo $title;?>"/>
				<?php } ?>
				<!--</a>-->
			</div>
			<div class="event_right_box oh">
				<h2 class="oh"><div class="fl">Members</div><div class="fr event_amount"><span class='love_count'><?php echo $love_count["count"];?></span> <font style="color:#777777">interest</font>&nbsp;&nbsp;&nbsp; <span class="event_member_count"><?php echo $member_count[0]["count"];?></span> <font style="color:#777777">join</font></div></h2>
				<div class="event_member_box oh">
				<?php foreach ($members as $member):?>
				<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($member["user_id"]));?>
				<?php $title = "";?>
				<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
					<?php if($user_info[0]["first_name"]!=""){$title .= $user_info[0]["first_name"]."&nbsp;";} $title .= trim($user_info[0]["last_name"]);?>
				<?php elseif($user_info[0]["show_nick"]==1):?>
					<?php $title .= $user_info["0"]["staffName"];?>
				<?php else:?>
					<?php $title .= $user_info["0"]["staffNo"];?>
				<?php endif;?>


<!--				<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$member["user_id"]));?>">-->
					<?php $avatar = "../publish/avatar/".$member["user_id"]."_thumb.".$member["headImageUrl"];?>
						<?php if(file_exists($avatar)){?>
							<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" title="<?php echo $title;?>" />
						<?php }else{?>
							<img id="userimg" class="fl" src="../skin/images/pic.jpg" title="<?php echo $title;?>" />
						<?php }?>
					<!--</a>-->
				<?php endforeach;?>
				</div>
			</div>
			</div>

		</div>
	</div>
	</div>

	<?php $inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
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
						type : "EVENT",
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
	});




$(function(){

<?php if($this->_tpl_vars["name"]!=""):?>
$(".list_show_list_love").click(function(){
	if(loving == 1){
			return false;
		}else{
			makeLove(<?php echo $this->_tpl_vars["IN"]["id"];?>,<?php echo $this->_tpl_vars["name"];?>,"EVENT",$(this),"heart_circle.png",true);
		}
	});


var joining = 0;
<?php if($event[0]["group_id"]==0):?>
$("#event_book_button").click(function(){

	if(joining == 0){
		joining =1
		}
	else{

		return false;
		}
	var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
		$("#event_book_button").removeClass("blue_button_large");
		$("#event_book_button").text("");
		$("#event_book_button").append(loading_icon);
	$.ajax({
		url : 'index.php',
		type : 'POST',
		dataType : "json",
		data:{
			action	: "share",
			method	: "eventBooking",
			id: <?php echo $this->_tpl_vars["IN"]["id"];?>
		},
		success : function(json)
		{
			$(".event_member_count").text(json.count);
			$(loading_icon).remove();
			$("#event_book_button").text("Book success!");
			<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($this->_tpl_vars["name"]));?>

			var booking_avatar = '<a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&userID='.$user_info[0]["user_id"]));?>">';
			<?php $avatar = "../publish/avatar/".$user_info[0]["user_id"]."_thumb.".$user_info[0]["headImageUrl"];?>
			<?php if(file_exists($avatar)){?>
				booking_avatar += '<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />';
			<?php }else{?>
				booking_avatar += '<img id="userimg" class="fl" src="../skin/images/pic.jpg" />';
			<?php }?>
			booking_avatar += '</a>';


			event_ctrl = '<a class="event_show_links" ';
			event_ctrl += "onClick=\"javascript: return confirm('Confirm to give up this event?')\" ";
			event_ctrl += 'href="<?php echo runFunc('encrypt_url',array('action=share&method=eventQuit&id='.$this->_tpl_vars["IN"]["id"]));?>">Give up</a>';

			<?php $event_time = runFunc("getEventTime",array($event[0]["id"]));?>
			<?php if($event[0]["event_time_type"]==4):?>


			<?php $kk = count($event_time)-1;
			$start_time = date("His",strtotime($event_time[0]["start_time"]));
			$end_time = date("His",strtotime($event_time[$kk]["end_time"]));

			?>
			<?php else:

			$start_time = date("His",strtotime($event_time[0]["start_time"]));
			$end_time = date("His",strtotime($event_time[0]["end_time"]));
			endif;?>

			<?php $site_name = runFunc('getGlobalModelVar',array('Site_Domain'));?>
			<?php $event_page_link = $site_name."/publish/index.php".runFunc('encrypt_url',array('action=share&method=eventShow&id='.$event[0]["id"]));?>
			<?php $cal_link = "http://www.google.com/calendar/event?action=TEMPLATE&text=WOWSHOPPING event:".$event[0]["name"]."&dates=".date("Ymd",strtotime($event_time[0]["start_date"]))."T".$start_time."/".date("Ymd",strtotime($event_time[0]["end_date"]))."T".$end_time."&details=".$event_page_link."&location=".$event[0]["address"]."&trp=false&sprop=www.wowshopping.com.cn&sprop=name:WOWSHOPPING"?>


			event_ctrl += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $cal_link;?>" target="_blank" class="event_show_links">Add to Google Calander</a>';
		//	event_ctrl += '&nbsp;&nbsp;&nbsp;&nbsp;<a class="event_show_links">Invite Your Friends</a>';

			$(".event_member_box").append(booking_avatar);
			$("#event_ctrl_td").append(event_ctrl);
			$(".comment_box_login_msg").remove();
			$("#comment_post_text").removeClass("hide");
			$("#comment_limit").removeClass("hide");
			$(".submit_commt").removeClass("hide");
		}
	});

});
<?php endif;?>
<?php endif;?>
$(".up_to_join").click(function(){

	$('html, body').animate({
         scrollTop: $(".circle_top_box").offset().top
     }, 1000);
});
		});

</script>
</body>
</html>
