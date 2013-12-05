<?php import('core.util.RunFunc'); ?><title>
<?php if ($this->_tpl_vars["node"]["nodeGuid"] != 'SYD4au'){?>
<?php if (!empty($this->_tpl_vars["listcontent"]["title"])){?>
<?php echo $this->_tpl_vars["listcontent"]["title"];?> - 
<?php } ?>
<?php if (!empty($this->_tpl_vars["node"]["nodeName"])){?>
<?php echo $this->_tpl_vars["node"]["nodeName"];?> - 
<?php } ?>
<?php } ?>
<?php if (!empty($this->_tpl_vars["title"])){?><?php echo $this->_tpl_vars["listcontent"]["title"];?> - <?php } ?>
<?php echo runFunc('getGlobalModelVar',array('Site_Name'));?>
</title>