<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>


<?php if ($this->_tpl_vars["name"]==''){?>			
		<?php $this->_tpl_vars["tmpUser"]=runFunc('readCookie',array()); ?>		
<?php }else{ ?>
	<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["name"]; ?>
<?php } ?>
<?php if ($this->_tpl_vars["method"]=='releaseOrder' and $this->_tpl_vars["IN"]["para"]["orderUser"]==$this->_tpl_vars["tmpUser"]){?>
	<?php $this->_tpl_vars["orderNodeId"]=runFunc('getGlobalModelVar',array('orderNode')); ?>
	<?php $this->_tpl_vars["orderNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["orderNodeId"])); ?>
	<?php $this->_tpl_vars["orderContentModel"]=$this->_tpl_vars["orderNode"]["0"]["appTableName"]; ?>

	<?php $this->_tpl_vars["para"]["orderStatus"]='0'; ?>
	<?php $this->_tpl_vars["para"]["orderNo"]=strtotime(date("Y-m-d H:i:s",time())) . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); ?>
	<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["orderNode"]["0"]["nodeGuid"]; ?>
	<?php $this->_tpl_vars["para"]["orderTime"]=strtotime(date('Y-m-d H:i:s',time())); ?>

	<?php $this->_tpl_vars["addorderTable"]=runFunc('addData',array($this->_tpl_vars["orderNodeId"],$this->_tpl_vars["orderContentModel"],$this->_tpl_vars["para"])); ?>	
	<?php if (addorderTable){?>
	<?php 
		import('core.apprun.cmsware.CmswareNode');
		import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
		$params = array (
		'action' => "sql",
		'return' => "",
		'query' => "delete from a0222211743.cms_publish_order where orderID != '{$this->_tpl_vars["addorderTable"]}' and orderStatus =1 and orderUser = '{$this->_tpl_vars["tmpUser"]}'"
		);
		CMS::CMS_sql($params);
	?>
			
			<?php $this->_tpl_vars["tempUrl"]='action=shop&method=addService&orderID=' .$this->_tpl_vars["addorderTable"]; ?>
			
			<?php header("Location: index.php".runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"])));?>
			
	<?php } ?>
<?php }else{ ?>
	<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>'</script>
<?php } ?>