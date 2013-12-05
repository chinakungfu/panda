<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddPublishPsn'){?>
<?php runFunc('addPublishPsnInfo',array($this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=publishPsnSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditPublishPsn'){ ?>
<?php runFunc('editPublishPsnInfo',array($this->_tpl_vars["psnId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=publishPsnSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delPublishPsn'){ ?>
<?php runFunc('delPublishPsnInfo',array($this->_tpl_vars["psnId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=publishPsnSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>