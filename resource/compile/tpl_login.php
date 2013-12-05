<html>
<head >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="skin/cssfiles/shared.css">
<link rel="stylesheet" type="text/css" href="skin/cssfiles/dtree.css">
<script type="text/javascript" src="skin/jsfiles/js-extfunc.js"></script>
<script type="text/javascript" src="jsfiles/json.js"></script>
<script type="text/javascript" src="jsfiles/ajax.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajaxControl.js"></script>
<script language=JavaScript type="" >

</script>
</head>
<center>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>
<form name="form" action="index.php" method="post">
<input type="hidden" name="action">
<input type="hidden" name="method">
<div id="login" style="display:disable">
<table width="100%" height="50" border="0" background="skin/images/headBg.gif">
<tr>
<td></td>
<td width="50">用户名：</td>
<td width="154"><input type="text" name="staffName" value=""></td>
<td></td>
</tr>
<tr>
<td></td>
<td>密 码：</td>
<td><input type="password" name="password" value=""></td>
<td></td>
</tr>
<tr>
<td colspan="4" align="center"><input type="button" name="login" value="登 录" onClick="submitdata();"><input type="button" name="register" value="注 册" onClick="registerdata();"><input type="button" name="register" value="忘记密码" onClick="findpassdata();"></td>
</tr>
<tr>
<td colspan="4" align="center"><input type="button" name="login" value="Ajax登 录" onClick="call_tpl('staff','loginData','backData(\'loginMessage\')','display',document.all.staffName.value,document.all.password.value);"></td>
</tr>
</table>
</div>
<div style="display:none" id="loginMessage" background="skin/images/headBg.gif"></div>
</form>
</body>
</center>
</html>