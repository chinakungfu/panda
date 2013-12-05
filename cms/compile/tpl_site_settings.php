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

$site_name = runFunc("getGlobalSettingsVar",array("Site_Name"));
$site_url = runFunc("getGlobalSettingsVar",array("SITE_DOMAIN"));
$seo_settings = runFunc("getSeoSettings");
?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			站点设置
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="site_settings_save" />
		 <fieldset class="admin_fieldset">
		    <legend>网站设置</legend>
			<table class="admin_edit_table">
				<tr>
					<th>网站地址：</th>
					<td><input type="text" name="SITE_DOMAIN" class="dark_border input_bar_long required " value="<?php echo $site_url["varValue"];?>"/></td>
				</tr>
				<tr>
					<th>网站名称：</th>
					<td><input type="text" name="Site_Name" class="dark_border input_bar_long required " value="<?php echo $site_name["varValue"];?>"/></td>
				</tr>
			</table>
		 </fieldset>
		 <fieldset class="admin_fieldset">
		    <legend>SEO设置</legend>
		    <table class="admin_edit_table">
		    	<tr>
					<th>关键字</th>
					<td><textarea class="dark_border long_text_area" name="seoKeywords" id="seoKeywords" cols="30" rows="10"><?php echo $seo_settings[0]["seoKeywords"]?></textarea></td>
				</tr>
				<tr>
					<th>网站简介</th>
					<td>
						<textarea class="dark_border long_text_area" name="seoDescription" id="seoDescription" cols="30" rows="10"><?php echo $seo_settings[0]["seoDescription"]?></textarea>
					
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