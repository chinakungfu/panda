<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<input type="hidden" name="method" value="savePublishSet">
<?php $this->_tpl_vars["publishSet"]=runFunc('getPublishInfoById',array($this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"])); ?>
<input type="hidden" name="frameListAction" value="<?php echo $this->_tpl_vars["frameListAction"];?>">
<input type="hidden" name="frameListMethod" value="<?php echo $this->_tpl_vars["frameListMethod"];?>">
<input type="hidden" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>">
<input type="hidden" name="para[nodeId]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["nodeId"];?>">
<input type="hidden" name="appTableName" value="<?php echo $this->_tpl_vars["contentModel"];?>">
<input type="hidden" name="para[appTableName]" value="<?php echo $this->_tpl_vars["contentModel"];?>">
<input type="hidden" name="contentId" value="<?php echo $this->_tpl_vars["appTableKeyValue"];?>">
<input type="hidden" name="para[contentId]" value="<?php echo $this->_tpl_vars["appTableKeyValue"];?>">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>内容发布设置>>编辑发布设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
    
<input type="hidden" name="publishId" value="<?php echo $this->_tpl_vars["publishId"];?>">
		<div class="detailMember_nav">基本发布设置</div>
		<div class="detailMember_txt">发布模式：</div>
			<input type='radio' id="publishMode" name='para[publishMode]' value="1" onclick="changeDisplayData(this.value);">静态发布
			<input type='radio' id="publishMode" name='para[publishMode]' value="2" onclick="changeDisplayData(this.value);">动态发布
			<input type='radio' id="publishMode" name='para[publishMode]' value="3" onclick="changeDisplayData(this.value);">不对外发布
			<div class="detailMember_txt">置顶设置：</div>
			<div class="detailMember_info">
			<input type="text" id="top" name="para[top]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["top"];?>">
			</div>
			<div class="detailMember_txt">精华设置：</div>
			<div class="detailMember_info">
			<input type="text" id="pink" name="para[pink]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["pink"];?>">
			</div>
			<div class="detailMember_txt">权重设置：</div>
			<div class="detailMember_info">
			<input type="text" id="sort" name="para[sort]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["sort"];?>">
			</div>
			<div class="detailMember_txt">开始日期：</div>
			<div class="detailMember_info">
			<input type="text" id="startDate" name="para[startDate]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["startDate"];?>">
			</div>
			<div class="detailMember_txt">结束日期：</div>
			<div class="detailMember_info">
			<input type="text" id="endDate" name="para[endDate]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["endDate"];?>">
			</div>
			<div class="detailMember_txt">自定义外部URL：</div>
			<div class="detailMember_info">
			<input type="text" id="selfURL" name="para[selfURL]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["selfURL"];?>">
			</div>
		<div id="staticPublish" style="display:none">
		<div class="detailMember_nav">静态发布设置</div>
		
			<div class="detailMember_txt">自定义套用模板：</div>
			<div class="detailMember_info">
			<input type="text" id="selfTemplate" name="para[selfTemplate]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["selfTemplate"];?>">
			</div>
			<div class="detailMember_txt">自定义发布文件名：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPublishFileName" name="para[selfPublishFileName]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["selfPublishFileName"];?>">
			</div>
			<div class="detailMember_txt">自定义发布点(PSN)：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPSN" name="para[selfPSN]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["selfPSN"];?>">
			</div>
			<div class="detailMember_txt">自定义发布URL：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPSNURL" name="para[selfPSNURL]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["selfPSNURL"];?>">
			</div>
			
		</div>
			
		<div id="dynamicPublish" style="display:none">
			<div class="detailMember_nav">动态发布设置</div>
			
			<div class="detailMember_txt">动态入口URL：</div>
			<div class="detailMember_info"><input type="text" id="appUrl" name="para[appUrl]" value="<?php echo $this->_tpl_vars["publishSet"]["0"]["appUrl"];?>"></div>
		</div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.window.history.back();"></div>
    </div>
    </form>     
    
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
<script>
radioIsSelected('publishMode','<?php echo $this->_tpl_vars["publishSet"]["0"]["publishMode"];?>');
changeDisplayData('<?php echo $this->_tpl_vars["publishSet"]["0"]["publishMode"];?>');
</script>
</body>
</html>
