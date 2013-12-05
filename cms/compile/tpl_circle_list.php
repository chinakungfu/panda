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

$items = runFunc("adminGetCircles",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["about"]));
	
$count = runFunc("adminGetCircles",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["about"]));

$circle_tags = runFunc("getAllCircleTags");
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
			商店列表
		</div>
		<ul class="fr ctrl_link">
			
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="circles">批量删除</a>
			</li>
			<li id="ctrl_5"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_recycle&type=share'));?>">回收站</a></li>
		</ul>
	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<select id="about" class="select_filter fr" name="about">
				<option value="">选择商店分类</option>
				<?php foreach($circle_tags as $tag):?>
				<option <?php if($tag["id"] == $this->_tpl_vars["IN"]["about"]){echo "selected='selelected'";}?> value="<?php echo $tag["id"];?>"><?php echo $tag["title"];?></option>
				<?php endforeach;?>
			</select>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户名或者商店名称：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="circle_list"/>
			<input type="hidden" name="type" value="share"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">正常</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">阻止</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="20%">商店标题</th>
			<th width="10%">商店分类</th>
			<th width="20%">发起人</th>
			<?php $register_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $register_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $register_sort = "desc";?>
			<?php endif;?>	
			<th width="15%">发言时间 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$register_sort.'&key=created'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<?php $verify_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="member_count" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $verify_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="member_count" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $verify_sort = "desc";?>
			<?php endif;?>	
			<th width="10%">参与 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_list&type=share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$verify_sort.'&key=member_count'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="member_count" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="member_count" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="10%">状态</th>
			<th width="10%">操作</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="5%"><input value="<?php echo $item["id"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td style="text-align:left;padding:0 10px;" width="20%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_show&id='.$item["id"].'&type=share'));?>"><?php echo $item["name"];?></a></td>
			<td width="10%"><?php echo $item["title"];?></td>
			<td width="20%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["user_id"].'&type=users'));?>"><?php echo $item["staffName"];?></a></td>
			<td width="15%"><?php echo $item["created"];?></td>
			<td width="10%"><?php echo $item["member_count"];?></td>
			<td width="10%"><?php echo  $_GLOBAL['share_block_'.$item["block"]]?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_show&id='.$item["id"].'&type=share'));?>">查看</a> | <a onClick="javascript:return confirm('是否确认删除该post？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_delete&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","circle_list",'share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
