<pp:include file="check_login.tpl" type="tpl"/>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用CMS</title>
<link rel="stylesheet" type="text/css" href="skin/cssfiles/css.css" />
</head>

<body>
<!--头部-->
<div class="top">
	
	<div class="top_left">
		<div class="user_action"><strong><pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
		欢迎您，[$name]</strong> - <u><a href="../member/index.php[@encrypt_url('action=member&method=logout')]">退出系统</a></u></div>
	    <div style="clear:both"></div>    
		</div>
	
</div>

<!--菜单部分开始-->
<div class="menu">
<div class="menu_line"></div>
	<ul>
      <li><a href="index.php[@encrypt_url('action=cms&method=right')]" target="mainFrame">系统首页</a></li>
      <pp:if expr="$IN.authCode.0.distinctionNo!='2'">
      <li><a href="index.php[@encrypt_url('action=cms&method=left&type=site')]" target="leftFrame">站点管理</a></li>
      </pp:if>
      <li><a href="index.php[@encrypt_url('action=cms&method=left&type=publish')]" target="leftFrame">发布管理</a></li>
      <pp:if expr="$IN.authCode.0.distinctionNo!='2'">
      <li><a href="index.php[@encrypt_url('action=cms&method=left&type=system')]" target="leftFrame">系统设置</a></li>
      </pp:if>
      <pp:if expr="$IN.authCode.0.distinctionNo=='0'||$IN.authCode.0.distinctionNo==''">
	  <li><a href="../member/index.php[@encrypt_url('action=member&method=left&type=member')]" target="leftFrame">会员管理</a></li>
	  </pp:if>
	  <li><a href="../member/index.php[@encrypt_url('action=member&method=left&type=person')]" target="leftFrame">个人管理</a></li>
  </ul>
</div>

</body>
</html>
