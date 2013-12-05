<pp:include file="check_login.tpl" type="tpl"/>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
a:link 
	text-decoration: none;

a:visited 
	text-decoration: none;

a:hover 
	text-decoration: underline;

a:active 
	text-decoration: none;

</style>
<head>
<pp:if expr="$actParams!=''">
<pp:var name="actParams" value="unserialize(base64_decode($actParams))"/>
<loop name="actParams"  var="var" key="key">
	<pp:if expr="$key=='frameListAction'">
		<pp:var name="key" value="'action'"/>
	</pp:if>
	<pp:if expr="$key=='frameListMethod'">
		<pp:var name="key" value="'method'"/>
	</pp:if>
	<pp:if expr="$params">
		<pp:var name="params" value="$params . '&' . $key . '=' . $var"/>
	<pp:else/>
		<pp:var name="params" value="$params . $key . '=' . $var"/>
	</pp:if>	
</loop>
<pp:else/>
<loop name="IN"  var="var" key="key">
	<pp:if expr="$key!='action'&&$key!='method'">
		<pp:if expr="$key=='frameListAction'">
			<pp:var name="key" value="'action'"/>
		</pp:if>
		<pp:if expr="$key=='frameListMethod'">
			<pp:var name="key" value="'method'"/>
		</pp:if>
		<pp:if expr="$params">
			<pp:var name="params" value="$params . '&' . $key . '=' . $var"/>
		<pp:else/>
			<pp:var name="params" value="$params . $key . '=' . $var"/>
		</pp:if>
	</pp:if>
</loop>
</pp:if>

<!--<pp:var name="tempUrl" value="'action=cms&method=commonListFrame&nodeId='. $nodeId"/>-->
<link href="skin/cssfiles/style.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
<link href="skin/cssfiles/style_condition.css"  rel="stylesheet" type="text/css"/>
<script language="javascript" src="skin/jsfiles/conditioninput.js"></script>
<script language="javascript" src="skin/jsfiles/calendar.js"></script>
<script language="javascript" src="skin/jsfiles/cms.js"></script>
<title>通用CMS</title>
<script>
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	//sqlConStr = escape(sqlConStr);
	document.all.listInfo.src = "index.php[@encrypt_url($params)]&sqlCon="+sqlConStr;
}
</script>
</head>
<body>
    <iframe id="listInfo" src="index.php[@encrypt_url($params)]" frameborder="0" width="100%" height="90%"></iframe>
	<!-- 列表页搜索框 -->
	[@getSelectData($nodeId)]
		
</html>
