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
<title>通用列表页面</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/right.menu.css" />
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<link type="text/css" href="skin/cssfiles/jq/ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="skin/jsfiles/tree/jquery-1.3.2.js"></script>
<script type="text/javascript" src="skin/jsfiles/ui/ui.core.js"></script>
<script type="text/javascript" src="skin/jsfiles/ui/ui.tabs.js"></script>
<script language="javascript" src="skin/jsfiles/tree/right.menu.js"></script>
<link type="text/css" href="demos.css" rel="stylesheet" />
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>
<script language=JavaScript type="" >
$(function() {
	$("#tabs").tabs();
});
function checkIsParent(value)
{
	var detailOperation = document.getElementById('detailOperation');
	if(value=='0')
	{
		detailOperation.style.display='none';
	}else
	{
		detailOperation.style.display='';
	}
}
function addData(value)
{
	if(value=='0')
	{
		document.forms[0].action.value="cms";
		document.forms[0].method.value="addData";
		document.forms[0].submit();
	}else if(value=='1')
	{
		document.forms[0].action.value="cms";
		document.forms[0].method.value="addExtData";
		document.forms[0].submit();	
	}
}

function batchChange(id,value)
{
	var obj = document.getElementById(id);
	document.forms[0].action.value="cms";
	document.forms[0].method.value=obj.value;
}
function exBatch(value,mapId)
{
	var batchCon = document.getElementById('selectConId');
	var type = document.getElementById("type");
	var obj = document.getElementById(mapId);
	var con = document.getElementById('selectConId');
	type.value=value;
	if(obj.value!='flushRec')
	{
		if(batchCon.value=='')
		{
			alert('请选择要操作的内容！');
			return false;
		}
	}
	if(obj.value=='setBatchTop')
	{
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=setBatchTop&nodeId=' .$this->_tpl_vars["nodeId"] .'&contentModel=' .$this->_tpl_vars["node"]["0"]["appTableName"] .'&appTableKeyName=' .$this->_tpl_vars["node"]["0"]["appTableKeyName"] .'&frameListAction=' .$this->_tpl_vars["action"] .'&frameListMethod=' .$this->_tpl_vars["method"]; ?>
		window.open('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&selectConId='+con.value, '批量置顶设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='setBatchBest')
	{
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=setBatchBest&nodeId=' .$this->_tpl_vars["nodeId"] .'&contentModel=' .$this->_tpl_vars["node"]["0"]["appTableName"] .'&appTableKeyName=' .$this->_tpl_vars["node"]["0"]["appTableKeyName"] .'&frameListAction=' .$this->_tpl_vars["action"] .'&frameListMethod=' .$this->_tpl_vars["method"]; ?>
		window.open('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&selectConId='+con.value, '批量精华设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='setBatchSort')
	{
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=setBatchSort&nodeId=' .$this->_tpl_vars["nodeId"] .'&contentModel=' .$this->_tpl_vars["node"]["0"]["appTableName"] .'&appTableKeyName=' .$this->_tpl_vars["node"]["0"]["appTableKeyName"] .'&frameListAction=' .$this->_tpl_vars["action"] .'&frameListMethod=' .$this->_tpl_vars["method"]; ?>
		window.open('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&selectConId='+con.value, '批量权重设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='copy')
	{
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=copy&nodeId=' .$this->_tpl_vars["nodeId"] .'&contentModel=' .$this->_tpl_vars["node"]["0"]["appTableName"] .'&appTableKeyName=' .$this->_tpl_vars["node"]["0"]["appTableKeyName"] .'&frameListAction=' .$this->_tpl_vars["action"] .'&frameListMethod=' .$this->_tpl_vars["method"]; ?>
		window.open('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&selectConId='+con.value, '复制', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	}else if(obj.value=='move')
	{
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=move&nodeId=' .$this->_tpl_vars["nodeId"] .'&contentModel=' .$this->_tpl_vars["node"]["0"]["appTableName"] .'&appTableKeyName=' .$this->_tpl_vars["node"]["0"]["appTableKeyName"] .'&frameListAction=' .$this->_tpl_vars["action"] .'&frameListMethod=' .$this->_tpl_vars["method"]; ?>
		window.open('index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&selectConId='+con.value, '移动', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	}else
	{
		if(document.forms[0].action.value=='')
		{
			document.forms[0].action.value = "cms";
		}
		if(document.forms[0].method.value=='')
		{
			document.forms[0].method.value = "update";
		}
		document.forms[0].submit();
	}
}
function changeIndex(url)
{
	location.href = url;
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
</style>
</head>
<META content="MSHTML 6.00.2900.3059" name=GENERATOR></head>   
<body oncontextmenu="return false;">
<form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>">
  <input type="hidden" name="contentModel" value="<?php echo $this->_tpl_vars["node"]["0"]["appTableName"];?>">
  <input type="hidden" name="appTableKeyName" value="<?php echo $this->_tpl_vars["node"]["0"]["appTableKeyName"];?>">
  <input type="hidden" name="frameListAction" value="<?php echo $this->_tpl_vars["action"];?>">
  <input type="hidden" name="frameListMethod" value="<?php echo $this->_tpl_vars["method"];?>">
  <div class="main_content">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">内容管理</a></li>
			<li><a href="#tabs-2">附加管理</a></li>
			<li><a href="#tabs-3">回收站</a></li>
		</ul>
		<div id="tabs-1">
		  <div class="main_content_nav">
		  	<?php echo $this->_tpl_vars["node"]["0"]["nodeName"];?>：
		  	<?php echo runFunc('getHeaderAction',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["sqlCon"],'0'));?>
		  	
		  </div>
		  <div style="clear:both"></div>
		  <div class="search_content detailMember">
		    <?php echo runFunc('listStr',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["sqlCon"]));?>
		  </div>		 
		</div>
		<div id="tabs-2">
		  <div class="main_content_nav">
		  	<?php echo $this->_tpl_vars["node"]["0"]["nodeName"];?>：
		  	<?php echo runFunc('getHeaderAction',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["sqlCon"],'1'));?>
		  	
		  </div>
		  <div style="clear:both"></div>
		  <div class="search_content detailMember">
		    <?php echo runFunc('listExtStr',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["sqlCon"]));?>
		  </div>
		</div>
		<div id="tabs-3">
			<div class="main_content_nav">
				<?php echo $this->_tpl_vars["node"]["0"]["nodeName"];?>
			</div>
			<div style="clear:both"></div>
			<div class="search_content detailMember">
				<?php echo runFunc('listRecStr',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["sqlCon"]));?>
			</div>
		</div>
	</div>
  </div>
</form>
<?php echo runFunc('getContentRightMenuAction',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["node"]["0"]["fieldConfigId"],$this->_tpl_vars["node"]["0"]["appTableName"],$this->_tpl_vars["node"]["0"]["appTableKeyName"]));?>

</body>

</html>
