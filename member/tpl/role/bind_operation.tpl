<html>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<head>
<title>选择操作</title>
</head>
<body>
<pp:var name="role" value="<pp:memfunc funcname="getRoleInfoById($roleId)"/>"/>
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='role'>
	<input type='hidden' name='method' value='saveOperation'>
	<input type="hidden" id="roleNo" name="roleNo" value="[$role.0.roleNo]">
	<div class="main_content">
	   	<div class="main_content_nav">
	    给角色『
	    [$role.0.roleName]
	    』绑定操作
	    </div>
	    <div style="clear:both"></div>
		<div class="search_content detailMember">
		<pp:var name="operations" value="<pp:memfunc funcname="listOperation($sqlCon,'1')"/>"/>
		 <loop name="operations"  var="var" key="key">
		 <pp:var name="judge" value="<pp:memfunc funcname="checkOperation($role.0.roleNo,$var.operationNo)"/>"/>
		 <pp:if expr="$judge">
		 <pp:var name="seltype" value="1"/>
		 <input type="checkbox" name="operationId[]" value="[$var.operationNo]" checked>[$var.operationName]<br>
		 <pp:else/>
		 <pp:var name="seltype" value="0"/>
		 <input type="checkbox" name="operationId[]" value="[$var.operationNo]">[$var.operationName]<br>
		 </pp:if>
		</loop>
		</div>
		<div align="center">
			<input type="submit" name="submit" value="保存" align="middle" class="button1">
		</div>
	</div>
</form>
</body>
</html>
