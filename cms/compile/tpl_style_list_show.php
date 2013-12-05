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

$item = runFunc("adminGetStyleListById",array($this->_tpl_vars["IN"]["id"]));
$goods = runFunc("adminGetStyleItem",array($this->_tpl_vars["IN"]["id"]));
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}

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
			Style List 信息<?php if($item[0]["block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["block"]==0):?>是否阻止此Style List的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share&page='.$page));?>"><?php if($item[0]["block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=style_list&type=share&page='.$page));?>">退出</a></li>
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
					<td><div style="word-wrap: break-word;width: 300px;"><?php echo $item[0]["title"];?></div></td>
					<th>状态：</th>
					<td>
						<?php echo $_GLOBAL['share_block_'.$item[0]["block"]]?>
					</td>
				</tr>
				<tr>
					<th>公开：</th>
					<td><?php echo $_GLOBAL['share_privacy_'.$item[0]["privacy"]];?></td>
					<th>发布：</th>
					<td><?php echo $_GLOBAL['share_publish_'.$item[0]["publish"]];?></td>
				</tr>
				<tr>
					<th>简介：</th>
					<td colspan="3"><div style="word-wrap: break-word;width: 700px;"><?php echo $item[0]["description"];?></div></td>
				</tr>
				<tr>
					<th>前台链接：</th>
					<td><a class="pink_link_s" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=showList&id='.$item[0]["id"].'&user_id='.$item[0]["user_id"]));?>">查看</a></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		    <legend>商品</legend>
		    <?php foreach($goods as $good):?>
		    <div id="good_<?php echo $good["list_item_id"]?>" class="list_box_items_show list_show_wh oh">
					<div class="list_box_item_img_box fl">
						<img src="<?php echo $good["goodsImgURL"]?>_310x310.jpg" alt="" />
					</div>
					<div class="list_box_item_detail_box fl">
						<div class="list_box_item_title">
							<?php echo $good["list_item_title"];?>
						</div>
						<div class="list_box_item_desc">
							<?php echo $good["list_item_desc"];?>
						</div>
						<div class="list_box_price_box">
							价格： <?php echo number_format($good["goodsUnitPrice"], 2, '.', ',');?> RMB
						</div>
						<div>
							评论：<?php echo $good["comment_count"];?>
						</div>
					</div>
					 <?php if($good["comment_count"]>0):?>
					<div class="item_comments_box fl ">
						<?php $comments = runFunc("adminGetCommentByAboutId",array($good["list_item_id"],"LIST GOODS"));?>
						<?php foreach($comments as $comment):?>
						<div class="item_comment_box oh">
							<div class="comment_creater fl">
								<a class="pink_link_s" href=""><?php echo $comment["staffName"];?></a>
							</div>
							<div class="comment_content fl">
								<?php echo $comment["comment"];?>
							</div>
							<div class="comment_ctrl fl">
							<?php if($comment["block"]==0):?>
								<a onClick="javascript: return confirm('是否确认阻止此条评论的发布,并发送邮件警告这个会员？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=style_list_item_comment_block&id='.$comment["id"]."&list_id=".$this->_tpl_vars["IN"]["id"]."&good_id=".$good["list_item_id"]));?>">阻止发布</a>
							<?php else:?>
								<a onClick="javascript: return confirm('是否确认恢复此条评论的发布？')" class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=style_list_item_comment_block&id='.$comment["id"]."&list_id=".$this->_tpl_vars["IN"]["id"]."&good_id=".$good["list_item_id"]));?>">恢复发布</a>
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