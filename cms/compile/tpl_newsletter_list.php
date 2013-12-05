<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);

?>
<?php
if($this->_tpl_vars["IN"]["delete_order"]!=""){
	runFunc("deleteOrder",array($this->_tpl_vars["IN"]["delete_order"]));
}

$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	
	$page = 1;
}

$items  = runFunc('getNewletters',array($page,15,false));
$items_count = runFunc('getNewletters',array(1,1,true));
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
			newsletter列表
		</div>
	</div>

	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="40%">标题</th>
			<th width="40%">创建日期</th>
			<th width="20%">操作</th>
		</tr>
	</table>
	
		<?php if(count($items>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td style="text-align:left;padding:0 10px;" width="40%"><?php echo $item["title"]?></td>
			<td width="40%"><?php echo $item["created"]?></td>
			<td width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_edit&id='.$item["id"].'&type=media'));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除这个newsletter')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=newsletter_delete&id='.$item["id"].'&type=media'));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>

	<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],15,"cms","newsletter_list",'users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>