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

$settings = runFunc("adminGetGlobalSetting");

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			服务设置
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="main_settings_save" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		 <fieldset class="admin_fieldset">
		    <legend>费率设置</legend>
			<table class="admin_edit_table">
				<tr>
					<th>服务费比率：</th>
					<td><input type="text" name="service_fee" class="dark_border small_input required number" min=0 max=1 value="<?php echo $settings[0]["service_fee"]?>"/></td>
				</tr>
				<tr>
					<th>全局运费</th>
					<td><input type="text" name="freight" class="dark_border small_input required number" min=0 value="<?php echo $settings[0]["freight"]?>"/></td>
				</tr>
				<tr>
					<th>税率</th>
					<td><input type="text" name="tax_rate" class="dark_border small_input required number" min=0 max=1 value="<?php echo $settings[0]["tax_rate"]?>"/></td>
				</tr>
				<tr>
					<th>美元汇率</th>
					<td><input type="text" name="USD_rate" class="dark_border small_input required number" min=0 value="<?php echo $settings[0]["USD_rate"]?>"/></td>
				</tr>
				<tr>
					<th>Paypal手续费率</th>
					<td><input type="text" name="paypal_fee" class="dark_border small_input required number" min=0 max=1 value="<?php echo $settings[0]["paypal_fee"]?>"/></td>
				</tr>
				<tr>
					<th>visa手续费率</th>
					<td><input type="text" name="union_fee" class="dark_border small_input required number" min=0 max=1 value="<?php echo $settings[0]["union_fee"]?>"/></td>
				</tr>
			
			</table>
		 </fieldset>
		 <fieldset class="admin_fieldset">
		    <legend>充值设置</legend>
		    <table class="admin_edit_table">
		    	<tr>
					<th>最低充值额度</th>
					<td><input type="text" name="limit_recharge" class="dark_border small_input required number" min=0  value="<?php echo $settings[0]["limit_recharge"]?>"/></td>
				</tr>
		    </table>
		 </fieldset>
		 <fieldset class="admin_fieldset">
		    <legend>信用点数设置</legend>
		    <table class="admin_edit_table">
		    	<tr>
					<th>信用点数获取比例</th>
					<td><input type="text" name="credit_consumption" class="dark_border small_input required number" min=0  value="<?php echo $settings[0]["credit_consumption"]?>"/> 元 = 1 点</td>
				</tr>
				<tr>
					<th>信用点数充值比例</th>
					<td><input type="text" name="credit_to_money" class="dark_border small_input required number" min=0  value="<?php echo $settings[0]["credit_to_money"]?>"/> 点 = 1 元</td>
				</tr>
		    </table>
		    
		 </fieldset>
		  <fieldset class="admin_fieldset">
		   <legend>订单提醒邮件设置</legend>
		   <table class="admin_edit_table">
				<tr>
					<th>邮件地址</th>
					<td><input type="text" name="order_notice_mail" class="dark_border input_bar_long required email"  value="<?php echo $settings[0]["order_notice_mail"]?>"/></td>
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