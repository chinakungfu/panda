<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>静态文件格式</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
</head>

<body>

<form method="post" action="index.php" id="form1">
	&nbsp;&nbsp;<input type="button" value="内容ID" onclick="getMacroVar('tableKeyName')"/>
	<input type="button" value="结点ID" onclick="getMacroVar('nodeId')"/>
	<input type="button" value="发布日期时间" onclick="getMacroVar('TimeStamp')"/>
	<div class="detailMember_info">
	&nbsp;&nbsp;<textarea name="fileFormat" id="fileFormat" cols="30" rows="5"><?php echo $this->_tpl_vars["IN"]["publishFileFormat"];?></textarea>
	</div>	
	<div class="detailMember_doedit">
	&nbsp;&nbsp;<input type="button" value="确定" onclick="getFileFormat('<?php echo $this->_tpl_vars["IN"]["backId"];?>')"/>
	<input type="button" value="取消" class="button" onClick="window.close();">
	</div>
</form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
