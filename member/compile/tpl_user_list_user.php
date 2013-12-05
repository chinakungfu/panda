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
	if(sqlConStr.indexOf('staffName')=='-1')
	{
		sqlConStr = escape(sqlConStr);
	}
	//sqlConStr = escape(sqlConStr);
	<?php $this->_tpl_vars["tempUrl"]='action=staff&method=frameListUser&mode='.$this->_tpl_vars["mode"]; ?>
	document.all.listInfo.src = "index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&sqlCon="+sqlConStr;
	//sqlConStr = sqlConStr+' and isCompanyMember=<?php echo $this->_tpl_vars["IN"]["isCompanyMember"];?>'
	//document.all.listInfo.src = "index.php?action=staff&method=frameListUser&mode=<?php echo $this->_tpl_vars["mode"];?>&sqlCon="+sqlConStr;
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
  <?php $this->_tpl_vars["tempUrl"]='action=staff&method=frameListUser&appName=' .$this->_tpl_vars["appName"] .'&isText=' .$this->_tpl_vars["isText"] .'&mode='.$this->_tpl_vars["mode"]; ?>
  <iframe id="listInfo" src="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>" frameborder="0" width="100%" height="85%"></iframe>
   <table border="0"><tr><td><table border="0" id="conditions"  width="100%"></table></td><td><input type="button" name="buttion" value="搜索" onclick="search();"/></td></table>
  </form>
  </body>
<script language="javascript" type="">

  var sqlcondition =new sqlcondition("conditions");
  fieldList=new Array();
  fieldList[0]=sqlcondition.newFieldbean("","","","","");
  fieldList[1]=sqlcondition.newFieldbean("staffID","会员ID","int","","");
  fieldList[1]=sqlcondition.newFieldbean("staffNo","会员帐户","varchar","","");
  fieldList[2]=sqlcondition.newFieldbean("staffName","姓名","varchar","","");
  sqlcondition.setFieldList(fieldList);

  sqlcondition.initHeader();

</script>	
</html>


