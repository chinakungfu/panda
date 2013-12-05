<?php import('core.util.RunFunc'); ?><html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

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
	<?php $this->_tpl_vars["tempUrl"]='action=role&method=frameListRole&mode='.$this->_tpl_vars["mode"]; ?>
	document.all.listInfo.src = "index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&sqlCon="+sqlConStr;
	//document.all.listInfo.src = "index.php?action=role&method=frameListRole&mode=<?php echo $this->_tpl_vars["mode"];?>&sqlCon="+sqlConStr;
}
</script>
</head>
<body>
  <form id="form1" action="index.php" method="POST">
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="<?php echo $this->_tpl_vars["isText"];?>">
  <input type="hidden" name="isId" value="<?php echo $this->_tpl_vars["isId"];?>">
  <input type="hidden" name="mode">
  <input type="hidden" name="Y_code">
  <?php $this->_tpl_vars["tempUrl"]='action=role&method=frameListRole&appName=' .$this->_tpl_vars["appName"] .'&isText=' .$this->_tpl_vars["isText"] .'&mode='.$this->_tpl_vars["mode"]; ?>
  <iframe id="listInfo" src="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>" frameborder="0" width="100%" height="90%"></iframe>
    
  </form>
  </body>	
</html>
