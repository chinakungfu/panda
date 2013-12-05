<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
function adddata()
{
	document.forms[0].action.value="resource";
	document.forms[0].method.value="addResource";
	document.forms[0].submit();
}
function deldata()
{
	document.forms[0].action.value="resource";
	document.forms[0].method.value="delResource";
	if (checkdata())
	{
		document.forms[0].submit();
	}
}
function selectSubmit()//选择资源的URL
{
	document.forms[0].action.value="resource";
	document.forms[0].method.value="selectResource";
	if (checkdata())
	{
		document.forms[0].submit();
	}
}
function checkdata()
{
	var bool=0;
	var chks=document.getElementsByName("checks");
	for(i=0;i<chks.length;i++){
		if(chks[i].checked){
			document.forms[0].resourceId.value=chks[i].value;
			bool=1;
			break;
		}
	}
	if (bool==1)
	{
		return true;
	}
	else
	{
		window.alert("你首先要选择一条记录然后再记录!");
		return false;
	}
}
function search()
{
	var sqlConStr = sqlcondition.generateStatement();
	location.href="index.php?action=resource&method=frame_list_lesource&sqlCon="+sqlConStr;
}
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;
  if(!d) 
  	d=document; 
  if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
	}
  if(!(x=d[n])&&d.all) 
    x=d.all[n]; 
	  for (i=0;!x&&i<d.forms.length;i++) 
	  x=d.forms[i][n];
     for(i=0;!x&&d.layers&&i<d.layers.length;i++) 
	 x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) 
   x=d.getElementById(n); 
   return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  if((obj=MM_findObj(args[i]))!=null) 
  { 
	v=args[i+2];
	if (obj.style) 
	{ 
		obj=obj.style;
		v=(v=='show')?'visible':(v=='hide')?'hidden':v;
	}
	obj.visibility=v;
  }
}
//-->
</script>
</head>
<body>
  <form action="index.php" method="POST">  
  <input type="hidden" name="action">
  <input type="hidden" name="method">
  <input type="hidden" name="resourceId">
  <input type="hidden" name="isText" value="[$isText]">
  <input type="hidden" name="isId" value="[$isId]">
  <input type="hidden" id="type" name="resourcetype">
      <table width="100%" class="tableTitle"/>
      <tr>
        <td class="tdTitle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   资源管理</TD>
      </tr>
    </TABLE>
    <table width="100%" class="tabletoolbutton" id="editgroup">
      <tr>
        <td class="tdtoolbutton" width="70%">
          <input type="button" class="button1" value="新 增" name="btnadd" onClick="adddata();">
          <input type="button" class="button1" value="删 除" name="btndel" onClick="deldata();">
          <input type="button" class="button1" value="确定" onclick="selectSubmit()">
          <input type="button" id="select" value="查询" class="button1" onClick="parent.search();">
          <!--<input type="button" class="button1" value="打 印" name="btnprint" onClick="insertdata();">
          <input type="button" class="button1" value="导 出" name="btnexport" onClick="insertdata();">-->
        </TD>
        <!--<td width="30%"><input type="text" name="search" value=""><input type="button" name="searchButton" value="搜索"></td>-->
      </tr>
    </TABLE>
    <table class="tableList" border="1" id="list" width="100%">    
      <tr>
      		<td class="listHeader">选中</td>
         	<td class="listHeader">资源Id</td>
      		<td class="listHeader">资源名称</td>
      		<td class="listHeader">资源类型</td>
      		<td class="listHeader">资源服务器</td>
      		<td class="listHeader">上传时间</td>
      		<td class="listHeader">操作</td>
       </tr>
       <pp:var name="result" value="<pp:memfunc funcname="listResource({$sqlCon})"/>"/>
       <loop name="result.data"  var="var" key="key">
       <tr>
          <td class="tdListItem"><input type="checkbox" name="checks" value="[$var.resourceId]"></td>
          <td class="tdListItem">[$var.resourceId]</td>
          <td class="tdListItem">[$var.resourceName]</td>
          <td class="tdListItem">[$var.resourceType]</td>
          <td class="tdListItem">[$var.serverName]</td>
          <td class="tdListItem">[$var.resourceDate]</td>
          <pp:if expr="$var.resourceType=='image'">
          <td class="tdListItem" onMouseOver="MM_showHideLayers('Layer[$key]','','show')" onMouseOut="MM_showHideLayers('Layer[$key]','','hide')">
          <a href='display.php?url=<pp:echomemfunc funcname="selectResource({$var.resourceId})"/>' target="_blank">预览</a>
          <div id=Layer[$key] style="position:absolute; width:200px; height:200px; z-index:1; left: 100px; top: 100px; visibility: hidden">
          <img src='<pp:echomemfunc funcname="selectResource({$var.resourceId})"/>' width="100%" height="100%"></div>
          </td>
          <pp:else/>
          <td class="tdListItem">无预览</td>
          </pp:if>
       </tr>
       </loop>
       </table>
       <pp:memfunc funcname="listPage({$result.pageinfo},'index.php','2')"/>
  </form>
  </body>
</html>
