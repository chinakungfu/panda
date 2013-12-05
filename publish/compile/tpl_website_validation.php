<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php if ($this->_tpl_vars["method"]=='Validation'){?>
<?php $this->_tpl_vars["result"]=runFunc('checkLogin',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["password"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
	
	<?php if ($this->_tpl_vars["result"]["0"]["groupName"]=='NoValidation'){?>
		<script>alert("Sorry,You are waiting for validation of sign up, please go to your mail box and finish all step of validation！");</script>
	<?php }else{ ?>
	<?php runFunc('writeSession',array($this->_tpl_vars["staffNo"]))?>
	
	<script>alert("Log in successfully!");location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"../cms/index.php<?php echo runFunc('encrypt_url',array('action=website&method=index'));?>";</script>
	<?php } ?>
<?php }else{ ?>
	<?php $this->_tpl_vars["tempUrl"]='action=website&method=index&closeFlag=&staffNo='.$this->_tpl_vars["staffNo"]; ?>
	<script>alert("用户名和密码不正确!");history.back()</script>
<?php
import('core.tpl.TplRun');
import('core.tpl.TplTemplate');
$tpl=new TplRun();
$tpl->display("login.tpl");
exit();
?>
<?php } ?>
<?php } ?>