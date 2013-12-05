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
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script>
function fullPublishFlag(value)
{
	call_tpl("cms","fullPublishFlag","backGetData('extraPublishGuid')","return",value,"");
}
function submitData()
{
	var extraPublishName = document.getElementById('extraPublishName');
	var extraPublishGuid = document.getElementById('extraPublishGuid');
	var extraPublishMode = document.getElementsByName('para[extraPublishMode]');
	var selfTemplate = document.getElementById('selfTemplate');
	if(extraPublishName.value=='')
	{
		alert("发布名称不能为空！");
		return false;
	}
	if(extraPublishGuid.value=='')
	{
		alert("附加发布标识不能为空！");
		return false;
	}
	var selectPublishModeFlag = false;
	for(i=0;i<extraPublishMode.length;i++)
	{
		if(extraPublishMode[i].checked)
		{
			selectPublishModeFlag = true;
		}
	}
	if(!selectPublishModeFlag)
	{
		alert("发布模式不能不选！");
		return false;
	}
	if(selfTemplate.value=='')
	{
		alert("套用模板不能为空！");
		return false;
	}
	document.forms[0].submit();
}
</script>
</head>

<body>

<form method="post" action="index.php" id="form1">

<input type="hidden" name="action" value="cms">
<?php if ($this->_tpl_vars["method"]=='addExtData'){?>
<input type="hidden" name="method" value="saveAddExtData">
<input type="hidden" class="edit" name="extraPublishId" value="">
<input type="hidden" class="edit" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>发布管理>>新建附加发布</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">

<?php }else{ ?>
<?php $this->_tpl_vars["extra"]=runFunc('getExtInfoById',array($this->_tpl_vars["extraPublishId"])); ?>
<input type="hidden" name="method" value="saveEditExtData">
<input type="hidden" class="edit" name="extraPublishId" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishId"];?>" >
<input type="hidden" class="edit" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>发布管理>>修改附加发布</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">

<?php } ?>        
		
		<div class="detailMember_nav">基本发布设置</div>
			<div class="detailMember_txt">发布名称：</div>
			<div class="detailMember_info">
			<?php if ($this->_tpl_vars["method"]=='addExtData'){?>
				<input type="text" id="extraPublishName" name="para[extraPublishName]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishName"];?>" onblur="fullPublishFlag(this.value);">
			<?php }else{ ?>
				<input type="text" id="extraPublishName" name="para[extraPublishName]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishName"];?>">
			<?php } ?>
			</div>
			<div class="detailMember_txt">附加发布标识：</div>
			<div class="detailMember_info">
			<?php if ($this->_tpl_vars["extra"]["0"]["extraPublishGuid"]){?>
				<input type="text" id="extraPublishGuid" name="para[extraPublishGuid]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishGuid"];?>" readonly>
			<?php }else{ ?>
				<input type="text" id="extraPublishGuid" name="para[extraPublishGuid]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishGuid"];?>">
			<?php } ?>
			</div>
			
			<div class="detailMember_txt">是否为首页：</div>
			<div>
			<input type='radio' id="isIndex" name='para[isIndex]' value="1">是
			<input type='radio' id="isIndex" name='para[isIndex]' value="0">否
			</div>
		<div class="detailMember_txt">发布模式：</div>
			<input type='radio' id="extraPublishMode" name='para[extraPublishMode]' value="1" onclick="changeDisplayData(this.value);">静态发布
			<input type='radio' id="extraPublishMode" name='para[extraPublishMode]' value="2" onclick="changeDisplayData(this.value);">动态发布
			<input type='radio' id="extraPublishMode" name='para[extraPublishMode]' value="3" onclick="changeDisplayData(this.value);">不对外发布
			<div class="detailMember_txt">置顶权重：</div>
			<div class="detailMember_info">
			<input type="text" id="extraPublishTop" name="para[extraPublishTop]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishTop"];?>">
			</div>
			<div class="detailMember_txt">精华权重：</div>
			<div class="detailMember_info">
			<input type="text" id="extraPublishPink" name="para[extraPublishPink]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishPink"];?>">
			</div>
			<div class="detailMember_txt">分类：</div>
			<div class="detailMember_info">
			<input type="text" id="extraPublishSort" name="para[extraPublishSort]" value="<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishSort"];?>">
			</div>

			<div class="detailMember_txt">自定义外部URL：</div>
			<div class="detailMember_info">
			<input type="text" id="selfURL" name="para[selfURL]" value="<?php echo $this->_tpl_vars["extra"]["0"]["selfURL"];?>">
			</div>
			<div class="detailMember_txt">附加属性：</div>
			<div class="detailMember_info">
				<textarea id="extraPublishAttr" rows="5" cols="25" name="para[extraPublishAttr]"><?php echo $this->_tpl_vars["extra"]["0"]["extraPublishAttr"];?></textarea>
			</div>
		<div class="detailMember_nav">套用模板设置</div>
		<div class="detailMember_txt">套用模板：</div>
		<div class="detailMember_info">
		<input type="text" id="selfTemplate" name="para[selfTemplate]" value="<?php echo $this->_tpl_vars["extra"]["0"]["selfTemplate"];?>">
		</div>
		<div id="staticPublish" style="display:none">
		<div class="detailMember_nav">静态发布设置</div>
			<div class="detailMember_txt">静态发布入口：</div>
			<div class="detailMember_info">
			<input type="text" id="staticURL" name="para[staticURL]" value="<?php echo $this->_tpl_vars["extra"]["0"]["staticURL"];?>">
			</div>
			<div class="detailMember_txt">自定义发布文件名：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPublishFileName" name="para[selfPublishFileName]" value="<?php echo $this->_tpl_vars["extra"]["0"]["selfPublishFileName"];?>">
			</div>
			<div class="detailMember_txt">自定义发布点(PSN)：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPSN" name="para[selfPSN]" value="<?php echo $this->_tpl_vars["extra"]["0"]["selfPSN"];?>">
			</div>
			<div class="detailMember_txt">自定义发布URL：</div>
			<div class="detailMember_info">
			<input type="text" id="selfPSNURL" name="para[selfPSNURL]" value="<?php echo $this->_tpl_vars["extra"]["0"]["selfPSNURL"];?>">
			</div>
			
		</div>
		<div id="dynamicPublish" style="display:none">
			<div class="detailMember_nav">动态发布设置</div>
			<div class="detailMember_txt">动态入口URL：</div>
			<div class="detailMember_info"><input type="text" id="dynamicURL" name="para[dynamicURL]" value="<?php echo $this->_tpl_vars["extra"]["0"]["dynamicURL"];?>"></div>
		</div>
					
			
    <div class="detailMember_doedit"><input type="button" value="保存" onclick="submitData()" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
         
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
<script>
if('<?php echo $this->_tpl_vars["extra"]["0"]["isIndex"];?>'=='')
{
	radioIsSelected('isIndex','0');
}
else
{
	radioIsSelected('isIndex','<?php echo $this->_tpl_vars["extra"]["0"]["isIndex"];?>');
}
radioIsSelected('extraPublishMode','<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishMode"];?>');
changeDisplayData('<?php echo $this->_tpl_vars["extra"]["0"]["extraPublishMode"];?>');
</script>
</body>
</html>
