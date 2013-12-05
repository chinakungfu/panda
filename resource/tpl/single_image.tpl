<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源管理</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>

<script type="text/javascript" language="JavaScript">
var ajax = new Ajax( "POST", "index.php", false, true );
function submitdata()
{
	document.forms[0].submit();
}
function getFileExt(obj)
{
    return obj.value.replace(/.+./,"");
}
function selValue(value)
{
	document.forms[0].resourcetype.value=value;
	document.forms[0].fileFolder.value = value+'/';
	//alert(document.forms[0].resourceType.value);
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
</script>
<body>
<div class="main_content">
<div class="main_content_nav">后台管理系统 >> 上传文件</div>
<div style="clear:both"></div> 
<br />
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="resource">
<input type="hidden" name="method" value="saveSingleImage">
<input type="hidden" name="resourceUrl" value="[$resourceUrl]">
<input type="hidden" class="edit" name="isText" value="[$isText]">
<input type="hidden" class="edit" name="isId" value="[$isId]">
<input type="hidden" class="edit" name="para[appid]" value="[$IN.appName]">
<input type="hidden" class="edit" name="prePath" value="[$IN.prePath]">
<input type="hidden" class="edit" name="para[resourceName]" value="">
<input type="hidden" class="edit" name="fileFolder" value="[$IN.appName]/[$IN.location]">
<input type="hidden" class="edit" name="para[serverName]" value="member">
<input type="hidden" class="edit" name="para[resourceDis]" value="">
<table align="center" cellpadding="5" class="editTable" id="edit">     
		<tr>	   
		<td class="editHeader"></td>
                <td class="editHeader">
               &nbsp;        
                </td>
        </tr>
        <tr>	   
		<td class="editHeader">文件</td>
                <td class="editHeader">
                <input type="file" id="fileId" class="edit" name="resourceUrl" value="">         
                </td>
        </tr>
        <tr>
  	<TD></TD>
		<td><div class="detailMember_doedit"><input type="button" value="上传" class="button" onClick="submitdata();"><input type="button" value="取消" class="button" onClick="window.close();"></div></td>

    </tr>
</table>
</form>
  <div style="clear:both"></div>
  <div class="copyright"></div>
</div>
<div class="detailMember_txt"></div>
</div>
</body>
</html>
