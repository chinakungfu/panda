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

$items  = runFunc('getMemberHelpMessagesIgnored',array($page,15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["reply_time"],$this->_tpl_vars["IN"]["search_word"]));
$items_count = runFunc('getMemberHelpMessagesIgnored',array(1,1,true));
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
			已忽略会员咨询信息
		</div>
	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户搜索：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="admin_help_ignored_messages"/>
			<input type="hidden" name="type" value="users"/>
		</form>
	</div>
<div class="filter_bar">
	
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
			<th width="35%">内容简览</th>
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
			<td width="35%">
				<?php if(strlen($item["content"])> 30){	
					echo mb_substr($item["content"],0,30,'utf-8')."...";
					}else{
						echo $item["content"];
					}?>
				
			</td>
			<td width="15%">
				  <a onClick="javascript:return confirm('确认恢复这条咨询？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=help_message_ignore&id='.$item["id"].'&type=users&ignored=1'));?>">恢复</a>	
			</td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>

	<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],15,"cms","admin_help_ignored_messages",'users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>