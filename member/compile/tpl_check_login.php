<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<script language="javascript" type="text/javascript">
<?php $this->_tpl_vars["tempUrl"]='action=member&method=login&closeFlag=1&url='.$this->_tpl_vars["url"]; ?>
top.location.href="../member/index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>";
</script>
<?php }else{ ?>
<?php runFunc('writeSession',array($this->_tpl_vars["name"]))?>
<?php } ?>