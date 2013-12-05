<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveInsert'){?>
	<?php $this->_tpl_vars["result"]=runFunc('addRole',array($this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["result"]){?>
		<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=role&method=listRoles'));?>";</script>
	<?php }else{ ?>
		<script>alert('角色标识已存在，请更换后保存！');window.history.back();</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveEdit'){ ?>
	<?php runFunc('editRole',array($this->_tpl_vars["roleId"],$this->_tpl_vars["IN"]["para"]))?>
	<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=role&method=listRoles'));?>";</script>
<?php } elseif ($this->_tpl_vars["method"]=='delData'){ ?>
	<?php runFunc('delRole',array($this->_tpl_vars["selectConId"]))?>
	<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=role&method=listRoles'));?>";</script>
<?php } ?>

