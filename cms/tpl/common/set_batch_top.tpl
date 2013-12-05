<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
</head>

<body>

<form method="post" action="index.php" id="form1">

<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="batchTop">

<input type="hidden" name="frameListAction" value="[$frameListAction]">
<input type="hidden" name="frameListMethod" value="[$frameListMethod]">
<input type="hidden" name="nodeId" value="[$nodeId]">
<input type="hidden" name="contentModel" value="[$contentModel]">
<input type="hidden" name="appTableKeyName" value="[$appTableKeyName]">
<input type="hidden" name="selectConId" value="[$selectConId]">
<div class="main_content">
   	<div class="main_content_nav">内容置顶设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">   
			<div class="detailMember_txt">置顶权重：</div>
			<div class="detailMember_info">
			<input type="text" id="top" name="para[top]" value="">
			</div>
    <div class="detailMember_doedit"><input type="submit" value="确定" /><input type="button" value="取消" class="button" onClick="window.close();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
