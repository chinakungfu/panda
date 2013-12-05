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
function submitdata()
{
	document.forms[0].submit();
}

function changeRoleNo()
{
	var roleNoText = document.getElementById("roleNom");
	var roleToValue = roleNoText.value;
	document.forms[0].roleNo.value = roleToValue;
}
function fullRoleFlag(value)
{
	call_tpl('member','fullRoleFlag','backGetData(\'roleNo\')','return',value,'');
}
</script>
</head>

<body>
<div class="main_content">
   	<div class="main_content_nav">后台管理系统 >>         
   	<pp:if expr="$method=='beginInsert'">
        新增角色设置
        <pp:else/>
        修改角色设置
        </pp:if></div>
   	<div style="clear:both"></div>
        


<div class="search_content detailMember">

<form method="post" action="index.php" onSubmit="return Validator.Validate(this,1)">
<input type="hidden" name="action" value="role">
<input type="hidden" name="roleNo" value="">
<pp:if expr="$method=='beginInsert'">
<input type="hidden" name="method" value="saveInsert">
<pp:else/>
<pp:var name="role" value="<pp:memfunc funcname="getRoleInfoById($roleId)"/>"/>
<input type="hidden" name="method" value="saveEdit">
</pp:if>
<pp:if expr="$method=='beginInsert'">
                <input type="hidden" class="edit" name="roleId" value="">
                <pp:else/>
                <input type="hidden" class="edit" name="roleId" value="[$role.0.roleId]">
                </pp:if>

    	<div class="detailMember_nav">
      
        <pp:if expr="$method=='beginInsert'">
        新增角色设置
        <pp:else/>
        修改角色设置
        </pp:if>
        
        </div>
                <div class="detailMember_txt">角色名称：</div>
                    <div class="detailMember_info">
               <pp:if expr="$method=='beginInsert'">
                	<input type="text" class="edit" name="para[roleName]" value="" onblur="fullRoleFlag(this.value);" dataType="Require" msg="角色名称不能为空！！">
                <pp:else/>
                	<input type="text" class="edit" name="para[roleName]" value="[$role.0.roleName]" readonly dataType="Require" msg="角色名称不能为空！！">
                </pp:if>
                	</div>
                	
	            <div class="detailMember_txt">角色标识：</div>
	                <div class="detailMember_info">
                <pp:if expr="$method=='beginInsert'">
                	<input type="text" id="roleNo" class="edit" name="para[roleNo]" value="" dataType="Require" msg="角色编号不能为空！！">
                <pp:else/>
                	<input type="text" id="roleNo" class="edit" name="para[roleNo]" readonly value="[$role.0.roleNo]" dataType="Require" msg="角色编号不能为空！！">
                </pp:if>
                </div>
                
                <div class="detailMember_txt">角色描述：</div>
                	<div class="detailMember_info">
    			<pp:if expr="$method=='beginInsert'">
					<input type="text" class="edit" name="para[roleDesc]" value="" dataType="Require" msg="角色描述不能为空！！">
				<pp:else/>
					<input type="text" class="edit" name="para[roleDesc]" value="[$role.0.roleDesc]" dataType="Require" msg="角色描述不能为空！！">
				</pp:if>
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
</body>
</html>
