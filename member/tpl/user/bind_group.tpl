<html>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:include file="check_login.tpl" type="tpl"/>
</head>
<body>
<pp:var name="staff" value="<pp:memfunc funcname="getStaffInfoById($staffId)"/>"/>
<form action="index.php" method="POST">  
	<input type='hidden' name='action' value='staff'>
	<input type='hidden' name='method' value='saveOperation'>
	<input type="hidden" id="staffNo" name="staffNo" value="[$staff.0.staffNo]">
	<div class="main_content">
	   	<div class="main_content_nav">
	   	给用户『
        [$staff.0.staffName]
        』绑定用户组
	   	</div>
	   	<div style="clear:both"></div>
		<div class="search_content detailMember">
		<pp:var name="group" value="<pp:memfunc funcname="listGroup($sqlCon,'1')"/>"/>
		<loop name="group"  var="var" key="key">
		<pp:var name="judge" value="<pp:memfunc funcname="checkGroup($staff.0.staffNo,$var.groupNo)"/>"/>
		<pp:if expr="$judge">
		<pp:var name="seltype" value="1"/>
		<input type="checkbox" name="index[]" value="[$var.groupNo]" checked>[$var.groupName]<br>
		<pp:else/>
		<pp:var name="seltype" value="0"/>
		<input type="checkbox" name="index[]" value="[$var.groupNo]">[$var.groupName]<br>
		</pp:if>
		</loop>
		</div>
	</div>
	<div align="center">
		<input type="submit" name="submit" value="保存" align="middle" class="button1">
	</div>
</form>
</body>
</html>
