<html>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<head>
<title>选择操作</title>
</head>
<body>
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='group'>
	<input type='hidden' name='method' value='saveOperation'>
	<div class="main_content">
	   	<div class="main_content_nav">
	   	<pp:if expr="$type=='group'">
	   	<pp:var name="group" value="<pp:memfunc funcname="getGroupInfoById($groupId)"/>"/>
	   	<input type="hidden" name="type" value="group">
	   	<input type="hidden" id="groupNo" name="groupNo" value="[$group.0.groupNo]">
	   	给用户组『
	        [$group.0.groupName]
	        』绑定角色
	  	<pp:else/>     
	  	<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoById($staffId)"/>"/>
	  	<input type="hidden" name="type" value="staff">
	  	<input type="hidden" id="staffNo" name="staffNo" value="[$staff.0.staffNo]">
	    给用户『
	        [$staff.0.staffName]
	        』绑定角色
	   </pp:if></div>
	   	<div style="clear:both"></div>
		<div class="search_content detailMember">
			<pp:var name="role" value="<pp:memfunc funcname="listRole($sqlCon,'1')"/>"/>
			 <loop name="role"  var="var" key="key">
				 <pp:if expr="$type=='group'">
				 <pp:var name="judge" value="<pp:memfunc funcname="checkRole($group.0.groupNo,$var.roleNo,'0')"/>"/>
				 <pp:else/>
				 <pp:var name="judge" value="<pp:memfunc funcname="checkRole($staff.0.staffNo,$var.roleNo,'1')"/>"/>
				 </pp:if>
				 <pp:if expr="$judge">
				 <input type="checkbox" name="index[]" value="[$var.roleNo]" checked>[$var.roleName]<br>
				 <pp:else/>
				 <input type="checkbox" name="index[]" value="[$var.roleNo]">[$var.roleName]<br>
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
