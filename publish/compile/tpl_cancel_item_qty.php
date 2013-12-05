<?php import('core.util.RunFunc'); ?>
<?php $settings =  runFunc("getGlobalSetting");?>
<?php
if($this->_tpl_vars["dataType"] == 'Delete'){
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
		'action' => "sql",
		'return' => "updateCart",
		'query' => "update cms_publish_cart set ItemStatus='Delete' where cartID='{$this->_tpl_vars["cartID"]}'",
	 );
	$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
}else if($this->_tpl_vars["dataType"] == 'Wish'){
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
		'action' => "sql",
		'return' => "updateCart",
		'query' => "update cms_publish_cart set ItemStatus='Wish',nodeId='WishListhhZI',ItemQTY='1' where cartID='{$this->_tpl_vars["cartID"]}'",
	 );
	$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
}
?>

<?php
$cart = runFunc("getCartById",array($this->_tpl_vars["cartID"]));
if ($this->_tpl_vars["cartType"]=='New' && $this->_tpl_vars["cartIdStr"]){

		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;

		 $params = array (
			'action' => "sql",
			'return' => "cartInfo",
			'query' => "SELECT sum(a.itemTotal) as totalPrice FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.ItemStatus = '{$this->_tpl_vars["cartType"]}' and a.cart_type = 1 and a.cartID in ({$this->_tpl_vars["cartIdStr"]}) and b.goodsShopId = '{$this->_tpl_vars["goodsShopId"]}'",
		 );
			$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
		    $this->_tpl_vars['PageInfo'] = &$PageInfo;
		//总价钱
		 $params2 = array (
			'action' => "sql",
			'return' => "cartInfoAll",
			'query' => "SELECT sum(itemTotal) as sellerSubTotalPrice,sum(ItemQTY) as itemNumTotal FROM a0222211743.cms_publish_cart WHERE UserName='{$this->_tpl_vars["userId"]}' and ItemStatus = '{$this->_tpl_vars["cartType"]}' and cart_type = 1 and cartID in ({$this->_tpl_vars["cartIdStr"]})",
		 );
			$this->_tpl_vars['cartInfoAll'] = CMS::CMS_sql($params2);
		    $this->_tpl_vars['PageInfo2'] = &$PageInfo2;
		//总运费
		$params3 = array (
		'action' => "sql",
		'return' => "shopList",
		'query' => "SELECT b.goodsShopId FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.ItemStatus = '{$this->_tpl_vars["cartType"]}' and cart_type = 1 and cartID in ({$this->_tpl_vars["cartIdStr"]}) Group By b.goodsShopId",
		);

		$this->_tpl_vars['shopList'] = CMS::CMS_sql($params3);
		$this->_tpl_vars['PageInfo'] = &$PageInfo3;

	if($cart[0]["cart_type"]==1){
		//商品总价
		$itemTotal = number_format($cart[0]["itemTotal"], 2, '.', ',');

		if($this->_tpl_vars["cartInfo"]["data"]){
			//店铺总价
			$sellerTotalPrice = number_format($this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"], 2, '.', ',');
			//店铺运费
			$sellerFreightPrice = number_format($settings[0]["freight"],2,'.',',');
		}else{
			$sellerTotalPrice = number_format(0, 2, '.', ',');
			$sellerFreightPrice = number_format(0,2,'.',',');
		}
		if($this->_tpl_vars['cartInfoAll']["data"]){
			//商品总数
			$itemNumTotal = $this->_tpl_vars['cartInfoAll']["data"]["0"]["itemNumTotal"];
			//总价钱
			$sellerSubTotalPrice = number_format($this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"],2,'.',',');
			//总服务费
			$serviceFeePrice = number_format($settings[0]["service_fee"]*$this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"], 2, '.', ',');
			if($serviceFeePrice < 20 && $serviceFeePrice > 0){
				$serviceFeePrice = 20;
			}				
		}else{
			$sellerSubTotalPrice = number_format(0, 2, '.', ',');
			$serviceFeePrice = number_format(0,2,'.',',');
		}
		if($this->_tpl_vars['shopList']["data"]){
			//总运费
			$shopNum =  count($this->_tpl_vars['shopList']["data"]);//商店数目
			$sellerSubFreightPrice =  number_format($shopNum*$settings[0]["freight"], 2, '.', ',');//总运费
			//总总价钱
			$sellerAllTotalPrice = number_format(($shopNum*$settings[0]["freight"]) + $this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"] + ($settings[0]["service_fee"]*$this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"]), 2, '.', ',');//总价钱
		}else{
			$sellerSubFreightPrice = number_format(0, 2, '.', ',');
			$sellerAllTotalPrice = number_format(0,2,'.',',');
		}

	}else{
		$cart_msg = runFunc("getGroupCartPriceTypeTotal",array($this->_tpl_vars["userId"],$this->_tpl_vars["cartIdStr"]));
		$total_price = $cart_msg["0"]["totalPrice"];
		$itemFreight = $cart_msg["0"]["itemFreight"];
	}
	return $this->_tpl_vars["cartID"].'-'.$this->_tpl_vars["goodsShopId"].'-'.$itemTotal. '-' .$sellerTotalPrice. '-' .$sellerFreightPrice. '-' .$sellerSubTotalPrice. '-' .$serviceFeePrice. '-' .$sellerSubFreightPrice. '-' .$sellerAllTotalPrice.'-'.$itemNumTotal;

}else{

	return false;

}?>




