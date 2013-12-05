<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["AddressNodeId"]=runFunc('getGlobalModelVar',array('AddressNode')); ?>
<?php $this->_tpl_vars["AddressNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["AddressNodeId"])); ?>
<?php $this->_tpl_vars["AddressContentModel"]=$this->_tpl_vars["AddressNode"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["tempUrl"]='action=account&method=address'; ?>
<?php if ($this->_tpl_vars["method"]=='addNewAddress'){?>
	<?php $this->_tpl_vars["checkData"]=runFunc('checkAddressData',array($this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["AddressNode"]["0"]["nodeGuid"]; ?>
		
		<?php $this->_tpl_vars["addAddress"]=runFunc('addData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["para"])); ?>
		<?php if ($this->_tpl_vars["addAddress"]){?>
			<?php $this->_tpl_vars["publishAddress"]=runFunc('publish',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addAddress"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>	
			<?php if ($this->_tpl_vars["publishAddress"]){?>
				<script>location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl1"]));?>"</script>						
			<?php }else{ ?>
			1
			<?php } ?>
		<?php }else{ ?>
			2
		<?php } ?>
	<?php }else{ ?>				
		<?php $this->_tpl_vars["backData"]=runFunc('backAddressData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"])); ?>		
		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>		
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='delAddress'){ ?>	
	
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["IN"]["addressId"]; ?>
	<?php $this->_tpl_vars["para"]["addressId"]=$this->_tpl_vars["IN"]["addressId"]; ?>
	<?php $this->_tpl_vars["para"]["status"]=Delete; ?>
	
	<?php runFunc('editData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	<script>location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
<?php } elseif ($this->_tpl_vars["method"]=='updateAddress'){ ?>	
	<?php $this->_tpl_vars["checkData"]=runFunc('checkAddressData',array($this->_tpl_vars["IN"]["para"])); ?>
	<?php if ($this->_tpl_vars["checkData"]==1){?>
		<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["addressId"]; ?>
		<?php $this->_tpl_vars["para"]["addressId"]=$this->_tpl_vars["IN"]["addressId"]; ?>		
		
		<?php runFunc('editData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
		<script>location.href="<?php echo $this->_tpl_vars["IN"]["url"];?>"||"index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl1"]));?>"</script>
	<?php }else{ ?>
		
		<?php $this->_tpl_vars["backData"]=runFunc('backAddressData',array($this->_tpl_vars["IN"]["para"],$this->_tpl_vars["checkData"])); ?>
		
		<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["IN"]["backUrl"] . $this->_tpl_vars["backData"] ));?>"</script>
		
	<?php } ?>

<?php } elseif ($this->_tpl_vars["method"]=='delOrderAddress'){ ?>	
	
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["IN"]["addressId"]; ?>
	<?php $this->_tpl_vars["para"]["addressId"]=$this->_tpl_vars["IN"]["addressId"]; ?>
	<?php $this->_tpl_vars["para"]["status"]=Delete; ?>	

	<?php runFunc('editData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	<?php $this->_tpl_vars["Url"]='action=shop&method=WOWd2d&orderID' . $this->_tpl_vars["IN"]["orderID"]; ?>
	<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>"</script>
<?php } elseif ($this->_tpl_vars["method"]=='updateOrderAddress'){ ?>	
	
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["addressId"]; ?>
	<?php $this->_tpl_vars["para"]["addressId"]=$this->_tpl_vars["IN"]["addressId"]; ?>
	
	<?php $this->_tpl_vars["Url"]='action=shop&method=WOWd2d&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>

	<?php runFunc('editData',array($this->_tpl_vars["AddressNodeId"],$this->_tpl_vars["AddressContentModel"],$this->_tpl_vars["AddressNode"]["0"]["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	<script>location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>"</script>
<?php } ?>
