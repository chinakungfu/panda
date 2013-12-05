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
	
	$item = runFunc("getGroupBuyFirstItem");

	$setting = runFunc("getGlobalSetting");
	?>

	<script type="text/javascript">
	$(function(){
		var item_img = new Array();
		var item_img_ctrl = new Array();
			<?php if($item[0]["goodsImgURL"]!=""):?>
			item_img[0]="<?php echo $item[0]["goodsImgURL"];?>";
			<?php endif;?>
			<?php if($item[0]["goodsImgURL1"]!=""):?>

			item_img[1]="<?php echo $item[0]["goodsImgURL1"];?>";
			<?php endif;?>
			<?php if($item[0]["goodsImgURL2"]!=""):?>
			item_img[2]="<?php echo $item[0]["goodsImgURL2"];?>";
			<?php endif;?>
			<?php if($item[0]["goodsImgURL3"]!=""):?>
			item_img[3]="<?php echo $item[0]["goodsImgURL3"];?>";
			<?php endif;?>
			<?php if($item[0]["goodsImgURL4"]!=""):?>

			item_img[4]="<?php echo $item[0]["goodsImgURL4"];?>";
			<?php endif;?>
			
		var img_num = 0;

		if(item_img.length <2){
			$(".item_img_next").hide();
			$(".item_img_prev").hide();
			}
		$(".item_img_next").click(function(){

				if((img_num+2) >item_img.length){
						img_num = 0;
					}else{
						img_num = img_num + 1;
						}
		
			var item_current_img = $(document.createElement("img")).attr("src",item_img[img_num]+"_600x600.jpg").addClass("publish_item_img");
	$(".publish_item_img").replaceWith(item_current_img);
					if($(".publish_item_img").width()>= $(".publish_item_img").height()){
						item_current_img.addClass("width_ctrl");
					}else{
						item_current_img.addClass("height_ctrl");
					}
			});
		
		$(".item_img_prev").click(function(){
			img_num = img_num - 1;
			if(img_num < 0){
					img_num = item_img.length - 1;
				}

			var item_current_img = $(document.createElement("img")).attr("src",item_img[img_num]+"_600x600.jpg").addClass("publish_item_img");
		
		$(".publish_item_img").replaceWith(item_current_img);
					
					if($(".publish_item_img").width()>= $(".publish_item_img").height()){
						item_current_img.addClass("width_ctrl");
					}else{
						item_current_img.addClass("height_ctrl");
					}
					
					
			
		});
		

		
		
			if($(".publish_item_img").width()>= $(".publish_item_img").height()){
						$(".publish_item_img").addClass("width_ctrl");
					}else{
						$(".publish_item_img").addClass("height_ctrl");
					}
			$(".publish_item_img").show();
	
			
		
		});
	</script>

	<div class="content">
		<div class="group_buy_top_bar oh">
			<h2 class="fl" style="width: 760px;">
				Group Buy <span>today’s deals</span>
			</h2>
			<h2 class="fl">
				Hot Deals
			</h2>
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyMain'));?>" style="color:#795881; margin-right: 9px; margin-top: 6px;" class="fr">View All</a>
		</div>
		<div class="full_width_box oh">
		<div id="group_buy_first_item_box" class="fl">
			<?php 
			if(count($item)>0):
	$purchase_count = runFunc("getGroupPurchasedCount",array($item[0]["id"]));
	$comments = runFunc("getComment",array($item[0]["id"],"GROUP BUY GOODS"));?>
			<div class="publish_item_left fl group_buy_publish">
		<div class="publish_item_img_contain">
				<div class="publish_item_img_box" style="height:335px;">
				
						
				<img  class="publish_item_img" src="<?php echo $item[0]["goodsImgURL"];?>_600x600.jpg" alt="" />
			
				
					
					
					<div class="item_img_prev"></div>
					<div class="item_img_next"></div>
				</div>
				</div>
				<div class="publish_item_ctrl_bar oh">
				<?php if(count($tags)>0):?>
				<div style="margin-top:2px;margin-right:5px;color:#5E97ED" class="fl">TAG:</div>
				<?php $tt= 1; foreach($tags as $tag):?>
				<?php if($tt++>5)continue;?>
					<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex&tag_id='.$tag["tag_id"]));?>" class="publish_tag_link" href=""><?php echo $tag["title"];?></a>
				<?php endforeach;?>
				<?php endif;?>
				<?php 
					
						$nav_id = runFunc("getGroupItemNavGroup",array($item[0]["id"]));
						
					if($nav_id["prev"] == ""){
						
						$prev="";
					}
					else{
							$prev = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$nav_id["prev"]));
					}
					if($nav_id["next"] == ""){
							
							$next="";
						}else{
							
							$next = runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$nav_id["next"]));
						}
				?>
					<div class="list_nav fr" style="margin-bottom: 0">
					<?php if($prev !=""):?>
						<a href="<?php echo $prev;?>" class="prev fl">Prev Item</a>
					<?php endif;?>
					<?php if($next !=""):?>
						<a href="<?php echo $next;?>" class="next fr">Next Item</a>
						<?php endif;?>
					</div>
				</div>
					</div>
			<div class="publish_item_right fl group_buy_sigle_left">
			<div class="item_detail_top" style="min-height:0;">
			<?php if($item[0]["offcial"]==0):?>
				<div class="item_created" style="margin-top:0">
					Created by <a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$item[0]["user_id"]));?>"><?php $user_info = runFunc("getShareMemberInfoAllInOne",array($item[0]["user_id"]));?>
							<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
								<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
							<?php elseif($user_info[0]["show_nick"]==1):?>
								<?php echo $user_info["0"]["staffName"];?>
							<?php else:?>
								<?php echo $user_info["0"]["staffNo"];?>
							<?php endif;?></a>
				</div>
				<?php endif;?>
				<div class="publish_item_title">
				<?php echo $item[0]["item_name"];?>
				</div>
				<div class="publish_item_intro">
					<?php echo $item[0]["description"];?>
				</div>
				<div class="oh">
				<?php if($item[0]["sell_way"]==2){
					
					$price = number_format($item[0]["goodsUnitPrice"] * $item[0]["price_rate"], 2, '.', ',');
					
				}else{
					
					$price = number_format($item[0]["goodsUnitPrice"], 2, '.', ',');
				}?>
					 <div class="publish_price_box fl"><sup>￥</sup><?php echo $price;?></div>
					 <?php if($item[0]["end_time"]>=date("Y-m-d")){?>
					 <?php if ($this->_tpl_vars["name"]):?>
					<a onclick="addShoppingBag(1);" id="publish_item_buy" class="light_blue_button fr">buy now!</a>
					<?php else:?>
					<?php 
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $item[0]["id"];
								$this->_tpl_vars["paraArr"]["show_type"] = $this->_tpl_vars["IN"]["show_type"];
								$this->_tpl_vars["paraArr"]["from"] = $this->_tpl_vars["IN"]["from"];
							?>
							<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>
					<div style="margin-top: 30px; float: right; margin-right: 18px;">Please <a style="color:#5E97ED" href="<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr='.$this->_tpl_vars["paraStr"] ));?>">Login</a> To Buy</div>
					<?php endif;?>
					<?php }else{?>
						 <?php if ($this->_tpl_vars["name"]):?>
						<a style="color:#5E97ED;margin-top:25px;margin-right:3px;" class="fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=add_group_buy&goodsid='.$item[0]["goodsid"]));?>">Create a group buy</a>
						<?php endif;?>
						 <?php }?>
				</div>
					<div class="oh group_buy_message_box">
					<div class="group_buy_message fl" style="border:0;margin-left:5px;display:inline;">
					<?php if($item[0]["sell_way"]==2):?>
						<b>￥<?php echo number_format($item[0]["goodsUnitPrice"], 2, '.', ',');?></b> 
						
						<br />VALUE
					<?php else:?>
					<b>SERVICE FEE </b>
					<br />DISCOUNT
						<?php endif;?>
					</div>
					<div class="group_buy_message fl">
						<b><?php echo (1 - $item[0]["price_rate"]) * 100;?>%</b> <br /> <?php if($item[0]["sell_way"]==2):?>SAVING<?php else:?>OFF<?php endif;?>
					</div>
					<div class="group_buy_message fl">
						<b><?php echo $purchase_count[0]["count"];?></b> <br /> PURCHASED
					</div>
					<div id="group_buy_time_counter" class="group_buy_message fl">
							<span class="day"></span> <span>days</span>
							<span class="hour"></span>:<span class="minute"></span>:<span class="second"></span>
							<br /> REMAINING
					</div>
				</div>
				<div class="oh">
					<div class="publish_item_freight fl">
					<?php if($item[0]["goodsURL"]!="" and $item[0]["show_link"]==1):?>
					<?php if(trim($item[0]["click_url"])!=""){
						
						$click_link = $item[0]["click_url"];
					}else{
						
						$click_link = $item[0]["goodsURL"];
					}?>
						<a style="color:#777777" title="orignal link" target="_blank" href="<?php echo $click_link;?>"><img src="../../skin/images/little_house.png" alt="" />Seller</a>
					<?php endif;?>
						<span class="small_blue_title">&nbsp;&nbsp;&nbsp;Freight</span>
						<span class="freight_price">
							￥<?php echo number_format($setting[0]["freight"], 2, '.', ',')?>
						</span>
					</div>
					<div class="fr buy_error">
						
					</div>
				</div>
				<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
				<input type="hidden" name="cart_type" value="2" />
				<div class="oh item_props">
				<?php $item_props = json_decode($item[0]["props"]);?>
				<?php foreach($item_props as $item_prop):?>
				<div class="props_box oh">
				<?php foreach($item_prop as $key=>$item_prop_values):?>
				<div class="prop_name fl"><?php echo ucfirst($key);?>:</div>
				<input class="prop_value_input" type="hidden" name="props[]" value="" />
				<div class="fl" style="width: 328px;">
				<?php foreach($item_prop_values as $item_value):?>
				<?php if(strtolower($key) == "color"):?>	
				<?php $color = runFunc("getProductColor",array(addslashes($item_value)));?>
				<?php if($color):?>
				<div prop_title="<?php echo $color[0]["name"];?>" prop_name="<?php echo $key;?>" class="prop_select_button_<?php echo $key;?> prop_select_button color_box_border fl">
				<a title="<?php echo $color[0]["name"];?>" class="color_box" style="background:#<?php echo $color[0]["color"];?>"></a>
				</div>
				<?php else:?>
				<a prop_title="<?php echo $item_value;?>" prop_name="<?php echo $key;?>" class="prop_select_button_<?php echo $key;?> prop_select_button prop_select_box fl">
						<?php echo $item_value;?>
					</a>
				<?php endif;?>
				<?php else:?>
					<a prop_title="<?php echo $item_value;?>" prop_name="<?php echo $key;?>" class="prop_select_button_<?php echo $key;?> prop_select_button prop_select_box fl">
						<?php echo $item_value;?>
					</a>
				<?php endif;?>
				<?php endforeach;?>

				<?php endforeach;?>
				</div>
				</div>
				<?php endforeach;?>
				
					<div class="prop_name fl">Qty:</div> <input class="item_props_box fl" type="text" name="para[ItemQTY]" value="1" />
						<input type="hidden" value="<?php echo $setting[0]["freight"];?>" name="para[itemFreight]">
						<input type="hidden" value="shop" name="action">
						<input type="hidden" value="addWish" name="method">
						<input type="hidden"  value="<?php echo $item[0]["id"];?>" name="page_id" />
						<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["show_type"];?>" name="show_type" />
						<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["from"];?>" name="from" />
						<input type="hidden" value="<?php echo $item[0]["id"];?>" name="para[goodsID]">
						<input type="hidden" value="<?php echo $item[0]["goodsUnitPrice"];?>" name="para[itemPrice]">
						<input id="goodsAddUser" type="hidden" value="<?php echo $this->_tpl_vars["name"];?>" name="para[goodsAddUser]">
						<?php if($this->_tpl_vars["IN"]["event_id"]!=""):?>
						<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["event_id"];?>" name="para[eventID]">
						<?php endif;?>
					<div class="group_buy_status_show fr">
					<?php if($item[0]["end_time"]<date("Y-m-d")){?>
						<div id="off" class="group_buy_status_show_box">
							The deal is off!
						</div>
					<?php }elseif($item[0]["group_size"]>$purchase_count[0]["count"] or ($item[0]["start_time"]>date("Y-m-d"))){?>
						<div id="pending" class="group_buy_status_show_box">
							Pending!
						</div>
					<?php }elseif($item[0]["start_time"]!="" and $item[0]["end_time"]>=date("Y-m-d")){?>
						
						<div id="starting" class="group_buy_status_show_box">
							The deal is on!
						</div>
					<?php }?>	
						
					<!-- <div id="pending" class="group_buy_status_show_box">
							Pending!
						</div> -->	
					</div>
				</div>
				</form>
				<div class="publish_item_ctrl_item">
				<?php if($this->_tpl_vars["IN"]["from"] != "search_url"):?>
					<div class="publish_item_ctrl_button fl">
						<img class="love_heart" alt="" src="/skin/images/heart.png">
						<?php $love_count = runFunc("getShareListLoveCount",array($item[0]["id"],"GROUP BUY ITEM"));?>
						<?php $check_love = runFunc("checkMemberLove",array($item[0]["id"],$this->_tpl_vars["name"],"GROUP BUY ITEM"));
						?>
						
						<span class="heart_love_count " style="color:#979595">(<?php echo $love_count["count"];?>)</span>
						&nbsp;&nbsp;
						<a class="love_it_button <?php if($check_love["count"] > 0){echo "disable_love";}?>"><?php if($check_love["count"] > 0){echo "-Love it";}else{echo "+Love it";}?></a>
					</div>
					<?php endif;?>
					
					<?php if($this->_tpl_vars["IN"]["from"] != "search_url"):?>
					<a id="item_comment_show_link" class="publish_item_ctrl_button fl">
						+Comments (<?php echo count($comments);?>)
					</a>
					<?php endif;?>
				</div>
				<div class="oh" style="height: 16px;">
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
		</div>
	
	
		<?php if($item[0]["goodsDesc"]!="" or $item[0]["goodsDetail"]!="" or $item[0]["goodsOthersTitle"]!="" or $item[0]["fine_print"] !="" or $item[0]["other_image_1"]!="" or $item[0]["other_image_2"]!="" or $item[0]["other_image_3"]!="" or $item[0]["other_image_4"]!="" or $item[0]["other_image_5"]!=""):?>
				<div id="tabs" class="fl" style="margin-left: 3px; width: 740px;margin-bottom: 20px;">
					<ul class="tab_button">
					<?php if($this->_tpl_vars["IN"]["event_id"]!=""):?>
					<?php $event = runFunc("getEvent",array($this->_tpl_vars["IN"]["event_id"]));?>
					<?php if($event[0]["map"]!=""):?>
					<li class="ui-state-active"><a href="#tabs-1">location</a></li>
					<?php endif;?>
					<?php endif;?>		
					<?php if(strip_tags($item[0]["fine_print"])!=""):?>	
					<li><a href="#tabs-4">fine print</a></li>	
					<?php endif;?>
					<?php if(strip_tags($item[0]["goodsDesc"])!="" or $item[0]["other_image_1"]!="" or $item[0]["other_image_2"]!="" or $item[0]["other_image_3"]!="" or $item[0]["other_image_4"]!="" or $item[0]["other_image_5"]!=""):?>
					
						<li <?php if($this->_tpl_vars["IN"]["event_id"]==""):?>class="ui-state-active"<?php endif;?>><a href="#tabs-2">description</a></li>
					<?php endif;?>
					<?php if(strip_tags($item[0]["goodsDetail"])!=""):?>
						<li><a href="#tabs-3">detail</a></li>
					<?php endif;?>
						
					
					</ul>
					<?php if($this->_tpl_vars["IN"]["event_id"]!=""):?>
						<?php if($event[0]["map"]!=""):?>
					<div class="" id="tabs-1">
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
					<div id="map_canvas" style="height:150px;width:372px;margin:auto;"></div>

			
						
					</div>
						<?php endif;?>
					<?php endif;?>
					<div <?php if($this->_tpl_vars["IN"]["event_id"]!=""):?>class="ui-state-active"<?php endif;?> id="tabs-2">
						<p>
							<?php echo  $item[0]["goodsDesc"];?>
						</p>
						<div class="item_other_img_box oh">
						<?php for($p=1;$p<=5;$p++):?>
						<?php if($item[0]["other_image_".$p]!=""):?>
						<div class="item_other_img_box_border fl" <?php if($p==5){echo 'style="margin-right:0"';}?>>
							<a title="<?php echo $item[0]["other_image_title_".$p];?>" href="<?php echo $item[0]["other_image_".$p]."_500x500.jpg";?>"><img src="<?php echo $item[0]["other_image_".$p]."_70x70.jpg";?>" alt="" /></a>
						</div>
						<?php endif;?>
						<?php endfor;?>
						</div>
					</div>
					<div class="ui-tabs-hide" id="tabs-3">
						<p>
							<?php echo $item[0]["goodsDetail"];?>
						</p>
					</div>
					<div class="ui-tabs-hide" id="tabs-4">
						<p><?php echo $item[0]["fine_print"];?></p>
					</div>
					
					</div>
				<?php endif;?>
				
				<div class="comment_box fl group_buy_xl_comment">
				
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
								<span><?php echo $comment["staffName"];?></span>&nbsp;&nbsp;&nbsp;<span class="create_time">at <?php echo $comment["created"];?></span>
								</a>
							</div>
							<div class="comment_content oh">
								<div class="comment_creater fl">
									<div class="comment_creater_box">
										<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$comment["user_id"]));?>">
										<?php $avatar = "../publish/avatar/".$comment["user_id"]."_thumb.".$comment["headImageUrl"]."_40.jpg";?>
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
											if($this->_tpl_vars["IN"]["from"] == "style_list"){
												$reply = runFunc("getCommentById",array($comment["reply_to"],"LIST GOODS"));
											}else{
												
												$reply = runFunc("getCommentById",array($comment["reply_to"],"GOODS"));
											}
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
										<a onClick="delete_comment(this,<?php echo $item[0]["id"];?>)" id="<?php echo $comment["id"];?>" class="delete_comment">delete</a>
									<?php endif;?>
									</div>
								</div>
							</div>
						</div>
						<?php if($key==0):?>
							<div class="comment_post_box">
							<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text"></textarea>
							<div id="comment_limit">250 characters remaining</div>
							<?php else:?>
							<div class="comment_box_login_msg">
							<?php 
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $item[0]["id"];
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
							<?php if($this->_tpl_vars["name"]!=""):?>
							<input class="fr" type="button" id="submit_commt" value="POST COMMENT" />
							<?php endif;?>
							</div>
							<?php if(count($comments)<2):?>
							<div class="other_comment_bar hide"></div>
							<?php endif;?>
							<?php endif;?>
					<?php endforeach;?>
					<?php else:?>
					<div class="comment_post_box">
						<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text"></textarea>
							<div id="comment_limit">250 characters remaining</div>
						<?php else:?>
						<div class="comment_box_login_msg">
							<?php 
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $item[0]["id"];
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
							<?php if($this->_tpl_vars["name"]!=""):?>
							<input class="fr" type="button" id="submit_commt" value="POST COMMENT" />
							<?php endif;?>
							</div>
					<div class="other_comment_bar hide"></div>
					<?php endif;?>
					</div>
					</div>
					<?php else:?>
					
					
					
					<?php endif;?>
				</div>
				<div id="group_buy_hot_deals_box" class="fr">
				<?php $hot_items = runFunc("getGroupBuyHotDeals",array($item[0]["id"]));?>
				
				<?php foreach($hot_items as $key=>$hot_item):?>
				<div class="group_buy_hot_deal_single_box">
				<div class="hot_deal_title">
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$hot_item["id"]));?>"><?php echo $hot_item["item_name"];?></a>
				</div>
				<div class="hot_deal_intro">
				<?php if(preg_replace('/<[^>]*>/', '', $hot_item["description"])!=""):?>
				<?php //echo $hot_item["description"];?>
				<?php endif;?>
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
				<div style="background:#bad782;" class="group_buy_price"><?php echo (1 - $hot_item["price_rate"]) * 100;?>% off</div>
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
					type : "GROUP BUY GOODS"
				
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
		$(".item_other_img_box a").lightBox();
		$("#group_buy_time_counter").counter({
			time: Date.parse("<?php echo date("Y-m-d",strtotime($item[0]["end_time"]. " + 1 days"));?>")
		});	

		$(".prop_select_button").click(function(){
				var clname = $(this).attr("prop_name");
				$(".prop_select_button_"+clname).removeClass("active_props");
				$(this).addClass("active_props");
				var prop_name = $(this).parent().siblings(".prop_name").text();
				var prop_val = $(this).attr("prop_title");
				$(this).parent().siblings(".prop_value_input").val(prop_name+" "+prop_val);
			});
		
		var reply = "0";
		var sending = 0;
		var member_id = <?php echo $this->_tpl_vars["name"];?>

			$( "#tabs" ).tabs({ fx: { opacity: 'toggle' } });
		
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
							type : "GROUP BUY GOODS",
							reply: reply,
							id : <?php echo $item[0]["id"];?>
						
						},
						success : function(json){

							var new_comment = '<div id="comment_box_'+ json.id +'" class="comment_talk_box">';
							new_comment += '<div class="comment_msg">';
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
							new_comment += '<span>'+ show_user_name +'</span>&nbsp;&nbsp;&nbsp;<span class="create_time">at '+json.created+'</span>';
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


			$(".love_it_button").click(function(){
				if(loving == 1){
					return false;
				}else{
					makeLove(<?php echo $item[0]["id"];?>,'<?php echo $this->_tpl_vars["name"];?>',"GROUP BUY ITEM",$(this),false);
				}
			});


			$("#item_comment_show_link").click(
					function(){
						 $('html, body').animate({
					         scrollTop: $(".comment_box").offset().top
					     }, 1000);
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
</script>
</body>
</html>
