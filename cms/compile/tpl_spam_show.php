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

$spam = runFunc("adminGetSpam",array($this->_tpl_vars["IN"]["id"]));

if($spam[0]["type"]=="COMMENT"){
	$item = runFunc("adminGetComment",array($spam[0]["about_id"]));
}

if($spam[0]["type"]=="VOTE COMMENT"){
	
	$item = runFunc("adminGetVoteComment",array($spam[0]["about_id"]));

}

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">

			举报信息查看 <span class="pink_link_s"><?php if($spam[0]["status"]>0){echo $_GLOBAL['spam_stauts_'.$spam[0]["spam_status"]];}?></span>
		</div>
		<ul class="fr ctrl_link">
		<?php if($spam[0]["status"]==0):?>
			<li id="ctrl_3"><a onClick="javascript: return confirm('是否确认忽略该被举报信息的发布?')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=spam_ignore&id='.$this->_tpl_vars["IN"]["id"].'&about_id='.$spam[0]["about_id"]."&type=".$spam[0]["type"]));?>">忽略举报</a></li>
			<li id="ctrl_4"><a onClick="javascript: return confirm('是否确认阻止该被举报信息的发布?')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=spam_block&id='.$this->_tpl_vars["IN"]["id"].'&about_id='.$spam[0]["about_id"]."&type=".$spam[0]["type"]));?>">阻止发布</a></li>
		<?php endif;?>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="manager_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>举报信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>举报人用户名：</th>
					<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$spam[0]["staffId"].'&type=users'));?>"><?php echo $spam[0]["staffName"];?></a></td>
					<th>举报时间：</th>
					<td><?php echo $spam[0]["created"]?></td>
				</tr>
				<tr>
					<th>举报理由:</th>
					<td colspan="3"><div style="word-wrap: break-word; width: 685px;"><?php echo $spam[0]["reason"];?></div></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		   <legend>举报对象</legend>
		  	<table class="admin_edit_table">
				<tr>
					<th>被举报人：</th>
					<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item[0]["staffId"].'&type=users'));?>"><?php echo $item[0]["staffName"];?></a></td>
				</tr>
				<tr>
					<th>被举报内容：</th>
					<td><div style="word-wrap: break-word; width: 685px;"><?php echo $item[0]["comment"];?></div></td>
				</tr>
				<tr>
					<th>来源：</th>
					<td>
					<?php if($spam[0]["type"]=="VOTE COMMENT"):?>
					投票留言：<a target="_blank" class="pink_link_s" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=PollPage&id='.$item[0]["poll_id"]));?>"><?php echo $item[0]["poll_name"];?></a>
					<?php elseif($spam[0]["type"]=="COMMENT"):?>
					<?php echo $_GLOBAL['comment_type_'.$item[0]["type"]];?>
					：
					<?php $comment_about = runFunc("getSpamCommentObj",array($item[0]["type"],$item[0]["about_id"]));?>
						<a target="_blank" class="pink_link_s" href="<?php echo $comment_about["link"];?>"><?php echo $comment_about["title"];?></a></td>
				<?php endif;?>
				</tr>
			</table>
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