<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddFieldConfig'){?>
<?php $this->_tpl_vars["fieldConfigId"]=runFunc('addFieldConfigInfo',array($this->_tpl_vars["IN"]["para"])); ?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listField&fieldConfigId='.$this->_tpl_vars["fieldConfigId"]; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditFieldConfig'){ ?>
<?php runFunc('editFieldConfigInfo',array($this->_tpl_vars["fieldConfigId"],$this->_tpl_vars["IN"]["para"]))?>
<script>window.history.back();</script>
<?php } elseif ($this->_tpl_vars["method"]=='delFieldConfig'){ ?>
<?php runFunc('delFieldConfigInfo',array($this->_tpl_vars["fieldConfigId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=listFieldConfig'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>