<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["backUrl"]='action=admin&method=taobaoLink'; ?>
<?php if ($this->_tpl_vars["method"]=='addLink'){?>	
				
	<?php $this->_tpl_vars["nodeId"]=90; ?>
	<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>	

	<?php $this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["para"])); ?>	
	<?php if ($this->_tpl_vars["addGoodsTable"]){?>		
		<script>
			alert("Add successfully!");			
			location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'
		</script>		
	<?php }else{ ?>
		<script>alert("Add failed, try again.");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
	<?php } ?>			
<?php } elseif ($this->_tpl_vars["method"]=='updateLink'){ ?>
	<?php $this->_tpl_vars["nodeId"]=90; ?>
	<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>
	
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["IN"]["linkId"]; ?>
	<?php $this->_tpl_vars["para"]["linkId"]=$this->_tpl_vars["IN"]["linkId"]; ?>
	
		
	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>		
	

<?php } elseif ($this->_tpl_vars["method"]=='delLink'){ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "delItem",
	'query' => "DELETE FROM  `cms_publish_link` WHERE linkId='{$this->_tpl_vars["IN"]["linkId"]}' ",
 ); 

$this->_tpl_vars['delItem'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
	<?php if ($this->_tpl_vars["delItem"]){?>		
		<script>
			alert("Del successfully!");			
			location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'
		</script>		
	<?php }else{ ?>
		<script>alert("Del failed, try again.");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
	<?php } ?>

<?php } ?>