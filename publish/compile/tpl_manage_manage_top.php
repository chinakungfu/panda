<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_check.php
LNMV
);
include($inc_tpl_file);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>top</title>
<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/adminstyle.css" />
</head>
<script language="javascript">
function getCurDate()
{
 var d = new Date();
 var week;
 switch (d.getDay()){
 case 1: week="星期一"; break;
 case 2: week="星期二"; break;
 case 3: week="星期三"; break;
 case 4: week="星期四"; break;
 case 5: week="星期五"; break;
 case 6: week="星期六"; break;
 default: week="星期天";
 }
 var years = d.getYear();
 var month = add_zero(d.getMonth()+1);
 var days = add_zero(d.getDate());
 var hours = add_zero(d.getHours());
 var minutes = add_zero(d.getMinutes());
 var seconds=add_zero(d.getSeconds());
 var ndate = years+"年"+month+"月"+days+"日 "+hours+":"+minutes+":"+seconds+" "+week;
 document.getElementById('divT').innerHTML= ndate;
}

function add_zero(temp)
{
 if(temp<10) return "0"+temp;
 else return temp;
}
setInterval("getCurDate()",100);
</script>
<body>
<div class="top">
	<div class="leftlogo"><div class="logo"><img src="/skin/images/logo.png" border="0" /></div></div>
    <div class="rightbox">“十一五”国家科技支撑计划重大项目<br />《村镇小康住宅关键技术研究与示范》资助</div>
</div>
<div class="guidebox">
	<div class="left">今天是：<span id="divT"></span></div>
    <div class="right">欢迎您：<?php echo $this->_tpl_vars["user"]["staffName"];?> <a href="/member/<?php echo runFunc('encrypt_url',array('action=member&method=logout&url=/login.html'));?>">退出系统</a> </div>
</div>
</body>
</html>
