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

$item = runFunc("getUser",array(1));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			超级管理员
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=managers&type=main'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="admin_user_save" />
		 <fieldset class="admin_fieldset">
		    <legend>账户信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>登录名：</th>
					<td><input type="text" name="manger_email" class="dark_border input_bar_long required" remote="/check_update_mail.php?id=1" value="<?php echo $item[0]["staffNo"]?>"/></td>
				</tr>
				<tr>
					<th>密码：</th>
					<td><input type="password" name="password" id="password" class="dark_border input_bar_long" value=""/></td>
				</tr>
				<tr>
					<th>确认密码：</th>
					<td><input type="password" name="repassword" id="repassword" class="dark_border input_bar_long" equalTo="#password" value=""/></td>
				</tr>
			</table>
		 </fieldset>
		  <fieldset class="admin_fieldset">
		   <legend>管理员资料</legend>
		  	<table class="admin_edit_table">
				<tr>
					<th>姓名：</th>
					<td><input type="text" name="manger_name" class="dark_border input_bar_long required" value="<?php echo $item[0]["staffName"]?>"/></td>
				</tr>
				<tr>
					<th>联系电话：</th>
					<td><input type="text" name="manger_phone" class="dark_border input_bar_long" value="<?php echo $item[0]["phone"]?>"/>
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