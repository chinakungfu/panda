<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
<script language="javascript" type="text/javascript">

top.location.href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>index.php?LCMSPID=AzJQOlMlUGoGb1Y4WmABfARuVGgGJVc8UCAFbw1yAD5UYVcqB21TbwJgAD0Abg1pBG9TaAIq";";
</script>
<?php }else{ ?>
<?php runFunc('writeSession',array($this->_tpl_vars["name"]))?>
<?php } ?>