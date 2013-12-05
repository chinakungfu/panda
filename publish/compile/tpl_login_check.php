<?php import('core.util.RunFunc'); ?><?php 
include_once('../publish/appfunc/common.php');
$appName ="publish";
$this->_tpl_vars["result"]=loginCheck($this->_tpl_vars["StaffNo"],$this->_tpl_vars["password"]);
 ?>
<?php if ($this->_tpl_vars["result"]){?>
	<?php if ($this->_tpl_vars["result"]["0"]["groupName"]=='NoValidation'){?>
		<?php return '2' ?>

	<?php }else{ ?>
		<?php return $this->_tpl_vars["result"] ?>
	
		<?php runFunc('writeSession',array($this->_tpl_vars["StaffNo"]))?>		
	<?php } ?>
<?php }else{ ?>
<?php return '0' ?>

<?php } ?>