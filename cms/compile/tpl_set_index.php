<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='setIndex'){?>
	<?php runFunc('modifyIndexFlag',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["isIndex"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
<?php } ?>