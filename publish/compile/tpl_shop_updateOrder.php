<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["tempUrl"]='action=shop&method=orderConfirm&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
<?php $this->_tpl_vars["Urltemp"]='action=shop&method=orderDetail&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
<?php $this->_tpl_vars["Urltemp1"]='action=shop&method=order_modify&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
<?php $this->_tpl_vars["Urltemp2"]='action=website&method=account'; ?>

<?php if ($this->_tpl_vars["method"]=='updateOrder'){?>
	<?php if ($this->_tpl_vars["IN"]["para"]["goodsTitleEn"]!='Input the English name here if you can'){?>
		<?php
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
	'action' => "sql",
	'return' => "updateGoods",
	'query' => "UPDATE cms_publish_goods SET goodsTitleEn = '{$this->_tpl_vars["IN"]["para"]["goodsTitleEn"]}' WHERE goodsID = '{$this->_tpl_vars["IN"]["para"]["goodsID"]}' ",
 );

$this->_tpl_vars['updateGoods'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php } ?>

	<?php if ($this->_tpl_vars["IN"]["para"]["goodsNotes"]=='Please input Color, Size here......'){?>
		<?php $this->_tpl_vars["goodsNotes"]=''; ?>
	<?php } ?>

	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemQTY = '{$this->_tpl_vars["IN"]["para"]["ItemQTY"]}',itemNotes='{$this->_tpl_vars["goodsNotes"]}',itemSize='{$this->_tpl_vars["IN"]["para"]["goodsSize"]}' ,itemColor='{$this->_tpl_vars["IN"]["para"]["goodsColor"]}' WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>

	<?php if (updateCart){?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>

	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='delOrder'){ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php if ($this->_tpl_vars["updateCart"]){?>
		<?php $this->_tpl_vars["NewcartIdStr"]=runFunc('delSpecialWord',array($this->_tpl_vars["cartIDString"],$this->_tpl_vars["cartID"])); ?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET cartIDstr = '{$this->_tpl_vars["NewcartIdStr"]}' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if (updateOrder){?>
			<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
		<?php } ?>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='OrderToWish'){ ?>
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	<?php if ($this->_tpl_vars["name"]){?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if ($this->_tpl_vars["updateCart"]){?>
			<?php $this->_tpl_vars["NewcartIdStr"]=runFunc('delSpecialWord',array($this->_tpl_vars["cartIDString"],$this->_tpl_vars["cartID"])); ?>
			<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET cartIDstr = '{$this->_tpl_vars["NewcartIdStr"]}' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
			<?php if (updateOrder){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["tempUrl"]));?>'</script>
			<?php } ?>
		<?php } ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["paraArr"]["backAction"]=shop; ?>
		<?php $this->_tpl_vars["paraArr"]["backMethod"]=orderConfirm; ?>
		<?php $this->_tpl_vars["paraArr"]["orderID"]=$this->_tpl_vars["IN"]["orderID"]; ?>

		<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

		<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=OrderToWish&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='cancelOrder'){ ?>
	<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
	<?php if ($this->_tpl_vars["name"]){?>
		<?php $this->_tpl_vars["Url"]='action=shop&method=myCart'; ?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET orderStatus = '-1' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php $this->_tpl_vars["tempUrl"]='action=shop&method=myCart&orderID=' . $this->_tpl_vars["IN"]["orderID"]; ?>
		<?php if ($this->_tpl_vars["cancelType"]=='move'){?>
			<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
			<?php if ($this->_tpl_vars["updateCart"]){?>
				<?php $this->_tpl_vars["NewcartIdStr"]=runFunc('delSpecialWord',array($this->_tpl_vars["cartIDString"],$this->_tpl_vars["cartID"])); ?>
				<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET  cartIDstr = '{$this->_tpl_vars["NewcartIdStr"]}' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
				<?php if (updateOrder){?>
					<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>'</script>
				<?php } ?>
			<?php } ?>
		<?php } elseif ($this->_tpl_vars["cancelType"]=='del'){ ?>
			<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
			<?php if ($this->_tpl_vars["updateCart"]){?>
					<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>'</script>
			<?php } ?>
		<?php } ?>
	<?php }else{ ?>
		<?php $this->_tpl_vars["paraArr"]["backAction"]=shop; ?>
		<?php $this->_tpl_vars["paraArr"]["backMethod"]=orderConfirm; ?>
		<?php $this->_tpl_vars["paraArr"]["orderID"]=$this->_tpl_vars["IN"]["orderID"]; ?>

		<?php $this->_tpl_vars["paraStr"]=serialize($this->_tpl_vars["paraArr"]); ?>

		<script>location.href='index.php<?php echo runFunc('encrypt_url',array('action=website&method=login&loginType=cancelOrder&paraStr=' . $this->_tpl_vars["paraStr"] ));?>'</script>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='updateOrderDetail'){ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_cart SET ItemQTY = '{$this->_tpl_vars["IN"]["para"]["ItemQTY"]}',itemNotes='{$this->_tpl_vars["IN"]["para"]["goodsNotes"]}' WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php if ($this->_tpl_vars["updateOrder"]){?>
		<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Urltemp"]));?>'</script>

	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='delOrderDetail'){ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php if ($this->_tpl_vars["updateCart"]){?>
		<?php $this->_tpl_vars["NewcartIdStr"]=runFunc('delSpecialWord',array($this->_tpl_vars["cartIDString"],$this->_tpl_vars["cartID"])); ?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET cartIDstr = '{$this->_tpl_vars["NewcartIdStr"]}' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if (updateOrder){?>
			<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Urltemp"]));?>'</script>
		<?php } ?>
	<?php } ?>





<?php } elseif ($this->_tpl_vars["method"]=='OrderDetailToWish'){ ?>
	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php if ($this->_tpl_vars["updateCart"]){?>
		<?php //echo $this->_tpl_vars["cartIDString"]."<br>";?>
		<?php //echo $this->_tpl_vars["cartID"]."<br>";?>
		<?php $this->_tpl_vars["NewcartIdStr"]=runFunc('delSpecialWord',array($this->_tpl_vars["cartIDString"],$this->_tpl_vars["cartID"])); ?>
		<?php //echo $this->_tpl_vars["NewcartIdStr"];?>

	<?php } ?>
	<?php if (strlen($this->_tpl_vars["NewcartIdStr"])>0){?>
			<?php
			 import('core.apprun.cmsware.CmswareNode');
			 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "updateOrder",
				'query' => "UPDATE cms_publish_order SET cartIDstr = '{$this->_tpl_vars["NewcartIdStr"]}' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
			 );

			$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
				$this->_tpl_vars['PageInfo'] = &$PageInfo;
			?>

			<?php
			$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));


			echo $this->_tpl_vars["NewcartIdStr"]."<br>";
			echo $this->_tpl_vars["IN"]["orderID"]."<br>";
			echo $order["invoice"]."<br>";
			echo $order["group_buy"]."<br>";

			$this->_tpl_vars['updateOrder'] = runFunc("updateUserOrderModify",array($this->_tpl_vars["NewcartIdStr"],$this->_tpl_vars["IN"]["orderID"],$order["invoice"],$order["group_buy"],$dataArray));
			echo $this->_tpl_vars['updateOrder']."1";
			?>

			<?php if (updateOrder){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Urltemp1"]));?>'</script>
			<?php }?>
		<?php }else{?>
			<?php
			 import('core.apprun.cmsware.CmswareNode');
			 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
			 $params = array (
				'action' => "sql",
				'return' => "updateOrder",
				'query' => "UPDATE cms_publish_order SET orderStatus = '-1' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
			 );

			$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
				$this->_tpl_vars['PageInfo'] = &$PageInfo;
			?>
			<?php if (updateOrder){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Urltemp2"]));?>'</script>
			<?php }?>

		<?php } ?>




<?php } elseif ($this->_tpl_vars["method"]=='cancelOrderDetail'){ ?>
	<?php $this->_tpl_vars["Url"]='action=shop&method=myCart'; ?>
	<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "UPDATE cms_publish_order SET orderStatus = '-1' WHERE orderID = '{$this->_tpl_vars["IN"]["orderID"]}' ",
 );

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
	<?php if ($this->_tpl_vars["cancelType"]=='move'){?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Wish'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if ($this->_tpl_vars["updateCart"]){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>'</script>
		<?php } ?>
	<?php } elseif ($this->_tpl_vars["cancelType"]=='del'){ ?>
		<?php
 import('core.apprun.cmsware.CmswareNode');
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
 $params = array (
	'action' => "sql",
	'return' => "updateCart",
	'query' => "UPDATE cms_publish_cart SET ItemStatus = 'Delete'  WHERE cartID = '{$this->_tpl_vars["IN"]["cartID"]}' ",
 );

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params);
    $this->_tpl_vars['PageInfo'] = &$PageInfo;
?>
		<?php if ($this->_tpl_vars["updateCart"]){?>
				<script>location.href='index.php<?php echo runFunc('encrypt_url',array($this->_tpl_vars["Url"]));?>'</script>
		<?php } ?>
	<?php } ?>
<?php } elseif ($this->_tpl_vars["method"]=='submitOrder'){

 	$this->_tpl_vars["user_id"] = runFunc('readSession',array());
 	$this->_tpl_vars["tmpUser"] = runFunc('readCookie',array());

 	if($this->_tpl_vars["user_id"]){
 		$current_user_id = $this->_tpl_vars["user_id"];
 		$pay_link = 'action=shop&method=payment&orderID=';
 	}else{

 		$current_user_id = $this->_tpl_vars["tmpUser"];

 		$pay_link = "action=shop&method=orderSubmit&orderID=";
 	}

 	if($this->_tpl_vars["IN"]["check_type"] == "group_buy"){

 		//$cartStr = runFunc("getUserCartStr",array($current_user_id,2));
		$cartStr = $this->_tpl_vars["IN"]["cartIdStr"];
 	}else{

 		//$cartStr = runFunc("getUserCartStr",array($current_user_id));
		$cartStr = $this->_tpl_vars["IN"]["cartIdStr"];
 	}


	if($cartStr==""){

		header("Location:".runFunc('encrypt_url',array('action=shop&method=myCart')));
		exit;
	}

	$orderAddressId = $this->_tpl_vars["IN"]["orderAddressId"];

	$invoice = $this->_tpl_vars["IN"]["invoice"];

	runFunc("updateCartTax",array($cartStr,$invoice));

	if($this->_tpl_vars["IN"]["check_type"] == "group_buy"){

		$group_buy = true;
	}else{

		$group_buy = false;
	}

	$order_id = runFunc("addCartToOrder",array($current_user_id,$orderAddressId,$cartStr,$invoice,$group_buy));

	//runFunc("updateCartOrderId",array($order_id,$cartStr));

	header("Location:index.php".runFunc('encrypt_url',array($pay_link.$order_id)));

} ?>