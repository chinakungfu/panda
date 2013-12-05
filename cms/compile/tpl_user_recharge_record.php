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

$items = runFunc("getMemberRechargeRecord",array($this->_tpl_vars["IN"]["id"]));
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
			用户：<?php echo $user_info[0]["staffNo"];?> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">会员资料</a> | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_social_message&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">社交信息</a> | <a class="active" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_recharge_record&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">充值记录</a>  | <a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_shipping_addresses&id='.$this->_tpl_vars["IN"]["id"].'&type=users&page='.$page));?>">收货人信息</a>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&page='.$page));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box" style="position:relative;">
		<table class="member_recharge_table">
			<tr>
				<th>充值金额</th>
				<th>充值日期</th>
				<th>充值方式</th>
			</tr>
			<?php foreach($items as $item):?>
			<tr>
				<td><?php echo $item["recharge"]?></td>
				<td><?php echo $item["created"]?></td>
				<td><?php echo $_GLOBAL['recharge_payment_'.$item["payment"]];?></td>
			</tr>
			<?php endforeach;?>
		</table>
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