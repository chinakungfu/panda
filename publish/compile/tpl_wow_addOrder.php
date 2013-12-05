<?php import('core.util.RunFunc'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>
<?php $this->_tpl_vars["conPlanInfo"]=runFunc('getContentPlanInfoById',array($this->_tpl_vars["node"]["0"]["contentPlanId"])); ?>
<?php if(!empty($this->_tpl_vars['actParam'])){ 
 foreach ($this->_tpl_vars['actParam'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
	<?php $this->_tpl_vars["actParamStr"]=$this->_tpl_vars["actParamStr"] . '&' .$this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
<?php  }
} ?>
<?php $this->_tpl_vars["ContentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["tempUrl"]=runFunc('getGlobalModelVar',array('Site_Domain')) . 'publish/index.php?LCMSPID=BDUFbwRyVG5XPlA%2BVmwNcFc3X3YAdlE%2BVzYPdAAxBztTZwk9VBUAO1E4AG9WIg9gB1pSaVFiVTIEaQV8W2c%3D'; ?>
<?php echo $this->_tpl_vars["IN"]["para"]["OrderNo"];?>
<?php if ($this->_tpl_vars["method"]=='addOrder'){?>
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
	<?php $this->_tpl_vars["addOrderTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["IN"]["para"])); ?>		
	<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["addOrderTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>	
	
	
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
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
	
<?php } elseif ($this->_tpl_vars["method"]=='WishToCart'){ ?>

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["node"]["0"]["appTableKeyName"]; ?>
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["ItemStatus"]='New'; ?>

	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
	
<?php } elseif ($this->_tpl_vars["method"]=='CartToWish'){ ?>	
	
	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["node"]["0"]["appTableKeyName"]; ?>
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["ItemStatus"]='Wish'; ?>

	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
	
	
<?php } elseif ($this->_tpl_vars["method"]=='DeleteData'){ ?>
	

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["node"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["node"]["0"]["appTableKeyName"]; ?>
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["ItemStatus"]='Delete'; ?>
	
	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>

	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } ?>