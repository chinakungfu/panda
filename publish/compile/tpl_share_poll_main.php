<?php import('core.util.RunFunc'); 
 $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc("common/header/common_header.tpl");
if($this->_tpl_vars["IN"]["sort"] == ""){
	
	$sort = "id";
}else{
	
	$sort = $this->_tpl_vars["IN"]["sort"];
}

include($inc_tpl_file);
?>

</head>
<body onload="window.location.hash = 'here'">
	<div class="poll_comment_box hide">
		<div class="poll_coment_inner_box">
		<div style="text-align:left;padding:0 17px;color: #5e97ed; font-size :14px;margin:5px 0">Comments on <span id="vote_comment_item_title"></span></div>
		<textarea class="vote_comment"></textarea>
		<input id="vote_comment_submit" class="blue_button_sm" type="submit" value="Submit">
		<a class="pick_list_close">No,thanks</a>
		</div>
	</div>
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$items = runFunc("getPolls",array($this->_tpl_vars["IN"]["page"],5,false));
	$count = runFunc("getPolls",array($this->_tpl_vars["IN"]["page"],15,true));
	?>
	<div class="content">
	<div class="content_top_bar oh fl" style="width: 662px;">
	
	<h2 class="cp_title">Polls <?php if($this->_tpl_vars["name"]==""):?><span style="font-size:12px;color:#777777;">Please login to vote.</span><?php else:?><a style="font-size:12px;color:#777777;" href="<?php echo runFunc('encrypt_url',array('action=share&method=add_poll'));?>">Add a poll</a><?php endif;?></h2>
	<div class="poll_box">
		<?php foreach($items as $item):?>
		<?php $check_vote = runFunc("checkMemberVoted",array($item["id"],$this->_tpl_vars["name"]));?>
		<div class="poll_single_box">
			<div class="poll_msg_box oh">
				<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($item["user_id"]));?>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$item["user_id"]));?>">
				<?php $avatar = "../publish/avatar/".$user_info[0]["user_id"]."_thumb.".$user_info[0]["headImageUrl"];?>
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
				</a>	
				<div class="poll_single_detail fl">
					<div class="poll_single_title">
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=PollPage&id='.$item["id"]));?>"><?php echo $item["name"];?></a>
					</div>
					<div class="poll_single_creater">
						by <a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$item["user_id"]));?>">
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
				<div class="poll_single_box_ctrl">
				<?php if($item["user_id"] ==  $this->_tpl_vars["name"]):?>
				<a class="member_list_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=PollEdit&id='.$item["id"]));?>"></a>
				<a class="member_list_delete" href="<?php echo runFunc('encrypt_url',array('action=share&method=PollDelete&poll_id='.$item["id"]));?>" onclick="javascript:return confirm('confirm to delete this poll?')"></a>
				<?php endif;?>
				</div>
			</div>
			<div class="poll_single_item_main_box oh">
				<?php $poll_items = runFunc("getPollItems",array($item["id"]));?>
				<ul class="poll_single_item_ul">
				<?php foreach($poll_items as $poll_item):?>
				<li class="poll_single_item_li fl">
					<div class="poll_single_item_title" id="poll_single_item_title_<?php echo $poll_item["id"];?>">
					<?php if(trim($poll_item["title"])!=""){$poll_item["goodsTitleCN"] =  $poll_item["title"]; }?>
					<?php 
						if(strlen($poll_item["goodsTitleCN"])> 15){
								$current_item_name =  mb_substr($poll_item["goodsTitleCN"],0,15,'utf-8')."...";
							}else{
								$current_item_name = $poll_item["goodsTitleCN"];
							}
					?>
					<?php echo $current_item_name;?>
					<br />
					￥<?php echo number_format($poll_item["goodsUnitPrice"], 2, '.', ',');?>
					</div>
					<div class="poll_single_item_img_box">
					<a target="_blank" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$poll_item["goodsid"]."&show_type=collections&from=collections_page"))?>">
						<img src="<?php echo $poll_item["goodsImgURL"]."_310x310.jpg"?>" alt="" />
					</a>
					</div>
					<div class="item_vote_box" id="vote_box_<?php echo $poll_item["id"];?>">
					<?php if($check_vote[0]["count"]>0 or $item["user_id"] ==  $this->_tpl_vars["name"]):?>
					<?php $vote_poll_item = runFunc("getPollItemVoteCount",array($poll_item["id"]));?>
					<?php echo $vote_poll_item[0]["vote_count"]." Votes <br/>".$vote_poll_item[0]["comment_count"]." Comments";?>
					<?php else:?>
					<?php if($this->_tpl_vars["name"]!=""):?>
					<img onClick="javascript: vote_item(<?php echo $poll_item["id"]?>,<?php echo $item["id"]?>,this)" id="vote_button" src="../skin/images/vote_icon.png" alt="" />
					<?php endif;?>
						<?php endif;?>
					</div>
				</li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	</div>
	<div class="fr poll_result_box">
		<h2>Hot Item</h2>
		<div class="poll_result_content">
			<?php $hot_items = runFunc("getVoteHotItem");?>
			<?php foreach($hot_items as $key=>$hot_item):?>
			
			<div class="poll_result_single_box oh <?php if($key == 0){echo "first_poll_result";}?>">
				<div class="poll_result_single_img_box fl">
					<a target="_blank" href="<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$hot_item["goodsid"]."&show_type=collections&from=collections_page"))?>">
						<img src="<?php echo $hot_item["goodsImgURL"]."_310x310.jpg"?>" title="<?php echo $hot_item["goodsTitleCN"];?>" />
					</a>
				</div>
				<div class="poll_result_single_detail fl">
					<div class="poll_result_single_title">
					<?php if(trim($hot_item["title"])!=""){$hot_item["goodsTitleCN"] =  $hot_item["title"]; }?>
						<?php 
						if(strlen($hot_item["goodsTitleCN"])> 15){
								$current_item_name =  mb_substr($hot_item["goodsTitleCN"],0,15,'utf-8')."...";
							}else{
								$current_item_name = $hot_item["goodsTitleCN"];
							}
						?>
						<?php echo $current_item_name;?>
					</div>
					<div class="poll_result_single_votes">
						<img src="../skin/images/vote_small.png" alt="" /> <span id="poll_result_vote_count_<?php echo $hot_item["id"];?>"><?php echo $hot_item["vote_count"]." Votes";?></span>
					</div>
				</div>
			</div>
				<?php endforeach;?>
		
		</div>
	</div>
	
		<style type="text/css">
		
		.main_page_nav {
			margin-top: 20px;
		}
		
		.main_page_nav a  {
			margin-left: 0;
			margin-right: 5px;
		}
	
	</style>
	<?php 
	if($this->_tpl_vars["IN"]["page"]==""){
					
		$page = 1;
	}else{
		
		$page = $this->_tpl_vars["IN"]["page"];
	}
	
	echo runFunc("pageNavi",array($count[0]["count"],5,"share","PollList",$page));?>
	
	</div>
	<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</div>
<script type="text/javascript">

	var voting = 0;

	var vote_comment_id = 0;

	function vote_item(item_id,poll_id,el){
		
		if(voting == 0){
			voting = 1;
			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
			$(el).replaceWith(loading_icon);
			var item_name = $("#poll_single_item_title_"+item_id).text();
		}else{
				return false;
			}
		
		$.ajax({
			url : 'index.php',
			type : 'POST',
			dataType : "json",
			data:{
				action	: "share",
				method	: "votePoll",
				user_id : <?php echo  $this->_tpl_vars["name"];?>,
				item_id	: item_id,
				poll_id : poll_id,
				item_name : item_name
			},
			success : function(json)
			{
				for(var i=0;i<json.length;i++)
				{
					$("#vote_box_"+json[i].id).children().remove();
					$("#vote_box_"+json[i].id).html(json[i]["vote_count"]+" Votes <br/>"+json[i]["comment_count"]+ " Comments");

				}

				$(".poll_coment_inner_box").show();
				vote_comment_id = json[0].vote_id;
				$("#vote_comment_item_title").text(json[0].current_title);
				$(".poll_comment_box").dialog("open");
				
				
			},complete: function(){
				voting = 0;
				}
		});
		}

	$(function(){

		$("#vote_comment_submit").click(function(){


			var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
			$(".poll_coment_inner_box").hide();
			$(".poll_comment_box").append(loading_icon);

			$.ajax({
				url : 'index.php',
				type : 'POST',
				dataType : "json",
				data:{
					action	: "share",
					method	: "votePollComment",
					comment : $(".vote_comment").val(),
					id : vote_comment_id
				},
				success : function(json)
				{

					if(json!=null){
						for(var i=0;i<json.length;i++)
						{
	
							$("#vote_box_"+json[i].item_id).children().remove();
							$("#vote_box_"+json[i].item_id).html(json[i]["vote_count"]+" Votes <br/>"+json[i]["comment_count"]+ " Comments");
	
						}	
					}

					$(".poll_comment_box").dialog("close");
					$(".poll_coment_inner_box").show();
					loading_icon.remove();
				},complete: function(){
					
					}
			});

			});
		
		$(".pick_list_close").click(function(){
			$(".poll_comment_box").dialog("close");
			vote_comment_id = 0;
		});
		$(".poll_comment_box").dialog({
			autoOpen: false,
			width: 400,
			resizable: false,
			dialogClass: "add_friend_dialog",
			show: { effect: 'drop', direction: "up" },
			hide: { effect: 'drop', direction: "up" },
			modal: true
		});
		})

</script>
</body>
</html>