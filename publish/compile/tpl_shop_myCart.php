<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="/publish/skin/jsfiles/shoppingcart.js"></script>
</head>
<body>
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "cartTotal",
	'query' => "SELECT SUM(ItemQTY) as cartTotal,SUM(itemTotal) as sellerSubTotalPrice FROM cms_publish_cart WHERE UserName = '{$this->_tpl_vars["tmpUser"]}' and ItemStatus = 'New'",
	);

	$this->_tpl_vars['cartTotal'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
<?php //print_r($this->_tpl_vars['cartTotal']);exit;?>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "shopList",
	'query' => "SELECT b.goodsShopId,b.goodsShopName,SUM(a.ItemQTY) as shopTotal,SUM(a.itemTotal) as sellerTotalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'New' and cart_type = 1 Group By b.goodsShopId Order By a.cartID DESC",
	);

	$this->_tpl_vars['shopList'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
    <?php $settings =  runFunc("getGlobalSetting");?>
    <?php
		$shopNum =  count($this->_tpl_vars["shopList"]["data"]);//商店数目
		$sellerSubFreightPrice =  number_format($shopNum*$settings[0]["freight"], 2, '.', ',');//总运费
		$sellerSubTotalPrice = number_format($this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品总价
		$serviceFeePrice = number_format($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品服务费
		$sellerAllTotalPrice = number_format(($shopNum*$settings[0]["freight"]) + $this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'] + ($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice']), 2, '.', ',');//总价钱
	?>
    <div id="result"></div>
	<div class="bagNav">
    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">Order History</a> > <a>Shopping Bag</a>
    </div>
    <div class="bagTitle">Items in Your Shopping Bag <span class="smallNum">(<b id="bagItemTatal"><?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal']){ echo $this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'];}else{echo 0;}?></b>)</span></div>
	<?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'] > 0){?>
        <div class="bagContent">
            <form id="submit_cart" action="/publish/index.php" method="post">
            <input type="hidden" name="action" value="shop">
            <input type="hidden" name="method" value="submitCart">
            <input type="hidden" name="goodsitem" value="">
            <table width="976px">
                <tr class="bagTh">
                    <td width="60px"></td>
                    <td width="80px"></td>
                    <td width="440px"></td>
                    <td width="150px" align="center"> Price </td>
                    <td width="120px" align="center"> Qty </td>
                    <td align="center"> Subtotal </td>
                </tr>
                <?php $userid = $this->_tpl_vars["tmpUser"]; ?>
                <?php foreach ($this->_tpl_vars["shopList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
                <?php
					$goodsShopId = $this->_tpl_vars['var']['goodsShopId'];
					$goodsshopName = $this->_tpl_vars['var']['goodsShopName'];
				?>

                <?php $sellerTotalPrice = number_format($this->_tpl_vars["var"]["sellerTotalPrice"], 2, '.', ','); //店铺总价钱?>
                <tr id="all_<?php echo $goodsShopId;?>"><td colspan="6">
                    <table width="976px">
                    <tr class="bagShopName">
                    	<td colspan="3"><span>Store :</span> <a href="<?php echo $this->_tpl_vars["var"]["goodsShopUrl"];?>" target="_blank"><?php echo $goodsshopName;?></a></td>
                    	<td width="150px"></td>
                    	<td width="120px"></td>
                        <td width="126px"><span class="itemShopHide" onClick="hideShop(<?php echo $goodsShopId;?>);"></span><span class="itemShopShow" onClick="showShop(<?php echo $goodsShopId;?>);"></span></td>
                    </tr>
                    <tr class="itemLineBg980" height="2px"><td colspan="6"></td></tr>
                    <tr style="margin-top:10px;" id="<?php echo $goodsShopId;?>">
                        <td colspan="6">
                           <?php $shopItemList = runFunc("getShopItemList",array($userid,$goodsShopId));?>
                            <?php foreach ($shopItemList as $this->_tpl_vars['itemkey'] => $this->_tpl_vars['itemvar']){?>
							<?php
                                if($this->_tpl_vars["itemvar"]["cart_props"] !=""){
                                     $props = explode("|",$this->_tpl_vars["itemvar"]["cart_props"]);
									 $propsArray[]='';
                                     foreach($props as $k => $prop){
                                        $prop_arr = explode(":",$prop);
										$propName = $prop_arr[0];
										$propsArray[$propName] = $prop_arr[1];
                                     }
                                }
								//cartID
								$cartID = $this->_tpl_vars["itemvar"]["cartID"];
								//goodsid
								$goodsid = $this->_tpl_vars['itemvar']['goodsid'];
								//itemPrice
								$itemPrice = $this->_tpl_vars['itemvar']['itemPrice'];
								//itemQTY
								$itemQTY = $this->_tpl_vars["itemvar"]["ItemQTY"];
								//total_price
								$total_price = number_format($this->_tpl_vars["itemvar"]["itemTotal"], 2, '.', ',');
								$isModify = $this->_tpl_vars['itemvar']['modifyPriceStatus'];
							?>
                                    <table style="margin-top:10px;width:976px;table-layout:fixed;word-wrap:break-word;" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td rowspan="2" width="60px" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
                                            <input type="checkbox" class="selectCheckBox"  name="selectgoodsitem" checked="true" onClick="cancelItemQTY(this,'<?php echo $cartID;?>','<?php echo $userid;?>','New','');" value="<?php echo $cartID;?>" />
                                            </td>
                                            <td rowspan="2" width="80px"  align="center" valign="top">
                                                <div class="itemImg"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_100x100.jpg" /></a></div>
                                            </td>
                                            <td width="440px" align="left" valign="top">
                                                <div class="itemTitle">
                                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleCN"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                <div class="itemPrice">¥ <span id="item_price">
													<?php echo number_format($itemPrice, 2, '.', ',');?></span>
                                                </div>
                                            </td>
                                            <td width="120px" align="center" valign="top">
                                            <span class="itemJia" id="<?php echo $cartID;?>_itemJian" onClick="addItemQTY('jian',this,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','New');"> - </span>
                                            <input type="text" value="<?php echo $itemQTY;?>" maxlength="3" class="numtextBag" id="itemQTY<?php echo $this->_tpl_vars["itemkey"];?>" onBlur="changeItemQTY(this,this.value,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','New','');">
                                            <span class="itemJia" id="<?php echo $cartID;?>_itemJia" onClick="addItemQTY('jia',this,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','New');"> + </span>
                                            </td>
                                            <td align="center" valign="top">
                                                <div class="itemPrice">
                                                ¥ <span id="<?php echo $cartID;?>_total_price"><?php echo $total_price; ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td width="440px" align="left" valign="middle">
                                                <div class="itemTitle"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleEn"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleEn"],60));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="middle">

                                            </td>
                                            <td colspan="2" align="right" valign="middle">

                                            </td>
                                        </tr>                                        

                                        <tr>
                                            <td class="itemLineBg980" height="10px" colspan="6"></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2"></td>
                                            <td>
                                                <?php $item_props = json_decode($this->_tpl_vars["itemvar"]["props"],true);?>
                                                <?php foreach($item_props as $item_prop):?>                              
                                                        <?php foreach($item_prop as $key=>$item_prop_values):?>                
                                                        <div class="itemProps">
                                                            <div class="itemPropsName fl"><?php echo ucfirst($key);?>:</div>
                                                            <span class="itemPropsCont">
                                                                <select style="max-width:300px;" class="<?php echo $cartID;?>_props" onChange="changeProps(this,'<?php echo $cartID;?>','<?php echo $userid;?>','props');" name="props[<?php echo $key;?>]" prop_name="<?php echo $key;?>">
                                                                    <?php foreach($item_prop_values as $item_key => $item_value):?>       
                                                                            <option <?php if(strtolower(trim($propsArray[$key])) == strtolower(trim(addslashes($item_value)))){echo 'selected';}?> value="<?php echo addslashes($item_value);?>">
																				<?php echo addslashes($item_value);?>
                                                                            </option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </span>
                                                         </div>
                                                         <div style="clear:both;"></div>
                                                        <?php endforeach;?>
                                                <?php endforeach;?>
                                            </td>
                                            <td align="center" valign="top">
												<?php if($isModify){?>
                                                	<div class="itemModifyPriceYes" requestVal="0" onClick="changeModify(this,'<?php echo $cartID;?>','<?php echo $userid;?>','modifyPrice');">Price Modify Requested</div><?php }else{?>
                                                    <div class="itemModifyPriceNo" requestVal="1" onClick="changeModify(this,'<?php echo $cartID;?>','<?php echo $userid;?>','modifyPrice');">Request Price Modify</div>
												<?php }?>
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2"></td>
                                            <td colspan="4">
                                                <div class="itemcartRequest">
                                                    <div class="itemRequestName fl">Request:</div>
                                                    <textarea class="itemRequestCont" onBlur="changeItemNotes(this.value,'<?php echo $cartID;?>','<?php echo $userid;?>','request');"><?php echo $this->_tpl_vars['itemvar']["itemNotes"];?></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="itemLineBg980"><td colspan="6" class="itemDelete"><span onClick="deleteItem(this,'<?php echo $cartID;?>','<?php echo $userid;?>','New','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','Wish');">Move to wish</span><span onClick="deleteItem(this,'<?php echo $cartID;?>','<?php echo $userid;?>','New','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','Delete');">Delete</span></td></tr>
                                     </table>
                            <?php }?>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td><td class="sellerFreight">Seller Freight:</td><td class="sellerFreightPrice">¥ <span id="<?php echo $goodsShopId;?>_sellerFreightPrice"><?php echo $settings[0]["freight"];?></span></td>
                    </tr>
                    <tr class="itemLineBg270" height="2px">
                    	<td colspan="6"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td><td colspan="2" class="sellerTotal">Merchandise Total:</td>
                        <td class="sellerTotalPrice">¥ <span id="<?php echo $goodsShopId;?>_sellerTotalPrice"><?php echo $sellerTotalPrice;?></span></td>
                    </tr>
                    <tr height="30px"><td colspan="6"></td></tr>
                 </table>
                 </td></tr>
                <?php }?>
                <tr style="border-top: 2px solid #ADAEAB;">
                    <td colspan="3"></td>
                    <td colspan="2" class="sellerSubTotal">Merchandise Sub-Total:</td>
                    <td class="sellerSubTotalPrice">¥ <span id="sellerSubTotalPrice"><?php echo $sellerSubTotalPrice;?></span></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="serviceFee"  colspan="2">Service Fee:</td>
                    <td class="serviceFeePrice">¥ <span id="serviceFeePrice"><?php echo $serviceFeePrice;?></span></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td class="sellerSubFreight"  colspan="2">Sub-Freight:</td>
                    <td class="sellerSubFreightPrice">¥ <span id="sellerSubFreightPrice"><?php echo $sellerSubFreightPrice;?></span></td>
                </tr>
                <tr style="border-bottom: 2px solid #ADAEAB;">
                    <td colspan="3"></td>
                    <td colspan="2" class="sellerAllTotal">Total:</td>
                    <td class="sellerAllTotalPrice">¥ <span id="sellerAllTotalPrice"><?php echo $sellerAllTotalPrice;?></span></td>
                </tr>
                <tr height="40px">
                    <td colspan="3"></td>
                    <td colspan="3" align="right">
                        <a class="cart_submit" href="javascript:submitCart();">Check Out</a>
                        <a class="cart_continue" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>">Continue Shopping</a>
                    </td>
                </tr>
                <tr height="50px"><td colspan="6"></td></tr>
            </table>
            </form>
        </div>

	<?php }else{?>
    		<div class="cartEmpty">Your shopping bag is currently empty</div>
    <?php }?>

	<div class="itemRequest cartRequest">
		<div class="itemRequestTop cartRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>When will I get my items?</h2>
        	<p>"Delivery" Time is the estimated time of your items being delivered to your shipping address. This takes into account the our processing time
and the Taobao seller’ s delivery time. On average, domestic shipping takes around 4-7 days to arrive at your destination.
For international shipping,Usually, delivery time depends on the destination country, the speed of the courier service and customs clearance
timings. Unfortunately we cannot accept responsibility for these services and therefore cannot be liable for any delays due to them.</p>

             <h2>Shipping Fees in General</h2>
        	<p>WowShopping charge you a flat rate fee of 15rmb per seller however, delivery rates (fees) usually depend upon distance and package
weight/size. Different couriers charge differing rates. These rates are determined by the Taobao seller and not Wow Shopping.
We will email you should any difference in expected rates occur.</p>
            <h2>How do I track my shipment?</h2>
        	<p>As each item ships from the Taobao seller, we’ll give you a tracking number and link to the courier page within your order form. Please visit the order list in your Account Home. Click the link and input the tracking number to view the status of your package on the couriers website. If you are in China, you need use google translate to change the page into English.</p>
			<p style="float:right;">Learn more about <a style="color:#5e97ed" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">How To Order</a></p>
        </div>
		</div>
    </div>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

	</div>
</body>
</html>