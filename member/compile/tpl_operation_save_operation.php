<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveInsert'){?>
	<?php $this->_tpl_vars["result"]=runFunc('addOperation',array($this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["result"]){?>
		<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=operation&method=listOperation'));?>";</script>
	<?php }else{ ?>
		<script>alert('操作标识已存在，请更换后保存！');window.history.back();</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveEdit'){ ?>
	<?php runFunc('editOperation',array($this->_tpl_vars["operationId"],$this->_tpl_vars["IN"]["para"]))?>
	<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=operation&method=listOperation'));?>";</script>
<?php } elseif ($this->_tpl_vars["method"]=='delData'){ ?>
	<?php runFunc('delOperation',array($this->_tpl_vars["selectConId"]))?>
	<script>parent.location.href="index.php<?php echo runFunc('encrypt_url',array('action=operation&method=listOperation'));?>";</script>
<?php } ?>