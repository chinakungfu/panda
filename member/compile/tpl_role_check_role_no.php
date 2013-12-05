<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='beginInsert'){?>
<?php $this->_tpl_vars["result"]=runFunc('RoleIsExists',array($this->_tpl_vars["roleNo"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return '角色编号异常，该编号已经存在，请输入其他编号！' ?>

<?php }else{ ?>
<?php return '' ?>

<?php } ?>
<?php }else{ ?>
<?php $this->_tpl_vars["result"]=runFunc('RoleIsExists',array($this->_tpl_vars["roleNo"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return '角色编号异常，该编号已经存在，请输入其他编号！' ?>

<?php }else{ ?>
<?php return '' ?>

<?php } ?>
<?php } ?>
