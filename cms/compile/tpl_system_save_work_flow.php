<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddWorkFlow'){?>
	<?php runFunc('addWorkFlow',array($this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowListFrame'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditWorkFlow'){ ?>
	<?php runFunc('editWorkFlow',array($this->_tpl_vars["flowId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowListFrame'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delWorkFlow'){ ?>
	<?php runFunc('delWorkFlow',array($this->_tpl_vars["flowId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowListFrame'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>