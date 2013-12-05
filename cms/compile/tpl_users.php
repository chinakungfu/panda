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

$items = runFunc("getUsers",array($this->_tpl_vars["IN"]["page"],15,false,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["main_message_link"]));

$count = runFunc("getUsers",array($this->_tpl_vars["IN"]["page"],15,true,$this->_tpl_vars["IN"]["sort"],$this->_tpl_vars["IN"]["key"],$this->_tpl_vars["IN"]["status"],$this->_tpl_vars["IN"]["search_word"],$this->_tpl_vars["IN"]["main_message_link"]));
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
			会员列表 <?php if($this->_tpl_vars["IN"]["main_message_link"]!=""):?>(<?php echo $_GLOBAL['user_'.$this->_tpl_vars["IN"]["main_message_link"]]?>)<?php endif;?>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_4">
				<a href="#" class="batch_delete" delete="users">批量删除</a>
			</li>
		</ul>
	</div>
<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">用户名/呢称/Email：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="users"/>
			<input type="hidden" name="type" value="users"/>
		</form>
	</div>
	<div class="filter_bar">
		<ul>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == ""){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">全部</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "1"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&status=1&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">正常</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "2"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&status=2&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">未激活</a></li>
			<li>|</li>
			<li><a <?php if($this->_tpl_vars["IN"]["status"] == "3"){echo "class='active_filter'";}?> href="<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&status=3&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">阻止登录</a></li>
		</ul>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="5%"><input type="checkbox" class="admin_form_check_all"/></th>
			<th width="20%">用户名</th>
			<?php $register_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="registerDate" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $register_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="registerDate" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $register_sort = "desc";?>
			<?php endif;?>
			<th width="25%">Email</th>
			<th width="15%">注册时间 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$register_sort.'&key=registerDate'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="registerDate" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="registerDate" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<?php $verify_sort = "desc";
			if($this->_tpl_vars["IN"]["key"]=="verifyDate" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>
			<?php $verify_sort = "asc";?>
			<?php elseif($this->_tpl_vars["IN"]["key"]=="verifyDate" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>
			<?php $verify_sort = "desc";?>
			<?php endif;?>

			<th width="15%">激活时间 <a href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=users&type=users&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$verify_sort.'&key=verifyDate'.'&search_word='.$this->_tpl_vars["IN"]["search_word"]));?>">排序 <?php if($this->_tpl_vars["IN"]["key"]=="verifyDate" and $this->_tpl_vars["IN"]["sort"]=="desc"):?>&darr;<?php elseif($this->_tpl_vars["IN"]["key"]=="verifyDate" and $this->_tpl_vars["IN"]["sort"]=="asc"):?>&uarr; <?php endif;?></a></th>
			<th width="10%">账号状态</th>
			<th width="10%">操作</th>
		</tr>
	</table>


		<?php if(count($events>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="5%"><input value="<?php echo $item["staffId"];?>" name="admin_check[]" type="checkbox" class="admin_form_check_box"/></td>
			<td width="20%" style="font-size: 11px;"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["staffId"].'&type=users'));?>"><?php echo $item["staffNo"];?></a></td>
			<td width="25%"><?php echo $item["email"];?></td>
			<td width="15%"><?php echo $item["registerDate"];?></td>
			<td width="15%"><?php echo $item["verifyDate"];?></td>
			<td width="10%"><?php if($item["groupName"]=="NoValidation"){echo "未激活";}else{echo $_GLOBAL['block_'.$item["block"]];}?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$item["staffId"].'&type=users&page='.$page));?>">编辑</a> | <a onClick="javascript:return confirm('是否确认删除该用户')" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user_delete&id='.$item["staffId"].'&page='.$page));?>">删除</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>
	<?php echo runFunc("adminPageNavi",array($count[0]["count"],15,"cms","users",'users&status='.$this->_tpl_vars["IN"]["status"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"]."&main_message_link=".$this->_tpl_vars["IN"]["main_message_link"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>
