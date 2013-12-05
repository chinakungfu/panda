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

$item = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
?>
</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			用户：<?php echo $item[0]["staffNo"];?> |  <a class="active" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item[0]["staffId"].'&type=users&page='.$page));?>">会员资料</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_social_message&id='.$item[0]["staffId"].'&type=users&page='.$page));?>">社交信息</a>  | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_recharge_record&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">充值记录</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_shipping_addresses&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">收货人信息</a>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&page='.$page));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="user_save" />
		<input type="hidden" name="id" value="<?php echo $item[0]["staffId"];?>"/>

			<table class="admin_edit_table">
				<tr>
					<th>用户名</th>
					<td><input type="text" name="staffNo" class="dark_border input_bar_long" value="<?php echo $item[0]["staffNo"];?>"/></td>
				</tr>
				<tr>
					<th>会员昵称</th>
					<td><input type="text" name="staffName" class="dark_border input_bar_long" value="<?php echo $item[0]["staffName"];?>"/></td>
				</tr>
				<tr>
					<th>密码：</th>
					<td><input type="password" name="password" class="dark_border input_bar_long" value=""/></td>
				</tr>
				<tr>
					<th>确认密码：</th>
					<td><input type="password" name="repassword" class="dark_border input_bar_long" value=""/></td>
				</tr>
				<tr>
					<th>注册日期</th>
					<td><?php echo $item[0]["registerDate"];?></td>
				</tr>
				<tr>
					<th>激活日期</th>
					<td><?php if($item[0]["verifyDate"]==""){?>未激活 <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_verify&id='.$this->_tpl_vars["IN"]["id"]));?>" onClick='javascript:return confirm("是否确认手动激活该会员账号，并发送邮件提醒？")' class='pink_link_s'>手动激活</a><?php }else{echo $item[0]["verifyDate"];}?></td>
				</tr>
				<tr>
					<th>注册邮箱：</th>
					<td><a href="mailto:<?php echo $item[0]["email"];?>"><?php echo $item[0]["email"];?></a></td>
				</tr>
				<tr>
					<th>忘记密码问题：</th>
					<td><?php echo $item[0]["safetyQuestion"];?></td>
				</tr>
				<tr>
					<th>忘记密码答案：</th>
					<td><?php echo $item[0]["questionResult"];?></td>
				</tr>
				<tr>
					<th>账户余额：</th>
					<td><input type="text" class="small_input" name="balance" value="<?php echo $item[0]["balance"]?>"/></td>
				</tr>
				<tr>
					<th>信用点数：</th>
					<td><input type="text" class="small_input" name="credits" value="<?php echo $item[0]["credits"]?>"/></td>
				</tr>
				<tr>
					<th>阻止登录：</th>
					<td>
						<select name="block" id="block">
							<option <?php if($item[0]["block"]==0){echo "selected='selected'";}?> value="0">否</option>
							<option <?php if($item[0]["block"]==1){echo "selected='selected'";}?> value="1">是</option>
						</select>
					</td>
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