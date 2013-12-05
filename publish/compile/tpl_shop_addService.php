<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>			
		<?php $this->_tpl_vars["tmpUser"]=runFunc('readCookie',array()); ?>		
<?php }else{ ?>
	<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"]; ?>
<?php } ?>

<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "listOrder",
	'query' => "SELECT * FROM a0222211743.cms_publish_order WHERE orderID='{$this->_tpl_vars["IN"]["orderID"]}' limit 1",
 ); 

$this->_tpl_vars['listOrder'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

<?php if ($this->_tpl_vars["method"]=='addService' and $this->_tpl_vars["listOrder"]["data"]["0"]["orderUser"]==$this->_tpl_vars["tmpUser"]){?>
	<?php $this->_tpl_vars["serviceName"]=1; ?>
	
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateOrderService",
	'query' => "UPDATE a0222211743.cms_publish_order SET serviceName = '{$this->_tpl_vars["serviceName"]}',orderStatus='1' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 ); 

$this->_tpl_vars['updateOrderService'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if ($this->_tpl_vars["updateOrderService"]){?>
		
		
		<?php $this->_tpl_vars["tempUrl"]='action=shop&method=WOWd2d&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?> '</script>
	<?php } ?>
<?php }else{ ?>
	<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>'</script>
<?php } ?>