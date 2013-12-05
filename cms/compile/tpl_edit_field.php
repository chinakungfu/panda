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
<title>通用cms</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
</head>

<body>

<form method="post" action="index.php" id="form1">

<input type="hidden" name="action" value="cms">
<?php if ($this->_tpl_vars["method"]=='addField'){?>
<input type="hidden" name="method" value="saveAddField">
<input type="hidden" class="edit" name="fieldId" value="">
<input type="hidden" class="edit" name="para[fieldConfigId]" value="<?php echo $this->_tpl_vars["fieldConfigId"];?>">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>字段配置管理>>新建字段</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php }else{ ?>
<?php $this->_tpl_vars["field"]=runFunc('getFieldInfoById',array($this->_tpl_vars["fieldId"])); ?>
<input type="hidden" name="method" value="saveEditField">
<input type="hidden" class="edit" name="fieldId" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldId"];?>" >
<input type="hidden" class="edit" name="para[fieldConfigId]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldConfigId"];?>">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>字段配置管理>>修改字段</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<?php } ?>        
		<div class="detailMember_nav">新建字段</div>
        
			<div class="detailMember_txt">字段中文名：</div>
			<div class="detailMember_info"><input type="text" id="fieldTitle" name="para[fieldTitle]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldTitle"];?>"></div>
			<div class="detailMember_txt">字段名：</div>
			<div class="detailMember_info"><input type="text" id="fieldName" name="para[fieldName]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldName"];?>"></div>
			<div class="detailMember_txt">是否在列表面显示：</div>
			<input type='radio' id="isDisplayHeader" name='para[isDisplayHeader]' value="1" checked>是
			<input type='radio' id="isDisplayHeader" name='para[isDisplayHeader]' value="0">否<br>
			<div class="detailMember_txt">是否在编辑页显示：</div>
			<input type='radio' id="isDisplayEdit" name='para[isDisplayEdit]' value="1" checked>是
			<input type='radio' id="isDisplayEdit" name='para[isDisplayEdit]' value="0">否<br>
			<div class="detailMember_txt">是否显示右击菜单：</div>
			<input type='radio' id="isDisplayMenu" name='para[isDisplayMenu]' value="1">是
			<input type='radio' id="isDisplayMenu" name='para[isDisplayMenu]' value="0" checked>否
			<div class="detailMember_txt">表头宽度：</div>
			<div class="detailMember_info"><input type="text" id="tableHeadWidth" name="para[tableHeadWidth]" value="<?php echo $this->_tpl_vars["field"]["0"]["tableHeadWidth"];?>">px</div>
			<div class="detailMember_txt">字段类型：</div>
			<div class="detailMember_info">
			<select id="fieldType" name="para[fieldType]">
			<option value="varchar">字符串(长度最大250)</option>
			<option value="date">日期</option>
			<option value="datetime">日期时间</option>
			<option value="int">数值</option>
			<option value="text">一般文本(不用设长度)</option>
			<option value="mediumtext">中型文本(不用设长度)</option>
			<option value="longtext">大型文本(不用设长度)</option>
			<option value="contentlink">其他结点内容(不用设长度)</option>
			</select>
			</div>
			<div class="detailMember_txt">字段长度：</div>
			<div class="detailMember_info"><input type="text" id="fieldSize" name="para[fieldSize]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldSize"];?>"></div>
			<div class="detailMember_txt">字段输入类型：</div>
			<div class="detailMember_info">
			<select id="fieldInput" name="para[fieldInput]">
			<option value="text">text</option>
			<option value="textarea">textarea</option>
			<option value="select">select</option>
			<option value="radio">radio</option>
			<option value="checkbox">checkbox</option>
			<option value="password">password</option>
			<option value="richEditor">richEditor</option>
			</select>
			</div>
			<div class="detailMember_txt">字段可选值：</div>
			<div class="detailMember_info">
			<input type="text" id="fieldDefaultValue" name="para[fieldDefaultValue]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldDefaultValue"];?>">多个可选值之间以分号分隔如：aaa:bbb;ccc:ddd或aaa;ccc
			</div>
			<div class="detailMember_txt">表单输入限制：</div>
			<div class="detailMember_info">
			<select id="fieldInputFilter" name="para[fieldInputFilter]">
			<option value="">无限制</option>
			<option value="notnull">不能为空</option>
			<option value="num">限数字</option>
			<option value="num_letter">限数字或字母</option>
			<option value="unique">值唯一</option>
			</select>
			</div>
			<div class="detailMember_txt">表单值采集器：</div>
			<select name="para[fieldInputPicker]" id="fieldInputPicker"   onchange="if(this.options[this.selectedIndex].value == 'url_content') {alert('请在 [  字段可选值   ] 处输入外部页面的URL.\n [ 表单输入预设模板 ] 处输入弹出窗口的尺寸例如500*380.');} else if(this.options[this.selectedIndex].value == 'dsn_content') {alert('请在字段附加信息处输入数据源获取语句');}">
			<option value="">无</option>
			<option value="color">颜色</option>
			<option value="date">时间</option>
			<option value="upload">图片录入</option>
			<option value="upload_attach">附件录入</option>
			<option value="flash">Flash录入</option>
			<option value="tpl">模板选择</option>
			<option value="psn">发布点(PSN)对象选择</option>
			<option value="content">基于结点内容</option>
			</select>
			<div class="detailMember_txt">表单输入预设模板：</div>
			<div class="detailMember_info">
			<input type="text" id="fieldInputTpl" name="para[fieldInputTpl]" value="<?php echo $this->_tpl_vars["field"]["0"]["fieldInputTpl"];?>">
			<input name="button" type='button' tabindex='13' value='...' onclick="tplSelect('0',this.form,'data_ImageTpl')"> 
			</div>
			<div class="detailMember_txt">字段附加信息：</div>
			<div class="detailMember_info">
			<textarea id="fieldDescription" name="para[fieldDescription]" cols="50" rows="5" tabindex="8"><?php echo $this->_tpl_vars["field"]["0"]["fieldDescription"];?></textarea>
			</div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
<script>
radioIsSelected('publishMode','<?php echo $this->_tpl_vars["field"]["0"]["publishMode"];?>');
radioIsSelected('isDisplayHeader','<?php echo $this->_tpl_vars["field"]["0"]["isDisplayHeader"];?>');
radioIsSelected('isDisplayEdit','<?php echo $this->_tpl_vars["field"]["0"]["isDisplayEdit"];?>');
jsSelectValue("fieldType",'<?php echo $this->_tpl_vars["field"]["0"]["fieldType"];?>');
jsSelectValue("fieldInput",'<?php echo $this->_tpl_vars["field"]["0"]["fieldInput"];?>');
jsSelectValue("fieldInputFilter",'<?php echo $this->_tpl_vars["field"]["0"]["fieldInputFilter"];?>');
jsSelectValue("fieldInputPicker",'<?php echo $this->_tpl_vars["field"]["0"]["fieldInputPicker"];?>');
</script>
</body>
</html>
