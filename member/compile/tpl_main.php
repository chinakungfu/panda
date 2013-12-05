<?php import('core.util.RunFunc'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>中国电信黄页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<input type="hidden" name="url" id="url" value="<?php echo $this->_tpl_vars["frameRight"];?>">
<?php $this->_tpl_vars["url"]=runFunc('decodeFrameRightURL',array($this->_tpl_vars["frameRight"])); ?>
<frameset rows="140,*" cols="*" frameborder="no" border="0" framespacing="0" >
  <frame src="index.php<?php echo runFunc('encrypt_url',array('action=member&method=title'));?>" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" />
  <frameset cols="230,*" frameborder="NO" border="0" framespacing="0" border="">
    <frame src="index.php<?php echo runFunc('encrypt_url',array('action=member&method=left'));?>" name="leftFrame" scrolling="Yes" noresize="noresize" marginwidth="50" id="leftFrame" style=""/>
    <frame src='<?php echo $this->_tpl_vars["url"];?>&Y_code=<?php echo $this->_tpl_vars["Y_code"];?>' name="mainFrame" id="mainFrame"  scrolling="yes"/>
  </frameset>
</frameset>
<noframes>
<body>对不起，你的浏览器不支持框架模式！</body>
</noframes>
</html>
