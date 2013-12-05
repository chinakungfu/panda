<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

?>
<?php
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	
	$page = 1;
}

$items = runFunc("getAllLogs",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["start_time"],$this->_tpl_vars["IN"]["end_time"]));
	
$count = runFunc("getAllLogs",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["start_time"],$this->_tpl_vars["IN"]["end_time"]));
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
			操作日志
		</div>

	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=logs_view&type=main'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr datePicker" type="text" value="<?php echo $this->_tpl_vars["IN"]["end_time"];?>" name="end_time"/>
			<label class="fr" for="">&nbsp;结束时间：</label>
			<input class="input fr datePicker" type="text" value="<?php echo $this->_tpl_vars["IN"]["start_time"];?>" name="start_time"/>
			<label class="fr" for="">开始时间：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="logs_view"/>
			<input type="hidden" name="type" value="main"/>
		</form>
	</div>
	<div class="filter_bar">

	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="60%">操作记录</th>
			<th width="20%">时间</th>
			<th width="20%">操作人</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td style="text-align:left;padding:0 10px;" width="60%"><?php echo $item["word"]?></td>
			<td width="20%"><?php echo $item["created"]?></td>
			<td width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["user_id"].'&type=users'));?>"><?php echo $item["staffName"]?$item["staffName"]:$item['staffNo'];?></a></td>	
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","logs_view",'main&start_time='.$this->_tpl_vars["IN"]["start_time"]."&end_time=".$this->_tpl_vars["IN"]["end_time"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript">
	$(function(){
		$(".datePicker").datepicker({ dateFormat: "yy-mm-dd" });
		});
</script>
