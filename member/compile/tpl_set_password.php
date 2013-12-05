<?php import('core.util.RunFunc'); ?>﻿<html>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" language="JavaScript">
var ajax = new Ajax( "POST", "index.php", false, true );
function submitdata()
{	
	if(checkdublepassword())
	{
		document.forms[0].submit();
	}else
	{
		alert('两次新密码不一致，请重新输入！');
		document.forms[0].newpassword.value='';
		document.forms[0].aginpassword.value='';
		document.forms[0].newpassword.focus();
		return false;
	}
}
function checkdublepassword()
{
	var newpassword = document.all.newpassword.value;
	var aginpassword = document.all.aginpassword.value;
	if(newpassword==aginpassword)
	{
		return true;
	}else
	{
		return false;
	}
}
function checkoldpassword()
{
	var oldpassword = document.all.oldpassword.value;
	if(oldpassword!='')
	{
		return true;
	}else
	{
		return false;
	}
}
</script>
<title>
修改用户密码
</title>
</head>
<body bgcolor="#ffffff">
<form method="post" action="index.php">
<input type="hidden" name="action" value="member">
<?php $this->_tpl_vars["staff"]=runFunc('getStaffInfoByNo',array($this->_tpl_vars["name"])); ?>
<input type="hidden" name="method" value="savePassword">
<input type="hidden" class="edit" name="staffId" value="<?php echo $this->_tpl_vars["name"];?>" >
<input type="hidden" class="edit" name="oldpassword" value="">
<table width="100%" class="tableTitle"/>
      <tr>
        <td class="tdTitle" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        修改用户密码
        </TD>
      </tr>
    </table>
<table class="editTable" id="edit" align="center">
	<tr>
		<td class="editHeader">用户账户：</td>
                <td class="editHeader"><?php echo $this->_tpl_vars["staff"]["0"]["staffNo"];?></td>
        </tr>
        <tr>
        <tr> 
        <td class="editHeader">新密码：</td>				
                <td class="editHeader"><input type="password" class="edit" name="newpassword" value=""></td>
        </tr>
        <tr>
        <td class="editHeader">重复一次新密码：</td>				
                <td class="editHeader"><input type="password" class="edit" name="aginpassword" value=""></td>
        </tr>
        <tr>
  	<TD align="center"><input type="button" value="确定" class="button" onClick="submitdata();"></TD>
		</tr>
</table>
</form>
</body>
</html>
