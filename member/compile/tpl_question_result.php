<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $this->_tpl_vars["result"]=runFunc('verifySafty',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["safetyQuestion"],$this->_tpl_vars["questionResult"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php runFunc('insertIdentify',array($this->_tpl_vars["staffNo"]))?>
<?php $this->_tpl_vars["MailResult"]=runFunc('sendMail',array($this->_tpl_vars["staffNo"])); ?>
<?php if ($this->_tpl_vars["MailResult"]){?>
<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=sendTo'));?>"</script>
<?php }else{ ?>
<script>alert('邮件发送失败，请与我们联系！');location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=login'));?>"</script>
<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["tempUrl"]='action=member&method=findPassworded&staffNo='.$this->_tpl_vars["staffNo"]; ?>
<script>alert("安全问题答案不正确，请重新输入！");location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
<?php } ?>