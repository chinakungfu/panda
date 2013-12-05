<?php import('core.util.RunFunc'); ?><?php runFunc('delRoleBindOperation',array($this->_tpl_vars["roleNo"]))?>
<?php if ($this->_tpl_vars["operationId"]!=''){?>
<?php if(!empty($this->_tpl_vars['operationId'])){ 
 foreach ($this->_tpl_vars['operationId'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
<?php runFunc('roleBindOperation',array($this->_tpl_vars["roleNo"],$this->_tpl_vars["var"]))?>
<?php  }
} ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
role/frame_list_role.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php }else{ ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
role/frame_list_role.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>