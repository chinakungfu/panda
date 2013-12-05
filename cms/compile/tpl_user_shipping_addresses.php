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
$getUserShippingAddresses =  runFunc("getUserShippingAddresses",array($this->_tpl_vars["IN"]["id"]));
$user_info = runFunc("getUser",array($this->_tpl_vars["IN"]["id"]));
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			用户：<?php echo $user_info[0]["staffNo"];?> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">会员资料</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_social_message&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">社交信息</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_recharge_record&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">充值记录</a>  | <a class="active" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_shipping_addresses&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">收货人信息</a>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&page='.$page));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box oh" style="padding-bottom: 20px;">
	<?php foreach($getUserShippingAddresses as $key=>$address):?>
	<table class="admin_member_address_table fl">
		<tr>
			<td style="background:none repeat scroll 0 0 #C8CCCF" colspan="2">地址<?php echo $key+1;?></td>
		</tr>
		<tr>
			<th>姓名</th>
			<td><?php echo $address["fullName"];?></td>
		</tr>
		<tr>
			<th>地址1</th>
			<td><?php echo $address["address1"];?></td>
		</tr>
		<tr>
			<th>地址2</th>
			<td><?php echo $address["address2"];?></td>
		</tr>
		<tr>
			<th>国家</th>
			<td><?php echo $address["country"];?></td>
		</tr>
		<tr>
			<th>省份</th>
			<td><?php echo $address["province"];?></td>
		</tr>
		<tr>
			<th>城市</th>
			<td><?php echo $address["city"];?></td>
		</tr>
		<tr>
			<th>邮编</th>
			<td><?php echo $address["zipcode"];?></td>
		</tr>
		<tr>
			<th>电话1</th>
			<td><?php echo $address["cellphone"];?></td>
		</tr>
		<tr>
			<th>电话2</th>
			<td><?php echo $address["telephone"];?></td>
		</tr>
		<tr>
			<th>email</th>
			<td><a class="pink_link_s" href="mailto:<?php echo $address["email"];?>"><?php echo $address["email"];?></a></td>
		</tr>
	</table>
	<?php endforeach;?>
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