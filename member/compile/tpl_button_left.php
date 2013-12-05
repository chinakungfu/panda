<?php
$inc_tpl_file=includeFunc(<<<LNMV
check_login.tpl
LNMV
);
include($inc_tpl_file);
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT LANGUAGE="JavaScript">
var i = 175;
var timeName;
function oa_tool(){
if(window.parent.panelMain.cols=="0,8,*"){
 timeName=setInterval("reTool1();",50);
 oa_tree.title="隐藏菜单";
}
else{
 timeName=setInterval("reTool();",50);
 oa_tree.title="显示菜单";

}
}
function reTool(){
i= i-15;
if(i<=0){
  clearInterval(timeName);
  i=0;
  frameshow.src="skin/images/splitter_r.gif";
}
window.parent.panelMain.cols=i+",8,*";

}
function reTool1(){
i= i+15;
if(i>=175){
  clearInterval(timeName);
  i=175;
  frameshow.src="skin/images/splitter_l.gif";
}
window.parent.panelMain.cols=i+",8,*";

}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" bgcolor="#D7E1F2" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td background="skin/images/left.gif" style="border-right:1px solid #C4CEE0"><table width="8" border="0" height="100%" cellpadding="0" cellspacing="0" align="left">
  <tr align="center">
    <td>
      <div id=oa_tree onClick="oa_tool();" title="隐藏菜单"><img id=frameshow src="skin/images/splitter_l.gif" width="9" height="79" ></div>
    </td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
