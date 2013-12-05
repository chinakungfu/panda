<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

$item = runFunc("getAdminHelpMail",array($this->_tpl_vars["IN"]["id"]));

$CKEditor->config['toolbar'] = "Basic";
?>
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
			直接回复咨询
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_mail_list&type=users'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		 <fieldset class="admin_fieldset">
		    <legend>回复信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>回复称谓：</th>
					<td><?php echo $item[0]["name"]?></td>
					<th>回复email：</th>
					<td><a class="pink_link_s" href="mailto:<?php echo $item[0]["email"]?>"><?php echo $item[0]["email"]?></a></td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="admin_fieldset">
		    <legend>邮件内容</legend>
		    <table style="border-bottom:1px solid black;width:600px;margin:auto">
<tr>
	<td>
		<img style="margin-left: 20px" src="../skin/images/logo.jpg" width="190"/>
	</td>

</tr>
</table>
<table style="margin:auto;margin-top:15px;width:560px;">
	<tr>
		<td style="font-size:14px;">Dear <font style="color:#bad782;"> <?php echo $item[0]["name"];?></font><br /><br /></td>
	</tr>
</table>
<table style="margin:auto;width:540px;">
	<tr>
		<td>
			<table style="line-height: 20px;">

				<tr>
					<td id="reply" style="font-size:12px;">
					<br />
						<?php echo $item[0]["content"]?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table style="margin:auto;width:540px;text-align:center;font-size:12px;" id="items_preview_table">
	<?php $mail_items = runFunc("getAdminHelpMailItem",array($this->_tpl_vars["IN"]["id"]));?>
	<?php
		$items_table = "<tr>";

foreach($mail_items as $key=>$mail_item){
	$str_value = "";
	$str_field = "";
	if(count($items)>3 and (($key)%3)==0){
		$items_table .="</tr><tr>";
	}
	$site_name = runFunc('getGlobalModelVar',array('Site_Domain'));
	$items_table .= '<td><a target="_blank" href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$mail_item["goods_id"]."&show_type=collections&from=collections_page")).'"><img style="border: 1px solid #777777" width="150px;" src="'.$mail_item["goodsImgURL"].'"/></a><br/><div style="width:150px;margin:auto"><a target="_blank" style="color:#D54D4D;text-decoration:none" href="'.$site_name.'/publish/index.php'.runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$mail_item["goods_id"]."&show_type=collections&from=collections_page")).'">'.$mail_item["title"].'</a></div><br/>￥'.number_format($mail_item["goodsUnitPrice"], 2, '.', ',').'</td>';

}

$items_table .= "</tr>";

echo $items_table;
	?>

</table>
<table style="margin:auto;width:540px;font-size:12px;">
	<tr>
		<td style="font-size:12px;"><br/>Sincerely, <br/>

The WOWSHOPPING SERVICE TEAM<br/>

Online Order Procedure</td>
		</tr>
</table>

<table style="border-top:1px solid black;width:600px;margin:auto;text-align:right;font-size:11px;margin-top:50px;">
	<tr>
		<td style="padding-right:10px;">
			WOWSHOPPING &copy;2012
		</td>
	</tr>
</table>
		</fieldset>
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