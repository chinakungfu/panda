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

$item = runFunc("getUserProfile",array($this->_tpl_vars["IN"]["id"]));
$user_info = runFunc("getUser",array($item["user_id"]));

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			用户：<?php echo $user_info[0]["staffNo"];?> |  <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["user_id"].'&type=users&page='.$page));?>">会员资料</a> | <a class="active" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_social_message&id='.$item["user_id"].'&type=users&page='.$page));?>">社交信息</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_recharge_record&id='.$item["user_id"].'&type=users&page='.$page));?>">充值记录</a>  | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_shipping_addresses&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">收货人信息</a>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&page='.$page));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box" style="position:relative;">
	<?php $social_count = runFunc("getMemberSocialCount",array($item["user_id"]));?>
		<table class="member_social_message">
			<tr>
				<th>讨论发言</th>
				<td><?php echo $social_count["comment_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>Style List</th>
				<td><?php echo $social_count["list_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>发布圈子</th>
				<td><?php echo $social_count["circle_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>参加圈子</th>
				<td><?php echo $social_count["circle_join_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>发布活动</th>
				<td><?php echo $social_count["event_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>参加活动</th>
				<td><?php echo $social_count["event_join_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>发布团购</th>
				<td><?php echo $social_count["group_buy_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>发布投票</th>
				<td><?php echo $social_count["poll_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>参与投票</th>
				<td><?php echo $social_count["poll_vote_count"][0]["count"];?></td>
			</tr>
			<tr>
				<th>好友数量</th>
				<td><?php echo $social_count["friend_count"][0]["count"];?></td>
			</tr>
		</table>
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="user_save" />
		<input type="hidden" name="id" value="<?php echo $item[0]["id"];?>"/>


			<table class="admin_edit_table">
				<tr>
					<th>头像</th>
					<td>
					<?php $avatar = "../publish/avatar/".$user_info["0"]["staffId"]."_thumb.".$user_info["0"]["headImageUrl"];?>
		<?php if(file_exists($avatar)){?>
			<img src="<?php echo $avatar."_100.".$user_info["0"]["headImageUrl"];?>" alt="userInfo" id="userimg" class="fl" />
			<?php }else{ ?>
			<img src="../skin/images/pic.jpg" alt="userInfo" id="userimg" class="fl"/>
		<?php } ?>
					</td>
				</tr>
				<tr>
					<th>First Name:</th>
					<td><?php echo $item["first_name"]?></td>
				</tr>
				<tr>
					<th>Last Name:</th>
					<td><?php echo $item["last_name"]?></td>
				</tr>
				<tr>
					<th>生日：</th>
					<td><?php echo $item["DateOfBirth_Month"]?> <?php echo $item["DateOfBirth_Day"];?></td>
				</tr>
				<tr>
					<th>性别：</th>
					<td><?php echo $_GLOBAL[$item["sex"]];?></td>
				</tr>
				<tr>
					<th>国家：</th>
					<td><?php echo $item["Country"];?></td>
				</tr>
				<tr>
					<th>地区：</th>
					<td><?php echo $item["Location"];?></td>
				</tr>
				<tr>
					<th>个人简介：</th>
					<td><?php echo $item["about_me"];?></td>
				</tr>
				<tr>
					<th>Facebook：</th>
					<td><?php echo $item["facebook"];?></td>
				</tr>
				<tr>
					<th>Twitter：</th>
					<td><?php echo $item["Twitter"];?></td>
				</tr>
				<tr>
					<th>Pinterest：</th>
					<td><?php echo $item["Pinterest"];?></td>
				</tr>
				<tr>
					<th>Picasa：</th>
					<td><?php echo $item["Picasa"];?></td>
				</tr>
				<tr>
					<th>Flickr：</th>
					<td><?php echo $item["Flickr"];?></td>
				</tr>
				<tr>
					<th>Youtube：</th>
					<td><?php echo $item["Youtube"];?></td>
				</tr>
				<tr>
					<th>Linkedin：</th>
					<td><?php echo $item["Linkedin"];?></td>
				</tr>
				<tr>
					<th>Google：</th>
					<td><?php echo $item["Google"];?></td>
				</tr>
				<tr>
					<th>Myspace：</th>
					<td><?php echo $item["Myspace"];?></td>
				</tr>
				<tr>
					<th>Mail：</th>
					<td><?php echo $item["mail"];?></td>
				</tr>
			</table>


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