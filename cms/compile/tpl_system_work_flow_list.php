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
<title>通用CMS</title>
<script language=JavaScript type="" >
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	if(sqlConStr.indexOf('flowName')=='-1')
	{
		sqlConStr = escape(sqlConStr);
	}
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowListFrame&mode='.$this->_tpl_vars["mode"]; ?>
	document.all.listInfo.src = "index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>&sqlCon="+sqlConStr;
	//document.all.listInfo.src = "index.php?action=operation&method=frameListOperation&mode=<?php echo $this->_tpl_vars["mode"];?>&sqlCon="+sqlConStr;
}
</script>
</head>
<body>
  <form id="form1" action="index.php" method="POST">
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowListFrame&appName=' .$this->_tpl_vars["appName"] .'&isText=' .$this->_tpl_vars["isText"] .'&mode='.$this->_tpl_vars["mode"]; ?>
  <iframe id="listInfo" src="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>" frameborder="0" width="100%" height="90%" frameborder="2"></iframe>
    <table border="0" width="100%">
	    <tr>
		    <td>
		    	<table border="0" id="conditions"  width="100%"></table>
		    </td>
		    <td>
		    	<input type="button" name="buttion" value="搜索" onClick="search();"/>
		    </td>
	    </tr>
    </table>
  </form>
  </body>
<script language="javascript" type="">
  var sqlcondition =new sqlcondition("conditions");
  fieldList=new Array();
  fieldList[0]=sqlcondition.newFieldbean("","","","","");
  fieldList[1]=sqlcondition.newFieldbean("flowName","流程名称","varchar","","");
  sqlcondition.setFieldList(fieldList);
  sqlcondition.initHeader();  
</script>	
</html>
