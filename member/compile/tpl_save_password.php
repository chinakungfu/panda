<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php $this->_tpl_vars["url"]=runFunc('encodeFrameRightURL',array('index.php?action=member&method=modifyPassword')); ?>
<?php if ($this->_tpl_vars["identify"]==''){?>
<?php $this->_tpl_vars["result"]=runFunc('changePassword',array($this->_tpl_vars["staffId"],$this->_tpl_vars["oldpassword"],$this->_tpl_vars["newpassword"],$this->_tpl_vars["identify"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<script language="JavaScript">alert("密码修改成功，请记住新密码！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=modifyPassword'));?>";</script>
<?php }else{ ?>
<script>alert("密码修改失败，旧密码不正确！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=modifyPassword'));?>"</script>
<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["result"]=runFunc('findPassword',array($this->_tpl_vars["staffId"],$this->_tpl_vars["newpassword"],$this->_tpl_vars["identify"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<script>alert("密码修改成功，请记住新密码！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=modifyPassword'));?>"</script>
<?php }else{ ?>
<script>alert("密码修改失败，修改密码时间过期，请申请找回密码！");location.href="index.php<?php echo runFunc('encrypt_url',array('action=member&method=login'));?>"</script>
<?php } ?>
<?php } ?>