<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $this->_tpl_vars["isCode"]=runFunc('isCode',array($this->_tpl_vars["IN"]["code"])); ?>
<?php if ($this->_tpl_vars["isCode"]!='1'){?>
	<?php $this->_tpl_vars["tempUrl"]='action=member&method=login&closeFlag=&staffNo='.$this->_tpl_vars["staffNo"]; ?>
	<script>alert("验证码不正确！");history.back();</script>
	<?php exit;?>
<?php } ?>
<?php if ($this->_tpl_vars["method"]=='logined'){?>
<?php $this->_tpl_vars["result"]=runFunc('checkLogin',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["password"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
	<?php runFunc('writeSession',array($this->_tpl_vars["result"][0]["staffId"]));?>
	<script>/*alert("登录成功！");*/location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"../cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=main'));?>";</script>
<?php }else{ ?>
	<?php $this->_tpl_vars["tempUrl"]='action=member&method=login&closeFlag=&staffNo='.$this->_tpl_vars["staffNo"]; ?>
	<script>alert("用户名和密码不正确!");history.back()</script>
	<?php exit;?>
<?php
import('core.tpl.TplRun');
import('core.tpl.TplTemplate');
$tpl=new TplRun();
$tpl->display("login.tpl");
exit();
?>
<?php } ?>
<?php } ?>
