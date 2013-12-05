<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
$CKEditor->config['toolbar'] = "Full";
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<div class="cms_main_box">
<div class="cms_left fl">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){

	$page = 1;
}
if($this->_tpl_vars["IN"]["status"]){
	$status = $this->_tpl_vars["IN"]["status"];
}

$item = runFunc("getAdminNoticeById",array($this->_tpl_vars["IN"]["id"]));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			编辑公告
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=notice_list&type=users&status='.$status.'&page='.$page));?>">取消</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="notice_save" />
		<input type="hidden" name="id" value="<?php echo $item["id"];?>"/>
		<input type="hidden" id="page" name="page" value="<?php echo $page;?>"/>
			<table class="admin_edit_table">
				<tr>
					<th>公告名称</th>
					<td ><input type="text" name="title" id="title" class="dark_border input_bar_long required" value="<?php echo $item["title"]?>"/></td>
				</tr>
				<tr>
					<th>发布</th>
					<td>
						<input <?php if($item["published"] == 1){echo 'checked="checked"';}?> id="publish" type="radio" value="1" name="published"/>
						<label for="publish">发布</label>
						&nbsp;&nbsp;
						<input <?php if($item["published"] == 2){echo 'checked="checked"';}?> id="unpublish" type="radio" value="2" name="published"/>
						<label for="unpublish">不发布</label>
					</td>
				</tr>
				<tr>
					<th>商品简介</th>
					<td >
						<?php $CKEditor->editor("notice_content",$item["content"]);?>
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
