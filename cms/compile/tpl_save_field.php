<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddField'){?>
<?php runFunc('addFieldInfo',array($this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listField&fieldConfigId='.$this->_tpl_vars["IN"]["para"]["fieldConfigId"]; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditField'){ ?>
<?php runFunc('editFieldInfo',array($this->_tpl_vars["fieldId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listField&fieldConfigId='.$this->_tpl_vars["IN"]["para"]["fieldConfigId"]; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delField'){ ?>
<?php runFunc('delFieldInfo',array($this->_tpl_vars["fieldId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listField&fieldConfigId='.$this->_tpl_vars["fieldConfigId"]; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>