<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddWorkFlowAction'){?>
	<?php runFunc('addWorkFlowAction',array($this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowAction'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditWorkFlowAction'){ ?>
	<?php runFunc('editWorkFlowAction',array($this->_tpl_vars["flowActionId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowAction'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delWorkFlowAction'){ ?>
	<?php runFunc('delWorkFlowAction',array($this->_tpl_vars["flowActionId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowAction'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>