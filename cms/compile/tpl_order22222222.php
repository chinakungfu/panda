<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="skin/jsfiles/orderDetail.js"></script>

<div class="cms_main_box">
	<div class="content">
<?php
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => "SELECT * FROM cms_publish_order as a LEFT JOIN cms_publish_address as b ON a.orderAddress = b.addressId WHERE a.orderID = {$this->_tpl_vars['IN']['orderID']}",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;
	 $order = $this->_tpl_vars['lists']['data'][0];
	 $settings =  runFunc("getGlobalSetting");
	 $credit = floor($order["totalAmount"] / $settings[0]["credit_consumption"]);
?>

    <div class="bagNav">
    <a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders'));?>">Orders</a> > <a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders'));?>">Orderlist WOW</a> > <a><?php echo $_GLOBAL['order_info_'.$order["orderStatus"]];?></a>
    <span style="">Choose Template<span>
    </div>
	<div class="saveas_box fr">
		<img src="/cms/skin/images/saveas.png" />
		<div class="saveas hide">
			<ul>
            <li class="bgbottom"><a onClick="batchSendMail('payment','batch');">Save</a><span>(在当前状态保存编辑项目）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('confirmation','batch');">Waiting Payment</a><span>(待付款订单，自动发送提醒邮件）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('refund','batch');">Verified</a><span>(待采购订单，自动发送提醒邮件）<span></li>
            <li class="bgbottom"><a onClick="batchDeleteOrder('delete','batch');">Purchased </a><span>(已采购订单）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('payment','batch');">On the Way</a><span>(发货中订单）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('confirmation','batch');">Shipped</a><span>(已发货订单，并发送确认提醒）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('refund','batch');">Returned</a><span>(已退换货订单，并发送已换货提醒）<span></li>
            <li class="bgbottom"><a onClick="batchDeleteOrder('delete','batch');">Refound</a><span>(待退款订单）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('payment','batch');">Paid Back* 自动及手动</a><span>(已退款订单，并发送退款提醒邮件）<span></li>
            <li class="bgbottom"><a onClick="batchSendMail('confirmation','batch');">Close Transaction * 主动关闭</a><span>(已取消订单）<span></li>
            <li><a onClick="batchSendMail('refund','batch');">Finished * 自动及手动</a><span>(已完成订单）<span></li>
          	</ul>
		</div>
	</div>
    <div class="payment">
    	 <div class="clb"></div>
        <div class="orderNo">
			<?php echo $_GLOBAL['order_info_'.$order["orderStatus"]];?>
			<div><span class="hong">NO.<?php echo $order['OrderNo'];?></span></div>
        </div>
        <div class="orderTimes">
        	<table width="387px">
        		<tr><td><span class="orderUser"><?php echo $user_info[0]["staffName"];?></span>Modify:</td><td width="120px"><?php if($order['modifyTime']){ echo date("y-m-d h:i:s",$order['modifyTime']);}?></td></tr>
        		<tr><td>Verified:</td><td><?php if($order['verifyTime']){ echo date("y-m-d h:i:s",$order['verifyTime']);}?></td></tr>
        		<tr><td>Purchased:</td><td><?php if($order['purchaseTime']){ echo $order['purchaseTime'];}?></td></tr>
        		<tr><td>Refounded:</td><td><?php if($order['refoundTime']){ echo date("y-m-d h:i:s",$order['refoundTime']);}?></td></tr>
        	</table>
        </div>
        <div class="clb"></div>

    	<div style="float:right;width:340px;"><span style="color:#adaeab;font-size:14px;">Transaction:</span><?php echo $order['payTime'];?></div>
    	<div style="float:right;margin-right:170px;font-size:12px;"><span style="color:#adaeab;font-size:14px;">Submit time:</span><?php echo $order['orderTime_n'];?></div>
        <div style="float:left;margin-right:20px;font-size:12px;"><span style="color:#adaeab;font-size:14px;"><?php echo $order['orderName'];?></span></div>
        <div class="clb"></div>
    	<div class="paymentContent">
            <table width="1080px">
                <tr class="paymentTh">
                    <td width="220">Shipping Address</td>
                    <td width="525" align="center"></td>
                    <td width="170">Payment Info</td>
                    <td align="right">
						<div class="editOrder_box fr">
							<img src="../../skin/images/shezhi.png" />
							<div class="editOrder hide">
								<ul>
					            <li class="bgbottom"><a onClick="batchSendMail('payment','batch');">Edit address</a><span>(编辑地址）<span></li>
					            <li class="bgbottom"><a onClick="batchSendMail('confirmation','batch');">Add additional payment</a><span>（追加付款）<span></li>
					            <li class="bgbottom"><a onClick="batchSendMail('refund','batch');">Add International Fee</a><span>（国际运费）<span></li>
					            <li><a onClick="batchDeleteOrder('delete','batch');">Refund to customer</a><span>（退款操作）<span></li>
					          	</ul>
							</div>
						</div>
                    </td>
                </tr>
                <tr>
                    <td>Receiving Name</td>
                    <td align="center" class="cartThreeCN"><span id="cartThreeFirstName"><?php echo $order['firstName'].' '.$order['lastName'];?></span></td>
                    <td>Merchandise Sub-Total: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['order_amount'],2,'.',',');?> </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td align="center"  class="cartThreeCN"><span id="cartThreeEmail"><?php echo $order['email'];?></span></td>
                    <td>Service Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['service_fee'],2,'.',',');?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td align="center"><span id="cartThreeTelephone"><?php echo $order['telephone'].' '.$order['cellphone'];?></span></td>
                    <td>Freight Fee: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['order_freight'],2,'.',',');?></td>
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
                    <table width="1080px">
                        <tr>
                            <td width="220">Address in Chinese </td>
                            <td width="525" align="center" class="cartThreeCN">
                            	<span id="cartThreeCNCity"><?php echo $order['countryCN'].';'.$order['provinceCN'].';'.$order['cityCN'];?></span></td>
                            <td width="170"></td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td><a href="#" class="cartThreeTaxi">Order a box of customized taxi card</a></td>
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
                <tr class="cartThreeInvoice" >
                    <td width="620" colspan="2">Invoice</td>
                    <td width="170">Estimated Tax:</td>
                    <td align="right" class="cartThreeRmb"><span id="tax_view">¥ <?php if($order['tax']):echo $order['tax'];else:?>0.00 <?php endif;?> </span></td>
                </tr>
                <tr>
                    <td width="620" colspan="2" class="cartThreeInvoiceTitle"><span>title:</span><input type="text" style="background-color:#efeb8a;"  name="invoiceTitle" disabled value="<?php echo $order['invoiceTitle'];?>" /></td>
                    <td width="170"></td>
                    <td align="right"></td>
                </tr>
                <tr>
                    <td width="620" colspan="2" class="cartThreeInvoiceTitle"><span>Tax Number: </span><input type="text" style="background-color:#efeb8a;"  name="invoiceNum" disabled value="<?php echo $order['invoiceNum'];?>" />
                    </td>
                    <td width="170" class="cartThreeApply"></td>
                    <td align="right"></td>
                </tr>
                <tr class="promoTr">
                    <td width="220"></td>
                    <td colspan="3">
                    	<div id="promoPrice" class="promoPrice<?php if(!$order['coupons']):?> hide<?php endif;?>">
                        	<span> - </span> ¥ <?php echo $order['coupon_word'];?>
                        </div>
                        <div id="promoCode" class="<?php if(!$order['coupons']):?>hide<?php endif;?> hui fr">Code:<?php echo $order['coupons'];?>
                        </div>
                    </td>
                </tr>
                <tr style="font-size:18px;border-top:2px solid #aaa;">
                    <td width="620" colspan="2"></td>
                    <td width="170">Total:</td>
                    <td align="right" class="cartThreeRmb"><span id="order_amount">¥ <?php echo number_format($order['totalAmount'],2,'.',',');?></span></td>
                </tr>
                <tr style="height:20px">
                    <td width="620" colspan="2"></td>
                    <td colspan="2" align="right" style="color:#adaeab;">Paid by Recharge <?php echo $_GLOBAL['order_payment_'.$order["payment"]];?></td>
                </tr>
                <tr style="height:20px">
                    <td width="620" colspan="2"></td>
                    <td width="170"> </td>
                    <td align="right" style="color:#5e97ed;">Points:&nbsp;&nbsp;&nbsp;&nbsp; + <?php echo $credit;?></td>
                </tr>
                <tr style="height:20px">
                    <td width="620" colspan="2"></td>
                    <td width="170"> </td>
                    <td align="right" style="color:#333;">Total Refund:&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:#a10000;">- ¥ <?php echo number_format($order['refundAmount'],2,'.',',');?></span></td>
                </tr>
               </table>
            </div>
        </div>

	<?php
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	$params = array (
	'action' => "sql",
	'return' => "cartTotal",
	'query' => "SELECT SUM(ItemQTY) as cartTotal,SUM(itemTotal) as sellerSubTotalPrice FROM cms_publish_cart WHERE ItemStatus = 'Order' and cartID in ({$order['cartIDstr']})",
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
	'query' => "SELECT b.goodsShopId,b.goodsShopName,SUM(a.ItemQTY) as shopTotal,SUM(a.itemTotal) as sellerTotalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.ItemStatus = 'Order' and cartID in ({$order['cartIDstr']}) and cart_type = 1 Group By b.goodsShopId Order By a.cartID DESC",
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
        <div style="width:1080px;margin:10px auto 0;background:url(../../skin/images/bg-line-1080.png) no-repeat left bottom;padding-bottom:5px;">
        	<span style="font:normal 24px Arial, Helvetica, sans-serif;color:#393a3c;margin-right:20px;">Detail</span>
        	<span id="showOrderItemCon" style="background:url(../../skin/images/jia.png) no-repeat left bottom; padding-left:15px;cursor:pointer;">Expand All</span>
            <span id="hideOrderItemCon"  style="background:url(../../skin/images/jian.png) no-repeat left bottom; padding-left:15px;margin-left:20px;cursor:pointer;">Collapase All</span>
        </div>
	<?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'] > 0){?>
        <div class="bagContent" style="margin-bottom:80px;" id="orderItemCon">
            <table width="1080px">
                <tr class="bagTh">
                    <td width="60px"></td>
                    <td width="80px"></td>
                    <td width="500px">Items</td>
                    <td width="150px" align="center"> Price </td>
                    <td width="150px" align="center"> Qty </td>
                    <td align="center"> Subtotal </td>
                </tr>
                <?php $userid = $this->_tpl_vars["tmpUser"]; ?>
                <?php foreach ($this->_tpl_vars["shopList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
                <?php
					$goodsShopId = $this->_tpl_vars['var']['goodsShopId'];
					$goodsshopName = $this->_tpl_vars['var']['goodsShopName'];
				?>
                <?php $sellerTotalPrice = number_format($this->_tpl_vars["var"]["sellerTotalPrice"], 2, '.', ','); //店铺总价钱?>
                <tr id="all_<?php echo $goodsShopId;?>">
                	<td colspan="6">
                    <table width="1080px">
                    <tr class="bagShopName">
                    	<td colspan="3"><span>Store :</span> <?php echo $goodsshopName;?></td>
                    	<td width="150px"></td>
                    	<td width="150px"></td>
                        <td width="140px">
							<div class="editOrder_box fl" style="margin-left:20px;">
								<img src="../../skin/images/shezhi.png" />
								<div class="editOrder hide" style="width:200px;">
									<ul>
						            <li class="bgbottom"><a onClick="batchSendMail('payment','batch');">Modify</a><span>(修改价格及采购提示）<span></li>
						            <li class="bgbottom"><a onClick="batchSendMail('confirmation','batch');">Perchase Record</a><span>(采购纪录）<span></li>
						            <li class="bgbottom"><a onClick="batchSendMail('refund','batch');">Refund Record</a><span>(退款录入）<span></li>
						            <li><a onClick="batchDeleteOrder('delete','batch');">Delivery Info</a><span>（运单纪录）<span></li>
						          	</ul>
								</div>
							</div>
                        <span class="itemShopHide" onClick="hideShop(<?php echo $goodsShopId;?>);"></span><span class="itemShopShow" onClick="showShop(<?php echo $goodsShopId;?>);"></span></td>
                    </tr>
                    <tr style="margin-top:10px;" id="<?php echo $goodsShopId;?>">
                        <td colspan="6">
                           <?php $shopItemList = runFunc("getCmsOrderShopItem",array($goodsShopId,$order['cartIDstr'],'Order'));?> 							                            <?php foreach ($shopItemList as $this->_tpl_vars['itemkey'] => $this->_tpl_vars['itemvar']){?>
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
								$isModify = $this->_tpl_vars['itemvar']['modifyPrice'];
							?>
                                    <table style="margin-top:10px;width:1080px" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td rowspan="4" width="60px" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
                                            </td>
                                            <td rowspan="4" width="80px"  align="center" valign="top">
                                                <div class="itemImg"><a href="<?php echo $this->_tpl_vars['itemvar']['goodsURL'];?>" target="_blank"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_60x60.jpg" /></a></div>
                                            </td>
                                            <td width="500px" align="left" valign="top">
                                                <div class="itemTitle">
                                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&from=search_url&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleCN"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></a></div>
                                                <div class="itemTitle"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&from=search_url&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleEn"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleEn"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                <div class="itemPrice">¥ <span id="item_price">
													<?php echo number_format($itemPrice, 2, '.', ',');?></span>
                                                </div>
                                            </td>
                                            <td width="150px" align="center" valign="top">

                                            	<span style="color:#a10000;"><?php echo $itemQTY;?></span>
                                            </td>
                                            <td align="center" valign="top">
                                                <div class="itemPrice">
                                                ¥ <span id="<?php echo $cartID;?>_total_price"><?php echo $total_price; ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="itemLineBg940" colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php $item_props = json_decode($this->_tpl_vars["itemvar"]["props"],true);?>
                                                <?php foreach($item_props as $item_prop):?>
                                                        <?php foreach($item_prop as $key=>$item_prop_values):?>
                                                        <div class="itemProps">
                                                            <div class="itemPropsName fl"><?php echo ucfirst($key);?>:</div>
                                                            <span class="itemPropsCont" style="color:#5e97ed;">

                                                                    <?php foreach($item_prop_values as $item_key => $item_value):?>
                                                                    	<?php if($propsArray[$key] == addslashes($item_value)):?>

																				<?php echo addslashes($item_value);?>

                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                            </span>
                                                         </div>
                                                         <div style="clear:both;"></div>
                                                        <?php endforeach;?>
                                                <?php endforeach;?>
                                            </td>
                                            <td align="center">
												<?php if($isModify == 2):?>
                                                	<span class="itemModifyPriceYes">Price Modified</span>
												<?php elseif($isModify == 1):?>
                                                    <span class="itemModifyPriceYes">Price Modify Requested</span>
												<?php endif;?>
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="itemcartRequest" style="height:30px;">
                                                    <div class="itemRequestName fl"><?php if($this->_tpl_vars['itemvar']["itemNotes"]):?>Request:<?php endif;?></div>
                                                    <div style="color:#5e97ed;"><?php echo $this->_tpl_vars['itemvar']["itemNotes"];?></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2"></td>
                                            <td colspan="2">
                                            	<?php if($this->_tpl_vars['itemvar']["serviceRemark"]):?>
                                                <div class="itemcartRequest" style="height:30px;">
                                                    <div class="fl" style="margin-right:20px;">Service Remark:</div>
                                                    <div style="color:#a10000;"><?php echo $this->_tpl_vars['itemvar']["serviceRemark"];?></div>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                             <td colspan="2" align="right" height="30px">
                                             	<?php if($this->_tpl_vars['itemvar']["order_item_status"] == '10'):?>
                                                  	<span class="bghong confirm_receipt" onClick="changeItemStatus(this,'<?php echo $this->_tpl_vars['itemvar']['cartID']?>','confirmReceipt');">Confirm Receipt</span>
                                                 <?php elseif($this->_tpl_vars['itemvar']["order_item_status"] == '19'):?>
                                            		<span class="hong return_items" onClick="returnItems('<?php echo $this->_tpl_vars['itemvar']['cartID']?>','<?php echo $order["orderID"];?>','<?php echo $order["OrderNo"]?>');">Return this items</span>
                                                 <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td colspan="6" align="right">
                                            	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&from=search_url&id='.$goodsid));?>" class="bghuang buy_again">Buy Again</a>
                                        	</td>
                                        </tr>
                                        <tr class="itemLineBg980">
                                        	<td colspan="2"></td>
                                            <td colspan="2">
                                            	<?php if($this->_tpl_vars['itemvar']["expressNum"]):?>
                                                <div class="itemcartRequest" style="height:30px;">
                                                    <div class="fl" style="margin-right:20px; background:url(../../skin/images/car.png) no-repeat left bottom;padding-left:35px;"><?php echo $this->_tpl_vars['itemvar']["expressNum"];?></div>
                                                    <div style="color:#5e97ed;cursor:pointer;"><a>view</a></div>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                            <td colspan="2" valign="middle" align="right" height="40px">
                                            <?php if($this->_tpl_vars['itemvar']["order_item_status"] == '4'):?>
                                               <span class="remove_modify_item" cartid="<?php echo $this->_tpl_vars['itemvar']["cartID"];?>" shopid="<?php echo $goodsShopId;?>">Delete</span>
                                            <?php endif;?>
                                        	</td>
                                        </tr>
                                     </table>
                            <?php }?>
                    	</td>
                    </tr>
                    <tr class="itemLineBg270">
                        <td colspan="4"></td><td class="sellerFreight">Seller Freight:</td><td class="sellerFreightPrice">¥ <span id="<?php echo $goodsShopId;?>_sellerFreightPrice"><?php echo $settings[0]["freight"];?></span></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td><td class="sellerTotal">Seller Total:</td>
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
</div>
















































<?php
$page = $this->_tpl_vars["IN"]["page"];
if($this->_tpl_vars["IN"]["page"]==""){
	$page = 1;
}
$order = runFunc('getOrder',array($this->_tpl_vars["IN"]["orderID"]));
$carts = runFunc('getOrderCarts',array($order["cartIDstr"]));
$cart_pay_back_amount = runFunc('getOrderCartsPayBackAmount',array($order["cartIDstr"]));
?>
<script type="text/javascript">
	$(function(){
		$("#save_order_info").click(function(){
				$("#order_info_form").submit();
			});

		$("#open_items").click(function(){

				$(".order_items").slideDown();
			});
		$("#close_items").click(function(){

			$(".order_items").slideUp();
		});

		$(".order_cart_pay_back_info").dialog({
			autoOpen: false,
			show: { effect: 'drop', direction: "up" },
			hide: { effect: 'drop', direction: "up" },
			width: 800,
			modal: true
		});

		$(".submit_order_pay_back_box").click(function(){
			if(confirm("是否确认退款？")){
				$(this).parent().siblings(".order_cart_pay_back_form").submit();
			}
		});

		$(".cart_pay_back_show").click(function(){

			var c_id = $(this).attr("id");
			$("#order_cart_pay_back_info_"+c_id).dialog( "open" );
			});

		$(".close_order_pay_back_box").click(function(){
			$(this).parent().parent().dialog( "close" );
			});

		$( "#order_problem_box" ).dialog({
			autoOpen: false,
			show: { effect: 'drop', direction: "up" },
			hide: { effect: 'drop', direction: "up" },
			width: 500,
			modal: true
		});

		$("#order_problem_open").click(function(){
			$("#order_problem_box").dialog( "open" );
		});

		$("#close_problem_box").click(function(){
			if(confirm("是否放弃此次提交？")){
			$("#order_problem_box").dialog( "close" );
			}
		});

		$(".submit_order_problem").click(function(){

			$("#order_problem_form").submit();
		});
	});
</script>
	<div id="order_problem_box" class="hide">
				<div class="order_problem_title">
					<div class="fl">交易问题</div>
					<div id="close_problem_box" class="fr">关闭</div>
					<div class="submit_order_problem fr cp">保存</div>
				</div>
				<form action="index.php" method="post" id="order_problem_form">
				<textarea name="order_problem" id="order_problem" cols="30" rows="10"><?php echo str_replace("<br />","",$order["problem"]);?></textarea>
					<input type="hidden" name="action" value="cms"/>
					<input type="hidden" name="method" value="order_problem_save"/>
					<input type="hidden" name="orderId" value="<?php echo $order["orderID"];?>" />
					<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>"/>
				</form>
			</div>

<div class="cms_main_box">
<div class="cms_left fl">
<?php
/*$this->_tpl_vars["IN"]["type"]='orders';*/
$inc_tpl_file=includeFunc(<<<LNMV
left.tpl
LNMV
);
include($inc_tpl_file);
?>

</div>
<div class="cms_right fr">
	<div class="ctrl_bar">
		<div class="title fl">
			订单 <?php echo $order["OrderNo"];?>  << <?php echo runFunc("getOrderStatusAdmin",array($order["orderStatus"]));?> >>
		</div>
		<ul class="fr ctrl_link">
			<li id="ctrl_1"><a href="#">撰写邮件</a></li>
			<li id="ctrl_4"><a onClick="javascript:return confirm('是否确定删除此订单？')" href="<?php echo runFunc('encrypt_url',array('action=cms&method='.$this->_tpl_vars["IN"]["type"].'&type='.$this->_tpl_vars["IN"]["type"].'&delete_order='.$this->_tpl_vars["IN"]["id"]));?>">删除订单</a></li>
			<li id="ctrl_2"><a href="<?php echo runFunc('encrypt_url',array('action=cms&method='.$this->_tpl_vars["IN"]["type"].'&type='.$this->_tpl_vars["IN"]["type"].'&page='.$page));?>">返回订单列表</a></li>
		</ul>
	</div>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">商品信息 <a style="font-size:12px;color:gray;cursor:pointer;" id="open_items" >展开商品</a> <a style="font-size:12px;color:gray;cursor:pointer;" id="close_items" >收起商品</a> </div>
			<?php switch($order["orderStatus"]){
				case 4:
			?>
			<a onClick="javascript:return confirm('您的这个操作将会发送一封邮件提醒买家付款，是否确定进行这个操作？')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderPayRemind&orderId='.$order["orderID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">
				提醒买家付款
			</a>
			<?php break;
				case 5:?>

			<a onClick="javascript:return confirm('您的这个操作将会使这个订单进入已采购状态，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderPurchase&orderId='.$order["orderID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">
				采购商品
			</a>
			<?php break;
				case 6:?>
			<a onClick="javascript:return confirm('您的这个操作将会使这个订单进入已发货状态，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=confirmShipping&orderId='.$order["orderID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">
				确认发货
			</a>
			<?php break;
				case 7:?>
			<!-- <a onClick="javascript:return confirm('您的这个操作将会发送一封邮件提醒买家确认收货，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderFinalConfirmRemind&orderId='.$order["orderID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">
				提醒买家收货
			</a>
			 -->
			<a onClick="javascript:return confirm('您的这个操作将会使这个订单进入已送达状态，请确认您的操作。')" class="order_step_submit fr" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderArrived&orderId='.$order["orderID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">
				确认已送达
			</a>
			<?php break;?>
			<?php }?>
			<a id="order_problem_open" style="margin-right:5px;" class="order_step_submit fr cp">
				交易问题记录
			</a>
		</div>
		<div class="order_items <?php if($order["orderStatus"]>6){echo "hide";}?>">
		<?php foreach($carts as $cart):
			$good = runFunc('getCatrGoods',array($cart["ItemGoodsID"]));
		?>

		<div id="order_cart_pay_back_info_<?php echo $cart["cartID"];?>" class="order_cart_pay_back_info hide">
		<div class="order_problem_title">
			<div class="fl">商品退款</div>
			<div class="close_order_pay_back_box fr cp" style="margin-right:10px">关闭</div>
			<?php if($cart["pay_back"]==0):?>
			<div id="<?php echo $cart["cartID"];?>" class="submit_order_pay_back_box fr cp">确认退款</div>
			<?php endif;?>
		</div>

		<form action="index.php" method="post" class="order_cart_pay_back_form">
		<input type="hidden" name="action" value="cms"/>
		<input type="hidden" name="method" value="order_cart_pay_back"/>
		<input type="hidden" name="cart" value="<?php echo $cart["cartID"];?>"/>
		<input type="hidden" name="id" value="<?php echo $order["orderID"];?>"/>
		<input type="hidden" name="goods_id" value="<?php echo $cart["ItemGoodsID"];?>"/>
		<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>"/>
			<table class="pay_back_cart_item_info">
			<tr>
				<th>商品</th>
				<th>数量</th>
				<th>运费</th>
				<th>单价</th>
				<th>总价</th>
			</tr>
			<tr>
				<td style="text-align:left; width: 70%;">
					<table>
							<tbody><tr>
								<td rowspan="3" style="padding-right:15px;">
									<img width=100px src="<?php echo $good["goodsImgURL"]."_310x310.jpg";?>" alt=""/>
								</td>
								<td style="font-weight: bold;vertical-align:top;">
								<?php echo $good["goodsTitleCN"];?>					<br>
								<font style="color:#ED5E83">
								（应收单价：<?php echo number_format($good["goodsUnitPrice"], 2, '.', '');?> 应收运费：<?php echo number_format($good["goodsFreight"], 2, '.', '');?>）
								</font>
								</td>
							</tr>
							<tr>
								<td style="color:#777777;"></td>
							</tr>
							<tr>
								<td style="color:#9a4aaa;"></td>
							</tr>
						</tbody></table>
				</td>
				<td style="text-align:center"><?php echo $cart["ItemQTY"]?></td>
				<td style="text-align:center"><?php echo number_format($cart["itemFreight"], 2, '.', ',');?></td>
				<td style="text-align:center"><?php echo number_format($cart["itemPrice"], 2, '.', ',');?></td>
				<td style="text-align:center"><?php echo number_format($cart["itemPrice"] * $cart["ItemQTY"] + $cart["itemFreight"], 2, '.', ',');?></td>
			</tr>
			<tr>
				<td style="text-align: right" colspan=5>退款金额：
			<?php if($cart["pay_back"]==0):?>
				<input type="text" name="pay_back_money" value="0.00" class="dark_border input_bar_long required number" min="1" style="width: 100px;">
			<?php else:?>
			<?php echo $cart["pay_back_money"];?>
			<?php endif;?>
				</td>
			</tr>
			<tr>
				<td style="text-align:center" colspan=5>
					备注信息<br />
					<br />
					<?php if($cart["pay_back"]==0):?>
					<textarea style="width:600px;border:1px solid black;height:100px" name="pay_back_info"></textarea>
					<?php else:?>
					<p><?php echo $cart["pay_back_info"];?></p>
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td style="text-align:center" colspan=5>
					给客户的消息<br />
					<br />
					<?php if($cart["pay_back"]==0):?>
					<textarea style="width:600px;border:1px solid black;height:100px" name="pay_back_message"></textarea>
						<?php else:?>
					<p><?php echo $cart["pay_back_message"];?></p>
					<?php endif;?>
				</td>
			</tr>
		</table>
		</form>
	</div>

			<div class="black_line"></div>
			<form action="index.php" method="post">
			<input type="hidden" name="action" value="cms"/>
			<input type="hidden" name="method" value="orderCartUpdate"/>
			<input type="hidden" name="cartID" value="<?php echo $cart["cartID"];?>"/>
			<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>"/>
			<input type="hidden" name="orderId" value="<?php echo $order["orderID"];?>"/>
			<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>"/>
			<table class="order_item_table" >
				<tr>
					<td width="45%">
						<table class="first_info">
							<tr>
								<td style="padding-right:15px;" rowspan=3><img width=100px src="<?php echo $good["goodsImgURL"]."_310x310.jpg";?>" alt=""/></td>
								<td style="font-weight: bold;">
								<?php echo $good["goodsTitleCN"];?>
								<br />
								<font style="color:#ED5E83">
								（应收单价：<?php echo number_format($good["goodsUnitPrice"], 2, '.', '');?> 应收运费：<?php echo number_format($good["goodsFreight"], 2, '.', '');?>）
								</font>
								</td>
							</tr>
							<tr>
								<td style="color:#777777;"><?php echo str_replace("|","<br>",$cart["props"]);?></td>
							</tr>
							<tr>
								<td style="color:#9a4aaa;"><?php echo runFunc("getOrderService",array($order["serviceName"]));?></td>
							</tr>
						</table>
					</td>
					<td style="vertical-align:middle;">
						<table class="price_table">
							<tr>
								<th>数量</th>
								<th>运费</th>
								<th>单价</th>
								<th></th>
							</tr>
							<tr>
						<?php if($order["orderStatus"]==4 or $order["orderStatus"]==5):?>
								<td><input class="item_modify" name="ItemQTY" style="width:15px;text-align:center" type="text" value="<?php echo $cart["ItemQTY"]?>"/></td>
								<td><input class="item_modify" name="itemFreight" type="text" value="<?php echo number_format($cart["itemFreight"], 2, '.', ',');?>"/></td>
								<td><input class="item_modify" name="itemPrice" type="text" value="<?php echo number_format($cart["itemPrice"], 2, '.', ',');?>"/></td>
								<td><input class="item_update_button" type="submit" value="更新商品"/></td>
							<?php else:?>
								<td><?php echo $cart["ItemQTY"]?></td>
								<td><?php echo number_format($cart["itemFreight"], 2, '.', ',');?></td>
								<td><?php echo number_format($cart["itemPrice"], 2, '.', ',');?></td>
							<?php endif;?>
							</tr>
						</table>
					</td>


					<td width="20%" style="vertical-align:middle; text-align:center;" colspan="2">
					   <?php if($good["goodsURL"]!=""):?>
                                        <?php if($good["click_url"]!=""){

                                                $click_link = $good["click_url"];
                                        }else{

                                                $click_link = $good["goodsURL"];
                                        }?>
						<a class="pink_link" target="_blank" href="<?php echo $click_link;?>">购买链接</a>
					<?php endif;?>
					<?php if($order["orderStatus"]<8 and $order["orderStatus"]>4):?>
					&nbsp;&nbsp;|&nbsp;&nbsp;
					 <a id="<?php echo $cart["cartID"];?>" class="pink_link cart_pay_back_show cp" ><?php if($cart["pay_back"]>0){echo "退款详情";}else{echo "退款";}?></a>

					<?php endif;?>
					<?php if($order["orderStatus"]==4 or $order["orderStatus"]==5):?>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a onClick="javascript:return confirm('是否要从订单中移除该产品？')" class="pink_link" href="<?php echo runFunc('encrypt_url',array('action=cms&method=orderItemDelete&id='.$this->_tpl_vars["IN"]["id"].'&all_cart='.$order["cartIDstr"].'&delete_cart='.$cart["cartID"].'&type='.$this->_tpl_vars["IN"]["type"]));?>">删除</a>
					<?php endif;?>
					</td>
				</tr>

				<tr>
					<td colspan=2>

						 <div class="item_info_box">
						 <?php if(trim($cart["itemNotes"])!=""):?>
						 	<h2>备注信息</h2>
						 	<?php if($cart["ItemType"] == "ivi"):?>
								<?php echo htmlspecialchars_decode($cart["itemNotes"]);?>
								<?php
									$iviinfo = explode('</span>',htmlspecialchars_decode($cart["itemNotes"]));
								?>
								<div>
								<?php
									foreach($iviinfo as $v){
										$b =  explode('"',htmlspecialchars_decode($v));
										echo "<a href='".trim($b[3])."' target='_blank'>".trim($b[3])."</a><br>";
									}

								?>
								</div>
							<?php else:?>
								<?php echo $cart["itemNotes"];?>
							<?php endif;?>
						<?php endif;?>
						</div>

					</td>
				</tr>

				<tr>
					<td>

					</td>
					<td colspan=2 style="text-align:right;"><?php if($cart["pay_back"]>0):?>
					<span  style="font-weight:bold;color:red">已退款</span>
					<?php endif;?><span style="font-weight:bold;">商品总价：</span><?php echo number_format($cart["itemPrice"] * $cart["ItemQTY"], 2, '.', ',');?> </td>
					<td>
						&nbsp;&nbsp;&nbsp;<span style="font-weight:bold;">总价：</span><?php echo number_format($cart["itemPrice"] * $cart["ItemQTY"] + $cart["itemFreight"], 2, '.', ',');?>
					</td>
				</tr>
			</table>
			</form>
		<?php endforeach;?>
		</div>
	</div>
	<form id="order_info_form" action="index.php" method="post">
	<input type="hidden" name="action" value="cms"/>
	<input type="hidden" name="method" value="orderInfoUpdate"/>
	<input type="hidden" name="orderNo" value="<?php echo $order["OrderNo"];?>"/>
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>"/>
	<input type="hidden" name="type" value="<?php echo $this->_tpl_vars["IN"]["type"];?>"/>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">订单信息</div>
		</div>
		<table class="order_detail">
			<tr>
				<td style="vertical-align:top" width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">订单号：</th>
							<td style="text-align:center;"><?php echo $order["OrderNo"];?></td>
						</tr>
						<tr>
							<th>商品总金额：</th>
							<td style="text-align:right;padding-right: 5px;"><?php echo $order["order_amount"];?></td>
						</tr>
						<tr>
							<th>卖家总运费：</th>
							<td style="text-align:right;padding-right: 5px;">
							<?php echo $order["order_freight"];?>
							</td>
						</tr>
						<!--
						<tr>
							<th>国内运费：</th>
							<td><input class="table_input" type="text" name="domestic_freight" value="0"/></td>
						</tr>
						<tr>
							<th>国际运费：</th>
							<td><input class="table_input" type="text" name="international_freight" value="0"/></td>
						</tr>
						 -->
 						<tr>
							<th>应收服务费：</th>
							<td style="text-align:right;padding-right: 5px;"><?php echo $order["service_fee"];?></td>
						</tr>
						<tr>
							<th>修改服务费：</th>
							<td>
							<input type="text" <?php if($order["orderStatus"]>5){echo "disabled='disabled'";}?> class="table_input" name="service_fee" value="<?php if($order["changed_service_fee"]<0){echo "";}else{echo $order["changed_service_fee"];}?>"/>
							</td>
						</tr>
						<tr>
							<th>优惠代码：</th>
							<td><?php echo $order["coupons"]?></td>
						</tr>
						<tr>
							<th>优惠方式：</th>
							<td><?php echo $order["coupon_word"]?></td>
						</tr>
					<!--
						<tr>
							<th>其他费用：</th>
							<td><input type="text" class="table_input" name="other_fee" value="0"/></td>
						</tr>
					 -->
					</table>
				</td>
				<td style="vertical-align:top" width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">下单日期：</th>
							<td style="text-align:center;"><?php echo date("Y-m-d H:i:s",$order["orderTime"]);?></td>
						</tr>
						<tr>
							<th>支付日期：</th>
							<td style="text-align:center;"><?php echo $order["payTime"];?></td>
						</tr>
						<tr>
							<th>支付方式：</th>
							<td style="text-align:center;">
							<?php if($order["orderStatus"]>4):?>
							<?php echo runFunc("getOrderPayment",array($order["orderID"]));?>
							<?php endif;?>
							</td>
						</tr>
						<tr>
							<th>退款金额：</th>
							<td style="text-align:center;"><?php if($cart_pay_back_amount[0]["amount"]==""){echo "0.00";}else{ echo $cart_pay_back_amount[0]["amount"];}?></td>
						</tr>
						<?php if($order["payment"]==1):?>
						<tr>
							<th>paypal支付金额：</th>
							<td style="text-align:center;">
							$ <?php echo $order["paypal_pay"];?>
							</td>
						</tr>
						<?php endif;?>
					</table>
					<table class="order_detail_table">
					<tr>
					<td style="text-align:right" width="30%">交易问题：</td>
					<td style="text-align:left;padding: 5px 5px;">
				<!-- 	<select name="shipping_mode" id="">
						<option value="1">快递</option>
						<option value="2">EMS</option>
						<option value="3">平邮</option>
					</select>
				 -->
				 <?php echo $order["problem"];?>
				 	</td>
				 	</tr>
					</table>
					</td>
			</tr>
		</table>
		<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		<table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">发票：</th>
							<td style="text-align:center;">
								<?php if($order["invoice"]>0){
									echo "需要";
								}else{

									echo "不需要";
								}?>
							</td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">税金：</th>
							<td style="text-align:center;">
							<?php echo $order["tax"];?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		<table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">采购日期：</th>
							<td style="text-align:center;"><?php echo $order["purchaseTime"];?></td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">发货日期：</th>
							<td style="text-align:center;"><?php echo $order["shippingTime"];?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class="black_line" style="border-bottom:1px solid #eef0f1;margin:9px 0"></div>
		<table class="order_detail">
			<tr>
				<td width="50%">
					<table class="order_detail_table">
						<tr>
							<th width="30%">总金额：</th>
							<td style="text-align:center;"><?php echo $order["totalAmount"];?></td>
						</tr>
					</table>
				</td>
				<td width="50%">
				<?php if($order["orderStatus"]==4):?>
					<a id="save_order_info" style="display:block;width:80px;height:20px;line-height:20px;margin:auto;text-align:center" class="item_update_button">更新订单信息</a>
				<?php endif;?>
				</td>
			</tr>
		</table>
	</div>
	<div class="order_info">
		<div class="order_info_bar">
			<div class="order_info_title fl">购买会员信息</div>
		</div>


					<table class="order_detail">
			<tr>
			<td width="50%" style="vertical-align:top;">
			<?php
				if(is_numeric($order["orderUser"])){
					$userinfo=runFunc('getStaffInfoById',array($order["orderUser"]));?>
					<table class="order_detail_table order_member_detail">
						<tr>
							<th width="30%">昵称：</th>
							<td style="text-align:center;"><a class="pink_link_s" href="<?php echo runFunc('encrypt_url',array('action=cms&method=user&id='.$order["orderUser"].'&type=users'));?>"><?php echo $userinfo[0]["staffName"];?></a></td>
						</tr>
						<tr>
							<th width="30%">姓名：</th>
							<td style="text-align:center;"><?php echo $userinfo[0]["staffNo"]?></td>
						</tr>
						<tr>
							<th width="30%">Email地址：</th>
							<td style="text-align:center;"><?php echo $userinfo[0]["email"]?></td>
						</tr>
					</table>
						<?php
				}else{
					echo "未注册用户";
				};?>
				</td>
				<td style="vertical-align:top;">
					<table class="order_detail_table">
						<tr>
							<th width="30%">收货人姓名：</th>
							<td style="text-align:center;"><?php echo $order["fullName"];?></td>
						</tr>
						<tr>
							<th width="30%">Email地址：</th>
							<td style="text-align:center;"><?php echo $order["email"];?></td>
						</tr>
						<tr>
							<th width="30%">联系电话：</th>
							<td style="text-align:center;"><?php echo $order["cellphone"];?> , <?php echo $order["telephone"];?></td>
						</tr>
						<tr>
							<th width="30%">地区：</th>
							<td style="text-align:center;"><?php echo $order["country"]." ".$order["province"]." ".$order["city"];?></td>
						</tr>
						<tr>
							<th width="30%">地址：</th>
							<td style="text-align:center;"><?php echo $order["address1"];?> <?php echo $order["address2"];?></td>
						</tr>
						<tr>
							<th width="30%">邮编：</th>
							<td style="text-align:center;"><?php echo $order["zipcode"];?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>


		<br/><br/><br/><br/>
	</div>
</form>
</div>
</div>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>