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

$items  = runFunc('getAdminHelpMails',array($page,15,false,$this->_tpl_vars["IN"]["search_word"]));
$items_count = runFunc('getAdminHelpMails',array(1,1,true));
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
			直接回复记录
		</div>
	</div>
	<div class="search_bar">
		<form action="index.php" method="post">
			<a style="margin-left:10px;" class="fl" href="<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_mail_list&type=users'));?>">清空搜索条件</a>
			<input class="fr button_link" type="submit" value="搜索"/>
			<input class="input fr" id="search_word" type="text" value="<?php echo $this->_tpl_vars["IN"]["search_word"];?>" name="search_word"/>
			<label for="search_word" class="fr">回复email搜索：</label>
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="admin_help_mail_list"/>
			<input type="hidden" name="type" value="users"/>
		</form>
	</div>
	<div class="admin_list_box">
	<table class="order_list_title">
		<tr>
			<th width="30%">回复称谓</th>
			<th width="35%">回复email</th>
			<th width="25%">回复时间</th>
			<th width="10%">操作</th>
		</tr>
	</table>
	
		<?php if(count($items>0)):
		$i = 1;
		foreach($items as $item):
	?>
	<table class="order_list <?php if(($i++%2)==""){echo "pink";}?>">
		<tr>
			<td width="30%"><?php echo $item["name"]?></td>
			<td width="35%"><?php echo $item["email"]?></td>
			<td width="25%"><?php echo $item["created"]?></td>
			<td width="10%"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method=admin_help_mail_show&id='.$item["id"].'&type=users'));?>">查看</a></td>
		</tr>
	</table>
	<?php endforeach;
	else:
	?>
	<?php endif;?>
	</div>

	<?php echo runFunc("adminPageNavi",array($items_count[0]["count"],15,"cms","admin_help_mail_list",'users&reply_time='.$this->_tpl_vars["IN"]["reply_time"].'&sort='.$this->_tpl_vars["IN"]["sort"].'&key='.$this->_tpl_vars["IN"]["key"].'&search_word='.$this->_tpl_vars["IN"]["search_word"],$page));?>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>