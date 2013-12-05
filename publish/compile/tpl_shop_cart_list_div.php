<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["userName"]=runFunc('readSession',array()); ?>

<?php if ($this->_tpl_vars["userName"]==''){?>
<?php $this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); ?>
	<?php if ($this->_tpl_vars["CookieUser"]){?>
		<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["CookieUser"]; ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["tmpUser"]=runFunc('getSessionID',array()); ?>
		<?php runFunc('writeCookie',array($this->_tpl_vars["tmpUser"]))?>
	<?php } ?>
<?php }else{ ?>
	<?php $this->_tpl_vars["tmpUser"]=$this->_tpl_vars["userName"]; ?>
<?php } ?>

<?php


	$carts = runFunc("getCartItemsById",array($this->_tpl_vars["tmpUser"]));

?>

<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "cartInfo",
	'query' => "SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' Order By a.cartid DESC",
 );

$this->_tpl_vars['cartInfo'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

<?php $this->_tpl_vars["SubTotalPrice"]=0; ?>
<?php $this->_tpl_vars["cartListNum"]=5; ?>
<?php $this->_tpl_vars["SubTotalPrice"]=number_format($this->_tpl_vars["cartInfo"]["data"]["0"]["totalPrice"], 2, '.', ','); ?>
<div class="viewShoppingBag">
	<h2 class="viewShoppingBagHead">
	 <a style="color:white;float:left;" href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>">View shopping bag</a>
	 <a href="#" class="close fr textHide mr12" id="close" onclick="$('.popupLayer').hide();">close</a>
	 <span>Subtotal: <?php echo $this->_tpl_vars["SubTotalPrice"];?></span>
	</h2>

	<div class="viewShoppingBagCont" id="dataStr1" >
	   <p>Note: Special offers will be applied after checkout.</p>
	   <span><?php echo $this->_tpl_vars["cartInfo"]["data"]["0"]["ItemQTY"];?> items in your bag</span>
	   <?php if(count($carts)>0){
 foreach ($carts as $cart){ ?>

	   <?php
	   if($cart["cart_type"]==1){
			$item = runFunc("getCartGoodsItem",array($cart["ItemGoodsID"]));
			$title = $item[0]["goodsTitleCN"];
	   }elseif($cart["cart_type"]==2){
		   	$item = runFunc("getSiteGroupBuyItem",array($cart["ItemGoodsID"]));
		   	$title = $item[0]["item_name"];
	   }
	   ?>
	   <dl>
	       <dt class="fl">

		    <img src="<?php echo $item[0]["goodsImgURL"]."_100x100.jpg";?>"  style="width:75px; border="0">

	       </dt>
	   	  <dd><strong><?php if(strlen($title)> 20){
					echo mb_substr($title,0,20,'utf-8')."...";
					}else{
						echo $title;
					}?></strong></dd>

	       <?php $this->_tpl_vars["SinglePrice"]=number_format($cart["itemPrice"], 2, '.', ','); ?>
	       <dd>Price:￥ <?php echo $this->_tpl_vars["SinglePrice"];?></dd>
	       <dd>Qty: <?php echo $cart["ItemQTY"];?></dd>
	       <dd>Seller Freight : <?php if ($cart["itemFreight"]<=0){?>NO<?php }else{ ?><?php $this->_tpl_vars["Freight"]=number_format($cart["itemFreight"], 2, '.', ','); ?><?php echo $this->_tpl_vars["Freight"];?><?php } ?></dd>
	  	   <?php if($cart["cart_type"]==2):?><dd><strong>GROUP BUY</strong></dd><?php endif;?>
	   </dl>
	   <?php } ?>
	   <?php  }
 ?>
	   </div>
		<div class="viewShoppingBagfoot">
			<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>" class="btn fl buyMore">Buy More</a>

			<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>" class="btn fl checkout">Checkout</a>
	   </div>
	</div>
