<?php import('core.util.RunFunc'); ?><html>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

</head>
<body>
<?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoById',array($this->_tpl_vars["staffId"])); ?>
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='staff'>
	<input type='hidden' name='method' value='saveOperation'>
	<input type="hidden" id="staffNo" name="staffNo" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?>">
	<div class="main_content">
	   	<div class="main_content_nav">
	   	给用户『
        <?php echo $this->_tpl_vars["staff"]["0"]["staffName"];?>
        』绑定用户组
	   	</div>
	   	<div style="clear:both"></div>
		<div class="search_content detailMember">
		<?php $this->_tpl_vars["group"]=runFunc('listGroup',array($this->_tpl_vars["sqlCon"],'1')); ?>
		<?php if(!empty($this->_tpl_vars['group'])){ 
 foreach ($this->_tpl_vars['group'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		<?php $this->_tpl_vars["judge"]=runFunc('checkGroup',array($this->_tpl_vars["staff"]["0"]["staffNo"],$this->_tpl_vars["var"]["groupNo"])); ?>
		<?php if ($this->_tpl_vars["judge"]){?>
		<?php $this->_tpl_vars["seltype"]=1; ?>
		<input type="checkbox" name="index[]" value="<?php echo $this->_tpl_vars["var"]["groupNo"];?>" checked><?php echo $this->_tpl_vars["var"]["groupName"];?><br>
		<?php }else{ ?>
		<?php $this->_tpl_vars["seltype"]=0; ?>
		<input type="checkbox" name="index[]" value="<?php echo $this->_tpl_vars["var"]["groupNo"];?>"><?php echo $this->_tpl_vars["var"]["groupName"];?><br>
		<?php } ?>
		<?php  }
} ?>
		</div>
	</div>
	<div align="center">
		<input type="submit" name="submit" value="保存" align="middle" class="button1">
	</div>
</form>
</body>
</html>
