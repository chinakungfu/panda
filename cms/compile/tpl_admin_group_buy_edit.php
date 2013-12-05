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

$item = runFunc("getMemberGroupBuyItem",array($this->_tpl_vars["IN"]["id"]));

?>

</div>
<div class="cms_right fr">
<div class="ctrl_bar">
		<div class="title fl">
			官方团购 (<?php if($item[0]["start_time"]!="" and $item[0]["end_time"]>=date("Y-m-d")){echo "进行中";}elseif($item[0]["start_time"]==""){echo "待审核";}elseif($item[0]["end_time"]<date("Y-m-d")){echo "已结束";}?>)
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_3"><a class="save_group_buy" href="#"><?php if($item[0]["start_time"]!="" and strtotime($item[0]["end_time"])>time()){echo "保存修改";}elseif($item[0]["start_time"]==""){echo "通过审核并发布";}elseif(strtotime($item[0]["end_time"])<time()){echo "保存修改";}?></a></li>
			<li id="ctrl_2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminGroupBuy&type=share'));?>">退出</a></li>
		</ul>
	</div>
	<div class="gray_line_box">
		
		<form class="admin_form" action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="cms" />
		<input type="hidden" name="method" value="group_buy_publish" />
		<input type="hidden" name="group_id" value="<?php echo $item[0]['id'];?>" />
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
					<td><img class="group_buy_item_img" width="100px" src="<?php echo $item[0]["goodsImgURL"];?>_310x310.jpg" alt="" /></td>
					<td><?php echo $item[0]["goodsTitleCN"];?></td>
					<td>￥<?php echo  number_format($item[0]["goodsUnitPrice"], 2, '.', ',');?></td>
					<td>￥<?php echo  number_format($item[0]["goodsFreight"], 2, '.', ',');?></td>
					<td><a target="_blank" href="<?php echo "/publish/index.php".runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$this->_tpl_vars["IN"]["id"]));?>">站内链接</a></td>
				</tr>
			</table>
			<table class="admin_edit_table">
				<tr>
				<th>前台链接</th>
				<td><a target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=groupBuyShow&id='.$this->_tpl_vars["IN"]["id"]));?>" class="pink_link_s">查看</a></td>
			</tr>
				<tr>
					<th>发布状态</th>
					<td><select name="published" id="published">
						<option <?php if($item[0]["published"]==1)echo "selected=selected"?> value="1">发布</option>
						<option <?php if($item[0]["published"]==0)echo "selected=selected"?> value="0">阻止发布</option>
					</select></td>
				</tr>
				<tr>
					<th>团购商品名称</th>
					<td>
						<input type="text" style="width:500px;" name="group_buy_item_name" id="group_buy_item_name" class="dark_border input_bar_long required" value="<?php echo $item[0]["item_name"]?>" />
					</td>
				</tr>
				<tr>
					<th>推荐</th>
					<td>
					<select name="special" id="special">
						<option <?php if($item[0]["special"]==0)echo "selected='selected'";?> value="0">不推荐</option>
						<option <?php if($item[0]["special"]==1)echo "selected='selected'";?> value="1">推荐</option>
					</select>
					</td>
				</tr>
				<tr>
					<th>打折项目</th>
					<td><select name="sell_type" id="sell_type">
						<option <?php if($item[0]["sell_way"]==1)echo "selected='selected'";?> value="1">服务费打折</option>
						<option <?php if($item[0]["sell_way"]==2)echo "selected='selected'";?> value="2">单价打折</option>
					</select></td>
				</tr>
				<tr>
					<th>打折比率</th>
					<td>
						<input type="text" name="price_rate" id="price_rate" class="dark_border input_bar_long required" min=0 value="<?php echo number_format($item[0]["price_rate"], 2, '.', ',')?>" />
						（例： 0.9表示打9折，1表示不打折，0表示不收费）
					</td>
				</tr>
				<tr>
					<th>开始时间</th>
					<td><input type="text" name="start_time" id="start_time" class="dark_border input_bar_long datePicker required" value="<?php echo $item[0]["start_time"];?>" /></td>
				</tr>
				<tr>
					<th>持续时间</th>
					<td>
					<?php   
						if($item[0]["start_time"]!=""){
							$d2=strtotime($item[0]["start_time"]);
							$d1=strtotime($item[0]["end_time"]);
							$Days=round(($d1-$d2)/3600/24);
						}else{
							
							$Days = 0;
						}
					?>
						<input type="text" class="small_input required" min=1 name="lasted_days" value="<?php echo $Days;?>"/> 天 （整数）
					</td>
				</tr>
				<tr>
					<th>成团人数</th>
					<td><input type="text" class="small_input" name="group_size" value="<?php echo $item[0]["group_size"];?>"/></td>
				</tr>
				<tr>
					<th style="vertical-align: top">团购简介</th>
					<td>
						<?php $CKEditor->editor("introduction",$item[0]["description"]);?>
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