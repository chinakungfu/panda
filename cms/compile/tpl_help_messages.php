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

$items  = runFunc('getMemberHelpMessages',array($page,15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["reply_time"],$this->_tpl_vars["IN"]["search_word"]));
$items_count = runFunc('getMemberHelpMessages',array(1,1,true));
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
			会员咨询信息
		</div>
	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户搜索：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="adminHelpMessages"/>
			<input type="hidden" name="type" value="users"/>
		</form>
	</div>
<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["reply_time"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["reply_time"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&reply_time=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">未回复</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["reply_time"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&reply_time=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">已回复</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="25%">用户名</th>
			<?php 
			$created_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $created_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $created_sort = "desc";?>
			<?php endif;?>
			<th width="25%">留言日期 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$created_sort.'&key=created'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="10%">回复状态</th>
			<?php 
			$reply_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="reply_time" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $reply_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="reply_time" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $reply_sort = "desc";?>
			<?php endif;?>
			<th width="25%">回复日期 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$reply_sort.'&key=reply_time'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="reply_time" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="reply_time" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="15%">操作</th>
		</tr>
	</table>
	
		<?php if(count($items>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="25%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["staff_id"].'&type=users'));?>"><?php if(trim($item["staffName"])==""){echo $item["staffNo"];}else{echo $item["staffName"];}?></a></td>
			<td width="25%"><?php echo $item["created"];?></td>
			<td width="10%"><?php if($item["reply_time"]==""){echo "未回复";}else{echo "已回复";}?></td>
			<td width="25%"><?php if($item["reply_time"]==""){echo "--";}else{echo $item["reply_time"];}?></td>
			<td width="15%">
				<a href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessage&id='.$item["id"].'&type=users'));?>">查看</a>
				<?php if($item["reply_time"]==""):?>
				 | <a onClick="javascript:return confirm('确认忽略这条咨询？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=help_message_ignore&id='.$item["id"].'&type=users'));?>">忽略</a>
				<?php endif;?>
			</td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>

	<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],15,"cms","adminHelpMessages",'users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>