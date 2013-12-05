<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
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
<pp:if expr="$method=='addModelVar'">
<input type="hidden" name="method" value="saveAddModelVar">
<input type="hidden" class="edit" name="varId" value="">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>模板变量设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<pp:else/>
<pp:var name="modelVar" value="@getModelVarInfoById($varId)"/>
<input type="hidden" name="method" value="saveEditModelVar">
<input type="hidden" class="edit" name="varId" value="[$modelVar.0.varId]" >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>模板变量设置</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
</pp:if>        	
			<div class="detailMember_txt">变量标识：</div>
			<div class="detailMember_info"><input type="text" id="varTitle" name="para[varTitle]" value="[$modelVar.0.varTitle]"></div>
			<div class="detailMember_txt">变量名：</div>
			<div class="detailMember_info"><input type="text" id="varName" name="para[varName]" value="[$modelVar.0.varName]"></div>
			<div class="detailMember_txt">变量值：</div>
			<div class="detailMember_info"><input type="text" id="varValue" name="para[varValue]" value="[$modelVar.0.varValue]"></div>
			<div class="detailMember_txt">是否全局变量：</div>
			<input type="radio" name="param[isGlobal]" value="1">是
			<input type="radio" name="param[isGlobal]" value="0">否
			</div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
