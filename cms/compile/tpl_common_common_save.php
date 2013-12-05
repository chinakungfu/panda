<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>
<?php $this->_tpl_vars["conPlanInfo"]=runFunc('getContentPlanInfoById',array($this->_tpl_vars["node"]["0"]["contentPlanId"])); ?>
<?php if(!empty($this->_tpl_vars['actParam'])){ 
 foreach ($this->_tpl_vars['actParam'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
	<?php $this->_tpl_vars["actParamStr"]=$this->_tpl_vars["actParamStr"] . '&' .$this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
<?php  }
} ?>
<?php $this->_tpl_vars["tempUrl"]='action=cms&method=commonListFrame&nodeId=' . $this->_tpl_vars["nodeId"] . $this->_tpl_vars["actParamStr"]; ?>
<?php if ($this->_tpl_vars["method"]=='saveAddData'){?>
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["savePre"]!=''){?>
		<?php
$this->_tpl_vars["saveType"] = 0;
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["savePre"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	
	<?php $this->_tpl_vars["addDataResult"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["IN"]["para"])); ?>
	
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["saveNext"]!=''){?>
		<?php
$this->_tpl_vars["saveType"] = 0;
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["saveNext"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveEditData'){ ?>
	<?php $this->_tpl_vars["editDataResult"]=runFunc('getDataByCon',array($this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"]));; ?>
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["savePre"]!=''){?>
		<?php
$this->_tpl_vars["saveType"] = 1;
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["savePre"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	
	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["IN"]["para"]))?>
	
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["saveNext"]!=''){?>
		<?php
$this->_tpl_vars["saveType"] = 1;
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["saveNext"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='delData'){ ?>
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["delPre"]!=''){?>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["delPre"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	
	<?php runFunc('delCommonData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"]))?>
	<?php if ($this->_tpl_vars["conPlanInfo"]["0"]["delNext"]!=''){?>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
{$this->_tpl_vars["conPlanInfo"]["0"]["delNext"]}
LNMV
);
include($inc_tpl_file);
?>

	<?php } ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>';</script>
<?php } elseif ($this->_tpl_vars["method"]=='saveNodeAuth'){ ?>
	<?php runFunc('saveNodeAuth',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["group"],$this->_tpl_vars["user"]))?>
	<?php $this->_tpl_vars["tempUrl"]='action=cms&method=editNode&nodeId=' .$this->_tpl_vars["nodeId"]; ?>
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>#tabs-2'</script>
<?php } ?>