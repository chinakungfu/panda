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

$CKEditor->config['toolbar'] = "Full";


?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			广告发布
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=advertising_list&type=media'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">

		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="advertising_save" />
		 <fieldset class="admin_fieldset">
		    <legend>基本信息</legend>
			<table class="admin_edit_table">
				<tr>
					<th>广告标题：</th>
					<td>
						<input type="text" name="title" class="dark_border input_bar_long required" value=""/>
					</td>
				<tr>
				<tr>
					<th>广告位置：</th>
					<td>
						<select name="position" id="position" class="required">
							<option value="">请选择</option>
							<option value="Quick Order Top">Quick Order顶部(宽度1014)</option>
							<option value="Quick Order">Quick Order右侧(438X500)</option>
							<option value="My Cart">购物车右下角(宽度232)</option>
							<option value="Brand Street A">Brand Street Hot Brand 上方(宽度1014)</option>
							<option value="Brand Street B">Brand Street Brand of Tmall 上方(宽度1014)</option>
							<option value="Style List">Style List 内页右侧(宽度340)</option>
							<option value="Discovery Circles">Discovery Circles 内页右侧(宽度280)</option>
							<option value="Shops">Shops 右侧(宽度250)</option>
							<option value="Category Search">Category Search 左侧(宽度202)</option>
							<option value="GROUP BUY LIST RIGHT">团购列表 右侧(宽度202)</option>
							<option value="INDEX TOP IMG">主页顶部IMG (宽度976)</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>广告类型：</th>
					<td>
						<input type="radio" class="adv_type_select" checked="checked" value="1" name="type" id="adv_type_1"/> <label class="cp" for="adv_type_1">图片幻灯</label>
						&nbsp;&nbsp;&nbsp;
						<input type="radio" class="adv_type_select" value="2" name="type" id="adv_type_2"/> <label class="cp" for="adv_type_2">静态内容</label>
					</td>
				</tr>
				<tr>
				<th>广告状态</th>
					<td>
						<input type="radio" checked="checked" value="1" name="publish" id="publish_1"/> <label class="cp" for="publish_1">发布</label>
						&nbsp;&nbsp;&nbsp;
						<input type="radio" value="0" name="publish" id="publish_2"/> <label class="cp" for="publish_2">不发布</label>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset id="adv_type_1_box" class="admin_fieldset adv_type_box">
		    <legend>图片幻灯</legend>
		    <table class="admin_edit_table">
		    	<tr>
			    	<th style="vertical-align: top; line-height: 25px;">上传图片</th>
			    	<td>
			    		<input type="file" name="pic[]" class="required"/>
						图片链接：<input type="text" name="link[]" class="dark_border input_bar_long" value=""/>
			    		<div class="add_file">

			    		</div>
			    		<a class="cp add_file_button pink_link_s">添加</a>
			    	</td>
		   		</tr>
		    </table>
		</fieldset>
		<fieldset id="adv_type_2_box" class="admin_fieldset hide adv_type_box">
		<legend>静态内容</legend>
		<br />
		<?php $CKEditor->editor("content");?>
		</fieldset>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(function(){

			$(".add_file_button").click(function(){

					var new_add_box = $(document.createElement("div")).addClass("new_add_file");
					var new_add_input = $(document.createElement("input")).attr({name:"pic[]",type:"file"});
					var delete_file_link = $(document.createElement("a")).addClass("delete_file_input cp pink_link_s").text("删除").click(function(){$(this).parent().remove()});

					var input_link = ' 图片链接：<input type="text" name="link[]" class="dark_border input_bar_long" value=""/>';
					new_add_box.append(new_add_input);
					new_add_box.append(input_link);
					new_add_box.append(delete_file_link);


					$(".add_file").append(new_add_box);
				});

			$(".adv_type_select").click(function(){

					var button_id = $(this).attr("id");
					var id = button_id + "_box";

					$(".adv_type_box").hide();
					$("#"+id).show();

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