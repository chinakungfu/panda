<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language="JavaScript" type="" >
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
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addWorkFlow";
	document.forms[0].submit();
}
function editdata()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="editWorkFlow";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}
function selfFlow()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="selfWorkFlow";
	if (checkdata())
	{
		document.forms[0].submit();
	}

}

function deldata()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="delWorkFlow";
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
			document.forms[0].flowId.value=chks[i].value;
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
</script>
</head>
<body>
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>工作流管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">

 <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="flowId">
    <table width="100%" id="editgroup">
      <tr>
        <td  width="70%">
          <input type="button"  value="新 增" name="btnadd" onClick="adddata();">
          <input type="button"  value="修 改" name="btnedit" onClick="editdata();">
          <input type="button"  value="自定流程" name="btnedit" onClick="selfFlow();">
          <input type="button" value="删 除" name="btndel" onClick="deldata();">
        </TD>
        <td width="30%"></td>
      </tr>
    </TABLE>
    <?php $this->_tpl_vars["result"]=runFunc('listWorkFlow',array($this->_tpl_vars["sqlCon"],'')); ?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
    		<td class="listHeader">选中</td>
          	
          	<td class="listHeader">工作流名称</td>
          	<td class="listHeader">工作流介绍</td>
       </tr>  
       
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="<?php echo $this->_tpl_vars["var"]["flowId"];?>" onclick="selectConCheck();"></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["flowGuid"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["flowRemark"];?></td>
       </tr>
       <?php  }
} ?>
    </table>
    <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <input type='hidden' name='selectConId' id='selectConId' >
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>

</body>
</html>
