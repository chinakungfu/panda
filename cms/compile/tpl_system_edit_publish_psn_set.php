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
<?php if ($this->_tpl_vars["method"]=='addPublishPsn'){?>
<input type="hidden" name="method" value="saveAddPublishPsn">
<input type="hidden" class="edit" name="psnId" value="">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>发布点(PSN)设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php }else{ ?>
<?php $this->_tpl_vars["publishPsn"]=runFunc('getPublishPsnInfoById',array($this->_tpl_vars["psnId"])); ?>
<input type="hidden" name="method" value="saveEditPublishPsn">
<input type="hidden" class="edit" name="psnId" value="<?php echo $this->_tpl_vars["publishPsn"]["0"]["psnId"];?>" >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>发布点(PSN)设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php } ?>        	
			<div class="detailMember_txt">
			发布点(PSN)标识名:
			</div>
			<div class="detailMember_info">
			<input type="text" id="psnName" name="para[psnName]" value="<?php echo $this->_tpl_vars["publishPsn"]["0"]["psnName"];?>">
			</div>
			<div class="detailMember_txt">
			发布点(PSN)类型:</div>
			<div class="detailMember_info">
			<select name="para[psnType]" id="psnType">
			<option value="0">本地发布</option>
			<option value="1">远程发布</option>
			</select>
			</div>
			<div class="detailMember_txt">
			本地路径:
			</div>
			<div class="detailMember_info">
			<input type="text" id="psn" name="para[psn]" value="<?php echo $this->_tpl_vars["publishPsn"]["0"]["psn"];?>">如：../../</div>
			<div class="detailMember_txt">URL:</div>
			<div class="detailMember_info"><input type="text" id="psnUrl" name="para[psnUrl]" value="<?php echo $this->_tpl_vars["publishPsn"]["0"]["psnUrl"];?>">如：http://domain/.../</div>
			<div class="detailMember_txt">附加信息:</div>
			<div class="detailMember_info"><input type="text" id="psnDes" name="para[psnDes]" value="<?php echo $this->_tpl_vars["publishPsn"]["0"]["psnDes"];?>"></div>
    <div class="detailMember_doedit">
    <input type="submit" value="保存" />
    <input type="button" value="取消" class="button" onClick="window.history.back();">
    </div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
