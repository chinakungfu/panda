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
function addSEO()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addSeo";
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
<?php echo runFunc('getSeoInfoBySeoName',array('cewer'));?>
<div class="main_content">
   	<div class="main_content_nav">当前位置： 系统管理 >> 系统管理 >> SEO设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
<?php $this->_tpl_vars["result"]=runFunc('listSeo',array()); ?>
<?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">SEO标识</td>
          	<td class="listHeader">SEO名称</td>
          	<td class="listHeader">生成工具</td>
          	<td class="listHeader">关键字</td>
          	<td class="listHeader">作者</td>
          	<td class="listHeader">机器人</td>
          	<td class="listHeader">执行操作</td>
       </tr> 
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoGuid"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoName"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoGenerator"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoKeywords"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoAuthor"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["seoRobots"];?></td>
            <td class="tdListItem">
            <?php $this->_tpl_vars["editUrl"]='action=cms&method=editSeo&seoId='.$this->_tpl_vars["var"]["seoId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delSeo&seoId='.$this->_tpl_vars["var"]["seoId"]; ?>
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
          <input type="button" value="新增SEO变量" onClick="addSEO();">
          </td>
        <td width="30%"></td>
      </tr>
    </TABLE>
    
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
