<html>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="skin/jsfiles/json.js"></script>
<script type="text/javascript" src="skin/jsfiles/ajax.js"></script>
<script type="text/javascript" language="JavaScript">

</script>
<title>
找回用户密码
</title>
</head>
<body bgcolor="#ffffff">
<form method="post" action="index.php">
<input type="hidden" name="action" value="memberCenter">
<input type="hidden" name="method" value="findpassworded">
<input type="hidden" class="edit" name="staffId" value="">
 <table width="100%" class="tableTitle"/>
      <tr>
        <td class="tdTitle" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        找回用户密码
        </TD>
      </tr>
    </table>
<table class="editTable" id="edit" align="center">
	<tr>
	   
		<td class="editHeader">用户账户</td>
                <td class="editHeader">
                <input type="text" class="edit" name="staffname" value="">
                </td>
        </tr>
        <tr>
  	<TD colspan="4" align="center"><input type="button" value="提交" class="button" onClick="submitdata();">
  	<input type="button" value="取消" class="button" onclick="location.href='index.php?action=staff&method=listuser';"></TD>
		</tr>
</table>
</form>
</body>
</html>
