<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='saveAddExtData'){?>
	<?php $this->_tpl_vars["result"]=runFunc('addExtData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["result"]){?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
	<?php }else{ ?>
		<script>alert('附加发布标识已存在，请更改后保存！');window.history.back();</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditExtData'){ ?>
	<?php runFunc('editExtData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
<?php } elseif ($this->_tpl_vars["method"]=='delExtData'){ ?>
	<?php runFunc('delExtData',array($this->_tpl_vars["extraPublishId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
<?php } ?>