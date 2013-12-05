<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源管理</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" language="JavaScript">
function addfile(){
	var str='<input type="file" id="fileId" class="edit" name="resourceUrl[]" value="">';         
	var tableObj = document.getElementById("edit");
	var insertTrData = tableObj.insertRow(-1).insertCell(-1);
	insertTrData.className="editHeader";
	insertTrData.innerHTML = str;
}
</script>
<body>
<div class="main_content">
<div class="main_content_nav">后台管理系统 >> 上传多文件</div>
<div style="clear:both"></div> 
<br />
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="action" value="resource">
<input type="hidden" name="method" value="saveMultFiles">
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
	<td class="editHeader">
		<input type="button"  value="增行"  onclick="addfile()"/>      
	</td>
</tr>
<tr>
	<td class="editHeader">
		<input type="file" id="fileId" class="edit" name="resourceUrl[]" value="">         
	</td>
</tr>
</table>
<table align="center" cellpadding="5" class="editTable">
        <tr>
  	<TD></TD>
		<td><div class="detailMember_doedit"><input type="submit" value="上传" class="button"><input type="button" value="取消" class="button" onClick="window.close();"></div></td>

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
