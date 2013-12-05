<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("adminGetPollById",array($this->_tpl_vars["IN"]["id"]));

$goods = runFunc("adminGetPollItem",array($this->_tpl_vars["IN"]["id"]));

?>

<script type="text/javascript">
	$(function(){
	<?php if($this->_tpl_vars["IN"]["good_id"]!=""):?>
		$('html, body').animate({
	         scrollTop: $("#good_<?php echo $this->_tpl_vars["IN"]["good_id"];?>").offset().top
	     }, 1000);

		});
	<?php endif;?>

</script>
</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
		投票信息<?php if($item[0]["block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["block"]==0):?>是否阻止此投票的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=poll_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share'));?>"><?php if($item[0]["block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=poll_list&type=share'));?>">退出</a></li>
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
					<th>标题：</th>
					<td><div style="word-wrap: break-word;width: 300px;"><?php echo $item[0]["name"];?></div></td>
					<th>状态：</th>
					<td>
						<?php echo $_GLOBAL['share_block_'.$item[0]["block"]]?>
					</td>
				</tr>
				<tr>
					<th>前台链接：</th>
					<td><a class="pink_link_s" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=PollPage&id='.$this->_tpl_vars["IN"]["id"]));?>">查看</a></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		    <legend>投票商品</legend>
		    <?php foreach($goods as $good):?>
			<?php $votes = runFunc("adminGetPollItemVote",array($good["poll_item_id"]));?>
		    <div id="good_<?php echo $good["poll_item_id"]?>" class="list_box_items_show list_show_wh oh">
					<div class="list_box_item_img_box fl">
						<img src="<?php echo $good["goodsImgURL"]?>_310x310.jpg" alt="" />
					</div>
					<div class="list_box_item_detail_box fl">
						<div class="list_box_item_title">
							<?php if($good["title"]!=""){echo $good["title"];}else{echo $good["goodsTitleCN"];}?>
						</div>
						<div class="list_box_item_desc">
							<?php echo $good["list_item_desc"];?>
						</div>
						<div class="list_box_price_box">
							价格： <?php echo number_format($good["goodsUnitPrice"], 2, '.', ',');?> RMB
						</div>
						<div>
							票数：<?php echo count($votes);?>
						</div>
					</div>
					 <?php if(count($votes)>0):?>
					<div class="item_comments_box fl ">
						<?php foreach($votes as $vote):?>
						<?php if($vote["comment"]=="")continue;?>
						<div class="item_comment_box oh">
							<div class="comment_creater fl">
								<a class="pink_link_s" href=""><?php echo $vote["staffName"];?></a>
							</div>
							<div class="comment_content fl">
								<?php echo $vote["comment"];?>
							</div>
							<div class="comment_ctrl fl">
							<?php if($vote["vote_block"]==0):?>
								<a onClick="javascript: return confirm('是否确认阻止此条评论的发布,并发送邮件警告这个会员？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=vote_comment_block&id='.$vote["id"]."&poll_id=".$this->_tpl_vars["IN"]["id"]."&good_id=".$good["poll_item_id"]));?>">阻止发布</a>			
							<?php else:?>
								<a onClick="javascript: return confirm('是否确认恢复此条评论的发布？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=vote_comment_block&id='.$vote["id"]."&poll_id=".$this->_tpl_vars["IN"]["id"]."&good_id=".$good["poll_item_id"]));?>">恢复发布</a>
							<?php endif;?>
							</div>
						</div>
						<?php endforeach;?>
					</div>
					<?php endif;?>
			</div>
			<?php endforeach;?>
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
