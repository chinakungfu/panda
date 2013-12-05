<?php import('core.util.RunFunc'); ?>﻿<html>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" language="JavaScript">

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
                <input type="button" value="检查" class="button" onclick="call_tpl(document.forms[0].ResourceId.value,document.forms[0].ResourceNo.value,'<?php echo $this->_tpl_vars["method"];?>');">
                </td>
        </tr>
        <td class="editHeader">所属应用</td>
                 <td class="editHeader">
                <?php echo runFunc('selectResourceApp',array());?>
                </td>
                </td>
        </tr>
        <td class="editHeader">资源类型</td>
                 <td class="editHeader">
                <?php echo runFunc('selectResourceType',array());?>
                <?php echo runFunc('selectDateUrl',array());?>
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
                <?php echo runFunc('serverSelect',array());?>
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
