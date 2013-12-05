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
<pp:if expr="$method=='addAction'">
<input type="hidden" name="method" value="saveAddAction">
<input type="hidden" class="edit" name="actionId" value="">
<input type="hidden" class="edit" name="para[contentPlanId]" value="[$contentPlanId]">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>内容编辑方案>>新建动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<pp:else/>
<pp:var name="actionR" value="<pp:memfunc funcname="getActionInfoById($actionId)"/>"/>
<input type="hidden" name="method" value="saveEditAction">
<input type="hidden" class="edit" name="actionId" value="[$actionR.0.actionId]" >
<input type="hidden" class="edit" name="para[contentPlanId]" value="[$actionR.0.contentPlanId]">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>内容编辑方案>>修改动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
</pp:if>        
		<div class="detailMember_nav">新建动作</div>
		
			<div class="detailMember_txt">动作标题：</div>
			<div class="detailMember_info"><input type="text" id="actionTitle" name="para[actionTitle]" value="[$actionR.0.actionTitle]">
			<div class="detailMember_txt">动作名称：</div>
			<div class="detailMember_info"><input type="text" id="actionName" name="para[actionName]" value="[$actionR.0.actionName]">
			<select name="ActionName" onchange="changeSelect(this.name,this.value);">
			<option value=""></option>
			[@getActionInfo()]
			</select></div>
			<div class="detailMember_txt">方法名称：</div>
			<div class="detailMember_info"><input type="text" id="methodName" name="para[methodName]" value="[$actionR.0.methodName]">
			<select name="methodName" onchange="changeSelect(this.name,this.value);">
			<option value=""></option>
			[@getMethodInfo()]
			</select></div>
			<div class="detailMember_txt">入口路径：</div>
			<div class="detailMember_info"><input type="text" id="tplPath" name="para[tplPath]" value="[$actionR.0.tplPath]">如：http://domain/.../index.php</div>
			<div class="detailMember_txt">路径参数：</div>
			<div class="detailMember_info"><input type="text" id="pathParams" name="para[pathParams]" value="[$actionR.0.pathParams]">参数值为字段的值要写成写成[fieldName],如：paramName1=[fieldName1],paramName2=paramValue2...</div>
			<div class="detailMember_txt">动作说明：</div>
			<div class="detailMember_info"><input type="text" id="actionDes" name="para[actionDes]" value="[$actionR.0.actionDes]"></div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </form>     
    </div>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
