<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddSeo'){?>
<?php runFunc('addSeo',array($this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=seoSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditSeo'){ ?>
<?php runFunc('editSeo',array($this->_tpl_vars["seoId"],$this->_tpl_vars["IN"]["para"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=seoSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delSeo'){ ?>
<?php runFunc('delSeo',array($this->_tpl_vars["seoId"]))?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=seoSet'; ?>
<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>