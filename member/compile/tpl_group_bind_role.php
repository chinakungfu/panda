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
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='group'>
	<input type='hidden' name='method' value='saveOperation'>
	<div class="main_content">
	   	<div class="main_content_nav">
	   	<?php if ($this->_tpl_vars["type"]=='group'){?>
	   	<?php $this->_tpl_vars["group"]=runFunc('getGroupInfoById',array($this->_tpl_vars["groupId"])); ?>
	   	<input type="hidden" name="type" value="group">
	   	<input type="hidden" id="groupNo" name="groupNo" value="<?php echo $this->_tpl_vars["group"]["0"]["groupNo"];?>">
	   	给用户组『
	        <?php echo $this->_tpl_vars["group"]["0"]["groupName"];?>
	        』绑定角色
	  	<?php }else{ ?>     
	  	<?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoById',array($this->_tpl_vars["staffId"])); ?>
	  	<input type="hidden" name="type" value="staff">
	  	<input type="hidden" id="staffNo" name="staffNo" value="<?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?>">
	    给用户『
	        <?php echo $this->_tpl_vars["staff"]["0"]["staffName"];?>
	        』绑定角色
	   <?php } ?></div>
	   	<div style="clear:both"></div>
		<div class="search_content detailMember">
			<?php $this->_tpl_vars["role"]=runFunc('listRole',array($this->_tpl_vars["sqlCon"],'1')); ?>
			 <?php if(!empty($this->_tpl_vars['role'])){ 
 foreach ($this->_tpl_vars['role'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
				 <?php if ($this->_tpl_vars["type"]=='group'){?>
				 <?php $this->_tpl_vars["judge"]=runFunc('checkRole',array($this->_tpl_vars["group"]["0"]["groupNo"],$this->_tpl_vars["var"]["roleNo"],'0')); ?>
				 <?php }else{ ?>
				 <?php $this->_tpl_vars["judge"]=runFunc('checkRole',array($this->_tpl_vars["staff"]["0"]["staffNo"],$this->_tpl_vars["var"]["roleNo"],'1')); ?>
				 <?php } ?>
				 <?php if ($this->_tpl_vars["judge"]){?>
				 <input type="checkbox" name="index[]" value="<?php echo $this->_tpl_vars["var"]["roleNo"];?>" checked><?php echo $this->_tpl_vars["var"]["roleName"];?><br>
				 <?php }else{ ?>
				 <input type="checkbox" name="index[]" value="<?php echo $this->_tpl_vars["var"]["roleNo"];?>"><?php echo $this->_tpl_vars["var"]["roleName"];?><br>
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
