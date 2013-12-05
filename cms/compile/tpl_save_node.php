<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_tpl_vars["method"]=='saveAddNode'){?>
	<?php $this->_tpl_vars["result"]=runFunc('addNode',array($this->_tpl_vars["IN"]["para"],parentId)); ?>
	
	<?php if ($this->_tpl_vars["result"]){?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=left&type=site'; ?>
		<?php $this->_tpl_vars["mainTemUrl"]='action=cms&method=editNode&nodeId='. $this->_tpl_vars["result"]; ?>
	<script>parent.frames["mainFrame"].location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["mainTemUrl"]));?>';
	        parent.frames["leftFrame"].location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2';</script>
	<?php }else{ ?>
		<script>alert("该结点标识已存在，请更换才能保存！");window.history.back();</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditNode'){ ?>
	<?php runFunc('editNode',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["IN"]["para"]))?>
	<script>window.history.back();</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveNodeBase'){ ?>
	
	
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=addNode&nodeId=' .$this->_tpl_vars["nodeId"] .'&parentId=' .$this->_tpl_vars["baseNodeId"]; ?>
	<script>window.close();window.opener.parent.document.getElementById('mainFrame').src='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
	
<?php } elseif ($this->_tpl_vars["method"]=='saveSortNode'){ ?>
	<?php runFunc('sortNode',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["order"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=left&type=site'; ?>
	
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2';</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveMoveNode'){ ?>
	<?php runFunc('moveNode',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["parentId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=left&type=site'; ?>
	
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2';</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveSetDefaultNode'){ ?>
	<?php runFunc('isDefaultNode',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["isDefault"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=left&type=site'; ?>
	
	<script>window.close();window.opener.parent.document.getElementById('leftFrame').src='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-1';</script>
<?php } elseif ($this->_tpl_vars["method"]=='delNode'){ ?>
	<?php runFunc('delNode',array($this->_tpl_vars["nodeId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=left'; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>	
<?php } ?>
