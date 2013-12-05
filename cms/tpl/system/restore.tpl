<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<pp:include file="check_login.tpl" type="tpl"/>-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script>
function submitData()
{
	var serverfileObj = document.getElementById('serverfile');
	if(serverfileObj.value!='')
	{
		document.forms[0].submit();
	}else
	{
		alert('您没有选择要恢复的文件！');
		return false;
	}
}

</script>
</head>

<body>

<form method="post" action="index.php" enctype="multipart/form-data">

<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveRestore">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>数据恢复</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">       	
			<!--<div class="detailMember_txt">备份方式：</div>
			<div class="detailMember_info"><input type="text" id="varTitle" name="para[varTitle]" value="[$modelVar.0.varTitle]"></div>
			<div class="detailMember_txt">变量名：</div>
			<div class="detailMember_info"><input type="text" id="varName" name="para[varName]" value="[$modelVar.0.varName]"></div>
			<div class="detailMember_txt">变量值：</div>
			<div class="detailMember_info"><input type="text" id="varValue" name="para[varValue]" value="[$modelVar.0.varValue]"></div>-->
			<div class="detailMember_txt">选择还原版本：</div>
<!--			<input type="radio" name="para[backupModel]" value="0">从本地文件恢复
			<input type="hidden" name="MAX_FILE_SIZE" value="1500000"><input type="file" name="myfile" id="myfile">
			<input type="radio" name="para[backupModel]" value="1" checked>从服务器文件恢复-->
			<select name="para[serverfile]" id="serverfile">
			<option value="">-请选择-</option>
			[@getBackupDataFile()]
			</select>
			</div>
			<!--<div class="detailMember_txt">选择目标位置：</div>
			<input type="radio" name="para[postion]" value="0">备份到服务器
			<input type="radio" name="para[postion]" value="1">备份到本地
			</div>-->
    <div class="detailMember_doedit"><input type="button" value="恢复" onclick="submitData();" /></div>
         
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
