<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->_tpl_vars["node"]=runFunc('getNodeInfoById',array($this->_tpl_vars["nodeId"])); ?>
<?php $this->_tpl_vars["conPlanInfo"]=runFunc('getContentPlanInfoById',array($this->_tpl_vars["node"]["0"]["contentPlanId"])); ?>
<?php if(!empty($this->_tpl_vars['actParam'])){ 
 foreach ($this->_tpl_vars['actParam'] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
	<?php $this->_tpl_vars["actParamStr"]=$this->_tpl_vars["actParamStr"] . '&' .$this->_tpl_vars["key"] . '=' . $this->_tpl_vars["var"]; ?>
<?php  }
} ?>

<?php $this->_tpl_vars["cartNodeId"]=runFunc('getGlobalModelVar',array('cartNodle')); ?>
<?php $this->_tpl_vars["cartNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["cartNodeId"])); ?>
<?php $this->_tpl_vars["cartContentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>
<?php $this->_tpl_vars["tempUrl"]='action=wow&method=myCart&nodeId=GWCGLHat1'; ?>

<?php if ($this->_tpl_vars["method"]=='addCart'){?>
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
	<?php $this->_tpl_vars["addGoodsTable"]=runFunc('addData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["IN"]["para"])); ?>		
	<?php runFunc('publish',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["node"]["0"]["appTableKeyName"],$this->_tpl_vars["addGoodsTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>	
	<?php $this->_tpl_vars["cartPara"]["nodeId"]=$this->_tpl_vars["cartNode"]["0"]["nodeGuid"]; ?>
	<?php $this->_tpl_vars["cartPara"]["ItemStatus"]='New'; ?>
	<?php $this->_tpl_vars["cartPara"]["ItemQTY"]=$this->_tpl_vars["ItemQTY"]; ?>
	<?php $this->_tpl_vars["cartPara"]["UserName"]=$this->_tpl_vars["IN"]["para"]["goodsAddUser"]; ?>
	<?php $this->_tpl_vars["cartPara"]["ItemGoodsID"]=$this->_tpl_vars["addGoodsTable"]; ?>	
	<?php $this->_tpl_vars["addCartTable"]=runFunc('addData',array($this->_tpl_vars["cartNodeId"],$this->_tpl_vars["cartContentModel"],$this->_tpl_vars["cartPara"])); ?>		
	<?php runFunc('publish',array($this->_tpl_vars["cartNodeId"],$this->_tpl_vars["cartContentModel"],$this->_tpl_vars["cartNode"]["0"]["appTableKeyName"],$this->_tpl_vars["addCartTable"],$this->_tpl_vars["selectConId"],$this->_tpl_vars["frameListAction"],$this->_tpl_vars["frameListMethod"],$this->_tpl_vars["extraPublishId"],$this->_tpl_vars["type"]))?>
	
	<?php if ($this->_tpl_vars["isLogin"]==0){?>	
		<?php runFunc('writeCookie',array($this->_tpl_vars["IN"]["para"]["goodsAddUser"]))?>
		<?php echo $this->_tpl_vars["IN"]["para"]["goodsAddUser"];?>
	<?php } ?>
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