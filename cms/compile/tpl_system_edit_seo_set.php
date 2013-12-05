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
<?php if ($this->_tpl_vars["method"]=='addSeo'){?>
<input type="hidden" name="method" value="saveAddSeo">
<input type="hidden" class="edit" name="seoId" value="">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>SEO设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php }else{ ?>
<?php $this->_tpl_vars["seoInfo"]=runFunc('getSeoInfoById',array($this->_tpl_vars["seoId"])); ?>
<input type="hidden" name="method" value="saveEditSeo">
<input type="hidden" class="edit" name="seoId" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoId"];?>" >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>SEO设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php } ?>        	
			<div class="detailMember_txt">SEO名称：</div>
			<div class="detailMember_info"><input type="text" id="seoName" name="para[seoName]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoName"];?>"></div>
			<div class="detailMember_txt">SEO标识：</div>
			<div class="detailMember_info"><input type="text" id="seoGuid" name="para[seoGuid]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoGuid"];?>"></div>
			<div class="detailMember_txt">生成工具：</div>
			<div class="detailMember_info"><input type="text" id="seoGenerator" name="para[seoGenerator]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoGenerator"];?>"></div>
			<div class="detailMember_txt">关键字：</div>
			<div class="detailMember_info"><input type="text" id="seoKeywords" name="para[seoKeywords]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoKeywords"];?>"></div>
			<div class="detailMember_txt">站点描述：</div>
			<div class="detailMember_info"><input type="text" id="seoDescription" name="para[seoDescription]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoDescription"];?>"></div>
			<div class="detailMember_txt">作者：</div>
			<div class="detailMember_info"><input type="text" id="seoAuthor" name="para[seoAuthor]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoAuthor"];?>"></div>
			<div class="detailMember_txt">机器人：</div>
			<div class="detailMember_info"><input type="text" id="seoRobots" name="para[seoRobots]" value="<?php echo $this->_tpl_vars["seoInfo"]["0"]["seoRobots"];?>"></div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>     
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
