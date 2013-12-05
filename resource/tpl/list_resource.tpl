<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:include file="isLogin" type="tpl"/>
<style type="text/css">
<!--
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
-->
</style><head>
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<title>资源管理页面</title>
<script language=JavaScript type="" >
<!--
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	document.all.listInfo.src = "index.php?action=resource&method=frame_list_resource&sqlCon="+sqlConStr;
}
//-->
</script>
</head>
<body>
  <form id="form1" action="index.php" method="POST">
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="[$isText]">
  <input type="hidden" name="isId" value="[$isId]">
  <input type="hidden" id="type" name="resourcetype">
    <iframe id="listInfo" src="index.php?action=resource&method=frame_list_resource&isText=[$isText]" frameborder="0" width="100%" height="90%"></iframe>
    <table border="1" id="conditions"  width="100%">
	  </table>
  </form>
  </body>
<script language="javascript" type="">
<!--
  var sqlcondition =new sqlcondition("conditions");
  fieldList=new Array();
  fieldList[0]=sqlcondition.newFieldbean("","","","","");
  fieldList[1]=sqlcondition.newFieldbean("resourceName","资源名称","varchar","","");
  fieldList[2]=sqlcondition.newFieldbean("resourceType","资源类型","varchar","10","");
  fieldList[3]=sqlcondition.newFieldbean("resourceDis","资源描述","text","","");
  fieldList[4]=sqlcondition.newFieldbean("resourceUrl","资源路径","text","","");
  fieldList[5]=sqlcondition.newFieldbean("resourceDate","上传时间","date","","");
  fieldList[6]=sqlcondition.newFieldbean("memberId","会员账户","varchar","","");
  fieldList[7]=sqlcondition.newFieldbean("fileName","文件名称","varchar","","");
  fieldList[8]=sqlcondition.newFieldbean("serverName","资源服务器","varchar","","");
  sqlcondition.setFieldList(fieldList);
  dictList=new Array();
  dictList[0]=sqlcondition.newDictBean("10","image","图片");
  dictList[1]=sqlcondition.newDictBean("10","file","文件");
  dictList[2]=sqlcondition.newDictBean("10","music","音乐");
  dictList[3]=sqlcondition.newDictBean("10","movie","电影");
  dictList[4]=sqlcondition.newDictBean("10","else","其它");
  sqlcondition.setDictList(dictList);
  sqlcondition.initHeader();
//-->
</script>	
</html>
