<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('StaffIsExists',array($this->_tpl_vars["staffNo"])); ?>
<?php if (!empty($this->_tpl_vars["name"])){?>
	<?php return $this->_tpl_vars["staffNo"] ?>

<?php }else{ ?>
	<?php return '' ?>

<?php } ?>