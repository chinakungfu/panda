<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$inc_tpl_file=includeFunc(<<<LNMV
isLogin
LNMV
);
include($inc_tpl_file);
?>

<style type="text/css">

</style><head>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<title>资源管理页面</title>
<script language=JavaScript type="" >

</script>
</head>
<body>
  <form id="form1" action="index.php" method="POST">
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="<?php echo $this->_tpl_vars["isText"];?>">
  <input type="hidden" name="isId" value="<?php echo $this->_tpl_vars["isId"];?>">
  <input type="hidden" id="type" name="resourcetype">
    <iframe id="listInfo" src="index.php?action=resource&method=frame_list_resource&isText=<?php echo $this->_tpl_vars["isText"];?>" frameborder="0" width="100%" height="90%"></iframe>
    <table border="1" id="conditions"  width="100%">
	  </table>
  </form>
  </body>
<script language="javascript" type="">

</script>	
</html>
