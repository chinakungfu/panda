<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
</head>
<body>
<?php runFunc('importNode',array())?>
<form method="post" action="index.php" id="form1" enctype="multipart/form-data">
	<input type="hidden" name="action" value="cms">
	<input type="hidden" name="method" value="importNode">
	<div class="main_content">
	<div class="main_content_nav">当前位置：系统管理>>系统管理>>结点导入</div>
	<div style="clear:both"></div>
	<div class="search_content detailMember">       	
	<div class="detailMember_txt">导入文件：</div>
	<div class="detailMember_info">
	<input type="file" id="importNodeFile" name="importNodeFile" value="">
	</div>
	<div class="detailMember_doedit">
	<input type="submit" value="导入"/>
	</div>
</form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
