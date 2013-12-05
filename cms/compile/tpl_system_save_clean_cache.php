<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["result"]=runFunc('executeCleanCache',array($this->_tpl_vars["appPath"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=cleanCache'; ?>
	<script>alert('您已成功清除缓存！');location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php }else{ ?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=cleanCache'; ?>
	<script>alert('您已清除缓存失败！')location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>