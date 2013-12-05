<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["result"]=runFunc('fullPublishFlag',array($this->_tpl_vars["extraPublishName"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return $this->_tpl_vars["result"] ?>

<?php }else{ ?>
<?php return $this->_tpl_vars["result"] ?>

<?php } ?>