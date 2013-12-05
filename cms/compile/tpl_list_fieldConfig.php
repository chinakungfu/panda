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
<title>内容模型管理页面</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
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
   	<div class="main_content_nav">当前位置： 系统管理 >> 字段配置管理</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php $this->_tpl_vars["result"]=runFunc('listFieldConfigInfo',array()); ?>
       <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">字段配置ID</td>
          	<td class="listHeader">字段配置名</td>
          	<td class="listHeader">配置描述</td>
          	<td class="listHeader">执行操作</td>
       </tr>  
       
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldConfigId"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldConfigName"];?></td>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldConfigDes"];?></td>
          <td class="tdListItem">
          <?php $this->_tpl_vars["editUrl"]='action=cms&method=listField&fieldConfigId='.$this->_tpl_vars["var"]["fieldConfigId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delFieldConfig&fieldConfigId='.$this->_tpl_vars["var"]["fieldConfigId"]; ?>
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["editUrl"]));?>">编辑</a>&nbsp;&nbsp;
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["delUrl"]));?>">删除</a>
          </td>
       </tr>
       <?php  }
} ?>
    </table>
     <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    </div>
<form id="from1" action="index.php" method="POST">
<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveAddFieldConfig">
<div class="detailMember_nav">新建字段配置</div>     
	<div class="detailMember_txt">字段配置名称：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigName]" value="" ></div>
	<div class="detailMember_txt">字段配置说明：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigDes]" value="" ></div>
<div class="detailMember_doedit">
<input type="submit" name="submit" value="创建"">
</div>
</form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
