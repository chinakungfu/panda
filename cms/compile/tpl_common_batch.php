<?php import('core.util.RunFunc'); ?><?php if ($this->_tpl_vars["method"]=='update'){?>
	<?php if ($this->_tpl_vars["type"]=='0'){?>
		<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
	<?php }else{ ?>
		<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='publish'){ ?>
	<?php if ($this->_tpl_vars["type"]=='0'){?>
		<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
	<?php }else{ ?>
		<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='cancelPublish'){ ?>
	<?php if ($this->_tpl_vars["type"]=='0'){?>
		<?php runFunc('cancelPublish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
	<?php }else{ ?>
		<?php runFunc('cancelPublish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='tempCancelPublish'){ ?>
	<?php if ($this->_tpl_vars["type"]=='0'){?>
		<?php runFunc('tempCancelPublish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId='.$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
	<?php }else{ ?>
		<?php runFunc('tempCancelPublish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
		<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='saveCopy'){ ?>
	<?php runFunc('batchCopy',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["parentId"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>window.opener.location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';top.window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveMove'){ ?>
	<?php runFunc('batchMove',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["parentId"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>window.opener.location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';top.window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='batchTop'){ ?>
	<?php runFunc('batchTop',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>window.opener.location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';top.window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='batchBest'){ ?>
	<?php runFunc('batchBest',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>window.opener.location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';top.window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='batchSort'){ ?>
	<?php runFunc('batchSort',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["IN"]["para"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>window.opener.location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';top.window.close();</script>
<?php } elseif ($this->_tpl_vars["method"]=='batchDel'){ ?>
	<?php runFunc('batchDel',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"],'0'))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='foreverDel'){ ?>
	<?php runFunc('foreverDel',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"],'1'))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='createVoidLink'){ ?>
	<?php runFunc('createVoidLink',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='createIndexLink'){ ?>
	<?php runFunc('createIndexLink',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='nodeCancelPublish'){ ?>
	<?php runFunc('nodeCancelPublish',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='nodeTempCancelPublish'){ ?>
	<?php runFunc('nodeTempCancelPublish',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='nodeAllRepublish'){ ?>
	<?php runFunc('nodeAllRepublish',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='resume'){ ?>
	<?php runFunc('resumeData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["selectConId"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-3';</script>
<?php } elseif ($this->_tpl_vars["method"]=='flushRec'){ ?>
	<?php runFunc('flushRecData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-3';</script>
<?php } ?>