<?php import('core.util.RunFunc'); ?>
<?php $settings =  runFunc("getGlobalSetting");?>
<?php $itemTotal = (float)($this->_tpl_vars["itemQTY"] * $this->_tpl_vars["itemPrice"]);?>
<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart set ItemQTY='{$this->_tpl_vars["itemQTY"]}',itemTotal = '{$itemTotal}' where cartID='{$this->_tpl_vars["cartID"]}'",
 );
	$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

<?php
$cart = runFunc("getCartById",array($this->_tpl_vars["cartID"]));
if ($this->_tpl_vars["cartType"]=='New'){?>
	<?php
		 import('core.apprun.cmsware.CmswareNode');
		 import('core.apprun.cmsware.CmswareRun');
		 global $PageInfo,$params,$PageInfo2,$params2,$PageInfo3,$params3;
		 $params = array (
			'action' => "sql",
			'return' => "cartInfo",
			'query' => "SELECT SUM(a.itemTotal) as totalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.ItemStatus = '{$this->_tpl_vars["cartType"]}' and a.cart_type = 1 and a.cartID in ({$this->_tpl_vars["cartIdStr"]}) and b.goodsShopId = '{$this->_tpl_vars["goodsShopId"]}'",
		 );
		$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
	    $this->_tpl_vars['PageInfo'] = &$PageInfo;

		//总价钱
		 $params2 = array (
			'action' => "sql",
			'return' => "cartInfoAll",
			'query' => "SELECT sum(itemTotal) as sellerSubTotalPrice,sum(ItemQTY) as itemNumTotal FROM cms_publish_cart WHERE UserName='{$this->_tpl_vars["userId"]}' and ItemStatus = '{$this->_tpl_vars["cartType"]}' and cart_type = 1 and cartID in ({$this->_tpl_vars["cartIdStr"]})",
		 );
			$this->_tpl_vars['cartInfoAll'] = CMS::CMS_sql($params2);
		    $this->_tpl_vars['PageInfo2'] = &$PageInfo2;
		//总运费
		$params3 = array (
		'action' => "sql",
		'return' => "shopList",
		'query' => "SELECT b.goodsShopId FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.ItemStatus = '{$this->_tpl_vars["cartType"]}' and cart_type = 1 and cartID in ({$this->_tpl_vars["cartIdStr"]}) Group By b.goodsShopId",
		);

		$this->_tpl_vars['shopList'] = CMS::CMS_sql($params3);
		$this->_tpl_vars['PageInfo'] = &$PageInfo3;
	?>
<?php }else{?>

		<?php
/*			 import('core.apprun.cmsware.CmswareNode');
			 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "cartInfo",
				'query' => "SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice) as totalPrice  FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["userId"]}' and a.cartID in ({$this->_tpl_vars["cartIdStr"]}) Order By a.cartid DESC",
			 );
			$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
			$this->_tpl_vars['PageInfo'] = &$PageInfo;*/
		?>
<?php } ?>

<?php
	if($cart[0]["cart_type"]==1){
		//商品总价
		$itemTotal = number_format($cart[0]["itemTotal"], 2, '.', ',');
		//店铺总价
		$sellerTotalPrice = number_format($this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"], 2, '.', ',');
		//店铺运费
		$sellerFreightPrice = number_format($settings[0]["freight"],2,'.',',');
		//商品总数
		$itemNumTotal = $this->_tpl_vars['cartInfoAll']["data"]["0"]["itemNumTotal"];
		//总价钱
		$sellerSubTotalPrice = number_format($this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"],2,'.',',');
		//总服务费
		$serviceFeePrice = number_format($settings[0]["service_fee"]*$this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"], 2, '.', ',');
		//总运费
		$shopNum =  count($this->_tpl_vars['shopList']["data"]);//商店数目
		$sellerSubFreightPrice =  number_format($shopNum*$settings[0]["freight"], 2, '.', ',');//总运费
		//总总价钱
		$sellerAllTotalPrice = number_format(($shopNum*$settings[0]["freight"]) + $this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"] + ($settings[0]["service_fee"]*$this->_tpl_vars['cartInfoAll']["data"]["0"]["sellerSubTotalPrice"]), 2, '.', ',');//总价钱

	}else{
/*		$total_price = $this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"];
		$itemFreight = $this->_tpl_vars["cartInfo"]["data"]["0"]["itemFreight"];	*/
		$cart_msg = runFunc("getGroupCartPriceTypeTotal",array($this->_tpl_vars["userId"],$this->_tpl_vars["cartIdStr"]));
		$total_price = $cart_msg["0"]["totalPrice"];
		$itemFreight = $cart_msg["0"]["itemFreight"];
	}?>

<?php return $this->_tpl_vars["cartID"].'-'.$this->_tpl_vars["goodsShopId"].'-'.$itemTotal. '-' .$sellerTotalPrice. '-' .$sellerFreightPrice. '-' .$sellerSubTotalPrice. '-' .$serviceFeePrice. '-' .$sellerSubFreightPrice. '-' .$sellerAllTotalPrice.'-'.$itemNumTotal;?>
