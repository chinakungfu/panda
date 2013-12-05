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

<head>
<title>选择操作</title>
</head>
<body>
<?php $this->_tpl_vars["role"]=runFunc('getRoleInfoById',array($this->_tpl_vars["roleId"])); ?>
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='role'>
	<input type='hidden' name='method' value='saveOperation'>
	<input type="hidden" id="roleNo" name="roleNo" value="<?php echo $this->_tpl_vars["role"]["0"]["roleNo"];?>">
	<div class="main_content">
	   	<div class="main_content_nav">
	    给角色『
	    <?php echo $this->_tpl_vars["role"]["0"]["roleName"];?>
	    』绑定操作
	    </div>
	    <div style="clear:both"></div>
		<div class="search_content detailMember">
		<?php $this->_tpl_vars["operations"]=runFunc('listOperation',array($this->_tpl_vars["sqlCon"],'1')); ?>
		 <?php if(!empty($this->_tpl_vars['operations'])){ 
 foreach ($this->_tpl_vars['operations'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
		 <?php $this->_tpl_vars["judge"]=runFunc('checkOperation',array($this->_tpl_vars["role"]["0"]["roleNo"],$this->_tpl_vars["var"]["operationNo"])); ?>
		 <?php if ($this->_tpl_vars["judge"]){?>
		 <?php $this->_tpl_vars["seltype"]=1; ?>
		 <input type="checkbox" name="operationId[]" value="<?php echo $this->_tpl_vars["var"]["operationNo"];?>" checked><?php echo $this->_tpl_vars["var"]["operationName"];?><br>
		 <?php }else{ ?>
		 <?php $this->_tpl_vars["seltype"]=0; ?>
		 <input type="checkbox" name="operationId[]" value="<?php echo $this->_tpl_vars["var"]["operationNo"];?>"><?php echo $this->_tpl_vars["var"]["operationName"];?><br>
		 <?php } ?>
		<?php  }
} ?>
		</div>
		<div align="center">
			<input type="submit" name="submit" value="保存" align="middle" class="button1">
		</div>
	</div>
</form>
</body>
</html>
