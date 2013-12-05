<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
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
<style>
body {font:normal 12px 宋体}
a.MzTreeview /* TreeView 链接的基本样式 */ { cursor: hand; color: #000080; margin-top: 5px; padding: 2 1 0 2; text-decoration: none; }
.MzTreeview a.select /* TreeView 链接被选中时的样式 */ { color: highlighttext; background-color: highlight; }
#kkk input {
vertical-align:middle;
}
.MzTreeViewRow {border:none;width:500px;padding:0px;margin:0px;border-collapse:collapse}
.MzTreeViewCell0 {border-bottom:1px solid #CCCCCC;padding:0px;margin:0px;}
.MzTreeViewCell1 {border-bottom:1px solid #CCCCCC;border-left:1px solid #CCCCCC;width:200px;padding:0px;margin:0px;}
</style>
<script>
function submitData()
{
	//checkBox();
	showsel()
	document.forms[0].submit();
}
function showsel()
	{
		var es=document.getElementsByName("sel");
		var out="";
		for(var i=0;i<es.length;i++)
		{
			if (es[i].checked) out+=es[i].value+",";
		}
		document.getElementById('multNodeId').value = out;
	}
</script>
<body>
<pp:if expr="$IN.multNodeId!=null">
<pp:var name="xmlFile" value="@exportNode($IN.multNodeId)"/>
<!--文件已导出到[$xmlFile]-->
</pp:if>
<form method="post" action="index.php" id="form1">
	<input type="hidden" name="action" value="cms">
	<input type="hidden" name="method" value="exportNode">
	<div class="main_content">
	<div class="main_content_nav">当前位置：系统管理>>系统管理>>结点导出</div>
	<div style="clear:both"></div>
	<div id="exportNode"></div>
	[@exportListNode()]
	<div class="detailMember_doedit">
	<input type="submit" value="导出" onclick="submitData();" />
	</div>
	<input type="hidden" name="multNodeId" id="multNodeId" value=""/>
</form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
