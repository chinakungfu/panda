<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<pp:include file="check_login.tpl" type="tpl"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title> 
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
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
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<script>
function fullActionFlag(value)
{
	call_tpl("cms","fullActionFlag","backGetData('actionGuid')","return",value,"");
}
</script>
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
<div class="detailMember_nav">新建动作</div>
<pp:else/>
<pp:var name="actionR" value="@getActionInfoById($actionId)"/>
<input type="hidden" name="method" value="saveEditAction">
<input type="hidden" class="edit" name="actionId" value="[$actionR.0.actionId]" >
<input type="hidden" class="edit" name="para[contentPlanId]" value="[$actionR.0.contentPlanId]">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>内容编辑方案>>修改动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<div class="detailMember_nav">修改动作</div>
</pp:if>        
		
		
			<div class="detailMember_txt">动作标题：</div>
			<div class="detailMember_info">
			<pp:if expr="$method=='addAction'">
				<input type="text" id="actionTitle" name="para[actionTitle]" value="[$actionR.0.actionTitle]"  onblur="fullActionFlag(this.value);">
			<pp:else/>
				<input type="text" id="actionTitle" name="para[actionTitle]" value="[$actionR.0.actionTitle]">
			</pp:if>
			<div class="detailMember_txt">动作标识：</div>
			<pp:if expr="$method=='addAction'">
				<div class="detailMember_info"><input type="text" id="actionGuid" name="para[actionGuid]" value="[$actionR.0.actionGuid]">
			<pp:else/>
				<div class="detailMember_info"><input type="text" id="actionGuid" name="para[actionGuid]" value="[$actionR.0.actionGuid]" disabled>
			</pp:if>
			<div class="detailMember_txt">动作名称：</div>
			<div class="detailMember_info"><input type="text" id="actionName" name="para[actionName]" value="[$actionR.0.actionName]">
			<select name="actionName" onchange="changeSelect(this.name,this.value);">
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
			<div class="detailMember_txt">动作去向：</div>
			<div class="detailMember_info">
			<select id="actionGoto" name="para[actionGoto]">
				<option value="1">当前窗口打开</option>
				<option value="2">父窗口打开</option>
				<option value="3">新窗口打开</option>
				<option value="4">弹出提示选择处理</option>
			</select></div>
			<div class="detailMember_txt">动作类型：</div>
			<div class="detailMember_info">
			<select id="actionType" name="para[actionType]">
				<option value="1">列表页动作</option>
				<option value="2">编辑页动作</option>
				<option value="3">其它页动作</option>
			</select>
			</div>
			<div class="detailMember_txt">动作说明：</div>
			<div class="detailMember_info"><input type="text" id="actionDes" name="para[actionDes]" value="[$actionR.0.actionDes]"></div>
    <div class="detailMember_doedit"><input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
         
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
<script>
jsSelectValue('actionType','[$actionR.0.actionType]');
jsSelectValue('actionGoto','[$actionR.0.actionGoto]');
</script>
</html>
