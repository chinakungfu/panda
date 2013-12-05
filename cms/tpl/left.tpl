<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/right.menu.css" />
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="skin/jsfiles/prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phprpc_client.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script language="javascript" src="skin/jsfiles/tree/MzTreeView.js"></script>
<script language="javascript" src="skin/jsfiles/tree/right.menu.js"></script>
<!--<script>
document.onclick = function ()
{
	var objMenuBase = document.getElementById("menuBase");
	var objMenu = document.getElementById("menu");
	objMenu.style.display   = "none";
	objMenuBase.style.display   = "none";
}
</script>-->
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>

<link type="text/css" href="skin/cssfiles/jq/ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="skin/jsfiles/tree/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="skin/jsfiles/ui/ui.core.js"></script>
	<script type="text/javascript" src="skin/jsfiles/ui/ui.tabs.js"></script>
	<link type="text/css" href="demos.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
<META content="MSHTML 6.00.2900.3059" name=GENERATOR></head>   
<body oncontextmenu="return false;">
<pp:if expr="$type=='site'">
<input type="hidden" name="method" value="[$method]">
当前位置:<span id="weizi">站点管理</span>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">默认操作</a></li>
		<li><a href="#tabs-2">结点树</a></li>
		<li><a href="#tabs-3">结点搜索</a></li>
	</ul>
	<div id="tabs-1">
		<div id="listNodeByCon"></div>
			[@listNodeByCon('1')]
		</div>
	<div id="tabs-2">
		<div class="dtree">
		<div id="nodeList"></div>
    		[@listNode()]
		</div>
	</div>
	<div id="tabs-3">
		<select name="field"　size="1">
			<option value="nodeId">结点号</option>
			<option value="nodeName">结点名称</option>
		</select>
		<input type="text" name="con" value="" size="5">
		<input type="button" name="button" value="搜索" onclick="searchNode('node');">
		<iframe height="300" width="175" style="display:none" id="searchResult" name="searchResult" src="" frameborder="0"></iframe>
	</div>
	<div class="skin0" id="menu" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">
		<DIV class="menuitems" name="" id="addCNode" url='index.php[@encrypt_url("action=cms&method=addNode")]'>新建子结点</DIV>
		<DIV class="menuitems" name="" id="nodeBase" url='index.php[@encrypt_url("action=cms&method=nodeBase")]'>新建子结点基于...</DIV>
		<DIV class="menuitems" name="" id="sortNode" url='index.php[@encrypt_url("action=cms&method=sortNode")]'>结点排序权重</DIV>
		<DIV class="menuitems" name="" id="moveNode" url='index.php[@encrypt_url("action=cms&method=moveNode")]'>结点移动</DIV>
		<DIV class="menuitems" name="" id="setDefaultNode" url='index.php[@encrypt_url("action=cms&method=setDefaultNode")]'>设为默认操作</DIV>
		<DIV class="menuitems" name="" id="delNode" url='index.php[@encrypt_url("action=cms&method=delNode")]'>删除结点</DIV>
		<DIV class="menuitems" name="" id="contentPublish" url='index.php[@encrypt_url("action=cms&method=commonList&frameListAction=cms&frameListMethod=commonListFrame")]'>内容发布管理</DIV>
	</div>
	<div class="skin0" id="menuBase" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">
		<DIV class="menuitems" name="" id="addPNode" url='index.php[@encrypt_url("action=cms&method=addNode")]'>新建根结点</DIV>
	</div>
</div>

<SCRIPT language="JavaScript1.2"> 
if(getOs()=='Firefox')
{
	addPNode = document.getElementById("addPNode");
	
	addCNode = document.getElementById("addCNode");
	nodeBase = document.getElementById("nodeBase");
	sortNode = document.getElementById("sortNode");
	moveNode = document.getElementById("moveNode");
	setDefaultNode = document.getElementById("setDefaultNode"); 
	delNode = document.getElementById("delNode");
	contentPublish = document.getElementById("contentPublish"); 
	 
} 
document.body.onclick = hideRightMenu;   
</script>
<pp:elseif expr="$type=='publish'||$type==''">
 <input type="hidden" name="method" value="[$method]">
当前位置:<span id="weizi">发布管理</span>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">默认操作</a></li>
		<li><a href="#tabs-2">结点树</a></li>
		<li><a href="#tabs-3">结点搜索</a></li>
	</ul>
	<div id="tabs-1">
		<div id="publishDefaultNode"></div>
			[@listPublishNodeByCon('1')]
		</div>
	<div id="tabs-2">
		<div class="dtree">
		<div id="publishListNode"></div>
    		[@listPublishNode()]
		</div>
	</div>
	<div id="tabs-3">
		<select name="field"　size="1">
			<option value="nodeId">结点号</option>
			<option value="nodeName">结点名称</option>
		</select>
		<input type="text" name="con" value="" size="5">
		<input type="button" name="button" value="搜索" onclick="searchNode('publishNode');">
		<iframe height="300" width="175" style="display:none" id="searchResult" name="searchResult" src="" frameborder="0"></iframe>
	</div>
	<div class="skin0" id="menu" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">
		<DIV class="menuitems" name="" id="refeshIndex" url='index.php[@encrypt_url("action=cms&method=refeshIndex")]'>刷新首页</DIV>
		<DIV class="menuitems" name="" id="newDoc" url='index.php[@encrypt_url("action=cms&method=addData&frameListAction=cms&frameListMethod=commonListFrame")]'>新建文档</DIV>
		<DIV class="menuitems" name="" id="nodeUpdate" url='index.php[@encrypt_url("action=cms&method=nodeUpdate&allSit=0")]'>结点更新</DIV>
		<DIV class="menuitems" name="" id="nodePublsh" url='index.php[@encrypt_url("action=cms&method=nodePublish&allSit=0")]'>结点发布</DIV>
		<!--<DIV class="menuitems" name="" id="viewIndex" url='index.php[@encrypt_url("action=cms&method=viewIndex")]'>查看首页</DIV>-->
		<DIV class="menuitems" name="" id="viewNodeIndex" url='index.php[@encrypt_url("action=cms&method=viewIndex")]'>查看首页</DIV>
		<DIV class="menuitems" name="" id="parmaSet" url='index.php[@encrypt_url("action=cms&method=editNode")]'>参数设置</DIV>
	</div>
	<div class="skin0" id="menuBase" name="" onmouseover="highRightMenu(event)" onclick="jumpRightMenu(event);" onmouseout="lowRightMenu(event)">
		<DIV class="menuitems" name="" id="allSitUpdate" url='index.php[@encrypt_url("action=cms&method=nodeUpdate&allSit=1")]'>整站更新</DIV>
		<DIV class="menuitems" name="" id="allSitePublish" url='index.php[@encrypt_url("action=cms&method=nodePublish&allSit=1")]'>整站发布</DIV>
	</div>
</div>
<SCRIPT language="JavaScript1.2"> 

if(getOs()=='Firefox')
{
	allSitUpdate = document.getElementById("allSitUpdate");
	allSitePublish = document.getElementById("allSitePublish");
	
	refeshIndex=document.getElementById("refeshIndex");
	newDoc=document.getElementById("newDoc");
	nodeUpdate=document.getElementById("nodeUpdate");
	nodePublsh=document.getElementById("nodePublsh");
	viewIndex=document.getElementById("viewIndex"); 
	parmaSet=document.getElementById("parmaSet"); 
}
</script>

<pp:elseif expr="$type=='system'">
 当前位置:<span id="weizi">系统设置</span>
 <div id="tabs">
	<ul>
		<li><a href="#tabs-1">系统设置</a></li>
	</ul>
	<div id="tabs-1">
		<div id="publishDefaultNode"></div>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=listFieldConfig')]" target="mainFrame">字段配置管理</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=listContentPlan')]" target="mainFrame">内容编辑方案</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=listAction')]" target="mainFrame">动作配置管理</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=workFlowAction')]" target="mainFrame">工作流动作</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=workFlowStep')]" target="mainFrame">工作流步骤</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=workFlow')]" target="mainFrame">工作流配置</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=publishPsnSet')]" target="mainFrame">发布点(PSN)管理</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=modelVarSet')]" target="mainFrame">模板变量管理</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=seoSet')]" target="mainFrame">SEO设置</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=backup')]" target="mainFrame">数据备份/优化</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=restore')]" target="mainFrame">数据恢复</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=importNode')]" target="mainFrame">结点导入</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=exportNode')]" target="mainFrame">结点导出</a><br><br>
		<img src="skin/images/ip.gif">
			<a href="index.php[@encrypt_url('action=cms&method=cleanCache')]" target="mainFrame">清除缓存</a><br><br>
	</div>
 </div>
 </pp:if> 
  </body>
  <script>
document.body.onclick = hideRightMenu;   
</script>
 </html>