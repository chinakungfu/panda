<?php import('core.util.RunFunc'); ?><?php 
include_once('./appfunc/shop_share.php');
$appName ="publish";
$this->_tpl_vars["shopShareInfo"]=getShopShareInfo($this->_tpl_vars["pageIndex"],$this->_tpl_vars["pageSize"]);
 ?>
<?php echo $this->_tpl_vars["shopShareInfo"];?>