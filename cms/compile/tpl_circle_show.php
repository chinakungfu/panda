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

$item = runFunc("adminGetCircle",array($this->_tpl_vars["IN"]["id"]));
$members = runFunc("adminGetCircleMembers",array($this->_tpl_vars["IN"]["id"]));
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			商店信息<?php if($item[0]["block"]==1):?> <span class="pink_link">(已阻止发布)</span><?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a onClick="javascript:return confirm('<?php if($item[0]["block"]==0):?>是否阻止此商店的发布，并且向该会员发出警告？<?php else:?>是否恢复此条发言的发布?<?php endif;?>')" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_block&id='.$this->_tpl_vars["IN"]["id"].'&type=share'));?>"><?php if($item[0]["block"]==0):?>阻止发布<?php else:?>恢复发布<?php endif;?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share'));?>">退出</a></li>
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
					<th>商店标题：</th>
					<td><?php echo $item[0]["name"];?></td>
					<th>商店分类：</th>
					<td>
						<?php echo $item[0]["title"]?>
					</td>
				</tr>
				<tr>
					<th>参与人数：</th>
					<td><?php echo $item[0]["member_count"];?></td>
					<th>post：</th>
					<td>
						<?php echo $item[0]["post_count"];?>
						<?php if($item[0]["post_count"]>0):?>
						<a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&circle_id='.$item[0]["id"]));?>" class="pink_link_s">(查看)</a>
						<?php endif;?>
					</td>
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
					<th>图片：</th>
					<td><img src="../circles_img/<?php echo $item[0]["user_id"]?>/<?php echo $item[0]["img"];?>" alt="" /></td>
				</tr>
				<tr>
					<th>简介：</th>
					<td colspan="3"><?php echo $item[0]["introduction"];?></td>
				</tr>
				<tr>
					<th>前台链接：</th>
					<td><a class="pink_link_s" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$item[0]["id"]));?>">查看</a></td>
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