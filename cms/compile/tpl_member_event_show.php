<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript">
	$(function(){
	<?php if($this->_tpl_vars["IN"]["comment_id"]!=""):?>
		$('html, body').animate({
	         scrollTop: $("#comment_<?php echo $this->_tpl_vars["IN"]["comment_id"];?>").offset().top
	     }, 1000);

		});
	<?php endif;?>

</script>
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("adminGetMemberEvent",array($this->_tpl_vars["IN"]["id"]));
$members = runFunc("adminGetEventMember",array($this->_tpl_vars["IN"]["id"]));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			活动信息<?php if($item[0]["event_block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["event_block"]==0):?>是否阻止此活动的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=member_event_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share'));?>"><?php if($item[0]["event_block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=member_event_list&type=share'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="manager_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>发布信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th width="10%">用户名：</th>
					<td width="40%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item[0]["staffId"].'&type=users'));?>"><?php echo $item[0]["staffName"];?></a></td>
					<th width="10%">发布时间：</th>
					<td width="40%"><?php echo $item[0]["created"]?></td>
				</tr>
				<tr>
					<th>活动标题：</th>
					<td><?php echo $item[0]["name"];?></td>
					<th>参与人数：</th>
					<td><?php echo $item[0]["member_count"];?></td>
				</tr>
				<tr>
					<th>组织者：</th>
					<td><?php echo $item[0]["organizers"];?></td>
					<th>活动圈子：</th>
					<td><?php echo $item[0]["circle_name"]?></td>
				</tr>
				<tr>
					<th>活动费用：</th>
					<td><?php echo $item[0]["event_pay"];?></td>
					<th>活动时间：</th>
					<td colspan=3>
						<?php $event_time = runFunc("adminGetEventTime",array($item[0]["id"]));?>
					
						<?php switch ($item[0]["event_time_type"]){
							
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
								echo "<tr><th>日期: </th><td>From ".date("Y-m-d",strtotime($event_time[0]["start_date"]))." To ".date("Y-m-d",strtotime($event_time[0]["end_date"]))."</td></tr>";
								echo "<tr><th>周: </th><td>".$event_time[0]["week_day"]."</td></tr>";
								echo "<tr><th>时间: </th><td>".$event_time[0]["start_time"]." - ".$event_time[0]["end_time"]."</td></tr>";	
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
					</td>
				</tr>
				<tr>
					<th>活动地点：</th>
					<td>
						<?php echo $item[0]["location"]?>
					</td>
					<th>活动地址</th>
					<td><div style="width:270px;word-wrap: break-word;"><?php echo $item[0]["address"]?></div></td>
				</tr>
				<tr>
					<th>电子邮件：</th>
					<td><a class="pink_link_s" href="mailto:<?php echo $item[0]["email"];?>"><?php echo $item[0]["email"];?></a></td>
					<th>联系电话：</th>
					<td>
						<?php echo $item[0]["phone"];?>
					</td>
				</tr>
				<tr>
					<th>前台链接：</th>
					<td><a class="pink_link_s" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=eventShow&id='.$this->_tpl_vars["IN"]["id"]));?>">查看</a></td>
				</tr>
				<tr>
					<th>图片：</th>
					<td><img class="event_show_img fl" src="../circle_event_img/<?php echo $item[0]["user_id"];?>/<?php echo $item[0]["img"];?>" alt="" /></td>
				</tr>
				<tr>
					<th>简介：</th>
					<td colspan="3"><div style="width:700px;word-wrap: break-word;"><?php echo $item[0]["introduction"];?></div></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		    <legend>参加会员</legend>
		    <?php foreach($members as $member):?>
			<?php if($member["user_id"] == $user_info[0]["user_id"] or $member[staffName]=="")continue;?>
			<div class="circle_member_box oh fl">
			<a href="<?php echo runFunc('encrypt_url',array('action=share&method=homePage&user_id='.$member["user_id"]));?>">
			<?php $avatar = "../publish/avatar/".$member["user_id"]."_thumb.".$member["headImageUrl"];?>
				<?php if(file_exists($avatar)){?>
					<img id="userimg" class="fl" src="<?php echo $avatar;?>" alt="" />
				<?php }else{?>
					<img id="userimg" class="fl" src="../skin/images/pic.jpg" />
				<?php }?>
			</a>	
				<div class="circle_member_name fl">
				<a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$member["user_id"].'&type=users'));?>">
					<?php echo $member["staffName"]?>
				</a>
				</div>
				
			</div>
		<?php endforeach;?>
		    
		    
		   </fieldset>
		    <fieldset class="admin_fieldset">
		   		<legend>评论</legend>
		   			<?php $comments = runFunc("adminGetCommentByAboutId",array($this->_tpl_vars["IN"]["id"],"EVENT"));?>
		   		 <?php if(count($comments)>0):?>
					<div class="item_comments_box fl ">	
						<?php foreach($comments as $comment):?>
						<div class="item_comment_box oh" id="comment_<?php echo $comment["id"]?>">
							<div class="comment_creater fl" style="width: 150px;">
								<a class="pink_link_s" href=""><?php echo $comment["staffName"];?></a>
							</div>
							<div class="comment_content fl" style="width: 625px;">
								<?php echo $comment["comment"];?>
							</div>
							<div class="comment_ctrl fl">
							<?php if($comment["block"]==0):?>
								<a onClick="javascript: return confirm('是否确认阻止此条评论的发布,并发送邮件警告这个会员？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=member_event_comment_block&id='.$comment["id"]."&event_id=".$this->_tpl_vars["IN"]["id"]."&comment_id=".$comment["id"]));?>">阻止发布</a>			
							<?php else:?>
								<a onClick="javascript: return confirm('是否确认恢复此条评论的发布？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=member_event_comment_block&id='.$comment["id"]."&event_id=".$this->_tpl_vars["IN"]["id"]."&comment_id=".$comment["id"]));?>">恢复发布</a>
							<?php endif;?>
							</div>
						</div>
						<?php endforeach;?>
					</div>
					<?php endif;?>
		    </fieldset>
		</form>
	
	</div>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>