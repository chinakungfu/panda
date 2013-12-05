<html>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
var ajax = new Ajax( "POST", "index.php", false, true );
function submitdata()
{
	document.forms[0].submit();
}
function selectAppValue(value)
{
	document.forms[0].appid.value=value;
	document.forms[0].fileFolder.value = value+'/';
}
function selectTypeValue(value)
{
	if(document.forms[0].appid.value=='')
	{
		alert("没有选择所属应用！");
	}else
	{
		document.forms[0].resourcetype.value=value;
		document.forms[0].fileFolder.value += value+'/';
	}
}
function call_method()
{
	ajax.callMethod('Resource','checkNo',call_method.arguments,"testdata()")
}
function call_tpl()
{
	ajax.callMethod('Resource','checkdata',call_tpl.arguments,"testdata()")
}
function testdata(response)
{
	alert(response);
}

function setPath(value)
{
	if(document.forms[0].fileFolder.value!='')
	{
		if(value!='自定义目录')
		{
			var str = "/";
			var fileFolderStr = document.forms[0].fileFolder.value;
			fileFolderStr = fileFolderStr+value;
			var startLen = fileFolderStr.length;
			var start = fileFolderStr.indexOf(str,fileFolderStr);
			var secendStr = fileFolderStr.substr(start+1);
			var secend = secendStr.indexOf(str,secendStr);
			var secentLen = secendStr.length;
			if(secend>0)
			{
				var lastStr = secendStr.replace(secendStr.substring(secend+1,secentLen),value);
				document.forms[0].fileFolder.value = fileFolderStr.replace(fileFolderStr.substring(start+1,startLen),lastStr);
				document.forms[0].fileFolder.readOnly = true;
			}else
			{
				document.forms[0].fileFolder.value = document.forms[0].fileFolder.value+'';
				document.forms[0].fileFolder.readOnly = true;
			}
		}else
		{
			document.forms[0].fileFolder.value = document.forms[0].fileFolder.value+'';
			document.forms[0].fileFolder.readOnly = false;
		}
	}else
	{
		alert("请选择资源类型！");
	}
} 
//-->
</script>
<title>
添加资源设置
</title>
</head>
<body bgcolor="#ffffff">
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="resource">
<input type="hidden" name="method" value="saveResource">
<input type="hidden" class="edit" name="resourceId" value="">
<input type="hidden" class="edit" name="resourcetype">
<input type="hidden" class="edit" name="appid">
 <table width="100%" class="tableTitle"/>
      <tr>
        <td class="tdTitle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
        新增资源设置
        </TD>
      </tr>
    </table>
<table class="editTable" id="edit" align="center">
<tr>
	   
		<td class="editHeader">资源名称</td>
                <td class="editHeader">
                <input type="text" class="edit" name="para[resourceName]" value="">
                <input type="button" value="检查" class="button" onclick="call_tpl(document.forms[0].ResourceId.value,document.forms[0].ResourceNo.value,'[$method]');">
                </td>
        </tr>
        <td class="editHeader">所属应用</td>
                 <td class="editHeader">
                <pp:echomemfunc funcname="selectResourceApp()"/>
                </td>
                </td>
        </tr>
        <td class="editHeader">资源类型</td>
                 <td class="editHeader">
                <pp:echomemfunc funcname="selectResourceType()"/>
                <pp:echomemfunc funcname="selectDateUrl()"/>
                </td>
                </td>
        </tr>
        <td class="editHeader">存放资源位置</td>
                <td class="editHeader">
                <input type="text" class="edit" name="fileFolder" value="" readOnly>
                </td>
        </tr>
        <td class="editHeader">存放服务器</td>
                <td class="editHeader">
                <pp:echomemfunc funcname="serverSelect()"/>
                </td>
        </tr>
	<tr>
	   
		<td class="editHeader">资源描述</td>
                <td class="editHeader">
                <input type="text" class="edit" name="para[resourceDis]" value="">
                </td>
        </tr>
        <tr>	   
		<td class="editHeader">资源文件</td>
                <td class="editHeader">
                <input type="file" class="edit" name="resourceUrl" value="">         
                </td>
        </tr>
        <tr>
  	<TD></TD>
		<td><input type="button" value="保存" class="button" onclick="submitdata();"><input type="button" value="取消" class="button" onclick="window.history.back();"></td>

         </tr>
</table>
</form>
</body>
</html>
