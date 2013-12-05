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

$item = runFunc("adminGetComment",array($this->_tpl_vars["IN"]["id"]));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			会员发言<?php if($item[0]["comment_block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["comment_block"]==0):?>是否阻止此条发言的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=comment_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share'));?>"><?php if($item[0]["comment_block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=comment_list&type=share'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="manager_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>发言信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>用户名：</th>
					<td><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item[0]["staffId"].'&type=users'));?>"><?php echo $item[0]["staffNo"];?></a></td>
					<th>发言时间：</th>
					<td><?php echo $item[0]["created"]?></td>
				</tr>
				<tr>
					<th>发言对象：</th>
					<td><?php echo $_GLOBAL['comment_type_'.$item[0]["type"]];?></td>
					<th>对象链接：</th>
					<td>
						<?php $comment_about = runFunc("getSpamCommentObj",array($item[0]["type"],$item[0]["about_id"]));?>
						<a target="_blank" class="pink_link_s" href="<?php echo $comment_about["link"];?>"><?php echo $comment_about["title"];?></a>
					</td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		   <legend>发言内容</legend>
		  	<table class="admin_edit_table">
				<tr>
					<td>
						<?php echo $item[0]["comment"];?>
					</td>
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