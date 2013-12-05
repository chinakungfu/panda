<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='destroy'){?>
<?php $this->_tpl_vars["result"]=runFunc('readSession',array()); ?>
<?php runFunc('logoutStaff',array($this->_tpl_vars["result"]))?>
<?php runFunc('destroySession',array())?>
	<script language="javascript" type="text/javascript">
	top.opener=null;top.close();
	</script>
<?php }else{ ?>

<?php runFunc('destroySession',array())?>
<script language="javascript" type="text/javascript">
top.opener=null;top.location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"../member/index.php<?php echo runFunc('encrypt_url',array('action=member&method=login&closeFlag=1'));?>";
</script>
<?php } ?>