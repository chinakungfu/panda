<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
	<?php $this->_tpl_vars["wishNodeId"]=runFunc('getGlobalModelVar',array('WishListNode')); ?>
	<?php $this->_tpl_vars["wishNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["wishNodeId"])); ?>	
	<?php if ($this->_tpl_vars["method"]=='addWish'){?>
		<?php $this->_tpl_vars["wishPara"]["nodeId"]=$this->_tpl_vars["wishNode"]["0"]["nodeGuid"]; ?>
		<?php $this->_tpl_vars["wishPara"]["ItemStatus"]='Wish'; ?>	
		<?php if ($this->_tpl_vars["IN"]["loginType"]=='addWish'){?>	
			<?php $this->_tpl_vars["wishPara"]["ItemQTY"]=$this->_tpl_vars["IN"]["ItemQTY"]; ?>
			<?php $this->_tpl_vars["wishPara"]["UserName"]=$this->_tpl_vars["name"]; ?>
			<?php $this->_tpl_vars["wishPara"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["ItemGoodsID"]; ?>
			<?php $this->_tpl_vars["wishPara"]["itemPrice"]=$this->_tpl_vars["IN"]["itemPrice"]; ?>
			<?php $this->_tpl_vars["wishPara"]["itemFreight"]=$this->_tpl_vars["IN"]["itemFreight"]; ?>
			<?php $this->_tpl_vars["tempUrl"]='action=surprise&method=item_show&id='.$this->_tpl_vars["IN"]["page_id"].'&show_type=normal&from='.$this->_tpl_vars["IN"]["from"]; ?>
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "wishCount",
	'query' => "select count(cartID) as qty from cms_publish_cart where ItemGoodsID='{$this->_tpl_vars["IN"]["ItemGoodsID"]}' and UserName='{$this->_tpl_vars["name"]}' and ItemStatus='Wish'",
 ); 

$this->_tpl_vars['wishCount'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
		<?php }else{ ?>
			<?php $this->_tpl_vars["tempUrl"]='action=surprise&method=item_show&id='.$this->_tpl_vars["IN"]["page_id"].'&show_type=normal&from='.$this->_tpl_vars["IN"]["from"]; ?>
			<?php $this->_tpl_vars["wishPara"]["ItemQTY"]=$this->_tpl_vars["IN"]["para"]["ItemQTY"]; ?>
			<?php $this->_tpl_vars["wishPara"]["UserName"]=$this->_tpl_vars["name"]; ?>
			<?php $this->_tpl_vars["wishPara"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["para"]["goodsID"]; ?>	
			<?php $this->_tpl_vars["wishPara"]["itemPrice"]=$this->_tpl_vars["IN"]["para"]["itemPrice"]; ?>
			<?php $this->_tpl_vars["wishPara"]["itemFreight"]=$this->_tpl_vars["IN"]["para"]["itemFreight"]; ?>
			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "wishCount",
	'query' => "select count(cartID) as qty from cms_publish_cart where ItemGoodsID='{$this->_tpl_vars["IN"]["para"]["goodsID"]}' and UserName='{$this->_tpl_vars["name"]}' and ItemStatus='Wish'",
 ); 

$this->_tpl_vars['wishCount'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
		<?php } ?>		
			<?php if ($this->_tpl_vars["wishCount"]["data"]["0"]["qty"]==0){?>	
				<?php $this->_tpl_vars["addCartTable"]=runFunc('addData',array($this->_tpl_vars["wishNodeId"],$this->_tpl_vars["wishNode"]["0"]["appTableName"],$this->_tpl_vars["wishPara"])); 
			$re = array("re"=>1);echo json_encode($re);}else{ $re = array("re"=>0);echo json_encode($re);}?>
		
	<?php } ?>
<?php }else{ ?>
	<?php $this->_tpl_vars["paraArr"]["backAction"]=shop; ?>
	<?php $this->_tpl_vars["paraArr"]["backMethod"]=addWish; ?>
	<?php $this->_tpl_vars["paraArr"]["ItemQTY"]=$this->_tpl_vars["IN"]["para"]["ItemQTY"]; ?>
	<?php $this->_tpl_vars["paraArr"]["ItemGoodsID"]=$this->_tpl_vars["IN"]["para"]["goodsID"]; ?>
	<?php $this->_tpl_vars["paraArr"]["itemPrice"]=$this->_tpl_vars["IN"]["para"]["itemPrice"]; ?>
	<?php $this->_tpl_vars["paraArr"]["itemFreight"]=$this->_tpl_vars["IN"]["para"]["itemFreight"]; ?>

	<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

	<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=addWish&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
<?php } ?>




