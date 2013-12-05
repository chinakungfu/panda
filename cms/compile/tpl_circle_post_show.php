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

$item = runFunc("adminGetCirclePost",array($this->_tpl_vars["IN"]["id"]));

$imgs = runFunc("adminGetCirclePostImg",array($this->_tpl_vars["IN"]["id"]));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			商店Post信息<?php if($item[0]["block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["block"]==0):?>是否阻止此post的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share'));?>"><?php if($item[0]["block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&circle_id='.$this->_tpl_vars["IN"]["circle_id"]));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="manager_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>POST信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th width="10%">用户名：</th>
					<td width="40%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item[0]["staffId"].'&type=users'));?>"><?php echo $item[0]["staffName"];?></a></td>
					<th width="10%">发布时间：</th>
					<td width="40%"><?php echo $item[0]["created"]?></td>
				</tr>
				<tr>
					<th>POST标题：</th>
					<td><?php echo $item[0]["title"]?></td>
					<th>来自：</th>
					<td>
						<a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_show&id='.$item[0]["c_id"].'&type=share'));?>"><?php echo $item[0]["c_name"]?></a>
					</td>
				</tr>
				<tr>
					<th>评论：</th>
					<td><?php echo $item[0]["comment_count"];?></td>
					<th>前台链接：</th>
					<td><a class="pink_link_s" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=circlePostPage&id='.$this->_tpl_vars["IN"]["id"].'&circle_id='.$item[0]["c_id"]));?>">查看</a></td>
				</tr>
				
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		    <legend>POST内容</legend>
		   	<table class="admin_edit_table">
				<tr>
					<th>内容：</th>
					<td><?php echo $item[0]["comment"];?></td>
				</tr>
				<tr>
					<th>图片：</th>
					<td>
						<?php foreach($imgs as $img):?>
						
						<img class="fl" style="margin-left:5px;margin-top:5px;" width="200px" src="../circle_post_img/<?php echo $item[0]["user_id"]?>/<?php echo $img["img"]?>" alt="" />
						<?php endforeach;?>
					</td>
				</tr>
			</table>
				
		   </fieldset>
		   <fieldset class="admin_fieldset">
		    <legend>评论</legend>
		    
		    <?php if($item[0]["comment_count"]>0):?>
					<div class="item_comments_box fl ">
						<?php $comments = runFunc("adminGetCommentByAboutId",array($this->_tpl_vars["IN"]["id"],"CIRCLE POST"));?>
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
								<a onClick="javascript: return confirm('是否确认阻止此条评论的发布,并发送邮件警告这个会员？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_comment_block&id='.$comment["id"]."&circle_post_id=".$this->_tpl_vars["IN"]["id"]."&comment_id=".$comment["id"]));?>">阻止发布</a>			
							<?php else:?>
								<a onClick="javascript: return confirm('是否确认恢复此条评论的发布？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_comment_block&id='.$comment["id"]."&circle_post_id=".$this->_tpl_vars["IN"]["id"]."&comment_id=".$comment["id"]));?>">恢复发布</a>
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