<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Cart</title>
	<link rel="stylesheet" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/css/style.css"/>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){ 
				$(document).pngFix(); 
			}); 
	</script>
</head>
<body>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/red_header.tpl
LNMV
);
include($inc_tpl_file);
?>


	<div class="wow-body">
		<div class="wow-body-contain">
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/top_guide.tpl
LNMV
);
include($inc_tpl_file);
?>

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/wow_left.tpl
LNMV
);
include($inc_tpl_file);
?>

			<div class="line2-full left">
				<h3 class="wow-module-title">
					SHOPPING CART
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center">Price</th>
						<th width="16%" align="center">Quantity</th>
					</tr>
				<?php $this->_tpl_vars["SubTotalPrice"]=0; ?>				
				 <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "cartList",
	'query' => "SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["name1"]}' and a.ItemStatus = 'New'",
	'orderby' => "i.publishDate DESC",
 ); 

$this->_tpl_vars['cartList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
            			 <?php $this->_tpl_vars["goodsIDstr_tmp"]=''; ?>
				 <?php if(!empty($this->_tpl_vars["cartList"]["data"])){ 
 foreach ($this->_tpl_vars["cartList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>							
							<img class="left item-view-s" src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt=""/>
							<span class="left item-name"><?php echo $this->_tpl_vars["var"]["goodsTitleEn"];?></span>
						</td>
						<td>
							<a class="ce" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=wow&method=DeleteData&nodeId=71&cartID=' .$this->_tpl_vars["var"]["cartID"]));?>">delete</a> 
							<a class="ce" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=wow&method=CartToWish&nodeId=71&cartID=' .$this->_tpl_vars["var"]["cartID"]));?>" >save as wish</a>
						</td>
						<td align="center">RMB <?php echo $this->_tpl_vars["var"]["goodsUnitPrice"];?></td>
						<td align="center">
							<span class="qcb">-</span> <input type="text" class="iq" value="<?php echo $this->_tpl_vars["var"]["ItemQTY"];?>"/> <span class="qcb">+</span>
						</td>
					</tr>
				<?php $this->_tpl_vars["SubTotalPrice"]=$this->_tpl_vars["SubTotalPrice"]+$this->_tpl_vars["var"]["ItemQTY"]*$this->_tpl_vars["var"]["goodsUnitPrice"]; ?>
				<?php if ($this->_tpl_vars["goodsIDstr_tmp"]){?>
				<?php $this->_tpl_vars["goodsIDstr_tmp"]=$this->_tpl_vars["goodsIDstr_tmp"] . ',' . $this->_tpl_vars["var"]["ItemGoodsID"]; ?>
				<?php }else{ ?>
				<?php $this->_tpl_vars["goodsIDstr_tmp"]=$this->_tpl_vars["var"]["ItemGoodsID"]; ?>
				<?php } ?>
				<?php  }
} ?>					

					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td align="right" colspan=2>Subtotal (<?php echo $this->_tpl_vars["var_CartNum"]["cnum"];?> items ):</td>
					
						<td align="center">RMB <?php echo $this->_tpl_vars["SubTotalPrice"];?></td>
						<td align="center">
						<?php $this->_tpl_vars["orderNo"]=strtotime(date("Y-m-d H:i:s",time())) . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT); ?>
						<form name="form" action="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php" method="post">
						<input type="hidden" name="action" value="wow">
						<input type="hidden" name="method" value="addOrder">
						<input type="hidden" name="nodeId" value="<?php echo runFunc('getGlobalModelVar',array('orderNode'));?>">
						<input type="hidden" name="para[goodsIDstr]" value="<?php echo $this->_tpl_vars["goodsIDstr_tmp"];?>">
						<input type="hidden" name="para[OrderNo]" value="<?php echo $this->_tpl_vars["orderNo"];?>">
						<input id="ocheck" type="submit" class="button-link" value="Checkout"/>
						<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
						<?php if ($this->_tpl_vars["name"]){?>
							<input type="hidden" name="para[goodsAddUser]" value="<?php echo $this->_tpl_vars["name"];?>">	
							<input type="hidden" name="isLogin" value="1">	
						<?php }else{ ?>	
							<input type="hidden" name="isLogin" value="0">
							<input type="hidden" name="para[goodsAddUser]" value="<?php echo runFunc('getSessionID',array());?>">
						<?php } ?>
						</form>
						
						</td>

						
					</tr>
				</table>
				<h3 id="wl-title" class="wow-module-title sec-title">
					WISH LIST
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center"></th>
						<th width="16%" align="center"></th>
					</tr>
					
					 <?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "WishList",
	'query' => "SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["name1"]}' and a.ItemStatus = 'Wish'",
	'orderby' => "i.publishDate DESC",
	'num' => "3",
 ); 

$this->_tpl_vars['WishList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php if(!empty($this->_tpl_vars["WishList"]["data"])){ 
 foreach ($this->_tpl_vars["WishList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<img class="left item-view-s" src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt=""/>
							<span class="left item-name"><?php echo $this->_tpl_vars["var"]["goodsTitleEn"];?></span>
						</td>
						<td>
							<a class="ce" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=wow&method=DeleteData&nodeId=71&cartID=' .$this->_tpl_vars["var"]["cartID"]));?>">delete</a> 
							<a class="ce" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>publish/index.php<?php echo runFunc('encrypt_url',array('action=wow&method=WishToCart&nodeId=71&cartID=' .$this->_tpl_vars["var"]["cartID"]));?>" >move to cart</a>
						</td>
						<td align="center">RMB <?php echo $this->_tpl_vars["var"]["goodsUnitPrice"];?></td>
						<td align="center">
							
						</td>
					</tr>
					<?php  }
} ?>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/red_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

</body>
</html>