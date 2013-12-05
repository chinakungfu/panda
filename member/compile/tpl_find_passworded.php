<?php import('core.util.RunFunc'); ?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<script type="text/javascript" src="skin/jsfiles/check.js"></script>
<style type="text/css">
#login {
	position: absolute;
	left:32%;
	top:40%;
	margin-left:-150px;
	margin-top:-32px;
	width:800px;
}   
  
  
/*左边部分*/
#login_left {
	width:350px;
	float:left;
}

#login_logo_intro{
	clear:both;
	color:#666;
	font-family:Verdana;
	font-size:12px;
	font-weight:bold;
	margin-top:5px;
}

#login_logo_name{
	clear:both;
	font-size:14px;
	font-weight:bold;
	color:#10559e;
	margin-top:5px;
}

#login_creat{
	clear:both;
	margin-top:10px;
}
#login_copyright{
	clear:both;
	color:#666;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	margin-top:5px;
}
#back{
	clear:both;
	color:#666;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	margin-top:5px;
	text-decoration:underline;
	font-weight:bold;
	
}
/*中间部分*/
#login_center {
	background:url(skin/images/login/login_line.gif) no-repeat;
	height:163px;
	width:1px;
	float:left;
	margin:0px 25px 0px 10px;
}

#login_right {
	float:left;
	width:290px;
}
#login_action_left{
	clear:both;
	margin-top:10px;
	background:url(skin/images/login/login_action_left.gif) no-repeat;
	width:53px;
	height:25px;
	float:left;
	padding:7px 0 0 10px;
	font-family:Tahoma;
	color:#666;
	font-size:12px;
}
#login_action_bg{
	float:left;
	margin-top:10px;
	width:210px;
	height:32px;
	background:url(skin/images/login/login_action_bg.gif) repeat-x;
}

#login_action_bg input{
	border:1px solid #fff;
	margin-top:6px;
	width:200px;
}

#login_action_right{
	float:left;
	margin:0px;
	background:url(skin/images/login/login_action_right.gif) no-repeat;
	width:10px;
	height:32px;
	margin-top:10px;
}

#login_action_code{
	float:left;
	color:#f00;
	margin:15px 0 0 10px;
	font-size:14px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
#login_submit{
	float:left;
	width:100px;
	height:100px;
	margin-top:10px;
}
#login_submit_bg{
	float:left;
	background:url(skin/images/login/login_bg.gif) no-repeat;
	width:70px;
	height:42px;
}
#find_password{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	clear:both;
	padding-top:10px;
	padding-left:5px;
}
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #666666;
}
a:hover {
	text-decoration: underline;
	color: #666666;
}
a:active {
	text-decoration: none;
	color: #666666;
}

</style>
<script type="text/javascript">
function submitdata()
{
	document.forms[0].submit();
}
</script>
</head>
<body>

<table cellpadding="0" cellspacing="0" width="663" align="center">
	<tr><td height="120"></td></tr>
    <tr><td height="392" valign="top" style="background-image:url(skin/images/login/member_bg_box.jpg); background-repeat:no-repeat; background-position:center middle;">

<form name="form" action="index.php" method="post" onSubmit="return Validator.Validate(this,1)">
<input type="hidden" name="action" value="member">
<input type="hidden" name="method" value="result">

<table cellpadding="0" cellspacing="0" width="630" height="auto" align="center">
	<tr><td height="60"></td></tr>
    <tr><td height="390" valign="top">
    	<table cellpadding="0" cellspacing="0" width="100%" align="center">
			
            <tr><td width="175" height="160" valign="middle" align="center"><a href="../"><img src="skin/images/login/member_logo.jpg" width="150" height="160" border="0" /></a></td>
              <td width="66" align="center" valign="middle"><img src="skin/images/login/member_line.jpg" width="20" height="160" border="0" /></td>
              <td width="385">
       	  <table cellpadding="0" cellspacing="0" width="100%" align="center">
                	<tr><td width="75%" height="160">
<?php $this->_tpl_vars["result"]=runFunc('StaffIsExists',array($this->_tpl_vars["staffNo"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<table cellpadding="0" cellspacing="0" width="100%" align="center">
                			<tr><td width="100%" height="32" style="background-image:url(skin/images/login/member_input1.jpg); background-repeat:no-repeat; background-position:left middle;">
<table cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr>
      <td width="63" height="32" style=" color:#666666; font-size:12px;" align="center";>用户名：</td>
      <td width="8"></td>
      <td width="auto"><input name="staffNo" type="text" value="<?php echo $this->_tpl_vars["result"]["0"]["staffNo"];?>" readonly dataType="Username" msg="请填写用户名" style="border:0px;"/></td>
    </tr>
</table>
                            </td></tr>
                            <tr><td height="8"></td></tr>
                            <tr><td width="100%" height="32" style="background-image:url(skin/images/login/member_input1.jpg); background-repeat:no-repeat; background-position:left middle;">
<table cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr>
      <td width="63" height="32" style=" color:#666666; font-size:12px;" align="center";>问 &nbsp; 题：</td>
      <td width="8"></td>
      <td width="auto"><input name="safetyQuestion" type="text"  value="" style="border:0px;"/></td>
    </tr>
</table>
                            </td></tr>
                            <tr><td height="8"></td></tr>
                            <tr><td width="100%" height="32" style="background-image:url(skin/images/login/member_input1.jpg); background-repeat:no-repeat; background-position:left middle;">
<table cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr>
      <td width="63" height="32" style=" color:#666666; font-size:12px;" align="center";>答 &nbsp; 案：</td>
      <td width="8"></td>
      <td width="auto"><input name="questionResult" type="text" dataType="Require" msg="答案不能为空！" style="border:0px;"/></td>
    </tr>
</table>
                            </td></tr>
                            <tr><td height="8"></td></tr>
                            <tr><td height="auto" align="center"><input type="submit" value="确定提交" class="button"> 
           <input type="button" value="返回" class="button" onClick="location.href='index.php<?php echo runFunc('encrypt_url',array('action=member&method=login'));?>';"></td></tr>
                      </table>
<?php }else{ ?>
<script>alert("账户名不正确或不存在！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=findPassword'));?>"</script>
<?php } ?>
                          
                    </td>
                	  <td width="2%"></td>
                	  <td width="23%">

                      </td>
               	</tr>
                </table>
              </td>
          </tr>
            <tr><td height="90" colspan="3"></td></tr>
            <tr>
                <td height="auto" colspan="3" align="center" style="line-height:20px; font-size:12px; color:#666666;">
                蓝慕科技 Lonmo Technology<br />
                ©2009 CopyRight
                </td>
            </tr>
            
        </table>    
    
    </td></tr>
</table>

</form>

</td></tr></table>
</body>
</html>


