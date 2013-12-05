<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["result"]=runFunc('checkNodeFlag',array($this->_tpl_vars["nodeGuid"])); ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return "该标识已存在!" ?>

<?php }else{ ?>
<?php return "该标识可以用!" ?>

<?php } ?>