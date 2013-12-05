<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:include file="check_login.tpl" type="tpl"/>
<style type="text/css">
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
</style><head>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<title>资源管理页面</title>
<script language=JavaScript type="" >
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	//sqlConStr = escape(sqlConStr);
	<pp:var name="tempUrl" value="'action=role&method=frameListRole&mode='.$mode"/>
	document.all.listInfo.src = "index.php[@encrypt_url($tempUrl)]&sqlCon="+sqlConStr;
	//document.all.listInfo.src = "index.php?action=role&method=frameListRole&mode=[$mode]&sqlCon="+sqlConStr;
}
</script>
</head>
<body>
  <form id="form1" action="index.php" method="POST">
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="[$isText]">
  <input type="hidden" name="isId" value="[$isId]">
  <input type="hidden" name="mode">
  <input type="hidden" name="Y_code">
  <pp:var name="tempUrl" value="'action=role&method=frameListRole&appName=' .$appName .'&isText=' .$isText .'&mode='.$mode"/>
  <iframe id="listInfo" src="index.php[@encrypt_url($tempUrl)]" frameborder="0" width="100%" height="90%"></iframe>
    <!--<table border="0"><tr><td><table border="0" id="conditions"  width="100%"></table></td><td><input type="button" name="buttion" value="搜索" onclick="search();"/></td></table>-->
  </form>
  </body>	
</html>
