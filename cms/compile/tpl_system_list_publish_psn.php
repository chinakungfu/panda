<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script language=JavaScript type="" >
function addPublishPsn()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addPublishPsn";
	document.forms[0].submit();
}
</script>
<style type="text/css">
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	color: #666666;
	text-decoration: none;
}
a:hover {
	color: #666666;
	text-decoration: underline;
}
a:active {
	color: #666666;
	text-decoration: none;
}
</style></head>
<body>

<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 系统管理 >> 发布点(PSN)管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
<?php $this->_tpl_vars["result"]=runFunc('listPublishPsn',array()); ?>
<?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">psnId</td>
          	<td class="listHeader">psn</td>
          	<td class="listHeader">发布类型</td>
          	<td class="listHeader">执行操作</td>
       </tr> 
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["psnId"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["psnName"];?></td>
          	<?php if ($this->_tpl_vars["var"]["psnType"]=='0'){?>
          	<td class="tdListItem">本地发布</td>
          	<?php }else{ ?>
          	<td class="tdListItem">远程发布</td>
          	<?php } ?>
          	<?php $this->_tpl_vars["editUrl"]='action=cms&method=editPublishPsn&psnId='.$this->_tpl_vars["var"]["psnId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delPublishPsn&psnId='.$this->_tpl_vars["var"]["psnId"]; ?>
            <td class="tdListItem">
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["editUrl"]));?>">编辑</a>&nbsp;&nbsp;
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["delUrl"]));?>">删除</a></td>              

       </tr>
       <?php  }
} ?>
    </table>
    <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
          <input type="button" value="新增发布点(PSN)" onClick="addPublishPsn();">
          </td>
        <td width="30%"></td>
      </tr>
    </TABLE>
    </form>
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
