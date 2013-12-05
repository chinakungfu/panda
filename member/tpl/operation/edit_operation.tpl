<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOCOSO</title>
<pp:include file="check_login.tpl" type="tpl"/>
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
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<script type="text/javascript" language="JavaScript">
/**
对radio默认选中的操作
**/
function radioIsSelected(radioId,radioValue) { 
	var i,myObj;
	myObj=document.getElementsByName(radioId);
	for(i=0;i<myObj.length;i++)
	{
		if(myObj[i].value == radioValue)
		{
			myObj[i].checked = true;
			break;
		}
	}
} 
function fullOperationFlag(value)
{
	call_tpl('member','fullOperationFlag','backGetData(\'operationNo\')','return',value,'');
}
</script>
<body>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 修改操作设置</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

<form method="post" action="index.php" onSubmit="return Validator.Validate(this,1)">
<input type="hidden" name="action" value="operation">
<pp:if expr="$method=='beginInsert'">
	<input type="hidden" name="method" value="saveInsert">
<pp:else/>
<pp:var name="operation" value="<pp:memfunc funcname="getOperationInfoById($operationId)"/>"/>
	<input type="hidden" name="method" value="saveEdit">
</pp:if>
<pp:if expr="$method=='beginInsert'">
	<input type="hidden" class="edit" name="operationId" value="">
<pp:else/>
	<input type="hidden" class="edit" name="operationId" value="[$operation.0.operationId]">
</pp:if>
<div class="detailMember_nav">
     
       <pp:if expr="$method=='beginInsert'">
        新增操作设置
        <pp:else/>
        修改操作设置
        </pp:if> 
        </div>
        <div class="detailMember_txt">操作名称：</div>
        <div class="detailMember_info">       
       <pp:if expr="$method=='beginInsert'">
        	<input type="text" class="edit" name="para[operationName]" value="" onblur="fullOperationFlag(this.value);" dataType="Require" msg="操作名称不能为空！！">
        <pp:else/>
        	<input type="text" class="edit" name="para[operationName]" value="[$operation.0.operationName]" dataType="Require" msg="操作名称不能为空！！">
        </pp:if>
		</div>
        <div class="detailMember_txt">操作标识：</div>
            <div class="detailMember_info">
          <pp:if expr="$method=='beginInsert'">
          	<input type="text" class="edit" name="para[operationNo]" id="operationNo" value="" dataType="Require" msg="操作编号不能为空！！">
          <pp:else/>
         	<input type="text" class="edit" name="para[operationNo]" id="operationNo" value="[$operation.0.operationNo]" readonly dataType="Require" msg="操作编号不能为空！！">
          </pp:if>
             </div>
        <div class="detailMember_txt">应用编号：</div>
            <div class="detailMember_info">
            <pp:if expr="$method=='beginInsert'">
            	<input type="text" class="edit" name="para[appId]" value="" dataType="Require" msg="应用编号不能为空！！"><span id="__ErrorMessagePanel"></span>
            <pp:else/>
            	<input type="text" class="edit" name="para[appId]" value="[$operation.0.appId]" dataType="Require" msg="应用编号不能为空！！"><span id="__ErrorMessagePanel"></span>
            </pp:if>
            </div>
        <div class="detailMember_txt">模块编号：</div>
            <div class="detailMember_info">
        <pp:if expr="$method=='beginInsert'">
        	<input type="text" class="edit" name="para[moduleId]" value="" dataType="Require" msg="模块编号不能为空！！">
        <pp:else/>
        	<input type="text" class="edit" name="para[moduleId]" value="[$operation.0.appId]" dataType="Require" msg="模块编号不能为空！！">
        </pp:if>
			</div>
                 
          <div class="detailMember_txt">动作编号：</div>
          	<div class="detailMember_info">        
	        <pp:if expr="$method=='beginInsert'">
	        <input type="text" class="edit" name="para[actionId]" value="" dataType="Require" msg="动作编号不能为空！！">
	        <pp:else/>
	        <input type="text" class="edit" name="para[actionId]" value="[$operation.0.actionId]" dataType="Require" msg="动作编号不能为空！！">
	        </pp:if>
	        </div>
          <div class="detailMember_txt">内容标识：</div>
          	<div class="detailMember_info">  
	         <pp:if expr="$method=='beginInsert'">
	        <input type="text" class="edit" name="para[contentFlag]" value="" dataType="Require" msg="内容标识不能为空！！">
	        <pp:else/>
	        <input type="text" class="edit" name="para[contentFlag]" value="[$operation.0.contentFlag]" dataType="Require" msg="内容标识不能为空！！">
	        </pp:if>  
	        </div> 
        <div class="detailMember_txt">级别标识：</div>
                <div class="detailMember_info">  
         <pp:if expr="$method=='beginInsert'">
        <input type="text" class="edit" name="para[distinctionNo]" value="" dataType="Require" msg="级别标识不能为空！！">
        <pp:else/>
        <input type="text" class="edit" name="para[distinctionNo]" value="[$operation.0.distinctionNo]" dataType="Require" msg="级别标识不能为空！！">
        </pp:if>  
        </div>  
        <div class="detailMember_txt">是否二级权限：</div>  
            <input type="radio" id="isSecondAuth" name="para[isSecondAuth]" value="0">否
            <input type="radio" id="isSecondAuth" name="para[isSecondAuth]" value="1">是 
        <div class="detailMember_txt">备注：</div>
        	<div class="detailMember_info">
        		<textarea name="para[remark]" id="remark" cols="24">[$operation.0.remark]</textarea>                
			</div>
    <div class="">
    	<input type="submit" value="保存" /><input type="button" value="取消" class="button" onClick="window.history.back();">
    </div>
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
<script>
radioIsSelected('distinctionNo','[$operation.0.distinctionNo]');
</script>
</body>
</html>
