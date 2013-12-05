<?php import('core.util.RunFunc'); ?>





<?php if ($this->_tpl_vars["saveType"]=='0'){?>
<?php $this->_tpl_vars["result"]=runFunc('createAppTable',array($this->_tpl_vars["IN"]["para"])); ?>

<?php } elseif ($this->_tpl_vars["saveType"]=='1'){ ?>
<?php $this->_tpl_vars["result"]=runFunc('editAppTable',array($this->_tpl_vars["editDataResult"],$this->_tpl_vars["IN"]["para"]["appId"],$this->_tpl_vars["IN"]["para"]["tableName"])); ?>
<?php } ?>