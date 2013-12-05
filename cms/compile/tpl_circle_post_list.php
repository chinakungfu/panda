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

$items = runFunc("adminGetCirclePosts",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["about"],false,$this->_tpl_vars["IN"]["circle_id"]));
	
$count = runFunc("adminGetCirclePosts",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["about"],false,$this->_tpl_vars["IN"]["circle_id"]));


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
			商店POST列表 <?php if($this->_tpl_vars["IN"]["circle_id"]!=""): $circle = runFunc("adminGetCircle",array($this->_tpl_vars["IN"]["circle_id"]));?>(商店：<?php echo $circle[0]["name"];?>)<?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="circle_post">批量删除</a>
			</li>
			<li id="ctrl_5"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_recycle&type=share&circle_id='.$this->_tpl_vars["IN"]["circle_id"]));?>">回收站</a></li>
		</ul>
	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户名或者商店名称：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="circle_post_list"/>
			<input type="hidden" name="type" value="share"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"]));?>">正常</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"]));?>">阻止</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="30%">标题</th>
			<th width="10%">发布人</th>
			<?php $register_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $register_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $register_sort = "desc";?>
			<?php endif;?>	
			<th width="15%">发言时间 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$register_sort.'&key=created'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<?php $verify_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="comment_count" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $verify_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="comment_count" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $verify_sort = "desc";?>
			<?php endif;?>	
			<th width="10%">评论 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_list&type=share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$verify_sort.'&key=comment_count'.'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="comment_count" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="comment_count" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
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
			<td style="text-align:left;padding:0 10px;" width="30%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_show&circle_id='.$this->_tpl_vars["IN"]["circle_id"].'&id='.$item["id"].'&type=share'));?>"><?php echo $item["title"];?></a></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["user_id"].'&type=users'));?>"><?php echo $item["staffName"];?></a></td>
			<td width="15%"><?php echo $item["created"];?></td>
			<td width="10%"><?php echo $item["comment_count"];?></td>
			<td width="10%"><?php echo  $_GLOBAL['share_block_'.$item["block"]]?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_show&circle_id='.$this->_tpl_vars["IN"]["circle_id"].'&id='.$item["id"].'&type=share'));?>">查看</a> | <a onClick="javascript:return confirm('是否确认删除该发言？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=circle_post_delete&circle_id='.$this->_tpl_vars["IN"]["circle_id"].'&id='.$item["id"]));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","circle_post_list",'share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]."&circle_id=".$this->_tpl_vars["IN"]["circle_id"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
