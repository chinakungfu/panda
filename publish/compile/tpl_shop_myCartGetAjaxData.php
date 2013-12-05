<?php import('core.util.RunFunc'); ?>
<?php //echo "update cms_publish_cart set ItemQTY='{$this->_tpl_vars["itemQTY"]}' where cartID='{$this->_tpl_vars["cartID"]}'";?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart set ItemQTY='{$this->_tpl_vars["itemQTY"]}' where cartID='{$this->_tpl_vars["cartID"]}'",
 ); 

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  

?>
<?php 
$cart = runFunc("getCartById",array($this->_tpl_vars["cartID"]));
if ($this->_tpl_vars["cartType"]=='New'){?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 
 $params = array ( 
	'action' => "sql",
	'return' => "cartInfo",
	'query' => "SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice) as totalPrice,sum(a.itemFreight) as itemFreight  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.ItemStatus = '{$this->_tpl_vars["cartType"]}' and a.cart_type = 1 and a.cartID in ({$this->_tpl_vars["cartIdStr"]}) Order By a.cartid DESC",
 ); 
$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php }else{?>

<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "cartInfo",
	'query' => "SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.cartID in ({$this->_tpl_vars["cartIdStr"]}) Order By a.cartid DESC",
 ); 
 

$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php } ?>

<?php  
	if($cart[0]["cart_type"]==1){
 	
		$total_price = $this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"];
		$itemFreight = $this->_tpl_vars["cartInfo"]["data"]["0"]["itemFreight"];
	}else{
/*		$total_price = $this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"];
		$itemFreight = $this->_tpl_vars["cartInfo"]["data"]["0"]["itemFreight"];	*/
		$cart_msg = runFunc("getGroupCartPriceTypeTotal",array($this->_tpl_vars["userId"],$this->_tpl_vars["cartIdStr"]));
		$total_price = $cart_msg["0"]["totalPrice"];
		$itemFreight = $cart_msg["0"]["itemFreight"];
	}?>
<?php return  $itemFreight. '-' .  $total_price;?>
