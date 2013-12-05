<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
$CKEditor->config['toolbar'] = "Full";
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

$item = runFunc("getAdminGoodsById",array($this->_tpl_vars["IN"]["id"]));


?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			官方团购 
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save_group_buy" href="#">保存</a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=memeberGroupBuy&type=share'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="group_buy_publish" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>" />
		<input type="hidden" name="offcial" value="1"/>
		
			<table class="group_buy_item_table">
				<tr>
					<th width="10%">图片</th>
					<th width="50%">商品名称</th>
					<th width="10%">商品价格</th>
					<th width="10%">运费</th>
					<th width="20%">链接</th>
				</tr>	
				<tr>
					<td><img class="group_buy_item_img" width="100px" src="<?php echo $item["goodsImgURL"];?>_310x310.jpg" alt="" /></td>
					<td><?php echo $item["goodsTitleCN"];?></td>
					<td>￥<?php echo  number_format($item["goodsUnitPrice"], 2, '.', ',');?></td>
					<td>￥<?php echo  number_format($item["goodsFreight"], 2, '.', ',');?></td>
					<td><a target="_blank" href="<?php echo "/publish/index.php".runFunc('encrypt_url',array('action=surprise&method=item_show&id='.$item["goodsid"]."&show_type=collections&from=collections_page"));?>">站内链接</a></td>
				</tr>
			</table>
			<table class="admin_edit_table">
				<tr>
					<th>发布状态</th>
					<td><select name="published" id="published">
						<option  value="1">发布</option>
						<option  value="0">阻止发布</option>
					</select></td>
				</tr>

				<tr>
					<th>团购商品名称</th>
					<td>
						<input type="text" style="width:500px;" name="group_buy_item_name" id="group_buy_item_name" class="dark_border input_bar_long required" value="<?php echo $item["goodsTitleCN"]?>" />
					</td>
				</tr>
				<tr>
					<th>推荐</th>
					<td>
					<select name="special" id="special">
						<option value="0">不推荐</option>
						<option value="1">推荐</option>
					</select>
					</td>
				</tr>
				<tr>
					<th>打折项目</th>
					<td><select name="sell_type" id="sell_type">
						<option value="1">服务费打折</option>
						<option value="2">单价打折</option>
					</select></td>
				</tr>
				<tr>
					<th>打折比率</th>
					<td>
						<input type="text" name="price_rate" id="price_rate" class="dark_border input_bar_long required number" min=0 value="1.00" />
						（例： 0.9表示打9折，1表示不打折，0表示不收费）
					</td>
				</tr>
				<tr>
					<th>开始时间</th>
					<td><input type="text" name="start_time" id="start_time" class="dark_border input_bar_long datePicker required" value="<?php echo date("Y-m-d");?>" /></td>
				</tr>
				<tr>
					<th>持续时间</th>
					<td>
						<input type="text" class="small_input required number" min=1 name="lasted_days" value="1"/> 天 （整数）
					</td>
				</tr>
				<tr>
					<th>成团人数</th>
					<td><input type="text" class="small_input required number" min=0 name="group_size" value="3"/></td>
				</tr>
				<tr>
					<th style="vertical-align: top">团购简介</th>
					<td>
						<?php $CKEditor->editor("introduction",$item["goodsIntro"]);?>
					</td>
				</tr>
				<tr>
					<th style="vertical-align: top">团购规则</th>
					<td>
						<?php $CKEditor->editor("fine_print","At least 3 members with should be needed.");?>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(function(){

		$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>
	
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>