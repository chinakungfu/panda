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
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script>
function submitData()
{
	var con = document.getElementById('selectConId');
	if(con.value!='')
	{
		document.forms[0].submit();
	}else
	{
		alert("您没有选择表！");
		return false;
	}
}
</script>
</head>

<body>

<form method="post" action="index.php" id="form1">

<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveBackup">
<input type='hidden' name='selectConId' id='selectConId' >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>数据备份</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember"> 
<?php $this->_tpl_vars["result"]=runFunc('getDatabaseTables',array()); ?>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
          	<td class="listHeader">数据表名</td>
          	<td class="listHeader">记录数</td>
          	<td class="listHeader">数据大小</td>
       </tr> 
       <?php if(!empty($this->_tpl_vars['result'])){ 
 foreach ($this->_tpl_vars['result'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
       <?php $this->_tpl_vars["tableCount"]=$this->_tpl_vars["key"]+1; ?>
       <?php $this->_tpl_vars["rowCount"]=$this->_tpl_vars["var"]["Rows"]+$this->_tpl_vars["rowCount"]; ?>
       <?php $this->_tpl_vars["contentCount"]=$this->_tpl_vars["var"]["total"]+$this->_tpl_vars["contentCount"]; ?>
       <tr>
       		<td class="tdListItem"><input type="checkbox" name="checks" value="<?php echo $this->_tpl_vars["var"]["Name"];?>" onclick="selectConCheck('checks');"></td>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["Name"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["Rows"];?></td>
          	<td class="tdListItem"><?php echo $this->_tpl_vars["var"]["total"];?></td>         
       </tr>
       <?php  }
} ?>
       <tr>
       		<td class="tdListItem">总计</td>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["tableCount"];?></td>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["rowCount"];?></td>
       		<td class="tdListItem"><?php echo $this->_tpl_vars["contentCount"];?> KB</td>
       </tr>
       <tr>
       		<td class="listHeader" ><input type="checkbox" id="all" onclick="selectAll('selectAll',this.id,'checks');"><span id="selectAll" name="" style="cursor:pointer" onclick="selectAll(this.id,'all','checks');">全选</span></td>
       		<td class="tdListItem" colspan="3"></td>
       </tr>
        <tr>
       		<td class="listHeader" >操作</td>
       		<td class="tdListItem" colspan="3"><input type="radio" name="operationType" value="0" checked>优化数据表&nbsp;&nbsp;<input type="radio" name="operationType" value="1">备份数据表&nbsp;&nbsp;分卷备份文件大小:<INPUT TYPE="text" size="2" NAME="MaxFileSize" value="0.5">MB&nbsp;&nbsp;</td>
       </tr>
    </table>			
    <div class="detailMember_doedit"><input type="button" value="提 交" onclick="submitData();"/></div>    
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
