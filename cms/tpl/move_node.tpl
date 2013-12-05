<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="prototype.js"></script>
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
</head>
<script>
function submitData(value)
{
	if(value=='1')
	{
		showsel('baseNodeId');
	}else
	{
		showsel('parentId');
	}
	document.forms[0].submit();
}
function showsel(returnId)
{
	var es=document.getElementsByName("sel");
	var out="";
	for(var i=0;i<es.length;i++)
	{
		if (es[i].checked) out = es[i].value;
	}
	document.getElementById(returnId).value = out;
}
</script>
<body leftmargin="50" topmargin="20">
<form method="post" action="index.php">
<input type="hidden" name="action" value="cms">
<pp:if expr="$method=='moveNode'">
	<input type="hidden" name="method" value="saveMoveNode">
	<input type="hidden" class="edit" name="nodeId" id="nodeId" value="[$nodeId]" >
	<input type="hidden" class="edit" name="parentId" id="parentId" value="" >
	<div id="nodeList">    
	</div> 
	[@selectListNode()]
	<input type="submit" value="保存" onclick="submitData('0');" />
	<input type="button" value="取消" class="button" onClick="window.close();">
<pp:elseif expr="$method=='nodeBase'">
	<input type="hidden" name="method" value="saveNodeBase">
	<input type="hidden" class="edit" name="nodeId" id="nodeId" value="[$nodeId]" >
	<input type="hidden" class="edit" name="baseNodeId" id="baseNodeId" value="" >
	<div id="nodeList">    
	</div> 
	[@selectListNode()]
	<input type="submit" value="保存" onclick="submitData('1');" />
	<input type="button" value="取消" class="button" onClick="window.close();">
<pp:elseif expr="$method=='copy'">
	<input type="hidden" name="method" value="saveCopy">
	<input type="hidden" class="edit" name="appTableKeyName" id="appTableKeyName" value="[$appTableKeyName]" >
	<input type="hidden" class="edit" name="contentModel" id="contentModel" value="[$contentModel]" >
	<input type="hidden" class="edit" name="selectConId" id="selectConId" value="[$selectConId]" >
	<input type="hidden" class="edit" name="nodeId" id="nodeId" value="[$nodeId]" >
	<input type="hidden" class="edit" name="parentId" id="parentId" value="" >
	<div id="nodeList">    
	</div> 
	[@selectListNode()]
	<input type="submit" value="保存" onclick="submitData('2');" />
	<input type="button" value="取消" class="button" onClick="window.close();">
<pp:elseif expr="$method=='move'">
	<input type="hidden" name="method" value="saveMove">
	<input type="hidden" class="edit" name="appTableKeyName" id="appTableKeyName" value="[$appTableKeyName]" >
	<input type="hidden" class="edit" name="contentModel" id="contentModel" value="[$contentModel]" >
	<input type="hidden" class="edit" name="selectConId" id="selectConId" value="[$selectConId]" >
	<input type="hidden" class="edit" name="nodeId" id="nodeId" value="[$nodeId]" >
	<input type="hidden" class="edit" name="parentId" id="parentId" value="" >
	<div id="nodeList">    
	</div> 
	[@selectListNode()]
	<input type="submit" value="保存" onclick="submitData('3');" />
	<input type="button" value="取消" class="button" onClick="window.close();">
</pp:if>
</form>
 </body>
 </html>