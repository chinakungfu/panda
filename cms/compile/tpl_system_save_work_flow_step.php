<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddWorkFlowStep'){?>
	<?php runFunc('addWorkFlowStep',array($this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowStep'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditWorkFlowStep'){ ?>
	<?php runFunc('editWorkFlowStep',array($this->_tpl_vars["flowStepId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowStep'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delWorkFlowStep'){ ?>
	<?php runFunc('delWorkFlowStep',array($this->_tpl_vars["flowStepId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=workFlowStep'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>