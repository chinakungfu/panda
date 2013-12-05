<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用ＣＭＳ</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/cms.css" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/dtree.css" />
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/prototype.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/utf.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/base64.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phpserializer.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/powmod.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/xxtea.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/bigint.js"></script>
<script type="text/javascript" src="skin/jsfiles/phprpc/phprpc_client.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script language="javascript" src="skin/jsfiles/dtree.js"></script>
</head>
<body>

<form method="post" action="index.php"  id="form1">

<input type="hidden" name="action" value="cms">
<input type="hidden" name="method" value="saveNodeUpdate">
<input type="hidden" class="edit" name="nodeId" value="<?php echo $this->_tpl_vars["nodeId"];?>">
<input type="hidden" class="edit" name="allSit" value="<?php echo $this->_tpl_vars["allSit"];?>">
		<div class="detailMember_nav">更新内容</div>
			<input type='checkbox' id="index" name='para[index]' value="index" checked>首页<br>
			<input type='checkbox' id="contentPage" name='para[contentPage]' value="contentPage"checked>内容页<br>
			<input type='checkbox' id="addPublish" name='para[extraPublish]' value="extraPublish" checked>其它附加发布<br>
		<div class="detailMember_nav">更新选项</div>
			<input type='checkbox' id="subNode" name='subNode' value="subNode">更新子结点<br>
			单次循环更新内容页数
			<input type='text' id="counter" name='counter' value="10">
    <div class="detailMember_doedit"><input type="submit" value="开始更新" /><input type="button" value="取消" class="button" onClick="window.close();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
