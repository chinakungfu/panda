<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<?php if ($this->_tpl_vars["name"]){?>
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
	<?php
	$inc_tpl_file=includeFunc("share/common/header.tpl");
	include($inc_tpl_file);


	$list_info = runFunc("getShareListById",array($this->_tpl_vars["IN"]["id"]));
$items = runFunc("getMemberShareListItem",array($list_info[0]["id"]));
$love_count = runFunc("getShareListLoveCount",array($this->_tpl_vars["IN"]["id"],"STYLE LIST"));
$check_love = runFunc("checkMemberLove",array($this->_tpl_vars["IN"]["id"],$this->_tpl_vars["name"],"STYLE LIST"));

$user_id = $this->_tpl_vars["IN"]["user_id"];
$user = runFunc('getUser',array($user_id));
if($user[0]['staffName']){
	$title = $user[0]['staffName']."'s"." Collection List";
}else{
	$title = $user[0]['staffNo']."'s"." Collection List";
}
	?>
		<div class="content">
            <div class="collection_top_bar oh">
            	<div class="collection_title" style="color:#5e97ed;margin-bottom:10px;font-size:20px;">
				<?php echo $title;?>
                </div>
            </div>
			<div class="list_show_box fl" >
				<div class="gray_line_box list_show_wh list_box_list_detail oh">
					<div class="list_show_list_info fl">
						<div class="list_show_list_title">
							<?php echo $list_info[0]["title"];?> <font style="font-size:12px;">(<?php echo count($items);?>)</font>
						</div>
						<div class="list_show_list_desc">
							<?php echo $list_info[0]["description"];?>
						</div>
					</div>
					<a class="list_show_list_love fr <?php if($check_love["count"] > 0){echo 'disable_love';}?>">
					<?php if($check_love["count"] > 0):?>
						<img src="../skin/images/disable_heart_circle.png" alt="" />
					<?php else:?>
						<img src="../skin/images/heart_circle.png" alt="" />
					<?php endif;?>
						<br />
						<span class='love_count'><?php if($check_love["count"] > 0):?>Loved<?php else:?>Love<?php endif;?> (<?php echo $love_count["count"];?>)</span>
					</a>
				</div>
				<div class="list_show_box_bar oh">
				<div class="member_list_share_bar">
				<label class="fl">SHARE</label>
					<div class="attentionInfo">
						<span class='st_email_large fl' displayText='Email'></span>
						<span class='st_facebook_large fl' displayText='Facebook'></span>
						<span class='st_twitter_large fl' displayText='Tweet'></span>
						<span class='st_linkedin_large fl' displayText='LinkedIn'></span>
						<span class='st_pinterest_large fl' displayText='Pinterest'></span>
						<span class='st_googleplus_large fl' displayText='Google +'></span>
					</div>
				</div>
				<?php if($list_info[0]["user_id"]==$this->_tpl_vars["name"]):?>
					<a class="add_list_show_link fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=editList&id='.$list_info["0"]["id"]."&user_id=".$this->_tpl_vars["name"]));?>"><img src="../skin/images/grid_botton.png" alt="" /> Edit this list</a>
				<?php endif;?>
				</div>
				<?php foreach ($items as $item):?>
				<div class="list_box_items_show gray_line_box list_show_wh oh">
					<div class="list_box_item_img_box fl">
						<img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" />
					</div>
						<div class="list_box_item_detail_box fl">
						<div class="list_box_item_title">
							<?php echo $item["list_item_title"];?>
						</div>
						<div class="list_box_item_desc">
							<?php echo $item["list_item_desc"];?>
						</div>
						<div class="list_box_item_link_box">
							<a target="_blank" href="<?php echo $item["goodsURL"]?>">Original link</a>
						</div>
						<div class="list_box_price_box">
							Price (single) <?php echo number_format($item["goodsUnitPrice"], 2, '.', ',');?> RMB
						</div>
						<?php $group_buy = runFunc("checkItemGroupBuy",array($item["goodsid"]));?>
						<div class="list_box_add_to_list oh" >
						<?php if(count($group_buy)>0):?>
						<!--<font style="color: #FFCC33;font-size:14px;">Group Buy</font>-->
						<?php endif;?>
						<?php if($user_id!=$this->_tpl_vars["name"]):?>
							<a id="<?php echo $item["list_item_id"]?>" class="add_to_my_list_button largest_blue fr">ADD TO YOUR LIST</a>
							<?php endif;?>
						</div>
						<?php $comments = runFunc("getComment",array($item["list_item_id"],"LIST GOODS",true));?>
						<div class="list_box_add_to_list oh" style="margin-top: 5px;">
							<div class="list_box_comments_show_box fl">
							<?php $love_count = runFunc("getShareListLoveCount",array($item["list_item_id"],"ITEM"));?>
								<?php echo $love_count["count"];?> <img class="love_heart" src="/skin/images/heart.png" alt=""> &nbsp;&nbsp;<font style="color: #5e97ed"><?php echo $comments[0]["count"]?> </font> comments
							</div>
							<?php $group_buy = runFunc("checkItemGroupBuy",array($item["goodsid"]));?>
							<?php if(count($group_buy)>0):?>
							<a class="largest_blue fr" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item["list_item_id"]."&show_type=normal&from=style_list"));?>">VIEW DETAILS</a>
							<?php else:?>
							<a class="largest_blue fr" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item["list_item_id"]."&show_type=normal&from=style_list"));?>">VIEW DETAILS</a>
							<?php endif;?>

						</div>
					</div>
				</div>
				<div id="add_to_my_list_<?php echo $item["list_item_id"];?>" class="add_to_my_list_box gray_line_box oh hide">
							<div class="add_to_my_list_box_tite">
								Pick a Collction List
							</div>
							<div class="pick_img_message fl">
							<div class="pick_list_img"><img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" /></div>
							<div id="pick_message_<?php echo $item["list_item_id"];?>" class="pick_message">

							</div>
							</div>
							<div class="pick_list_detail fr">
								<div id="pick_item_title_<?php echo $item["list_item_id"];?>" class="pick_item_title"><?php echo $item["list_item_title"];?></div>
								<?php $my_lists = runFunc("getShareListByUserId",array($this->_tpl_vars["name"]));?>
								<select name="" class="my_list_select">
									<option class="no_choose" value="">Select List from Collection</option>
									<?php foreach($my_lists as $my_list):?>
									<option value="<?php echo $my_list["id"]?>"><?php echo $my_list["title"];?></option>
									<?php endforeach;?>
								</select>
								<div class="pick_link_comment">
									<a href="<?php echo runFunc('encrypt_url',array('action=share&method=addList&add_item_id='.$item["list_item_id"]));?>"> Create New Collection List</a>
									<textarea onkeyup="checkWordLen(this);" name="" class="pick_item_comment" cols="30" rows="10"></textarea>
									<span class="pick_link_comment_limit">300 characters limit</span>
								</div>
								<div class="pick_list_item_ctrls">
									<input item_id="<?php echo $item["list_item_id"];?>"  goods_id="<?php echo $item["goodsid"];?>" class="pick_list_submit blue_button_sm" type="submit" value="Submit" />
									<a id="<?php echo $item["list_item_id"];?>" class="pick_list_close">Cancel</a>
								</div>
							</div>
						</div>
                       	
				<?php endforeach;?>
			</div>
			<div class="fr list_page_adv" style="margin-top:0;">

			<?php echo runFunc("getSiteAdv",array("Style List","style_list_right_adv"));?>
			</div>
            
		</div>
        <div class="clb" style="height:50px;"></div>
			<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
	</div>

	<script type="text/javascript">

	function checkWordLen(e){
		var limit = 300 - $(e).val().length;
		var limit_word = "("+ limit +" characters limit)";

		if($(e).val().length >=300){
			$(e).val($(e).val().substring(0, 300));
			limit_word = "(0 words max)";
		}
		$(e).siblings(".pick_link_comment_limit").text(limit_word);
	}

		$(function(){

			var submiting = 0;

			$(".pick_list_submit").click(function(){
					var item_id = $(this).attr("item_id");
					var goods_id = $(this).attr("goods_id");
					var list_id = $(this).parent().siblings(".my_list_select").val();
					var title = $("#pick_item_title_"+item_id).text();
					var comment = $(this).parent().siblings(".pick_link_comment").children(".pick_item_comment").val();

					if(submiting == 0){
						submiting = 1;

					}else{
							return false;
						}
					if(list_id==""){
							alert("Please select your list first!");
							submiting = 0;
							return false;
						}
					$("#pick_message_"+item_id).children().remove();
					$("#pick_message_"+item_id).text("");
					var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
					$("#pick_message_"+item_id).append(loading_icon);
					$.ajax({
						url : 'index.php',
						type : 'POST',
						dataType : "json",
						data:{
							action		: "share",
							method		: "addItemToList",
							list_id 	: list_id,
							title 		: title,
							comment 	: comment,
							goods_id 	: goods_id
						},
						success : function(data)
						{

						},complete: function(){
							$("#pick_message_"+item_id).children().remove();
							submiting = 0;
							$("#pick_message_"+item_id).text("Add successful!");
							$(".pick_list_submit").hide();
							$(".pick_list_close").addClass("pick_list_success_close");
							$(".pick_list_close").text("Close");
						}
					});
				});

			$( ".add_to_my_list_box" ).dialog({
				autoOpen: false,
				show: { effect: 'drop', direction: "up" },
				hide: { effect: 'drop', direction: "up" },
				width: 430,
				modal: true
			});

			$( ".add_to_my_list_button" ).click(function() {
				$(".pick_list_close").removeClass("pick_list_success_close");
				$(".pick_list_close").text("Cancel");
				$(".pick_list_submit").show();
				$(".my_list_select").children(".no_choose").attr("selected","selected");
				$(".pick_item_comment").val("");
				$(".pick_item_comment").siblings(".pick_link_comment_limit").text("300 characters limit");
				var id = $(this).attr("id");
				$("#add_to_my_list_"+id).dialog( "open" );
				return false;
			});

			$(".pick_list_close").click(function(){
					var id = $(this).attr("id");
					$("#add_to_my_list_"+id).dialog( "close" );
					return false;
				});


			$(".list_show_list_love").click(function(){
				if(loving == 1){
						return false;
					}else{
						makeLove(<?php echo $this->_tpl_vars["IN"]["id"];?>,<?php echo $this->_tpl_vars["name"];?>,"STYLE LIST",$(this),"heart_circle.png",false);
					}
				});


			});
	</script>
</body>
</html>

	<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc("common/account_passPara.tpl");
		include($inc_tpl_file);
		?>
<?php } ?>

