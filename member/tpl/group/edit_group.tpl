<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改用户组设置</title>
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
function submitdata()
{
	document.forms[0].submit();
}
function fullGroupFlag(value)
{
	call_tpl('member','fullGroupFlag','backGetData(\'groupNo\')','return',value,'');
}
</script>
</head>

<body>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >> 修改用户组设置</div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

<form method="post" action="index.php" onSubmit="return Validator.Validate(this,1)">
<input type="hidden" name="action" value="group">
<pp:if expr="$method=='beginInsert'">
<input type="hidden" name="method" value="saveInsert">
<pp:else/>
<pp:var name="group" value="<pp:memfunc funcname="getGroupInfoById($groupId)"/>"/>
<input type="hidden" name="method" value="saveEdit">
</pp:if>
<pp:if expr="$method=='beginInsert'">
                <input type="hidden" class="edit" name="groupId" value="">
                <pp:else/>
                <input type="hidden" class="edit" name="groupId" value="[$group.0.groupId]">
                </pp:if>

<div class="detailMember_nav">
     
        <pp:if expr="$method=='beginInsert'">
        新增用户组设置
        <pp:else/>
        修改用户组设置
        </pp:if>
        
        </div>
        		<div class="detailMember_txt">用户组名称：</div>
                    <div class="detailMember_info">
                
                <pp:if expr="$method=='beginInsert'">
                	<input type="text" class="edit" name="para[groupName]" value="" onblur="fullGroupFlag(this.value);" dataType="Require" msg="用户组名称不能为空！！">
                <pp:else/>
                	<input type="text" class="edit" name="para[groupName]" value="[$group.0.groupName]" dataType="Require" msg="用户组名称不能为空！！">
                </pp:if>
                </div>
        
                <div class="detailMember_txt">用户组标识：</div>
                    <div class="detailMember_info">      
				<pp:if expr="$method=='beginInsert'">
                	<input type="text" class="edit" id="groupNo" name="para[groupNo]" value=""  dataType="Require" msg="组编号不能为空！！">
                <pp:else/>
                	<input type="text" class="edit" id="groupNo" name="para[groupNo]" value="[$group.0.groupNo]" readonly dataType="Require" msg="组编号不能为空！！">
                </pp:if>                
                </div>
          
                <div class="detailMember_txt">用户组描述：</div>
                        <div class="detailMember_info">   
				<pp:if expr="$method=='beginInsert'">
					<input type="text" class="edit" name="para[remark]" value="" dataType="Require" msg="用户组描述不能为空！！">
				<pp:else/>
					<input type="text" class="edit" name="para[remark]" value="[$group.0.remark]" dataType="Require" msg="用户组描述不能为空！！">
				</pp:if>
			</div>            
    <div class=""><input type="submit" value="保存"  onSubmit="return Validator.Validate(this,1)"/><input type="button" value="取消" class="button" onClick="window.history.back();"></div>
    </div>
    </form>
  <br />
  <div style="clear:both"></div>
  <div class="copyright"></div>
    </div>
</body>
</html>
