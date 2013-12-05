<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if ($this->_tpl_vars["method"]=='logined'){?>
<?php $this->_tpl_vars["result"]=runFunc('checkLogin',array({$this->_tpl_vars["staffName"]},{$this->_tpl_vars["password"]})); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php runFunc('writeSession',array({$this->_tpl_vars["staffName"]}))?>
<script>alert("登录成功！");location.href="index.php?action=resourceManage&method=main"</script>
<?php }else{ ?>
<script>alert("用户名和密码不正确！")</script>
<?php
import('core.tpl.TplRun');
import('core.tpl.TplTemplate');
$tpl=new TplRun();
$tpl->display("login.tpl");
exit();
?>
<?php } ?>
<?php } ?>
