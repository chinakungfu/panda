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
<script language=JavaScript type="" >
function editTable()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="saveEditFieldConfig";
	document.forms[0].submit();
}
function addField()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="addField";
	document.forms[0].submit();
}
function fieldOrder()
{
	document.forms[0].action.value="cms";
	document.forms[0].method.value="fieldOrder";
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
   	<div class="main_content_nav">当前位置： 系统管理 >> 字段配置管理 >> 编辑字段集</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="fieldConfigId" value="<?php echo $this->_tpl_vars["fieldConfigId"];?>">
<?php $this->_tpl_vars["fieldConfig"]=runFunc('getFieldConfigInfoById',array($this->_tpl_vars["fieldConfigId"])); ?>
	<div class="detailMember_txt">字段配置名称：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigName]" value="<?php echo $this->_tpl_vars["fieldConfig"]["0"]["fieldConfigName"];?>" ></div>
	<div class="detailMember_txt">字段配置说明：</div>
	<div class="detailMember_info"><input type="text" name="para[fieldConfigDes]" value="<?php echo $this->_tpl_vars["fieldConfig"]["0"]["fieldConfigDes"];?>" ></div>
<div class="detailMember_nav">编辑字段集</div>
<?php $this->_tpl_vars["result"]=runFunc('listFieldInfo',array($this->_tpl_vars["fieldConfigId"])); ?>
<?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>    
<table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">字段中文名</td>
          	<td class="listHeader">字段英文名</td>
          	<td class="listHeader">字段类型</td>
          	<td class="listHeader">字段长度</td>
          	<td class="listHeader">字段输入类型</td>
          	<td class="listHeader">字段可选值</td>
          	<td class="listHeader">表单输入限制</td>
          	<td class="listHeader">表单值采集器</td>
          	<td class="listHeader">表单输入预设模板</td>
          	<td class="listHeader">执行操作</td>
       </tr>  
       
       <?php if(!empty($this->_tpl_vars["result"]["data"])){ 
 foreach ($this->_tpl_vars["result"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <tr>
          <td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldTitle"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldName"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldType"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldSize"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldInput"];?></td>
          	<td class="tdListItem" title="<?php echo $this->_tpl_vars["var"]["fieldDefaultValue"];?>"><?php echo runFunc('CsubStr',array($this->_tpl_vars["var"]["fieldDefaultValue"],0,10));?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldInputFilter"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldInputFilter"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["fieldInputPicker"];?></td>
          <td class="tdListItem">
          <?php $this->_tpl_vars["editUrl"]='action=cms&method=editField&fieldConfigId='.$this->_tpl_vars["fieldConfigId"] .'&fieldId='.$this->_tpl_vars["var"]["fieldId"]; ?>
          	<?php $this->_tpl_vars["delUrl"]='action=cms&method=delField&fieldConfigId='.$this->_tpl_vars["fieldConfigId"] .'&fieldId='.$this->_tpl_vars["var"]["fieldId"]; ?>
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["editUrl"]));?>">编辑</a>&nbsp;&nbsp;
            <a href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["delUrl"]));?>">删除</a>
          </td>              

       </tr>
       <?php  }
} ?>
    </table>
    <?php runFunc('listPage',array($this->_tpl_vars["result"]["pageinfo"],'index.php','5'))?>
    <table width="100%" id="editgroup">
      <tr>
        <td width="70%">
          <input type="button" value="修改" onClick="editTable();">
          <input type="button" value="新增字段" onClick="addField();">
          <input type="button" value="字段排序" onClick="fieldOrder();">	
          </TD>
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
