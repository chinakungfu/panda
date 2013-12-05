<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head >
<link rel="stylesheet" type="text/css" href="skin/cssfiles/shared.css">
<link rel="stylesheet" type="text/css" href="skin/cssfiles/dtree.css">
<script type="text/javascript" src="skin/jsfiles/dtree.js"></script>
<script language="javascript">
function turnit (dvn){
if (dvn.style.display=="none") {
  dvn.style.display="";
}else {
  if (dvn.style.display=="") {
    dvn.style.display="none";
  }
}
}

function   rightFrame(url)   
{   
var   rUrl=url; 
//window.frames['rightFrame'].document.location.href=rUrl;   
window.top.rightFrame.location.href=rUrl;   
//window.parent.rightFrame.location.href=rUrl;   
}
</script>
<title>Linkage</title>
</head>
<body basetarget="mainFrame"  BGCOLOR="#F1F1F1" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<div class="dtree">
	<script type="text/javascript">
		d = new dTree('d');
		d.add(0,-1,'<b>资源管理</b>','','','');
		d.add(11,0,'资源管理','index.php?action=resourceManage&method=listResource','','rightFrame');
		document.write(d);

	</script>

</div>
</body>
</html>