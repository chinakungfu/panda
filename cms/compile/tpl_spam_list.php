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

$items = runFunc("adminGetSpams",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"]));
	
$count = runFunc("adminGetSpams",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"]));

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
			被举报信息列表
		</div>

	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户名：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="spam_list"/>
			<input type="hidden" name="type" value="share"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">已阻止</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">未处理</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&status=3&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"]));?>">已忽略</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="30%">举报内容</th>
			<th width="25%">举报人</th>
			<?php $register_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $register_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $register_sort = "desc";?>
			<?php endif;?>	
			<th width="20%">举报时间 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=spam_list&type=share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$register_sort.'&key=created'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="created" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>	
			<th width="10%">状态</th>
			<th width="15%">操作</th>
		</tr>
	</table>

	
		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
		
		$spam = runFunc("adminGetSpamContent",array($item["type"],$item["about_id"]));
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td style="text-align:left;padding:0 10px;" width="30%"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_show&id='.$item["id"].'&type=share'));?>">
			<?php if(strlen($spam[0]["comment"])> 30){	
					echo mb_substr($spam[0]["comment"],0,30,'utf-8')."...";
					}else{
						echo $spam[0]["comment"];
					}?>
			</a>
			</td>
			<td width="25%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["user_id"].'&type=users'));?>"><?php echo $item["staffName"];?></a></td>
			<td width="20%"><?php echo $item["created"];?></td>
			<td width="10%"><?php echo $_GLOBAL['spam_stauts_'.$item["status"]];?></td>
			<td width="15%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=spam_show&id='.$item["id"].'&type=share'));?>">查看</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","spam_list",'share&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"].'&about='.$this->_tpl_vars["IN"]["about"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
