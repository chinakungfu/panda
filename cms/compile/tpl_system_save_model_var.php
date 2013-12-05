<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddModelVar'){?>
<?php runFunc('addModelVarInfo',array($this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=modelVarSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditModelVar'){ ?>
<?php runFunc('editModelVarInfo',array($this->_tpl_vars["varId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=modelVarSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delModelVar'){ ?>
<?php runFunc('delModelVarInfo',array($this->_tpl_vars["varId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=modelVarSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>