<?php import('core.util.RunFunc'); ?><?php 
include_once('./appfunc/shop_list.php');
$appName ="publish";
$this->_tpl_vars["shopListInfo"]=getShopListInfo($this->_tpl_vars["word"],$this->_tpl_vars["cid"],$this->_tpl_vars["pageIndex"],$this->_tpl_vars["pageSize"]);
 ?>
<?php echo $this->_tpl_vars["shopListInfo"];?>