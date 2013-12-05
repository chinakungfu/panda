<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>中国电信黄页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<input type="hidden" name="url" id="url" value="[$frameRight]">
<pp:var name="url" value="<pp:memfunc funcname="decodeFrameRightURL($frameRight)"/>"/>
<frameset rows="140,*" cols="*" frameborder="no" border="0" framespacing="0" >
  <frame src="index.php[@encrypt_url('action=member&method=title')]" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" />
  <frameset cols="230,*" frameborder="NO" border="0" framespacing="0" border="">
    <frame src="index.php[@encrypt_url('action=member&method=left')]" name="leftFrame" scrolling="Yes" noresize="noresize" marginwidth="50" id="leftFrame" style=""/>
    <frame src='[$url]&Y_code=[$Y_code]' name="mainFrame" id="mainFrame"  scrolling="yes"/>
  </frameset>
</frameset>
<noframes>
<body>对不起，你的浏览器不支持框架模式！</body>
</noframes>
</html>
