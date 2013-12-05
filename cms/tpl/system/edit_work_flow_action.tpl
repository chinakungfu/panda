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
<pp:if expr="$method=='addWorkFlowAction'">
<input type="hidden" name="method" value="saveAddWorkFlowAction">
<input type="hidden" class="edit" name="flowActionId" value="">
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>新增工作流动作动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
<pp:else/>
<pp:var name="workFlowAction" value="@getWorkFlowActionInfoById($flowActionId)"/>
<input type="hidden" name="method" value="saveEditWorkFlowAction">
<input type="hidden" class="edit" name="flowActionId" value="[$workFlowAction.0.flowActionId]" >
<div class="main_content">
   	<div class="main_content_nav">当前位置：系统管理>>系统管理>>修改工作流动作</div>
   	<div style="clear:both"></div>
<div class="search_content detailMember">
</pp:if>        	
			<div class="detailMember_txt">工作流动作名称：</div>
			<div class="detailMember_info">
				<input type="text" id="flowActionName" name="para[flowActionName]" value="[$workFlowAction.0.flowActionName]">
			</div>
			<!--<div class="detailMember_txt">工作流动作标识：</div>
			<div class="detailMember_info">
				<input type="text" id="flowActionGuid" name="para[flowActionGuid]" value="[$workFlowAction.0.flowActionGuid]">
			</div>-->
			<div class="detailMember_txt">工作流动作说明：</div>
			<div class="detailMember_info">
				<textarea id="flowActionRemark" name="para[flowActionRemark]" value="">[$workFlowAction.0.flowActionRemark]</textarea>
			</div>
    <div class="detailMember_doedit">
    <input type="submit" value="保存" />
    <input type="button" value="取消" class="button" onClick="window.history.back();">
       
    </div>  
    
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
