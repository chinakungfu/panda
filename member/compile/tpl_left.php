<?php import('core.util.RunFunc'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>
<script>
function clearCon()
{
	document.forms[0].action.value="yellowPages";
	document.forms[0].method.value="clearCon";
	document.forms[0].submit();
}
function aaa()
{
	if(window.confirm('确定注销吗？'))
	{
		location.href="../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=destroy'));?>";
	}
}
</script>
<body>
<div>
<div class="left_menu">
    	<div class="left_menu_content">
    	<?php if ($this->_tpl_vars["type"]=='member'){?>
    		<div class="left_menu_nav">会员管理</div>
    	
    	<div class="menu_list bottom_border">
    		<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=operation&method=listOperation'));?>" target="mainFrame">操作管理</a>
    	</div>
    	<div class="menu_list bottom_border">
    		<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=role&method=listRoles'));?>" target="mainFrame">角色管理</a>
    	</div>

    	<div class="menu_list bottom_border">
    		<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=staff&method=listUser'));?>" target="mainFrame">用户管理</a>
    	</div>

		<?php }else{ ?>
		<div class="left_menu_nav">会员管理</div>
			<div class="menu_list bottom_border">
				<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=detailMember'));?>" target="mainFrame">个人信息</a>
			</div>
			<div class="menu_list bottom_border">
				<a href="../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=modifyPassword'));?>" target="mainFrame">修改密码</a>
			</div> 
		<?php } ?>  
		</div>
 </div>

 </body>
 </html>