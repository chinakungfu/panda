<?php import('core.util.RunFunc'); ?><?php runFunc('delStaffBindGroup',array($this->_tpl_vars["staffNo"]))?>
<?php if ($this->_tpl_vars["index"]!=''){?>
<?php if(!empty($this->_tpl_vars['index'])){ 
 foreach ($this->_tpl_vars['index'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
<?php runFunc('staffBindGroup',array($this->_tpl_vars["staffNo"],$this->_tpl_vars["var"]))?>
<?php  }
} ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
frame_list_user.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php }else{ ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
frame_list_user.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>