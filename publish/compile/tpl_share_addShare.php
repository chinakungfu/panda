<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["shareNodeId"]=runFunc('getGlobalModelVar',array('shareNode')); ?>
<?php $this->_tpl_vars["shareNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["shareNodeId"])); ?>
<?php $this->_tpl_vars["shareContentModel"]=$this->_tpl_vars["shareNode"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]==''){?>
	<script>alert("Sorry, you are not login!");location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=shareindex'));?>"</script>
<?php } ?>
<?php if (empty($this->_tpl_vars["sharePara"]["shareComment"])){?>
	<script>alert("Sorry, you need input 1 character at least.");location.href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=order'));?>"</script>
<?php }else{ ?>
	<?php if ($this->_tpl_vars["method"]=='addShare'){?>

		<?php $this->_tpl_vars["sharePara"]["goodsId"]=$this->_tpl_vars["IN"]["goodsID"]; ?>
		<?php $this->_tpl_vars["sharePara"]["nodeId"]=$this->_tpl_vars["shareNode"]["0"]["nodeGuid"]; ?>
		<?php $this->_tpl_vars["sharePara"]["userId"]=$this->_tpl_vars["name"]; ?>
		<?php $this->_tpl_vars["sharePara"]["shareStatus"]='1'; ?>
		
		<?php date_default_timezone_set("prc");?>
		<?php $this->_tpl_vars["sharePara"]["shareTime"]=strtotime(date('Y-m-d H:i:s',time())); ?>
		
		<?php $this->_tpl_vars["addshareTable"]=runFunc('addData',array($this->_tpl_vars["shareNodeId"],$this->_tpl_vars["shareContentModel"],$this->_tpl_vars["sharePara"])); ?>		
		<?php if (addshareTable){?>
		
			<?php $this->_tpl_vars["publishshareTable"]=runFunc('publish',array($this->_tpl_vars["shareNodeId"],$this->_tpl_vars["shareContentModel"],$this->_tpl_vars["shareNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addshareTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"])); ?>	
			<?php if (publishshareTable){?>
				<script>location.href="index.php<?php echo runFunc('encrypt_url',array('action=website&method=shareindex'));?>"</script>
			<?php } ?>
		<?php } ?>
	<?php } ?>
<?php } ?>