<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/admin.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/base.css" />
</head>

<body scroll="no">
<div class="message_table_box fl">
	<table>
		<tr>
			<th width="50%">今日新注册会员</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>本周过生日会员</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>今日新充值账户</th>
			<td>1000</td>
		</tr>
	</table>
</div>
<div class="message_table_box fl">
	<table>
		<tr>
			<th width="50%">未处理订单</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>代付款订单</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>已付款代购订单</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>待退货订单</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>待退款订单</th>
			<td>1000</td>
		</tr>
	</table>
</div>
<div class="message_table_box fl last">
	<table>
		<tr>
			<th width="70%">未处理团购申请</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>待发布团购</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>未处理圈子请求</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>今日SHARETALK评论</th>
			<td>1000</td>
		</tr>
		<tr>
			<th>今日SURPRISE商品评论</th>
			<td>1000</td>
		</tr>
	</table>
</div>
<img class="fl" style="margin-left:128px;margin-top: 30px;" src="skin/images/table.png" alt=""/>


</body>
</html>