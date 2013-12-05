<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='addGoods'){?>
	
	<?php $this->_tpl_vars["backUrl"]='action=website&method=shopindex&grapRst=alert'; ?>
			
	<?php $this->_tpl_vars["nodeId"]=$this->_tpl_vars["IN"]["para"]["nodeId"]; ?>
	<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["node"]["0"]["nodeGuid"]; ?>
	
	<?php $this->_tpl_vars["para"]["goodsStatus"]='Open'; ?>
	<?php $this->_tpl_vars["para"]["goodsType"]='inside'; ?>
	
	
	<?php $this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["para"])); ?>	
	<?php if ($this->_tpl_vars["addGoodsTable"]){?>
		<?php $this->_tpl_vars["publishGoods"]=runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["addGoodsTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>	
		<?php if ($this->_tpl_vars["publishGoods"]){?>
			<script>
			alert("Add successfully!");			
			location.href='index.php<?php echo runFunc('encrypt_url',array('action=admin&method=goodsDetail&goodsID=' . $this->_tpl_vars["addGoodsTable"]));?>'
			</script>
		<?php }else{ ?>
			<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
		<?php } ?>
	<?php }else{ ?>
		<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["backUrl"]));?>'</script>
	<?php } ?>			
			
	
<?php } ?>