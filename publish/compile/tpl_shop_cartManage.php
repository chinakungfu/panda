<?php import('core.util.RunFunc'); ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->_tpl_vars["cartNodeId"]=runFunc('getGlobalModelVar',array('cartNode')); ?>
<?php $this->_tpl_vars["cartNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["cartNodeId"])); ?>
<?php $this->_tpl_vars["cartContentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>

<?php $this->_tpl_vars["wishNodeId"]=runFunc('getGlobalModelVar',array('WishListNode')); ?>
<?php $this->_tpl_vars["wishNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["wishNodeId"])); ?>
<?php $this->_tpl_vars["wishContentModel"]=$this->_tpl_vars["wishNode"]["0"]["appTableName"]; ?>

<?php 
		if($this->_tpl_vars["IN"]["type"]=="account_wish"){
			$this->_tpl_vars["tempUrl"]='action=account&method=wishlist';
		}else{
				$this->_tpl_vars["tempUrl"]='action=shop&method=myCart'; 
			
		}
?>

<?php if ($this->_tpl_vars["method"]=='WishToCart'){?>

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["cartNode"]["0"]["appTableKeyName"]; ?>
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["ItemStatus"]='New'; ?>
	<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["cartNode"]["0"]["nodeGuid"]; ?>

	<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>
	
	<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
<?php } elseif ($this->_tpl_vars["method"]=='CartToWish'){ 
			import('core.apprun.cmsware.CmswareNode');
			import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			$params = array (
				'action' => "sql",
				'return' => "addresslist",
				'query' => "UPDATE a0222211743.cms_publish_cart SET ItemQTY='1',itemNotes='',props='' WHERE cartID='{$this->_tpl_vars["IN"]["cartID"]}'",
			);
			CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;
		
		
		
		
	?>	
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	<?php if ($this->_tpl_vars["name"]){?>
		<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>
		<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["cartNode"]["0"]["appTableKeyName"]; ?>
		<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
		<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
		<?php $this->_tpl_vars["para"]["ItemStatus"]='Wish'; ?>
		<?php $this->_tpl_vars["para"]["nodeId"]=$this->_tpl_vars["wishNode"]["0"]["nodeGuid"]; ?>
		
		<?php
		 import('core.apprun.cmsware.CmswareNode'); 
		 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
		 $params = array ( 
	'action' => "sql",
	'return' => "wishCount",
	'query' => "select count(cartID) as qty from cms_publish_cart where cartID='{$this->_tpl_vars["IN"]["$cartID"]}' and UserName='{$this->_tpl_vars["name"]}'",
 ); 

$this->_tpl_vars['wishCount'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
		<?php if ($this->_tpl_vars["wishCount"]["data"]["0"]["qty"]==0){?>
			<?php runFunc('editData',array($this->_tpl_vars["nodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>			
			<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
		<?php }else{ ?>
			<script>alert("This item has already in your Wish List, please don't add it repeatedly.");location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
		<?php } ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["paraArr"]["backAction"]=shop; ?>
		<?php $this->_tpl_vars["paraArr"]["backMethod"]=myCart; ?>		

		<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

		<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=CartToWish&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
	<?php } ?>
	
<?php } elseif ($this->_tpl_vars["method"]=='DeleteData'){ ?>
	

	<?php $this->_tpl_vars["contentModel"]=$this->_tpl_vars["cartNode"]["0"]["appTableName"]; ?>
	<?php $this->_tpl_vars["appTableKeyName"]=$this->_tpl_vars["cartNode"]["0"]["appTableKeyName"]; ?>
	<?php $this->_tpl_vars["appTableKeyValue"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["cartID"]=$this->_tpl_vars["cartID"]; ?>
	<?php $this->_tpl_vars["para"]["ItemStatus"]='Delete'; ?>
	
	<?php runFunc('editData',array($this->_tpl_vars["cartNodeId"],$this->_tpl_vars["contentModel"],$this->_tpl_vars["appTableKeyName"],$this->_tpl_vars["appTableKeyValue"],$this->_tpl_vars["para"]))?>

	
		
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>

<?php } ?>