<?php import('core.util.RunFunc'); ?><?php 
include_once('../member/appfunc/common.php');
$appName ="yellowpages";
$this->_tpl_vars["result"]=userIsExists($this->_tpl_vars["StaffNo"]);
 ?>
<?php if ($this->_tpl_vars["result"]){?>
<?php return '该用帐户已存在，不可重复使用！' ?>

<?php }else{ ?>
<?php return '该帐户可以用！' ?>

<?php } ?>

