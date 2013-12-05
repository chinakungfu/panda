<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$inc_tpl_file=includeFunc("common/header/common_header.tpl");
include($inc_tpl_file);
?>

</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	if($this->_tpl_vars["IN"]["from"] == "search_url"){
		$good = runFunc("getGoodsById",array($this->_tpl_vars["IN"]["id"]));
		$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"GOODS"));
		$talk_type ="GOODS";
		$item = array();
		$item[0] = $good;
	}

	if($this->_tpl_vars["IN"]["from"] == "style_list"){
		$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"LIST GOODS"));
		$item = runFunc("getItemDetail",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["show_type"]));
		$talk_type = "LIST GOODS";
	}

	if($this->_tpl_vars["IN"]["from"] == "collections_page"){
		$comments = runFunc("getComment",array($this->_tpl_vars["IN"]["id"],"GOODS"));
		$item = runFunc("getItemDetail",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["IN"]["show_type"]));
		$talk_type ="GOODS";
	}

	$tags = runFunc("getGoodsTagsById",array($item[0]["goodsid"]));
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

					if($(".publish_item_img").width()>=$(".publish_item_img").height()){
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
	function itemSubmit(){
		var qit = $("#itemQty").val();
		if(isNaN(qit)){
			$("#itemQty").val(1);
		}else{
			if(!isNum(qit) || qit < 1){
				$("#itemQty").val(1);
			}
		}
		$(".prop_value_input").each(function(){
			if($(this).val()==''){
				$(".buy_error").html("Please select color,size or etc..");
				exit;
			}
		});
		$("#goodsInfo").submit();
	}
	function isNum(s){
		var r,reg;
		reg=/\d*/;
		r=s.match(reg);
		if(r==s)
		  return true;
		else
		  return false;
	};	
	</script>

	<div class="content">
		<div class="full_width_box oh">
			<div class="publish_item_left fl">
				<div class="publish_item_img_contain">
				<div class="publish_item_img_box">
				<img  class="publish_item_img" src="<?php echo $item[0]["goodsImgURL"];?>_600x600.jpg" alt="" />
				</div>
				<div class="item_img_prev"></div>
					<div class="item_img_next"></div>
				</div>
				<div class="publish_item_ctrl_bar oh">
				<?php if(count($tags)>0):?>
				<div style="margin-top:2px;margin-right:5px;color:#5E97ED" class="fl">TAG:</div>
				<?php $tt= 1; foreach($tags as $tag):?>
				<?php if($tt++>5)continue;?>
					<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surpriseindex&tag_id='.$tag["tag_id"]));?>" class="publish_tag_link" href=""><?php echo $tag["title"];?></a>
				<?php endforeach;?>
				<?php endif;?>
				<?php if($this->_tpl_vars["IN"]["from"]=="style_list"){

						$nav_id = runFunc("getItemNavGroup",array($this->_tpl_vars["IN"]["id"]));

					if($nav_id["prev"] == ""){

						$prev="";
					}
					else{
							$prev = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$nav_id["prev"].'&show_type=normal&from=style_list'));
					}

					if($nav_id["next"] == ""){

							$next="";
						}else{

							$next = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$nav_id["next"]."&show_type=normal&from=style_list"));
						}
				}elseif($this->_tpl_vars["IN"]["from"]=="collections_page"){

					$nav_id = runFunc("getGoodsNavGroup",array($this->_tpl_vars["IN"]["id"]));

					if($nav_id["prev"] == ""){

						$prev="";
					}
					else{
							$prev = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$nav_id["prev"].'&show_type=collections&from=collections_page'));
					}
					if($nav_id["next"] == ""){

							$next="";
						}else{

							$next = runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$nav_id["next"]."&show_type=collections&from=collections_page"));
						}


				}?>
					<div class="list_nav fr" style="margin-bottom: 0">
					<?php if($prev !=""):?>
						<a href="<?php echo $prev;?>" class="prev fl">Prev Item</a>
					<?php endif;?>
					<?php if($next !=""):?>
						<a href="<?php echo $next;?>" class="next fr">Next Item</a>
						<?php endif;?>
					</div>
				</div>
				<?php if($this->_tpl_vars["IN"]["from"] != "search_url"):?>
				<div class="comment_box">

					<h2 class="gray_line_title">Comments <span id="comment_count">(<?php echo count($comments);?>)</span></h2>
					<div class="comment_main_box gray_line_box oh">
					<?php if(count($comments)):?>
					<?php foreach($comments as $key=>$comment):?>
					<?php if($key==1):?>
							<div class="other_comment_bar"></div>
						<?php endif;?>
					<div id="comment_box_<?php echo $comment["id"];?>" class="comment_talk_box" style="margin-left:13px;">
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
										<p style="width:490px;">
										<?php if($comment["reply_to"]>0){
											if($this->_tpl_vars["IN"]["from"] == "style_list"){
												$reply = runFunc("getCommentById",array($comment["reply_to"],"LIST GOODS"));
											}else{

												$reply = runFunc("getCommentById",array($comment["reply_to"],"GOODS"));
											}
											?>
											<span style="color:#5E97ED"><?php echo "@".$reply[0]["staffName"];?></span>
										<?php }?>

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
							<div class="comment_post_box" style="margin-left:13px;">
							<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text"></textarea>
							<div id="comment_limit">250 characters remaining</div>
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
					<div class="comment_post_box" style="margin-left:13px;">
						<?php if($this->_tpl_vars["name"]!=""):?>
							<textarea id="comment_post_text" class="comment_post_text"></textarea>
							<div id="comment_limit">250 characters remaining</div>
						<?php else:?>
						<div class="comment_box_login_msg">
							<?php
								$this->_tpl_vars["paraArr"]["backAction"]=$this->_tpl_vars["IN"]["action"];
								$this->_tpl_vars["paraArr"]["backMethod"]=$this->_tpl_vars["IN"]["method"];
								$this->_tpl_vars["paraArr"]["backId"] = $this->_tpl_vars["IN"]["id"];
								$this->_tpl_vars["paraArr"]["show_type"] = $this->_tpl_vars["IN"]["show_type"];
								$this->_tpl_vars["paraArr"]["from"] = $this->_tpl_vars["IN"]["from"];
								$this->_tpl_vars["paraArr"]["loginType"] = "itemShow";
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
            <?php endif;?>
                </div>
			<div class="publish_item_right fr">
			<div class="item_detail_top">
				<div class="publish_item_title">
				<?php if($this->_tpl_vars["IN"]["from"] == "style_list"):?>
					<?php echo $item[0]["change_title"];?>
				<?php elseif($this->_tpl_vars["IN"]["from"] == "search_url" or $this->_tpl_vars["IN"]["from"] == "collections_page"):?>
                	<?php $goodsTitle = $item[0]['goodsTitleEn']?$item[0]['goodsTitleEn']:$item[0]['goodsTitleCN'];?>
					<?php echo $goodsTitle;?>
				<?php endif;?>
				</div>
				
					<?php if($this->_tpl_vars["IN"]["from"] == "collections_page"):?>
                    	<div class="publish_item_intro">
						<?php echo $item[0]["goodsIntro"];?>
                        </div>
					<?php elseif($this->_tpl_vars["IN"]["from"] == "style_list"):?>
                    	<div class="publish_item_intro">
						<?php echo $item[0]["change_description"];?>
                        </div>
					<?php endif;?>

				<div class="oh">
					 <div class="publish_price_box fl"><sup>￥</sup><?php echo number_format($item[0]["goodsUnitPrice"], 2, '.', ',');?></div>
				<div class="fr" style="width: 112px;">
					<a onclick="itemSubmit();" id="publish_item_buy" class="light_blue_button fr">buy now!</a>
				</div>
				</div>
				<div class="oh">
					<div class="publish_item_freight fl">
						<span class="small_blue_title"><?php if($item[0]["goodsURL"]!="" and $item[0]["show_link"]==1):?><?php endif;?>Freight</span>
						<span class="freight_price">
							￥<?php echo number_format($setting[0]["freight"], 2, '.', ',')?>
						</span>
<!--						<span id="freight_tip">?</span>
						<script type="text/javascript">
							$(function(){

									$("#freight_tip").qtip({
										   content: "Standart freight is 15RMB/order on Wowshopping website. Because shipping cost depends on distance and package weight. Different delivery service companies charge different. Shipping cost is determined by the Taobao seller. We won't let you charge the difference of the price, even if the actual cost is higher than 15RMB.",
										   show: 'mouseover',
										    position: {
											  corner: {
												 target: 'topLeft',
												 tooltip: 'bottomLeft'
											  }
										   },
										   style: {
											      name: 'cream'
											   }

										});
								});
						</script>-->
					</div>

					<div class="fr buy_error">

					</div>
				</div>
                <?php if($item[0]["goodsURL"]!="" && $item[0]["show_link"]==1):?>
					<?php if(trim($item[0]["click_url"])!=""){
						$click_link = $item[0]["click_url"];
					}else{
						$click_link = $item[0]["goodsURL"];
					}?>
                <div style="margin:20px auto 0;">                
					<div style="height:20px;line-height:20px; vertical-align:bottom;" class="fl"><img alt="" src="../../skin/images/little_house.png" style="margin-top:2px;">
					</div>                
               		<div class="itemShowRank fl" style="height:20px;line-height:20px; vertical-align:bottom;">
                    	<a style="color:#5E97ED" title="orignal link" target="_blank" href="<?php echo $click_link;?>">Seller</a>
                   	</div>
                    <div class="clb"></div>
                </div>
                
              	<?php endif;?>           
			
			
            <div class="oh" style="margin: 15px 0px 15px;">
            	<?php if($item[0]["goodsOriginalPrice"]>0):?>
                <div class="prop_name fl" style="width: 100px;">Original Price:</div><div class="original_price_box fl">￥<?php echo number_format($item[0]["goodsOriginalPrice"], 2, '.', ',');?></div>
                <?php endif;?>
            </div>
            
            <form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
            <input type="hidden" name="cart_type" value="1" />
				<?php $brand =  runFunc("getGoodsBrandById",array($item[0]["brand_id"]));?>
				<?php if(count($brand)>0):?>
				<div class="oh" style="margin-top: 20px">

					<span>Brand: <a style="color:#5E97ED;margin-left:6px;" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=surprise_brand_item_list&brand_id='.$brand["id"]));?>"><?php echo $brand["title"]?></a></span>
				</div>
				<?php endif;?>

				<div class="oh item_props">
				<?php $item_props = json_decode($item[0]["props"]);?>
				<?php foreach($item_props as $item_prop):?>

						<?php foreach($item_prop as $key=>$item_prop_values):?>
						<div class="props_box oh">
							<div class="prop_name fl"><?php echo ucfirst($key);?>:</div>
							<input class="prop_value_input" type="hidden" name="props[<?php echo $key;?>]" prop_name="<?php echo $key;?>" value="" />
  
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
							<?php endforeach;?></div>
<br /><div style="clear:both;"></div>
						<?php endforeach;?>


					</div>
				<?php endforeach;?>

					<div class="prop_name fl">Qty:</div> <input class="item_props_box fl" id="itemQty" type="text" name="ItemQTY" value="1" />
						<input type="hidden" value="<?php echo $setting[0]["freight"];?>" name="itemFreight">
						<input type="hidden" value="shop" name="action">
						<input type="hidden" value="addCart" name="method">
						<input type="hidden"  value="<?php echo $this->_tpl_vars["IN"]["id"];?>" name="page_id" />
						<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["show_type"];?>" name="show_type" />
						<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["from"];?>" name="from" />
						<input type="hidden" value="<?php echo $item[0]["goodsid"];?>" name="goodsID">
						<input type="hidden" value="<?php echo $item[0]["goodsUnitPrice"];?>" name="itemPrice">
						<input id="goodsAddUser" type="hidden" value="<?php echo $this->_tpl_vars["name"];?>" name="goodsAddUser">
					</div>
				</form>
				<div class="publish_item_ctrl_item">
				<?php if($this->_tpl_vars["IN"]["from"] != "search_url"):?>
					<div class="publish_item_ctrl_button fl">
						<img class="love_heart" alt="" src="/skin/images/heart.png">
						<?php $love_count = runFunc("getShareListLoveCount",array($this->_tpl_vars["IN"]["id"],"ITEM"));?>
						<?php $check_love = runFunc("checkMemberLove",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"],"ITEM"));
						?>

						<span class="heart_love_count " style="color:#979595">(<?php echo $love_count["count"];?>)</span>
						&nbsp;&nbsp;
						<a class="love_it_button <?php if($check_love["count"] > 0){echo "disable_love";}?>"><?php if($check_love["count"] > 0){echo "-Love it";}else{echo "+Love it";}?></a>
					</div>
					<?php endif;?>

					<?php $check_wish =  runFunc("countWishList",array($this->_tpl_vars["name"],$item[0]["goodsid"]));?>
					<?php if($check_wish>0):?>
					<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>" class="publish_item_ctrl_button fl">
					Already in wish list
					</a>
					<?php else:?>
					<a <?php if($this->_tpl_vars["name"]==""){echo "href='".runFunc('encrypt_url',array('action=website&method=login&loginType=itemShow&paraStr=' . $this->_tpl_vars["paraStr"] ))."'";}else{echo 'id="add_wish_button"';}?> class="publish_item_ctrl_button fl" style="width:100px;">
					+Add to wish list
					</a>
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
				<?php if($item[0]["goodsDesc"]!="" or $item[0]["goodsDetail"]!="" or $item[0]["goodsOthersTitle"]!="" or $item[0]["other_image_1"]!="" or $item[0]["other_image_2"]!="" or $item[0]["other_image_3"]!="" or $item[0]["other_image_4"]!="" or $item[0]["other_image_5"]!=""):?>
				<div id="tabs">
					<ul class="tab_button">
					<?php if($item[0]["goodsDesc"]!="" or $item[0]["other_image_1"]!="" or $item[0]["other_image_2"]!="" or $item[0]["other_image_3"]!="" or $item[0]["other_image_4"]!="" or $item[0]["other_image_5"]!=""):?>
						<li class="ui-state-active"><a href="#tabs-1">description</a></li>
					<?php endif;?>
					<?php if($item[0]["goodsDetail"]!=""):?>
						<li><a href="#tabs-2">detail</a></li>
					<?php endif;?>
						<?php if(trim($item[0]["goodsOthersTitle"])!=""):?>
						<li><a href="#tabs-3"><?php echo $item[0]["goodsOthersTitle"];?></a></li>
						<?php endif;?>
					</ul>
					<div class="" id="tabs-1">
						<p>
							<?php echo $item[0]["goodsDesc"];?>
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
					<div class="ui-tabs-hide" id="tabs-2">
						<p>
							<?php echo $item[0]["goodsDetail"];?>
						</p>
					</div>
					<div class="ui-tabs-hide" id="tabs-3">
						<p><?php echo $item[0]["goodsOthers"];?></p>
					</div>
				</div>

				<?php endif;?>
					</div>
			<?php if(count($tags)>0):

				$tags_array = array();
				foreach ($tags as $tag){

					$tags_array[] = $tag["tag_id"];
				}
				$tags_str = implode(",", $tags_array);
				$tag_goods = runFunc("getTagGoods",array($tags_str));
				?>
				<div class="hot_box">
					<h2 class="hot_box_title">You may like</h2>
					<div class="hot_box_content">
						<?php $ii = 1; foreach($tag_goods as $tag_good):?>
						<?php if($tag_good["goodsid"] == $item[0]["goodsid"] or $ii == 5)continue;?>
						<a href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$tag_good["goodsid"]."&show_type=collections&from=collections_page"));?>" class="hot_box_img_box <?php if($ii++%2!=""){echo "fl";}else{echo "fr";}?>">
						<img width="170" src="<?php echo $tag_good["goodsImgURL"];?>_310x310.jpg" alt="" />
						</a>
						<?php endforeach;?>
					</div>
				</div>
			<?php endif;?>
			</div>
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
					type : "GOODS"

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

		$(".prop_select_button").click(function(){
				var clname = $(this).attr("prop_name");
				$(".prop_select_button_"+clname).removeClass("active_props");
				$(this).addClass("active_props");
				var prop_name = $(this).parent().siblings(".prop_name").text();
				var prop_val = $(this).attr("prop_title");
				$(this).parent().siblings(".prop_value_input").val(prop_val);
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
							type : "<?php echo $talk_type;?>",
							reply: reply,
							id : <?php echo $this->_tpl_vars["IN"]["id"];?>

						},
						success : function(json){

							var new_comment = '<div id="comment_box_'+ json.id +'" class="comment_talk_box" style="margin-left:13px">';
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
								new_comment += '<p style="width:490px"><span style="color:#5E97ED">@'+ json.reply.staffName +'</span> '+ json.comment +'</p>';
								}else{
								new_comment += '<p style="width:490px">'+ json.comment +'</p>';
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
					makeLove(<?php echo $this->_tpl_vars["IN"]["id"];?>,'<?php echo $this->_tpl_vars["name"];?>',"ITEM",$(this),false);
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
var adding_wish = 0;
			$("#add_wish_button").click(function(){


				if(adding_wish == 0){
						adding_wish = 1;
					}
				else{return false;}
				var para = new Array();
				para = {};
				para["ItemQTY"] = 1;
				para["itemFreight"] = <?php echo $setting[0]["freight"];?>;
				para["goodsID"] = <?php echo $item[0]["goodsid"];?>;
				para["itemPrice"]=<?php echo $item[0]["goodsUnitPrice"];?>;
				para["goodsAddUser"]='<?php echo $this->_tpl_vars["name"];?>';

				var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
				$("#add_wish_button").text("");
				$("#add_wish_button").append(loading_icon);
				$.ajax({
					url : 'index.php',
					type : 'POST',
					dataType : "json",
					data:{
						action	: "shop",
						method	: "addWish",
						para : para

					},
					success : function(json){
						if(json.re == 1){
								$("#add_wish_button").text("Add successfully");
								$("#add_wish_button").attr("href","/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>");
								loading_icon.remove();
							}else{

								$("#add_wish_button").text("Add successfully");
								$("#add_wish_button").attr("href","/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>");
								loading_icon.remove();
								}
					}

				});

				});

		});
</script>
</body>
</html>

