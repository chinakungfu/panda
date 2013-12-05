<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
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
<pp:var name="node" value="@getNodeInfoById($nodeId)"/>
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
		<pp:var name="tempUrl" value="'action=cms&method=setBatchTop&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
		window.open('index.php[@encrypt_url($tempUrl)]&selectConId='+con.value, '批量置顶设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='setBatchBest')
	{
		<pp:var name="tempUrl" value="'action=cms&method=setBatchBest&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
		window.open('index.php[@encrypt_url($tempUrl)]&selectConId='+con.value, '批量精华设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='setBatchSort')
	{
		<pp:var name="tempUrl" value="'action=cms&method=setBatchSort&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
		window.open('index.php[@encrypt_url($tempUrl)]&selectConId='+con.value, '批量权重设置', 'height=200, width=320, top=300, left=400, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
	}else if(obj.value=='copy')
	{
		<pp:var name="tempUrl" value="'action=cms&method=copy&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
		window.open('index.php[@encrypt_url($tempUrl)]&selectConId='+con.value, '复制', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
	}else if(obj.value=='move')
	{
		<pp:var name="tempUrl" value="'action=cms&method=move&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
		window.open('index.php[@encrypt_url($tempUrl)]&selectConId='+con.value, '移动', 'height=400, width=500, top=300, left=400, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no');
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
  <input type="hidden" name="nodeId" value="[$nodeId]">
  <input type="hidden" name="contentModel" value="[$node.0.appTableName]">
  <input type="hidden" name="appTableKeyName" value="[$node.0.appTableKeyName]">
  <input type="hidden" name="frameListAction" value="[$action]">
  <input type="hidden" name="frameListMethod" value="[$method]">
  <div class="main_content">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">内容管理</a></li>
			<li><a href="#tabs-2">附加管理</a></li>
			<li><a href="#tabs-3">回收站</a></li>
		</ul>
		<div id="tabs-1">
		  <div class="main_content_nav">
		  	[$node.0.nodeName]：
		  	[@getHeaderAction($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$sqlCon,'0')]
		  	<!--<input type="button" name="addbtn" value="添加内容" onclick="addData(0);">-->
		  </div>
		  <div style="clear:both"></div>
		  <div class="search_content detailMember">
		    [@listStr($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$sqlCon)]
		  </div>		 
		</div>
		<div id="tabs-2">
		  <div class="main_content_nav">
		  	[$node.0.nodeName]：
		  	[@getHeaderAction($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$sqlCon,'1')]
		  	<!--<input type="button" name="addbtn" value="新增附加发布" onclick="addData(1);">-->
		  </div>
		  <div style="clear:both"></div>
		  <div class="search_content detailMember">
		    [@listExtStr($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$sqlCon)]
		  </div>
		</div>
		<div id="tabs-3">
			<div class="main_content_nav">
				[$node.0.nodeName]
			</div>
			<div style="clear:both"></div>
			<div class="search_content detailMember">
				[@listRecStr($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName,$sqlCon)]
			</div>
		</div>
	</div>
  </div>
</form>
[@getContentRightMenuAction($nodeId,$node.0.fieldConfigId,$node.0.appTableName,$node.0.appTableKeyName)]
<!--<div class="skin0" id="contentRightMenu" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">
	<pp:var name="tempUrl" value="'action=cms&method=copy&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="copy" url='index.php[@encrypt_url($tempUrl)]'>复制</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=move&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="move" url='index.php[@encrypt_url($tempUrl)]'>剪切</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=batchTop&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="batchTop" url='index.php[@encrypt_url($tempUrl)]'>置顶设置</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=batchBest&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="batchBest" url='index.php[@encrypt_url($tempUrl)]'>精华设置</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=batchSort&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="batchSort" url='index.php[@encrypt_url($tempUrl)]'>排序权重设置</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=createVoidLink&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="createVoidLink" url='index.php[@encrypt_url($tempUrl)]'>创建虚链接</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=createIndexLink&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="createIndexLink" url='index.php[@encrypt_url($tempUrl)]'>创建索引链接</DIV>
	<pp:var name="tempUrl" value="'action=cms&method=viewLinkState&nodeId=' .$nodeId .'&contentModel=' .$node.0.appTableName .'&appTableKeyName=' .$node.0.appTableKeyName .'&frameListAction=' .$action .'&frameListMethod=' .$method"/>
	<DIV class="menuitems" name="" id="viewLinkState" url='index.php[@encrypt_url($tempUrl)]'>查看链接状态</DIV>

</div>
<SCRIPT language="JavaScript1.2"> 
if(getOs()=='Firefox')
{
	copy = document.getElementById("copy");
	move = document.getElementById("move");
	batchTop = document.getElementById("batchTop");
	batchBest = document.getElementById("batchBest");
	batchSort = document.getElementById("batchSort");
	createVoidLink = document.getElementById("createVoidLink"); 
	createIndexLink = document.getElementById("createIndexLink");
	viewLinkState = document.getElementById("viewLinkState"); 
	 
} 
document.body.onclick = hideContentRightMenu;   
</script>-->
</body>

</html>
