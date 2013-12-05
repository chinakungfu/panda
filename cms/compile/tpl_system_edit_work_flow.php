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
</head>

<body>

<form method="post" action="index.php" id="form1">

<input type="hidden" name="action" value="cms">
<?php if ($this->_tpl_vars["method"]=='addWorkFlow'){?>
<input type="hidden" name="method" value="saveAddWorkFlow">
<input type="hidden" class="edit" name="flowId" value="">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>新增工作流</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php }else{ ?>
<?php $this->_tpl_vars["workFlow"]=runFunc('getWorkFlowInfoById',array($this->_tpl_vars["flowId"])); ?>
<input type="hidden" name="method" value="saveEditWorkFlow">
<input type="hidden" class="edit" name="flowId" value="<?php echo $this->_tpl_vars["workFlow"]["0"]["flowId"];?>" >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>修改工作流</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php } ?>        	
			<div class="detailMember_txt">工作流名称：</div>
			<div class="detailMember_info">
				<input type="text" id="flowName" name="para[flowName]" value="<?php echo $this->_tpl_vars["workFlow"]["0"]["flowName"];?>">
			</div>
			
			<div class="detailMember_txt">工作流说明：</div>
			<div class="detailMember_info">
				<textarea id="flowRemark" name="para[flowRemark]" value=""><?php echo $this->_tpl_vars["workFlow"]["0"]["flowRemark"];?></textarea>
			</div>
    <div class="detailMember_doedit">
    <input type="submit" value="保存" />
    <input type="button" value="取消" class="button" onClick="window.history.back();">
       
    </div>  
    
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
