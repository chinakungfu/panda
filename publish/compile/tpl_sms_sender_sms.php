<?php import('core.util.RunFunc'); ?><?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_check.php
LNMV
);
include($inc_tpl_file);
?>

<?php if ($this->_tpl_vars["mobileCode"]!=''&&$this->_tpl_vars["smsContent"]!=''){?>
<?php 
include_once('./appfunc/sms.php');
$appName ="publish";
$this->_tpl_vars["result"]=senderSms($this->_tpl_vars["mobileCode"],$this->_tpl_vars["smsContent"]);
 ?>
<script>
	alert("短信已发送！");
	window.location.href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=sms&method=listSMS'));?>";
</script>
<?php } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main</title>
<link rel="stylesheet" type="text/css" media="screen" href="/skin/css/adminstyle.css" />
</head>
<script>
function senderData()
{
	var mobileCode = document.getElementById("mobileCode").value;
	var smsContent = document.getElementById("smsContent").value;
	if(mobileCode=='')
	{
		alert("手机号不能为空！");
		return false;
	}
	if(smsContent=='')
	{
		alert("短信内容不能为空！");
		return false;
	}
}
</script>
<body class="rightbody">
<div class="mainbox">
	<div class="yplace">
    	<div class="cfont">
当前位置：<a href="/publish/index.php?LCMSPID=ADEHbVUjVG4Ca1I8BjwKbVA%2BXm4BMFA1BmdTego%2BUGYDJwVkBWgBNgQ%2FAG1XMQBjDm8%3D">首页</a> > 发送短信
        </div>
    </div>
    
    <div class="block">
   	  <div class="bcbox">
   		  <div class="topt"><div class="fontbox">◎ 发送短信</div></div>
          <div class="cbox">
            <form method="post" onSubmit="return senderData()">
			<input type="hidden" value="<?php echo $this->_tpl_vars["IN"]["nodeId"];?>" name="nodeId"/>
			<input type="hidden" value="20" name="pageSize"/>
			<input type="hidden" name="tpl" value="manage/manage_gzzlc"/>
            <table cellpadding="0" cellspacing="0" border="0" width="770" align="center" class="searchtablelist">
            	<tr>
                  <td width="20%">手机号：</td>
                  <td><textarea id="mobileCode" name="mobileCode" cols="51"></textarea></td>
               </tr>
               <tr>
                  <td width="20%">&nbsp;</td>
                  <td><font color="Red">请输入您要发送的手机号码，多个手机号用分号(;)隔开</font></td>
              </tr>
               <tr>
                  <td width="20%">短信内容：</td>
                  <td><textarea id="smsContent" name="smsContent" cols="60" rows="5"></textarea></td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center; padding:10px 0px 0px 0px;">
	                <input type="submit" value="发送" />
                </td>
              </tr>
            </table>
			</form>
          </div>
      </div>
      
      <div class="copyrightBox">
      	<div class="cboxc">
<?php
$inc_tpl_file=includeFunc(<<<LNMV
manage/manage_inc_copyright.tpl
LNMV
);
include($inc_tpl_file);
?>

        </div>
      </div>
    </div>
    
</div>
</body>
</html>
