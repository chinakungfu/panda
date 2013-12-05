<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<title>角色管理页面</title>
<script language=JavaScript type="" >
function selectConCheck()
{
	var con = '';
	var chks =document.getElementsByName('checks');
	for(i=0;i<chks.length;i++){

		if(chks[i].checked){

			 con = chks[i].value+','+con;

		}

	}
	var selectCon=document.getElementById('selectConId');
	selectCon.value = con;
}
function adddata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="beginInsert";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="beginUpdate";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function deldata()
{
	document.forms[0].action.value="role";
	document.forms[0].method.value="delData";
	if (checkdata())
	{
		document.forms[0].submit();
	}
}
function checkdata()
{
	var bool=0;
	var chks=document.getElementsByName("checks");
	for(i=0;i<chks.length;i++){
		if(chks[i].checked){
			document.forms[0].roleId.value=chks[i].value;
			bool=1;
			break;
		}
	}
	if (bool==1)
	{
		return true;
	}
	else
	{
		window.alert("你首先要选择一条记录然后再记录!");
		return false;
	}
}
function clearCon()
{
	document.forms[0].action.value="yellowPages";
	document.forms[0].method.value="clearCon";
	document.forms[0].submit();
}
</script>
</head>
<body>
<?php $this->_tpl_vars["data"]=runFunc('readSession',array()); ?>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 角色管理</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

    <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="roleId">

    <table width="100%" id="editgroup">
      <tr>
        <td  width="70%">
        
        
          <input type="button" value="新 增" name="btnadd" onClick="adddata();">
          <input type="button" value="修 改" name="btnedit" onClick="editdata();">
          <input type="button" value="删 除" name="btndel" onClick="deldata();">
          <input type="hidden" name="sessionaction" value="<?php echo $this->_tpl_vars["action"];?>">
  			<input type="hidden" name="sessionmethod" value="<?php echo $this->_tpl_vars["method"];?>"> 
          
          
         </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <?php $this->_tpl_vars["result"]=runFunc('listRole',array($this->_tpl_vars["sqlCon"],'')); ?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
          
      		<td class="listHeader">角色标识</td>
      		<td class="listHeader">角色名称</td>
      		<td class="listHeader">角色说明</td>
      		<td class="listHeader">绑定功能</td>
       </tr>
       
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="<?php echo $this->_tpl_vars["var"]["roleId"];?>" onclick="selectConCheck();"></td>
         
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["roleNo"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["roleName"];?></td>
          <td class="tdListItem"><?php echo runFunc('CsubStr',array($this->_tpl_vars["var"]["roleDesc"],0,25));?></td>
          <td class="tdListItem">
          <?php $this->_tpl_vars["tempUrl"]='action=role&method=bindops&roleId= ' .$this->_tpl_vars["var"]["roleId"] .'&sqlCon='.$this->_tpl_vars["sqlCon"]; ?>
          <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>">绑定功能</a>
          </td>         
       </tr>
       <?php  }
} ?>
    </table>
    <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <input type='hidden' name='selectConId' id='selectConId' >
  </form>
    
     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
