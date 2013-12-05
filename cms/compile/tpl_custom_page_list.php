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

$items = runFunc("getCustomPageList",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["position"]));
	
$count = runFunc("getCustomPageList",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["position"]));
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
			活动页列表
		</div>
		<ul class="fr ctrl_link">
			
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="custom_page">批量删除</a>
			</li>
		</ul>
	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
		
			<select id="position" class="select_filter fr" name="position">
				<option value="">选择活动页位置</option>
				<option <?php if($this->_tpl_vars["IN"]["position"] == "1"){echo "selected=selected";}?> value="1">SHOPPING</option>
				<option <?php if($this->_tpl_vars["IN"]["position"] == "2"){echo "selected=selected";}?> value="2">COLLECTION</option>
			</select>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">活动标题：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="custom_page_list"/>
			<input type="hidden" name="type" value="media"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&position='.$this->_tpl_vars["IN"]["position"].'&adv_type='.$this->_tpl_vars["IN"]["adv_type"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&position='.$this->_tpl_vars["IN"]["position"].'&adv_type='.$this->_tpl_vars["IN"]["adv_type"]));?>">发布</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&position='.$this->_tpl_vars["IN"]["position"].'&adv_type='.$this->_tpl_vars["IN"]["adv_type"]));?>">不发布</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="40%">活动页标题</th>
			<th width="15%">活动页位置</th>
			<th width="10%">状态</th>
			<?php $register_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $register_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $register_sort = "desc";?>
			<?php endif;?>	
			<th width="15%">建立日期 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_list&type=media&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$register_sort.'&key=created'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"].'&position='.$this->_tpl_vars["IN"]["position"].'&adv_type='.$this->_tpl_vars["IN"]["adv_type"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="15%">操作</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td style="text-align:left;padding:0 10px;" width="40%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_edit&id='.$item["id"].'&type=media'));?>"><?php echo $item["title"];?></a></td>
			<td width="15%"><?php echo $_GLOBAL["custom_page_positoin_".$item["position"]]?></td>
			<td width="10%"><?php echo $_GLOBAL['published_'.$item["publish"]];?></td>
			<td width="15"><?php echo $item["created"];?></td>
			<td width="15%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_edit&id='.$item["id"].'&type=media'));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除该页面？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=custom_page_delete&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","custom_page_list",'media&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&position='.$this->_tpl_vars["IN"]["position"].'&adv_type='.$this->_tpl_vars["IN"]["adv_type"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
