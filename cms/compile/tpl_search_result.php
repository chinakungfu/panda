<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["type"]=='node'){?>
<?php $this->_tpl_vars["result"]=runFunc('listNodeByCon',array($this->_tpl_vars["con"])); ?>
<?php }else{ ?>
<?php $this->_tpl_vars["result"]=runFunc('listPublishNodeByCon',array($this->_tpl_vars["con"])); ?>
<?php } ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return $this->_tpl_vars["result"] ?>

<?php }else{ ?>
<?php return $this->_tpl_vars["result"] ?>

<?php } ?>