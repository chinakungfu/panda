<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<link rel="stylesheet" href="skin/cssfiles/jquery-ui-1.8.24.custom.css" />
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			生成优惠券
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">生成</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=brands&type=products'));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="coupons_make" />
			<table class="admin_edit_table">
				<tr>
					<th>优惠券类型</th>
					<td><select name="type" id="type">
						<option value="1">金额优惠</option>
						<option value="2">打折优惠</option>
					</select></td>
				</tr>
				<tr id="money_box">
					<th>优惠金额</th>
					<td>￥ <input type="text" name="money" id="money" class="dark_border small_input" value="0.00"/></td>
				</tr>
				<tr></tr>
				<tr id="price_rate_box" class="hide">
					<th>折扣</th>
					<td>
						<input type="text" name="price_rate" id="price_rate" class="dark_border small_input" value="0.00"/>
					</td>
				</tr>
				<tr>
					<th>最低消费</th>
					<td><input type="text" name="order_limit" id="order_limit" class="dark_border small_input" value="0.00"/></td>
				</tr>
				<tr>
					<th>截止日期</th>
					<td><input type="text" name="end_time" id="end_time" class="dark_border small_input datePicker" value="<?php echo date("Y-m-d")?>"/></td>
				</tr>
				<tr>
					<th>生成数量</th>
					<td><input type="text" name="make_num" id="make_num" class="dark_border small_input" value="10"/></td>
				</tr>
			</table>
		
		
		</form>
	
	</div>
</div>
</div>
<script type="text/javascript">

	$(function(){
		$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });
		$("#type").change(function(){
				if($(this).val()==1){
						$("#money_box").show();
						$("#price_rate_box").hide();
					}else{
						$("#price_rate_box").show();
						$("#money_box").hide();
						}

			});
		});

</script>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>