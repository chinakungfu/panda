<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
	<?php $this->_tpl_vars["wishNodeId"]=runFunc('getGlobalModelVar',array('WishListNode')); ?>
	<?php $this->_tpl_vars["wishNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["wishNodeId"])); ?>	

	

	<?php if ($this->_tpl_vars["method"]=='addWish'){?>

		<?php $this->_tpl_vars["wishPara"]["nodeId"]=$this->_tpl_vars["wishNode"]["0"]["nodeGuid"]; ?>
		<?php $this->_tpl_vars["wishPara"]["ItemStatus"]='Wish'; ?>

		<?php $this->_tpl_vars["wishPara"]["ItemQTY"]=1; ?>
		<?php $this->_tpl_vars["wishPara"]["UserName"]=$this->_tpl_vars["name"]; ?>
		<?php $this->_tpl_vars["wishPara"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["goodsID"]; ?>
		<?php $this->_tpl_vars["wishPara"]["itemPrice"]=$this->_tpl_vars["IN"]["itemPrice"]; ?>
		<?php $this->_tpl_vars["wishPara"]["itemFreight"]=$this->_tpl_vars["IN"]["itemFreight"]; ?>

		<?php $this->_tpl_vars["tempUrl"]='action=share&method=detail&shareID=' . $this->_tpl_vars["IN"]["shareID"]; ?>

		<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "wishCount",
	'query' => "select count(cartID) as qty from cms_publish_cart where ItemGoodsID='{$this->_tpl_vars["IN"]["goodsID"]}' and UserName='{$this->_tpl_vars["name"]}'  and ItemStatus='Wish'",
 ); 

$this->_tpl_vars['wishCount'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
		
		
	
		
		
		<?php if ($this->_tpl_vars["wishCount"]["data"]["0"]["qty"]==0){?>	
			<?php $this->_tpl_vars["addCartTable"]=runFunc('addData',array($this->_tpl_vars["wishNodeId"],$this->_tpl_vars["wishNode"]["0"]["appTableName"],$this->_tpl_vars["wishPara"])); ?>		
			
			<?php print_r( $this->_tpl_vars["addCartTable"]);?>
			<?php if ($this->_tpl_vars["addCartTable"]){?>
						
				<script>alert("Add Successfully!");location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
			<?php }else{ ?>
				<script>alert("add failed.");location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
			<?php } ?>
		<?php }else{ ?>
			<script>alert("This item has already in your Wish List, please don't add it repeatedly.");location.href="index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>"</script>
		<?php } ?>
		
	<?php } ?>
<?php }else{ ?>
	<?php $this->_tpl_vars["paraArr"]["backAction"]=share; ?>
	<?php $this->_tpl_vars["paraArr"]["backMethod"]=addWish; ?>	
	<?php $this->_tpl_vars["paraArr"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["goodsID"]; ?>
	<?php $this->_tpl_vars["paraArr"]["shareID"]=$this->_tpl_vars["IN"]["shareID"]; ?>
	<?php $this->_tpl_vars["paraArr"]["itemPrice"]=$this->_tpl_vars["IN"]["itemPrice"]; ?>
	<?php $this->_tpl_vars["paraArr"]["itemFreight"]=$this->_tpl_vars["IN"]["itemFreight"]; ?>

	<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=addShareWish&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
<?php } ?>




