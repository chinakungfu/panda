<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $this->_tpl_vars["result"]=runFunc('sendMail',array($this->_tpl_vars["staffNo"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<script>location.href="index.php?action=member&method=sendTo"</script>
<?php }else{ ?>
<script>alert('邮件发送失败，请与我们联系！');location.href="index.php?action=member&method=login"</script>
<?php } ?>