<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["saveType"]=='0'){?>
<?php $this->_tpl_vars["result"]=runFunc('addFieldForTable',array($this->_tpl_vars["para"]["tableId"],$this->_tpl_vars["addDataResult"])); ?>
<?php } elseif ($this->_tpl_vars["saveType"]=='1'){ ?>
<?php $this->_tpl_vars["result"]=runFunc('editFieldForTable',array($this->_tpl_vars["editDataResult"],$this->_tpl_vars["IN"]["para"]["tableId"],$this->_tpl_vars["IN"]["para"])); ?>
<?php } ?>