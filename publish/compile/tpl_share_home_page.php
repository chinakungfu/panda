<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
//************************select country***************************************
import('core.apprun.cmsware.CmswareNode');
import('core.apprun.cmsware.CmswareRun'); 
?>
<?php if ($this->_tpl_vars["name"]){?>
<?php header("Location: ".runFunc('encrypt_url',array('action=website&method=index')));?>
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
<script type="text/javascript" src="/publish/skin/jsfiles/date.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/jquery.counter.js"></script>
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
	?>
	
	<?php
	$inc_tpl_file=includeFunc("share/common/header.tpl");
	include($inc_tpl_file);
	$lists = runFunc('getMemberShareList',array($user_id,1,2));
	$lists_count = runFunc('getMemberShareList',array($user_id,$this->_tpl_vars["IN"]["page"],4,true));
	
	$circle = runFunc("getCircleByUserId",array($user_id));
	$check = runFunc("checkJoin",array($circle[0]["id"],$this->_tpl_vars["name"]));
	if(count($circle)>0){
	$member_count = runFunc("getCircleMember",array($circle[0]["id"],10,true));
	
	$last_comment = runFunc("getCircleLastActivity",array($circle[0]["id"]));
	}
	?>
	
		<div class="content">
		<div class="full_width_box oh">
		<?php if($user_id == $this->_tpl_vars["name"]):?>
		<?php $member =  runFunc("getStaffInfoById",array($user_id));?>
		<?php $messages = runFunc("getMemberMessageByToId",array($user_id,1,5,true));?>
		<div class="my_home_page_top_bar oh">
			<h2 class="my_home_page_title_left fl">Activity Stream</h2>
			<h2 class="my_home_page_title_right fl">Info</h2>
		</div>
		<div class="my_home_page_box oh">
			<div class="my_home_page_left_part fl">
				<div class="my_home_page_message_contain">
				<?php if(count($messages)>0):?>
				<?php foreach($messages as $message):?>
					<div class="my_home_page_message_box oh ">
					<form class="read_message_form" action="index.php" method="post">
					<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$message["from"]));?>">
					<?php $avatar = "../publish/avatar/".$message["from"]."_thumb.".$message["from_avatar_ext"];?>
						<?php if(file_exists($avatar)){?>
						<img class="fl" id="userimg" src="<?php echo $avatar."_40.".$message["from_avatar_ext"];?>" alt="userInfo" id="userHeaderImg" />
							<?php }else{ ?>
						<img class="fl" id="userimg" src="../skin/images/pic.jpg" alt="userInfo" />
						<?php } ?>
					</a>
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$message["from"]));?>" class="my_home_page_message_from fl">
							<?php echo $message["from_name"];?>
						</a>
						<div class="my_home_page_message_content fl">
							<?php echo $message["content"];?>
							<?php if($message["message_type"]=="FRIEND REQUEST"):?>
							, you can <a href='<?php echo runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=confirm&message_id='.$message["id"].'&user_id='.$message["from"]));?>'>confirm</a> or <a href='<?php echo runFunc('encrypt_url',array('action=share&method=confirmAddFriend&type=refuse&message_id='.$message["id"].'&user_id='.$message["from"]));?>'>refuse</a>
							<br/><?php echo $message["message_content"];?>
							<?php endif;?>
						</div>
					<input type="hidden" name="action" value="website"/>
					<input type="hidden" name="method" value="readMessage"/>
					<input type="hidden" name="id" value="<?php echo $message["id"];?>" />
					<input type="hidden" name="link" value="<?php echo $message["link"];?>"/>
					</form>
					</div>
				<?php endforeach;?>
				<?php else:?>
				<div class="home_page_no_message">
					No Activity Stream Temporarily <br />
					<a href="<?php echo runFunc('encrypt_url',array('action=website&method=friendInvite'));?>">Invite Friends</a>
				</div>
				<?php endif;?>	
				</div>
				<div class="my_home_page_left_footer">
					<a href="<?php echo runFunc('encrypt_url',array('action=share&method=messageAll'));?>">view all</a>
				</div>
			</div>
			<div class="my_home_page_right_part fl">
				<div class="my_home_page_info">
					<h2>Your online account info :</h2>
					<div class="my_home_page_info_1 oh">
						<div class="fl my_home_page_info_tag_b"><font style="color:#eca6bd;"><?php echo $member[0]["balance"];?> RMB</font> Balance</div>
						<?php $setting = runFunc("getGlobalSetting");?>
						<script type="text/javascript">
							$(function(){
					
									$("#credit_help").qtip({
										   content: "Receive 1 credit for <?php echo $setting[0]["credit_consumption"];?> Chinese Yuan you spend on items fee and domestic shipping fee.<br>For every <?php echo $setting[0]["credit_to_money"];?> credits, you can deduct 1 RMB.The member credit's valid period is one year.",
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
						</script>
						<div class="fl my_home_page_info_tag_b" style="margin-left: 102px;"><font style="color:#eca6bd;"><?php echo $member[0]["credits"];?></font> Credits <a style="color:#ac0909;cursor:pointer;" id="credit_help">?</a></div>
					</div>
					<div class="home_page_oh_div oh">
					<a class="home_gray_button fl" href="<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>">Recharge</a>
					</div>
				</div>
				<div class="my_home_page_info">
					<h2>Your shopping info :</h2>
					<?php $order = runFunc("getMyOrdersCount",array($user_id));?>
					<?php $wishlist = runFunc("getMyWishListCount",array($user_id));?>
					<div class="my_home_page_info_1 oh">
						<div style="margin-left:63px" class="fl my_home_page_info_tag_s"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>" style="color:#eca6bd;"><?php echo $order[0]["count"];?></a> orders</div>
					
					<?php $order_need_to_pay = runFunc("getMyOrderCountByStatus",array($this->_tpl_vars["name"],4));?>

					<?php $order_need_to_confirm = runFunc("getMyOrderCountByStatus",array($this->_tpl_vars["name"],7));?>
						<div class="fl my_home_page_info_tag_s"><a href="<?php echo runFunc('encrypt_url',array('action=account&method=payment'));?>" style="color:#eca6bd;"><?php echo $order_need_to_pay[0]["count"];?></a> payment info</div>
						<div class="fl my_home_page_info_tag_s"><a href="<?php echo runFunc('encrypt_url',array('action=account&method=confirmOrder'));?>" style="color:#eca6bd;"><?php echo $order_need_to_confirm[0]["count"];?></a> confirm info</div>
						<div class="fl my_home_page_info_tag_s"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=wishlist'));?>" style="color:#eca6bd;"><?php echo $wishlist[0]["count"];?></a> wishes</div>
					</div>
				</div>
				<div class="home_page_info_buttons oh">
					<a class="home_gray_button fl" href="<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Setting</a>
					<a class="home_black_button fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=editProfile'));?>">Edit Profile</a>
				</div>
			</div>
		</div>
		<?php else:?>
			<div class="box_inner_left fl home_page_inner">
				<div class="box_inner_bar oh">
				<?php if(count($lists)>0):?>
					<h2 class="full_box_title fl"><a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareList&user_id='.$user_id));?>">Style Lists (<?php echo $lists_count[0]["count"];?>)</a></h2>
					<?php if($user_id==$this->_tpl_vars["name"]):?>
					<a class="gray_link fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=addList'));?>">Create a list</a>
					<?php endif;?>
				</div>
				<div class="member_list_box oh">
				
				<?php $ii = 1;?>
					<?php foreach($lists as $list):?>
					<?php $items = runFunc("getMemberShareListItem",array($list["id"]));?>
						<div class="member_list_item fl" <?php if($ii++ == 2){ echo "style='margin-right:0'";}?>>
						<div class="member_list_item_header oh">
							<a class="member_list_title fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"]));?>">
								<?php if(strlen($list["title"])> 25){	
									echo mb_substr($list["title"],0,25,'utf-8')."...";
								}else{
									echo $list["title"];
								}?>
								 (<?php echo count($items);?>)
							</a>
							<?php if($list["user_id"]==$this->_tpl_vars["name"]):?>
							<div class="member_list_ctrl fr">
								<a class="member_list_editor" href="<?php echo runFunc('encrypt_url',array('action=share&method=editList&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
								<a onClick="javascript:return confirm('confirm to delete this list?')" class="member_list_delete" href="<?php echo runFunc('encrypt_url',array('action=share&method=memberShareListDelete&id='.$list["id"]."&user_id=".$this->_tpl_vars["name"]));?>"></a>
							</div>
							
							<?php endif;?>
						</div>
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$list["id"].'&user_id='.$user_id));?>" class="member_list_item_body oh">
							<?php foreach($items as $key=>$item):?>
							<?php if($key>9)break;?>
								<div class="main_item_img_box fl">
									<img src="<?php echo $item["goodsImgURL"]?>_310x310.jpg" alt="" />
								</div>
							<?php endforeach;?>
						</a>
						<?php $staff = runFunc("getStaffInfoById",array($list["user_id"]));//print_r($staff);?>
						<div class="member_list_item_footer">
							<div class="created_box fl">
								<div class="member_list_avatar_box fl">
								<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$user_id));?>">
								<?php $avatar = "../publish/avatar/".$list["user_id"]."_thumb.".$staff[0]["headImageUrl"];?>
								<?php if(file_exists($avatar)){?>
									<img style="width: 30px;" src="<?php echo $avatar;?>" alt="" />
								<?php }else{?>
									<img style="width: 30px;" src="../skin/images/pic.jpg" />
								<?php }?>
								</a>
								</div>
								<div class="created_member fl">
									<span>Created by</span> <br />
									<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$user_id));?>">
									<span style="color:#e85eed">	
									<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($user_id));?>
											<?php if($user_info[0]["real_name"]==1 and ($user_info[0]["first_name"]!="" or $user_info[0]["last_name"] !="")):?>
												<?php if($user_info[0]["first_name"]!=""){echo $user_info[0]["first_name"]."&nbsp;";} echo trim($user_info[0]["last_name"]);?>
											<?php elseif($user_info[0]["show_nick"]==1):?>
												<?php echo $user_info["0"]["staffName"];?>
											<?php else:?>
												<?php echo $user_info["0"]["staffNo"];?>
											<?php endif;?></span>
										</a>
								</div>
							</div>
							<?php $love_count = runFunc("getShareListLoveCount",array($list["id"],"STYLE LIST"));?>
							<div class="list_message_box fr" style="margin-top: 13px;">
								<div class="list_message_content">
									<span style="color:#5e97ed"><?php echo $love_count["count"];?></span> <img src="/skin/images/heart.png" alt="" />
								</div>
								<div class="list_message_content">
									<span style="color: #5e97ed">0</span> comments
								</div>
							</div>
						</div>	
					</div>
					<?php endforeach;?>
				
				
				<?php endif;?>
				<?php $poll_count = runFunc("getMemberPolls",array($user_id,1,1,true));?>
				<?php $my_polls = runFunc("getMemberPolls",array($user_id,1,1,false));?>
				<?php if(count($my_polls)>0):?>
				<div class="box_inner_bar oh" style="margin-bottom: 5px;">
					<h2 class="full_box_title fl"><a href="<?php echo runFunc('encrypt_url',array('action=share&method=memberPolls&user_id='.$user_id));?>">Polls (<?php echo $poll_count[0]["count"];?>)</a></h2>
				</div>
				<div class="poll_single_box">
				
				
				<div class="poll_msg_box oh">
				<?php $user_info = runFunc("getShareMemberInfoAllInOne",array($my_polls[0]["user_id"]));?>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$my_polls[0]["user_id"]));?>">
				<?php $avatar = "../publish/avatar/".$user_info[0]["user_id"]."_thumb.".$user_info[0]["headImageUrl"];?>
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
				</a>	
				<div class="poll_single_detail fl">
					<div class="poll_single_title">
						<a href="<?php echo runFunc('encrypt_url',array('action=share&method=PollPage&id='.$my_polls[0]["id"]));?>"><?php echo $my_polls[0]["name"];?></a>
					</div>
					<div class="poll_single_creater">
						by <a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$my_polls[0]["user_id"]));?>">
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
			</div>
				
				<div class="poll_single_item_main_box oh">
				<?php $poll_items = runFunc("getPollItems",array($my_polls[0]["id"]));?>
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
					<?php $check_vote = runFunc("checkMemberVoted",array($my_polls[0]["id"],$this->_tpl_vars["name"]));?>
					<?php if($check_vote[0]["count"]>0 or $my_polls[0]["user_id"] ==  $this->_tpl_vars["name"] or $my_polls[0]["end_time"] < date("Y-m-d")):?>
					<?php $vote_poll_item = runFunc("getPollItemVoteCount",array($poll_item["id"]));?>
					<?php echo $vote_poll_item[0]["vote_count"]." Votes <br/>".$vote_poll_item[0]["comment_count"]." Comments";?>
					<?php else:?>
					<?php if($this->_tpl_vars["name"]!=""):?>
					<img onClick="javascript: vote_item(<?php echo $poll_item["id"]?>,<?php echo $my_polls[0]["id"]?>,this)" id="vote_button" src="../skin/images/vote_icon.png" alt="" />
					<?php endif;?>
						<?php endif;?>
					</div>
				</li>
				<?php endforeach;?>
				</ul>
			</div>
				
				</div>
				<?php endif;?>
				</div>
				<?php if((count($lists) + $poll_count[0]["count"])==0):?>
					<div class="no_posts_word" style="text-align: center;">
					The quick brown fox jumps over the lazy dog ^_^
					</div>
				<?php endif;?>
			</div>
			<div class="box_inner_right fr" style="width: 370px;">
			<?php if(count($circle)>0):?>
			<h2 class="home_page_right_title">
			My Circles
			</h2>
			<div class="circle_top_box_left fl">
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));?>" >
				<img class="circle_box_img fl" src="../circles_img/<?php echo $circle[0]["user_id"];?>/<?php echo $circle[0]["img"];?>" alt="" class="circle_box_img" />
			</a>
				<div class="my_circle_detail fl">
					<div class="my_circle_detail_box_top">
					<h2 class="my_circle_title">
					<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$circle[0]["id"]));?>" >
						<?php echo $circle[0]["name"];?>
					</a>
					</h2>
					<?php if(count($check)>0 and $this->_tpl_vars["name"]!=$circle[0]["user_id"]):?>
					<a onClick="javascript: return confirm('Confirm to give up this circle?')" href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$circle[0]["id"]));?>" class="circle_quit_link">Give up</a>
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
			<?php endif;?>
			

			<?php $my_event = runFunc("getEventByUserId",array($user_id,1,1));?>
			<?php if(count($my_event)>0):?>
			<div class="gray_line_div fl"></div>
			<h2 class="home_page_right_title">
			My Events
			</h2>
			<a class="fl" href="<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$my_event[0]["id"]));?>" style="background: url(../circle_event_img/<?php echo $my_event[0]["user_id"]?>/<?php echo $my_event[0]["img"]?>) no-repeat center center;width:325px;height: 175px;border:1px solid #979595;margin-left: 22px;" class="event_preview">
			<div class="event_preview_detail">
				<div class="event_preview_title">
				<?php if(strlen($my_event[0]["name"])> 60){	
					echo mb_substr($my_event[0]["name"],0,60,'utf-8')."...";
					}else{
						echo $my_event[0]["name"];
					}?>
				</div>
				<div class="event_start">
					availability 
					<?php if( date("Y.m.d",strtotime($my_event[0]["start"])) == date("Y.m.d",strtotime($my_event[0]["end"]))):?>
					<?php echo date("Y.m.d",strtotime($my_event[0]["start"]))?>
					<?php else:?>
					<?php echo date("Y.m.d",strtotime($my_event[0]["start"]))?> - <?php echo date("Y.m.d",strtotime($my_event[0]["end"]))?>
					<?php endif;?>
				</div>
			</div>
		</a>
		<?php endif;?>
		
		
		<?php $checkFriend = runFunc("checkFriend",array($user_id,$this->_tpl_vars["name"]));?>

		<?php if($checkFriend>0 or $user_id){
			$my_group_buy = runFunc("getMyGroupBuyItem",array($user_id,true));
		}else{
			
			$my_group_buy = runFunc("getMyGroupBuyItem",array($user_id));
		}?>
<?php if(count($my_group_buy)>0):?>
		<div class="gray_line_div fl"></div>
			<h2 class="home_page_right_title">
			My Group Buy
			</h2>
			<div class="my_group_buy_title_box fl">
			<div class="my_group_buy_img_box fl">
				<img src="<?php echo $my_group_buy[0]["goodsImgURL"]."_310x310.jpg"?>" width="75px" alt="" />
			</div>
			<div class="my_group_buy_detail_box fl">
				<div class="my_group_buy_detail_title">
					<?php echo $my_group_buy[0]["item_name"];?>
				</div>
				<div class="my_group_buy_detail_price">
				<?php if($my_group_buy[0]["sell_way"]==2){
					
					$price = number_format($my_group_buy[0]["goodsUnitPrice"] * $my_group_buy[0]["price_rate"], 2, '.', ',');
					
				}else{
					
					$price = number_format($my_group_buy[0]["goodsUnitPrice"], 2, '.', ',');
				}?>
					 <sup>￥</sup><?php echo $price;?>
				</div>
			</div>
			</div>
			<div class="group_buy_message_box fl" style="width:370px;">
					<div class="group_buy_message fl" style="border:0;display:inline;">
					<?php if($my_group_buy[0]["sell_way"]==2):?>
						<b>￥<?php echo number_format($my_group_buy[0]["goodsUnitPrice"], 2, '.', ',');?></b> 
						
						<br />VALUE
					<?php else:?>
					<b>SERVICE FEE </b>
					<br />DISCOUNT
						<?php endif;?>
					</div>
					<div class="group_buy_message fl">
						<b><?php echo (1 - $my_group_buy[0]["price_rate"]) * 100;?>%</b> <br /> <?php if($my_group_buy[0]["sell_way"]==2):?>SAVING<?php else:?>OFF<?php endif;?>
					</div>
					<div class="group_buy_message fl">
						<b><?php echo $my_group_buy[0]["count"];?></b> <br /> PURCHASED
					</div>
					<div id="group_buy_time_counter" class="group_buy_message fl">
							<span class="day"></span> <span>days</span>
							<span class="hour"></span>:<span class="minute"></span>:<span class="second"></span>
							<br /> REMAINING
					</div>
					<script type="text/javascript">
						$(function(){
							$("#group_buy_time_counter").counter({
								time: Date.parse("<?php echo date("Y-m-d",strtotime($my_group_buy[0]["end_time"]. " + 1 days"));?>")
							});

							})
					
					</script>
					
				</div>
				<div class="my_group_buy_msg fl" >
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$my_group_buy[0]["id"]));?>" class="light_blue_button fl">View</a>
				
				<div class="group_buy_status_show fr">
					<?php if($my_group_buy[0]["end_time"]<date("Y-m-d")){?>
						<div id="off" class="group_buy_status_show_box">
							The deal is off!
						</div>
					<?php }elseif($my_group_buy[0]["group_size"]>$my_group_buy[0]["count"] or ($my_group_buy[0]["start_time"]>date("Y-m-d"))){?>
						<div id="pending" class="group_buy_status_show_box">
							Pending!
						</div>
					<?php }elseif($my_group_buy[0]["start_time"]!="" and $my_group_buy[0]["end_time"]>=date("Y-m-d")){?>
						
						<div id="starting" class="group_buy_status_show_box">
							The deal is on!
						</div>
					<?php }?>	
						
					<!-- <div id="pending" class="group_buy_status_show_box">
							Pending!
						</div> -->	
					</div>
				</div>
<?php endif;?>

			</div>
		
		
			<?php endif;?>
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
					id: "<?php echo $circle[0]["id"];?>"
				},
				success : function(json)
				{
					$(".my_circle_member_count").text(json.count + " members");
					$(loading_icon).remove();
					$("#circle_join_button").text("Join success!");
					var quit_link = "<?php echo runFunc('encrypt_url',array('action=share&method=circlePostQuit&circle_id='.$this->_tpl_vars['IN']['id']));?>";
					var quit_button = $(document.createElement("a")).attr("href",quit_link).addClass("circle_quit_link").text('Give up!').attr("onClick","javascript: return confirm('Confirm to give up this circle?')");
					$(quit_button).insertAfter($(".my_circle_title"));
					var post_link = "<?php echo runFunc('encrypt_url',array('action=share&method=circlePostCreate&id='.$circle[0]["id"]));?>";
					var post_button = '<a style="color:#777777;" href="" class="circle_post_button gray_line_box fr">New Post</a>';
					$(".circle_page_center .circle_page_content_bar").append(post_button);
					$(".no_login_or_join").remove();
				}
			});
			});

		});


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
<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc("common/account_passPara.tpl");
		include($inc_tpl_file);
		?>

<?php } ?>