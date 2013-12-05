<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
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
<script type="text/javascript" src="/publish/skin/jsfiles/datepicker/WdatePicker.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/ajaxfileupload2.js"></script>
<script type="text/javascript" src="/publish/skin/jsfiles/accountOrderDetail.js"></script>
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
website/lang.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<div class="content">
<?php
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => "SELECT * FROM cms_publish_order as a LEFT JOIN cms_publish_address as b ON a.orderAddress = b.addressId WHERE a.orderUser ={$this->_tpl_vars["name"]} AND a.orderID = {$this->_tpl_vars['IN']['orderID']}",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;
	 $order = $this->_tpl_vars['lists']['data'][0];
	 $settings =  runFunc("getGlobalSetting");
	 $creditTotalAmount = $order["totalAmount"] - $order["refundAmount"];
	 $credit = floor($creditTotalAmount / $settings[0]["credit_consumption"]);

?>
<?php if($order["orderStatus"] == 4):?>
<script type="text/javascript" src="/publish/skin/jsfiles/accountOrderDetailModify.js"></script>
<?php endif;?>
    <div class="bagNav">
    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>">Account Home</a> > <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">Orders</a> > <a><?php echo $_GLOBAL['order_info_'.$order["orderStatus"]];?></a> > <span class="hong">NO.<?php echo $order['OrderNo'];?></span>
    </div>

    <div class="payment">
        <div style="margin:10px auto; width:487px;float:left;color:#f5940b;font:normal 24px Arial, Helvetica, sans-serif;">
        	<?php if($order["orderStatus"] == 4 && $order["pending"] == 1):?>
				<?php echo $_GLOBAL['order_info_3'];?>
            <?php else:?>
            	<?php echo $_GLOBAL['order_info_'.$order["orderStatus"]];?>
            <?php endif;?>
        </div>
<!--        <div style="float:left; margin:10px auto;width:487px; text-align:right;color:#b0b0b0;font:normal 14px Arial, Helvetica, sans-serif;">
        	Modify: 2013-06-04 13:00
        </div>-->
        <div class="clb"></div>
        <div>
        	<span class="hong" style="font:bold 24px Arial, Helvetica, sans-serif; padding-right:5px;">NO.<?php echo $order['OrderNo'];?></span>
            <?php if($order['country'] != 'China'):?>
            <img src="../../skin/images/global2.png" />
            <?php endif;?>
        </div>
		<table>
        <tr>
			<td width="300" style="font-size:12px;color:#adaeab;"><?php echo $order['orderName'];?></td>
            <td width="290" align="center" style="font-size:12px;text-align:center;color:#adaeab;"><span style="color:#adaeab;">Submit time:</span><?php echo $order['orderTime_n'];?></td>
             <td width="386" align="right" style="font-size:12px;color:#adaeab;text-align:right;">
            	<?php if($order['payTime']):?><span style="color:#adaeab;">Transaction:</span><?php echo $order['payTime'];?>
            	<?php endif;?>
            </td>
        </tr>
        </table>

        <div class="clb"></div>
    	<div class="paymentContent">
            <table width="976px">
                <tr class="paymentTh">
                    <td width="220">Shipping Address</td>
                    <td width="450" align="center"></td>
                    <td width="170">Payment Info</td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td>Receiving Name</td>
                    <td align="center" class="cartThreeCN"><span id="cartThreeFirstName"
						<?php if($order['firstName'] && $order['lastName']):?>
							<?php echo $order['firstName'].' '.$order['lastName'];?>
						<?php else:?>
							<?php echo $order['fullName'];?>
						<?php endif;?>
						</span>
					</td>
                    <td>Merchandise Sub-Total: </td>
                    <td align="right" class="cartThreeRmb">¥ <span id="sellerSubTotalPrice"><?php echo number_format($order['order_amount'],2,'.',',');?> </span></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td align="center"  class="cartThreeCN"><span id="cartThreeEmail"><?php echo $order['email'];?></span></td>
                    <td>Service Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <span id="serviceFeePrice"><?php echo number_format($order['service_fee'],2,'.',',');?></span></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td align="center"><span id="cartThreeTelephone"><?php echo $order['telephone'].' '.$order['cellphone'];?></span></td>
                    <td>Freight Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <span id="sellerSubFreightPrice"><?php echo number_format($order['order_freight'],2,'.',',');?></span></td>
                </tr>
                <tr>
                    <td>Shipping Address </td>
                    <td align="center"><span id="cartThreeAddress1"><?php echo $order['address1'];?></span></td>
                    <td><?php if($order['orderStatus'] == '8' || $order['orderStatus'] == '9'):?>Additional Payment:<?php endif;?></td>
                    <td align="right">
						<?php if($order['orderStatus'] == '8'):?>
							<span class="bghuang" style="font:normal 14px Arial, Helvetica, sans-serif;color:#fff;padding:2px auto;cursor:pointer; width:120px;height:20px; display:block; text-align:center;">View and Pay</span>
						<?php elseif($order['orderStatus'] == '9'):?>
							<?php echo number_format($order['additional'],2,'.',',');?>
						<?php endif;?></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeAddress2"><?php echo $order['address2'];?></span></td>
                    <td class="hide">International Shipping:</td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeCity"><?php echo $order['city'].';'.$order['province'].';'.$order['country'];?></span></td>
                    <td class="hide"></td>
                    <td align="right"></td>
                </tr>
                <?php if($order['addressCN1']):?>
                <tr id="addressCN">
                    <td colspan="4">
                    <table>
                        <tr>
                            <td width="220">Address in Chinese </td>
                            <td width="450" align="center" class="cartThreeCN">
                            	<span id="cartThreeCNCity"><?php echo $order['countryCN'].' ; '.$order['provinceCN'].' ; '.$order['cityCN'];?></span></td>
                            <td width="170"></td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="cartThreeTaxi hide">Order a box of customized taxi card</a></td>
                            <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress1"><?php echo $order['addressCN1'];?></span></td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress2"><?php echo $order['addressCN2'];?></span></td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                    </table>
                    </td>
                </tr>
                <?php endif;?>
                <tr class="itemLineBg980" style="height:2px"><td colspan="6"></td></tr>
                <tr class="cartThreeInvoice" >
                    <td colspan="2" style="color:#333;font:bold 14px Arial, Helvetica, sans-serif;">Invoice</td>
                    <td style="color:#333;font:bold 14px Arial, Helvetica, sans-serif;">Estimated Tax:</td>
                    <td align="right" class="cartThreeRmb">¥ <span id="orderTax"><?php if($order['tax']):echo $order['tax'];else:?>0.00<?php endif;?></span></td>
                </tr>
                <?php if($order['invoice']):?>
                <tr>
                    <td colspan="2" class="cartThreeInvoiceTitle"><div style="margin-left:50px;">Title: <?php echo $order['invoiceTitle'];?></div></td>
                    <td></td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td colspan="2" class="cartThreeInvoiceTitle"><div style="margin-left:50px;">Tax Number: <?php echo $order['invoiceNum'];?></div></td>
                    <td class="cartThreeApply"></td>
                    <td align="right"></td>
                </tr>
                <?php endif;?>
                <tr class="promoTr<?php if(!$order['coupons']):?> hide<?php endif;?>">
                    <td></td>
                    <td colspan="3">
                    	<div id="promoPrice" class="promoPrice<?php if(!$order['coupons']):?> hide<?php endif;?>">
                        	<span> - </span> ¥ <?php echo $order['coupon_word'];?>
                        </div>
                        <div id="promoCode" class="<?php if(!$order['coupons']):?>hide<?php endif;?> hui fr">Code:<?php echo $order['coupons'];?>
                        </div>
                    </td>
                </tr>
                <tr style="font-size:18px;border-top:2px solid #aaa;">
                    <td colspan="2"></td>
                    <td>Total:</td>
                    <td align="right" class="cartThreeRmb">¥ <span id="sellerAllTotalPrice"><?php echo number_format($order['totalAmount'],2,'.',',');?></span></td>
                </tr>
                <?php if($order["payment"] && $order["orderStatus"] >4):?>
                <tr style="height:20px">
                    <td colspan="2"></td>
                    <td colspan="2" align="right" style="color:#adaeab;">

                    Paid by <?php echo $_GLOBAL['order_payment_'.$order["payment"]];?></td>
                </tr>
                <?php endif;?>
                <tr>
                    <td colspan="2"></td>
                    <td> </td>
                    <td align="right" style="color:#5e97ed;">Points:&nbsp;&nbsp;&nbsp;&nbsp; + <span id="orderCredit"><?php echo $credit;?></span></td>
                </tr>
                <?php if($order['refundAmount'] && $order['refundAmount'] > 0):?>
                <tr style="height:20px">
                    <td colspan="2"></td>
                    <td align="right" colspan="2" style="color:#333;">Total Refund:&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:#a10000;">- ¥ <?php echo number_format($order['refundAmount'],2,'.',',');?></span></td>
                </tr>
                <?php endif;?>
               </table>
            </div>
        </div>
        <div style="margin:10px auto;color:#333;width:976px; text-align:center; border-bottom:2px solid #aaa;padding:5px 0;">
            <p>Important: Within 72 hours after receipt can apply to return, once the receipt was confirmed, you can not return the items</p>
        </div>
        <?php if($order['orderStatus'] == 4):?>
		<div class="paymentSubmit"><a id="submit_payment" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=newPayment&orderID='.$order['orderID']));?>">Pay</a></div>
        <?php endif;?>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "cartTotal",
	'query' => "SELECT SUM(ItemQTY) as cartTotal,SUM(itemTotal) as sellerSubTotalPrice FROM cms_publish_cart WHERE UserName = '{$this->_tpl_vars["tmpUser"]}' and ItemStatus = 'Order' and cartID in ({$order['cartIDstr']})",
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
	'query' => "SELECT b.goodsShopId,b.goodsShopName,SUM(a.ItemQTY) as shopTotal,SUM(a.itemTotal) as sellerTotalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$this->_tpl_vars["tmpUser"]}' and a.ItemStatus = 'Order' and cartID in ({$order['cartIDstr']}) and cart_type = 1 Group By b.goodsShopId Order By a.cartID DESC",
	);

	$this->_tpl_vars['shopList'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
	?>
    <?php
		$shopNum =  count($this->_tpl_vars["shopList"]["data"]);//商店数目
		$sellerSubFreightPrice =  number_format($shopNum*$settings[0]["freight"], 2, '.', ',');//总运费
		$sellerSubTotalPrice = number_format($this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品总价
		$serviceFeePrice = number_format($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品服务费
		$sellerAllTotalPrice = number_format(($shopNum*$settings[0]["freight"]) + $this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'] + ($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice']), 2, '.', ',');//总价钱
	?>

        <div style="width:976px;margin:10px auto 0;background:url(../../skin/images/bg-line-980.png) no-repeat left bottom;padding-bottom:5px;">
        	<span style="font:normal 24px Arial, Helvetica, sans-serif;color:#393a3c;margin-right:20px;">Detail</span>
        	<span id="showOrderItemCon" style="background:url(../../skin/images/jia.png) no-repeat left bottom; padding-left:15px;cursor:pointer;">Expand All</span>
            <span id="hideOrderItemCon"  style="background:url(../../skin/images/jian.png) no-repeat left bottom; padding-left:15px;margin-left:20px;cursor:pointer;">Collapase All</span>
        </div>

	<?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'] > 0){?>
        <div class="bagContent" id="orderItemCon">
            <table width="976px">
                <tr class="bagTh">
                    <td width="60px"></td>
                    <td width="80px"></td>
                    <td width="440px">Items</td>
                    <td width="150px" align="center"> Price </td>
                    <td width="150px" align="center"> Qty </td>
                    <td align="center"> Subtotal </td>
                </tr>
                <?php $userid = $this->_tpl_vars["tmpUser"]; ?>
                <?php foreach ($this->_tpl_vars["shopList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
                <?php
					$goodsShopId = $this->_tpl_vars['var']['goodsShopId'];
					$goodsshopName = $this->_tpl_vars['var']['goodsShopName'];
					$sellerTotalPrice = number_format($this->_tpl_vars["var"]["sellerTotalPrice"], 2, '.', ','); //店铺总价钱
				?>
                <tr id="all_<?php echo $goodsShopId;?>" class="goodsShop"><td colspan="6">
                    <table width="976px">
                    <tr class="bagShopName">
                    	<td width="580px" colspan="3"><span>Store :</span> <a target="_blank" href="<?php echo $this->_tpl_vars["var"]["goodsShopUrl"];?>"><?php echo $goodsshopName;?></a></td>
                    	<td width="150px"></td>
                    	<td width="150px"></td>
                        <td><span class="itemShopHide" onClick="hideShop(<?php echo $goodsShopId;?>);"></span><span class="itemShopShow" onClick="showShop(<?php echo $goodsShopId;?>);"></span></td>
                    </tr>
                    <tr class="itemLineBg980" height="2px"><td colspan="6"></td></tr>
                    <tr style="margin-top:10px;" id="<?php echo $goodsShopId;?>">
                        <td colspan="6">
                           <?php $shopItemList = runFunc("getOrderShopItemByCartStr",array($userid,$goodsShopId,$order['cartIDstr'],'Order'));?> 							                            <?php foreach ($shopItemList as $this->_tpl_vars['itemkey'] => $this->_tpl_vars['itemvar']){?>
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
								if($this->_tpl_vars['itemvar']['modifyPrice']){
									$itemPrice = $this->_tpl_vars['itemvar']['modifyPrice'];
									$originalPrice = $this->_tpl_vars['itemvar']['itemPrice'];
								}else{
									$itemPrice = $this->_tpl_vars['itemvar']['itemPrice'];
									$originalPrice = '';
								}
								//itemQTY
								$itemQTY = $this->_tpl_vars["itemvar"]["ItemQTY"];
								//total_price
								$total_price = number_format($this->_tpl_vars["itemvar"]["itemTotal"], 2, '.', ',');
								$isModify = $this->_tpl_vars['itemvar']['modifyPriceStatus'];
							?>
                                    <table style="margin-top:10px;width:976px;table-layout:fixed;word-wrap:break-word;" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td width="60px" rowspan="2" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
                                            </td>
                                            <td width="80px" rowspan="2"  align="center" valign="top">
                                                <div class="itemImg"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_100x100.jpg" /></a></div>
                                            </td>
                                            <td width="440px" align="left" valign="top">
                                                <div class="itemTitle">
                                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleCN"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                <div class="itemPrice">¥ <span id="item_price">
                                                	<?php echo number_format($itemPrice, 2, '.', ',');?>
                                                </span>
                                                </div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
												<?php if($order["orderStatus"] == 4 && $order["pending"] != 1):?>
                                                    <span class="itemJia" id="<?php echo $cartID;?>_itemJian" onClick="addItemQTY('jian',this,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','Order','<?php echo $order["orderID"];?>');"> - </span>
                                                    <input type="text" value="<?php echo $itemQTY;?>" maxlength="3" class="numtextBag" id="itemQTY<?php echo $this->_tpl_vars["itemkey"];?>" onBlur="changeItemQTY(this,this.value,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','Order','<?php echo $order["orderID"];?>');">
                                                    <span class="itemJia" id="<?php echo $cartID;?>_itemJia" onClick="addItemQTY('jia',this,'<?php echo $cartID;?>','<?php echo $goodsShopId;?>','<?php echo $itemPrice;?>','<?php echo $userid;?>','Order','<?php echo $order["orderID"];?>');"> + </span>
                                                <?php else:?>
                                                	<span style="color:#a10000;"><?php echo $itemQTY;?></span>
                                                <?php endif;?>
                                            </td>
                                            <td width="96px" align="center" valign="top">
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
                                                <div class="originalPrice">
                                                <?php if($originalPrice):?>
                                                	¥ <STRIKE><?php echo number_format($originalPrice, 2, '.', ',');?></STRIKE>
                                                <?php endif;?>
                                                </div>
                                            </td>

                                            <td colspan="2" align="right" valign="middle">
                                        <div class="itemPrice">
                                        	<span class="refundReason hide nan"><?php echo $_GLOBAL['refund_reason_'.$this->_tpl_vars['itemvar']['pay_back_message']];?></span>
                                        <?php if($this->_tpl_vars['itemvar']['pay_back_money'] && $this->_tpl_vars['itemvar']['pay_back_money'] > 0):?>
                                              <span class="refundInfo hui"> <?php if($order["order_return"] < 2):?>Waiting Refund<?php else:?>Refunded<?php endif;?>:</span>  ¥ <?php echo number_format($this->_tpl_vars['itemvar']['pay_back_money'], 2, '.', ',');?>
                                        <?php endif;?>
                                        </div>
                                            </td>
                                        </tr>
                                        <tr class="itemLineBg980" style="height:10px;"><td colspan="6"></td></tr>
                                        <tr>
                                        	<td colspan="2"></td>
                                            <td>
                                                <?php $item_props = json_decode($this->_tpl_vars["itemvar"]["props"],true);?>
                                                <?php foreach($item_props as $item_prop):?>
                                                        <?php foreach($item_prop as $key=>$item_prop_values):?>
                                                        <div class="itemProps">
                                                            <div class="itemPropsName fl"><?php echo ucfirst($key);?>:</div>
                                                            <div class="itemPropsCont fl" style="color:#5e97ed;">

                                                                    <?php foreach($item_prop_values as $item_key => $item_value):?>
                                                                    	<?php if(strtolower(trim($propsArray[$key])) == strtolower(trim(addslashes($item_value)))):?>
																				<?php echo addslashes($item_value)."</br>";?>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                            </div>
                                                            <div class="clb"></div>
                                                         </div>
                                                         <div style="clear:both;"></div>
                                                        <?php endforeach;?>
                                                <?php endforeach;?>
                                            </td>
                                            <td align="center" valign="top">
												<?php if($isModify == 2):?>
                                                	<div class="itemModifyPriceYes">Price Modified</div>
												<?php elseif($isModify == 1):?>
                                                    <div class="itemModifyPriceYes">Price Modify Requested</div>
												<?php endif;?>
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>

                                        <tr class="<?php if(!$this->_tpl_vars['itemvar']["itemNotes"]){echo "hide";}?>">
                                        	<td colspan="2"></td>
                                            <td colspan="4">
                                     			<?php if($this->_tpl_vars['itemvar']["itemNotes"]):?>
                                                <div class="itemcartRequest">
                                                    <div class="itemRequestName fl">Request:</div>
                                                    <div class="fl" style="color:#5e97ed;width:520px;"><?php echo $this->_tpl_vars['itemvar']["itemNotes"];?></div>
                                                    <div class="clb"></div>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                        </tr>

                                        <?php if($order["orderStatus"] > 3 && $this->_tpl_vars['itemvar']["serviceRemark"]):?>
                                        <tr>
                                        	<td colspan="2"></td>
                                            <td colspan="2">
                                                <div class="itemcartRequest" style="height:30px;">
                                                    <div class="fl" style="margin-right:20px;">Service Remark:</div>
                                                    <div style="color:#a10000;"><?php echo $this->_tpl_vars['itemvar']["serviceRemark"];?></div>
                                                </div>
                                            </td>
                                             <td colspan="2" align="right" height="30px">
                                            </td>
                                        </tr>
                                        <?php endif;?>
                                        <?php if($order["orderStatus"] == '10' || $order["orderStatus"] == '18' || $order["orderStatus"] == '19'):?>
                                        <tr>
                                        	<td colspan="4"></td>
                                             <td colspan="2" align="right" height="30px">
                                             	<?php if($this->_tpl_vars['itemvar']["order_item_status"] == '19'):?>
                                                	<div class="bghui confirmed">Confirmed</div>

                                               <?php else:?>
                                               <div class="bghong confirm_receipt" onClick="changeItemStatus(this,'<?php echo $this->_tpl_vars['itemvar']['cartID']?>','confirmReceipt');">Confirm Receipt</div>
                                               <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endif;?>


                                        <?php if($this->_tpl_vars['itemvar']["expressNum"] && $this->_tpl_vars['itemvar']["order_item_status"] != 12 && $this->_tpl_vars['itemvar']["order_item_status"] != 13 && $this->_tpl_vars['itemvar']["order_item_status"] != 15 && $this->_tpl_vars['itemvar']["order_item_status"] != 14 && $order["orderStatus"] < 19 && $order["orderStatus"] > 4 && $this->_tpl_vars['itemvar']["order_item_status"] < 19):?>
                                         <tr>
                                        	<td colspan="4"></td>
                                             <td colspan="2" align="right" height="30px">

                                            	<span class="hong return_items" onClick="returnItems('<?php echo $this->_tpl_vars['itemvar']["cartID"];?>','<?php echo $order['orderID'];?>','<?php echo $order['OrderNo'];?>');">Return this items</span>
                                            </td>
                                        </tr>
                                        <?php endif;?>

                                        <?php if($this->_tpl_vars['itemvar']["order_item_status"] == 12 || $this->_tpl_vars['itemvar']["order_item_status"] == 14):?>
                                         <tr>
                                        	<td colspan="4"></td>
                                             <td colspan="2" align="right" height="30px">

                                            	Return in process
                                            </td>
                                        </tr>
                                        <?php endif;?>
                                        <?php if($this->_tpl_vars['itemvar']["order_item_status"] == 13 || $this->_tpl_vars['itemvar']["order_item_status"] == 15):?>
                                         <tr>
                                        	<td colspan="4"></td>
                                             <td colspan="2" align="right" height="30px">

                                            	Returned
                                            </td>
                                        </tr>
                                        <?php endif;?>



                                        <?php if($order["orderStatus"] == 4):?>
                                         <tr>
                                        	<td colspan="4"></td>
                                             <td colspan="2" align="right" height="30px">
												<a style="cursor:pointer;" address="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=orderDelete&type=item&cartID='.$cartID.'&orderID='.$order['orderID']));?>" onClick="deleteItem(this,'<?php echo $goodsShopId;?>');">Delete</a>
                                            </td>
                                        </tr>
                                        <?php endif;?>

                                        <tr>
                                        	<td colspan="2"></td>
                                            <td colspan="2">
                                            	<?php if($this->_tpl_vars['itemvar']["expressNum"]):?>
                                                <div class="itemcartRequest" style="height:30px;">
                                                    <div class="fl" style="margin-right:20px; background:url(../../skin/images/car.png) no-repeat left bottom;padding-left:35px;"><?php echo $this->_tpl_vars['itemvar']["expressNum"];?></div>
                                                    <div style="color:#5e97ed;"><a href="<?php echo $this->_tpl_vars['itemvar']["expressUrl"];?>">view</a></div>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                            <td colspan="2" valign="middle" align="right" height="40px">
                                            	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" class="bghuang buy_again">Buy Again</a>
                                        	</td>
                                        </tr>
                                        <tr class="itemLineBg980" height="2px"><td colspan="6"></td></tr>
                                     </table>
                            <?php }?>

                    	</td>
                    </tr>

                    <tr>
                        <td colspan="4"></td><td class="sellerFreight">Seller Freight:</td><td class="sellerFreightPrice">¥ <span id="<?php echo $goodsShopId;?>_sellerFreightPrice"><?php echo $settings[0]["freight"];?></span></td>
                    </tr>
                    <tr class="itemLineBg270" height="2px"><td colspan="6"></td></tr>
                    <tr>
                        <td colspan="3"></td><td colspan="2" class="sellerTotal">Merchandise Total:</td>
                        <td class="sellerTotalPrice">¥ <span id="<?php echo $goodsShopId;?>_sellerTotalPrice"><?php echo $sellerTotalPrice;?></span></td>
                    </tr>

                 </table>
                 </td></tr>
                <?php }?>
                <tr style="border-top: 2px solid #ADAEAB;">
                    <td colspan="3"></td>
                    <td colspan="2"></td>
                    <td></td>
                </tr>
            </table>
        </div>

	<?php }?>
	<div style="margin-bottom:80px;"></div>
	<div class="itemRequest accountRequest">
		<div class="itemRequestTop accountRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <?php if($order["orderStatus"] == 4):?>
            <h2>What is pending status?</h2>
        	<p>The order you may already request some prices modify. You may not be able to edit or pay your order until the order enters
the the Payment acceptble order status.</p>
             <h2>How I know the order become payment acceptble? </h2>
        	<p>It takes withing 24 hours to process. After we finish, you will receive a payment notice email. Please also check your account home page,
view order history. You will find your recent order, and the pay button will apear as clickble.</p>
            <h2>Can I edit or cancel my order?</h2>
        	<p>You can edit it before you submit. It will not be able to edit during we doing modify process. You can cancle the order or delete some items after
our modify process. Unfortunately, if you paid and our team has already started to process purchasing your order, it cannot be cancelled due
to commitments we have made to buy from the seller.</p>
			<p style="text-align:right;margin-top:60px;">Learn more about <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>" style="color:#5e97ed;">How To Order</a> </p>
			<?php else:?>
            <h2>Delivery time</h2>
        	<p>Monday to Sunday 8:30 am to 5:30 pm (No deliveries take place during public holidays).</p>
            <h2>What if I will not be available to receive my shipment? </h2>
        	<p>In this case, most courier companies in china will deliver the goods to your residential guard and let them sign it. Please check with your guards, if you still have a problem please <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>" style="color:#5e97ed;">contact us</a> for help.</p>
             <h2>How do I track my shipment?</h2>
        	<p>As each item ships from the Taobao seller, we’ll give you a tracking number and link to the courier page within your order form. Please visit the order list in your Account Home. Click the link and input the tracking number to view the status of your package on the couriers website. If you are in China, you need use google translate to change the page into English.</p>
              <p style="text-align:right;margin-top:100px;">Learn more about <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>" style="color:#5e97ed;">How To Order</a> </p>
			<?php endif;?>

        </div>
		</div>
    </div>

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
account/returnDialog.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
	</div>

	<script type="text/javascript">
	$(function(){

		$(".remove_modify_item").click(function(){
			var cartid = $(this).attr('cartid');
			var shopid = $(this).attr('shopid');

			if($(".remove_modify_item").length==1){

				if(confirm('Note: If you want to cancel the last item of the order, this order will be cancelled too.')){
					location.href='index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify_save&delstatus=true&orderID=' . $order["orderID"]));?>';
				}

			}else{
				if(confirm('Remove this item from order?')){
					var cont = $("#"+shopid).children("td").children("table:visible").size();
					if(cont > 1){
						$("#"+cartid).remove();
					}else{
						$("#all_"+shopid).remove();
					}
					removeOrderQTY(cartid,'normal','<?php echo $order["cartIDstr"];?>','<?php echo $order["orderID"];?>')
				}

			}

		});
	});


	</script>
<span id="back-top" class="gotoup" style="display: none; position: fixed; bottom: 50px; top: auto;"></span>
</body>
</html>
		<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>