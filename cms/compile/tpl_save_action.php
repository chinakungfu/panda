<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddAction'){?>
<?php runFunc('addActionInfo',array($this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listAction'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditAction'){ ?>
<?php runFunc('editActionInfo',array($this->_tpl_vars["actionId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listAction'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delAction'){ ?>
<?php runFunc('delActionInfo',array($this->_tpl_vars["actionId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listAction'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>