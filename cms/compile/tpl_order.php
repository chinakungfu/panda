<?php import('core.util.RunFunc'); ?>
<?php
$inc_tpl_file=includeFunc(<<<LNMV
header.tpl
LNMV
);
include($inc_tpl_file);
?>
<script type="text/javascript" src="skin/jsfiles/orderDetail.js"></script>
<script type="text/javascript" src="skin/jsfiles/city.js"></script>

<div class="cms_main_box">
	<div class="content">
<?php
	 import('core.apprun.cmsware.CmswareNode');
	 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
	 $params = array (
				'action' => "sql",
				'return' => "lists",
				'query' => "SELECT * FROM cms_publish_order as a LEFT JOIN cms_publish_address as b ON a.orderAddress = b.addressId LEFT JOIN cms_member_staff as c ON c.staffId = b.userId WHERE a.orderID = {$this->_tpl_vars['IN']['orderID']} limit 0,1",
	 );
	 $this->_tpl_vars['lists'] = CMS::CMS_sql($params);
	 $this->_tpl_vars['PageInfo'] = &$PageInfo;
	 $order = $this->_tpl_vars['lists']['data'][0];
	 $orderStatus  = $order["orderStatus"];
	 $pending = $order["pending"];
	 $order_return = $order['order_return'];
	 $settings =  runFunc("getGlobalSetting");
	 $credit = floor($order["totalAmount"] / $settings[0]["credit_consumption"]);
	 $userInfo = runFunc("getUser",array($order["orderUser"]));
?>
<?php //echo $orderStatus;?>
    <div class="bagNav">
    <a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders'));?>">Orders</a> > <a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orders'));?>">Orderlist WOW</a> > <a><?php echo $_GLOBAL['order_info_'.$order["orderStatus"]];?></a>
    <a class="template" href="index.php<?php echo runFunc('encrypt_url',array('action=cms&method=adminHelpMessages&type=users'));?>">Choose Template</a>
    </div>
	<div class="saveas_box fr">
		<img src="/cms/skin/images/saveas.png" />
		<div class="saveas hide saveHover">
			<ul>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=waitingPayment'));?>">Waiting Payment<br /><span>(待付款订单，自动发送提醒邮件）<span></a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=verified'));?>">Verified<br /><span>(待采购订单）<span></a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=purchased'));?>">Purchased <br /><span>(已采购订单）<span></a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=onTheWay'));?>">On the Way<br /><span>(发货中订单）<span></a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=shipped'));?>">Shipped<br /><span>(已发货订单，并发送确认提醒）<span></a></li>
<!--            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=returned'));?>">Returned<br /><span>(已退货订单，并发送已退货提醒）<span></a></li>
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=replacement'));?>">Replacement<br /><span>(已换货订单，并发送已换货提醒）<span></a></li>-->
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=refund'));?>">Refund<br /><span>(待退款订单）<span></a></li>
<!--            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=paidBack'));?>">Paid Back* 自动及手动<br /><span>(已退款订单，并发送退款提醒邮件）<span></a></li>-->
            <li class="bgbottom"><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=close'));?>">Close Transaction * 主动关闭<br /><span>(已关闭订单）<span></a></li>
            <li><a href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderInfoUpdate&orderID='.$order['orderID'].'&type=finished'));?>">Finished * 自动及手动<br /><span>(已完成订单）<span></a></li>
          	</ul>
		</div>
	</div>
    <div class="payment">
    	 <div class="clb"></div>
        <div class="orderNo">
        	<?php
				switch($order["orderStatus"]){
					case '4':
						if($order["pending"] == 1){
							echo $_GLOBAL['order_info_2']." <h2>".$_GLOBAL['order_info_cn_2']."</h2>";
						}else if($order["pending"] == 2){
							echo $_GLOBAL['order_info_'.$order["orderStatus"]]." <h2>".$_GLOBAL['order_info_cn_3']."</h2>";
						}else{
							echo $_GLOBAL['order_info_'.$order["orderStatus"]]." <h2>".$_GLOBAL['order_info_cn_1']."</h2>";
						}
					break;
					case '5':
						echo $_GLOBAL['order_info_'.$order["orderStatus"]]." <h2>".$_GLOBAL['order_info_cn_5']."</h2>";
					break;
					case '6':
						echo $_GLOBAL['order_info_'.$order["orderStatus"]]." <h2>".$_GLOBAL['order_info_cn_'.$order["orderStatus"]]."</h2>";
					break;
					default:
						echo $_GLOBAL['order_info_'.$order["orderStatus"]];
					break;
				}
			?>
			<div><span class="hong">NO.<?php echo $order['OrderNo'];?></span>
				<?php if($order['country'] != 'China'):?>
                <img src="../../skin/images/global2.png" />
                <?php endif;?>
            </div>
        </div>
        <div class="orderTimes">
        	<table width="387px">
        		<tr><td><span id="orderOperator" class="orderUser hide"></span><span class="viewOperator" operator="<?php echo $order['mender'];?>">Modify:</span></td><td width="120px"><?php if($order['modifyTime']){ echo date("y-m-d H:i:s",$order['modifyTime']);}?></td></tr>
        		<tr><td><span class="viewOperator" operator="<?php echo $order['verifier'];?>">Verified:</span></td><td><?php if($order['verifyTime']){ echo date("y-m-d H:i:s",$order['verifyTime']);}?></td></tr>
        		<tr><td><span class="viewOperator" operator="<?php echo $order['buyer'];?>">Purchased:</span></td><td><?php if($order['purchaseTime']){ echo date("y-m-d H:i:s",strtotime($order['purchaseTime']));}?></td></tr>
        		<tr><td><span class="viewOperator" operator="<?php echo $order['refunder'];?>">Refounded:</span></td><td><?php if($order['refoundTime']){ echo date("y-m-d H:i:s",$order['refoundTime']);}?></td></tr>
        	</table>
        </div>
        <div class="clb"></div>

    	<div style="float:right;width:337px;font-size:12px;"><span style="color:#adaeab;font-size:12px;">Transaction:</span><?php echo $order['payTime'];?></div>
    	<div style="float:right;width:525px;text-align:center;font-size:12px;"><span style="color:#adaeab;font-size:12px;">Submit time:</span><?php echo $order['orderTime_n'];?></div>
        <div style="float:left;margin-right:20px;font-size:12px;"><span style="color:#adaeab;font-size:12px;"><?php echo $order['orderName'];?></span></div>
        <div class="clb"></div>
    	<div class="paymentContent">
            <table width="1080px">
                <tr class="paymentTh">
                    <td width="220" style="color:#333;font:bold 14px Arial, Helvetica, sans-serif;">Shipping Address</td>
                    <td width="525" align="center"></td>
                    <td width="170" style="color:#333;font:bold 14px Arial, Helvetica, sans-serif;">Payment Info</td>
                    <td align="right">

						<div class="editOrder_box fr">
							<img src="../../skin/images/shezhi.png" />
							<div class="editOrder hide">
								<ul>
					            <li class="bgbottom" onClick="openEdit('addressCN','address');"><a>Edit address</a><span>(编辑地址）<span></li>
					            <li class="bgbottom"><a>Add additional payment</a><span>（追加付款）<span></li>
					            <li class="bgbottom"><a>Add International Fee</a><span>（国际运费）<span></li>
                                <?php if($order["orderStatus"] > 4 && $order["orderStatus"] < 19):?>
					            <li><a style="display:block;" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=order_cart_pay_back&orderID='.$order['orderID']));?>">Refund to customer<span style="color:#333;">（退款操作）<span></a></li>
                                <?php endif;?>
					          	</ul>
							</div>
						</div>
                        <div class="fr" style="margin-right:20px;"><img style="cursor:pointer;" isOpen="0" id="saveAddress" onclick="saveAddressCN('<?php echo $order['addressId'];?>');" src="../../skin/images/saveBtn.png" /></div>
                    </td>
                </tr>
                <tr>
                    <td>Receiving Name</td>
                    <td align="center" class="cartThreeCN"><span id="cartThreeFirstName">
						<?php if($order['firstName'] && $order['lastName']):?>
							<?php echo $order['firstName'].' '.$order['lastName'];?>
						<?php else:?>
							<?php echo $order['fullName'];?>
						<?php endif;?>
						</span>
					</td>
                    <td>Merchandise Sub-Total: </td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['order_amount'],2,'.',',');?> </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td align="center"  class="cartThreeCN"><span id="cartThreeEmail"><?php echo ($userInfo[0]['email']?$userInfo[0]['email']:$userInfo[0]['staffNo']);?></span></td>
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
                    <td>Special Service Fee:</td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['special_service_fee'],2,'.',',');?></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeAddress2"><?php echo $order['address2'];?></span></td>
                    <td>Additional Payment:</td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['additional'],2,'.',',');?></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><span id="cartThreeCity"><?php echo $order['city'].';'.$order['province'].';'.$order['country'];?></span></td>
                    <td>International Shipping:</td>
                    <td align="right" class="cartThreeRmb">¥ <?php echo number_format($order['order_international_freight'],2,'.',',');?></td>
                </tr>
<script language="javascript">
	$(function(){
		setup();
	});
	var s=["country","province","city"];
	var opt0 = ["国家","省份、州","地级市、县"];
	function setup()
	{
		for(i=0;i <s.length-1;i++)
		document.getElementById(s[i]).onchange=new Function("change("+(i+1)+")"); 	//s[0] 国家,s[1] 省,s[2] 市 给每个select梆定事件change
		initializeChange(0);
	}

	function initializeChange(v){
		//根据国家省市来匹配selected值
		var selectedVal = "";
		if(v == 0){
			selectedVal = "<?php echo $order['countryCN'];?>";
		}else if(v == 1){
			selectedVal = "<?php echo $order['provinceCN'];?>";
		}else if(v == 2){
			selectedVal = "<?php echo $order['cityCN'];?>";
		}
		var str="0";
		for(i=0;i <v;i++){
			str += ("_"+(document.getElementById(s[i]).selectedIndex-1));  //获取下一级数据的ID号
		};


		var ss=document.getElementById(s[v]);
		with(ss){ 	//引用下一级select 对
		  length = 0;
		  options[0]=new Option(opt0[v],opt0[v]); 	//第一项为opt0的对应值
		  if(dsy.Exists(str)){
			ar = dsy.Items[str]; //获取对应option数据
			//var k = 0;
			for(i=0;i <ar.length;i++){
				options[length]=new Option(ar[i],ar[i]); //循环填充option
				if(ar[i] == selectedVal){
					options[i+1].selected = true;
				}
			}
		  }
		  if(++v < s.length && selectedVal != ""){initializeChange(v);}
		}
	}
	function change(v){

		var str="0";
		for(i=0;i <v;i++){
			str += ("_"+(document.getElementById(s[i]).selectedIndex-1));  //获取下一级数据的ID号
		};
		var ss=document.getElementById(s[v]); //获取下一级select

		with(ss){ 	//引用下一级select 对象
		  length = 0;
		  options[0]=new Option(opt0[v],opt0[v]); 	//第一项为opt0的对应值
		  if(v && document.getElementById(s[v-1]).selectedIndex>0 || !v)
		  {
			  if(dsy.Exists(str)){
				ar = dsy.Items[str]; //获取对应option数据
				for(i=0;i <ar.length;i++){
					options[length]=new Option(ar[i],ar[i]); //循环填充option
				}
				if(v)options[1].selected = true; //当选择某一项时,下级项目填充之后默认显示第一个
			  }
		  }
		  if(++v <s.length){change(v);}
		}
	}

</script>
                <tr id="addressCN">
                    <td colspan="4">
                    <table width="1080px">
                        <tr>
                            <td width="220">Address in Chinese </td>
                            <td width="525" align="center" class="cartThreeCN">
                                <select disabled="disabled" class="bghui2" id="country" name="country"> <option>国家 </option> </select>
                                <select disabled="disabled" class="bghui2" id="province" name="province"> <option>省份、州 </option> </select>
                                <select disabled="disabled" class="bghui2" id="city" name="city"> <option>地级市、县 </option> </select>
                            </td>
                            <td width="170"></td>
                            <td width="165" align="right"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center" class="cartThreeCN">
                            	<input disabled="disabled" class="bghui2" name="addressCN1" id="addressCN1" value="<?php echo $order['addressCN1'];?>" />
                            </td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center" class="cartThreeCN">
                            	<input disabled="disabled" class="bghui2" name="addressCN2" id="addressCN2" value="<?php echo $order['addressCN2'];?>" />
                            </td>
                            <td></td>
                            <td align="right"></td>
                        </tr>
                    </table>
                    </td>
                </tr>
                <tr class="itemLineBg1080" style="height:2px"><td colspan="6"></td></tr>
                <tr class="cartThreeInvoice" >
                    <td colspan="2">Invoice</td>
                    <td>Estimated Tax:</td>
                    <td align="right" class="cartThreeRmb"><span id="tax_view">¥ <?php if($order['tax']):echo $order['tax'];else:?>0.00 <?php endif;?> </span></td>
                </tr>
                <?php if($order['invoice']):?>
                <tr>
                    <td colspan="2" class="cartThreeInvoiceTitle"><div style="margin-left:50px;">title: <?php echo $order['invoiceTitle'];?></div></td>
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
                        <div id="promoCode" style="color:#333;font:bold 14px Arial, Helvetica, sans-serif;" class="<?php if(!$order['coupons']):?>hide<?php endif;?> hui fr">Code:<?php echo $order['coupons'];?>
                        </div>
                    </td>
                </tr>
                <tr style="font-size:18px;border-top:2px solid #aaa;">
                    <td colspan="2"></td>
                    <td>Total:</td>
                    <td align="right" class="cartThreeRmb"><span id="order_amount">¥ <?php echo number_format($order['totalAmount'],2,'.',',');?></span></td>
                </tr>
                <?php if($order["payment"]):?>
                <tr style="height:20px">
                    <td colspan="2"></td>
                    <td colspan="2" align="right" style="color:#adaeab;">
                    Paid by <?php echo $_GLOBAL['order_payment_'.$order["payment"]];?></td>
                </tr>
                <?php endif;?>
                <tr style="height:20px">
                    <td colspan="2"></td>
                    <td> </td>
                    <td align="right" style="color:#5e97ed;">Points:&nbsp;&nbsp;&nbsp;&nbsp; + <?php echo $credit;?></td>
                </tr>
                <tr style="height:20px">
                    <td colspan="2"></td>
                    <td align="right" colspan="2" style="color:#333;">Total Refund:&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:#a10000;">- ¥ <?php echo number_format($order['refundAmount'],2,'.',',');?></span></td>
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

                <?php foreach ($this->_tpl_vars["shopList"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){?>
					<?php
                        $goodsShopId = $this->_tpl_vars['var']['goodsShopId'];
                        $goodsshopName = $this->_tpl_vars['var']['goodsShopName'];
                        $sellerTotalPrice = number_format($this->_tpl_vars["var"]["sellerTotalPrice"], 2, '.', ','); //店铺总价钱
                    ?>
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
                                	<?php if($orderStatus == 4 && $pending < 2):?>
						            <li class="bgbottom" onClick="openEdit('<?php echo $goodsShopId;?>','modify');"><a>Modify</a><span>(修改价格及采购提示）<span></li>
                                    <?php endif;?>

                               		<?php if($orderStatus == 6):?>
						            <li class="bgbottom" onClick="openEdit('<?php echo $goodsShopId;?>','purchase');"><a>Purchase Record</a><span>(采购纪录）<span></li>
                                    <?php endif;?>

                                    <?php if($orderStatus > 6 && $orderStatus < 11):?>
                                    <li class="bgbottom" onClick="openEdit('<?php echo $goodsShopId;?>','delivery');"><a>Delivery Info</a><span>（运单纪录）<span></li>
                                    <?php endif;?>

									<?php if($orderStatus > 4 && $orderStatus < 19 && $order_return != 2 && $orderStatus != 17):?>
						            <li onClick="openEdit('<?php echo $goodsShopId;?>','refund');"><a>Refund Record</a><span>(退款录入）<span></li>
						            <?php endif;?>
						          	</ul>
								</div>
							</div>
                        <span class="itemShopHide" onClick="hideShop(<?php echo $goodsShopId;?>);"></span><span class="itemShopShow" onClick="showShop(<?php echo $goodsShopId;?>);"></span></td>
                    </tr>
                    <tr class="itemLineBg1080" height="2px"><td colspan="6"></td></tr>
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
                                    <table style="margin-top:10px;width:1080px;table-layout:fixed;word-wrap:break-word;" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td width="60px" rowspan="2" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
                                            </td>
                                            <td width="80px" rowspan="2"  align="center" valign="top">
                                                <div class="itemImg"><a href="<?php echo $this->_tpl_vars['itemvar']['goodsURL'];?>" target="_blank"><img src="<?php echo $this->_tpl_vars['itemvar']['goodsImgURL'];?>_100x100.jpg" /></a></div>
                                            </td>
                                            <td width="500px" align="left" valign="top">
                                                <div class="itemTitle">
                                                    <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleCN"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleCN"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                 <div class="itemPrice">¥ <span id="item_price">
                                                	<?php if($orderStatus == '4'):?>
                                                    	<input name="item_price" disabled="disabled" class="bghui2" style="width:80px;height:20px;text-align:center;" value="<?php echo number_format($itemPrice, 2, '.', ',');?>" />
                                                    <?php else:?>
                                                    	<?php echo number_format($itemPrice, 2, '.', ',');?>
                                                    <?php endif;?>
													</span>
                                                </div>

                                            </td>
                                            <td width="150px" align="center" valign="top">

                                            	<span style="color:#a10000;"><?php echo $itemQTY;?></span>
                                            </td>
                                            <td width="140px" align="center" valign="top">
                                                <div class="itemPrice">
                                                ¥ <span id="<?php echo $cartID;?>_total_price"><?php echo $total_price; ?></span>
                                                </div>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td width="500px" align="left" valign="top">
                                                <div class="itemTitle"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=surprise&method=item_show&show_type=collections&from=collections_page&id='.$goodsid));?>" target="_blank" title="<?php echo $this->_tpl_vars["itemvar"]["goodsTitleEn"];?>"><?php echo runFunc('g_substr',array($this->_tpl_vars["itemvar"]["goodsTitleEn"],58));?></a></div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                                <div class="originalPrice">
                                                <?php if($originalPrice):?>
													¥ <STRIKE><?php echo number_format($originalPrice, 2, '.', ',');?></STRIKE>
                                                <?php endif;?>
                                                </div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                            </td>
                                            <td width="96px" align="right" valign="top">

                                            </td>
                                        </tr>


                                        <tr class="itemLineBg1080" style="height:10px"><td colspan="6"></td></tr>
                                        <tr>
                                        	<td></td>
                                            <td></td>
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
                                                            <div class="clr"></div>
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

                                        <tr>
                                        	<td></td>
                                            <td></td>
                                            <td colspan="3">
                                            	<?php if($this->_tpl_vars['itemvar']["itemNotes"]):?>
                                                <div class="itemcartRequest">
                                                    <div class="itemRequestName fl">Request:</div>
                                                    <div class="fl" style="color:#5e97ed;width:680px;"><?php echo $this->_tpl_vars['itemvar']["itemNotes"];?></div>
                                                    <div class="clr"></div>
                                                </div>
                                                <?php endif;?>
                                            </td>
                                            <td></td>
                                        </tr>

                                        <tr height="50px">
                                        	<td></td>
                                            <td></td>
                                            <td colspan="3">
                                                <div>
                                                    <div class="fl" style="width:180px;">Purchase Considerations:<br />采购须知</div>
                                                    <div style="color:#5e97ed;">
														<textarea name="purchaseInfo" disabled="disabled" class="bghui2 purchaseInfo" style="height:40px;width:580px;font-size:12px;"><?php echo $this->_tpl_vars['itemvar']["purchaseInfo"];?></textarea>

                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>

                                         <tr height="50px">
                                        	<td></td>
                                            <td></td>
                                            <td colspan="3">
                                                <div>
                                                    <div class="fl" style="width:180px;">Service Remark:</div>
                                                    <div style="color:#5e97ed;">
														<textarea name="serviceRemark" disabled="disabled"  class="bghui2" style="height:40px;width:580px;font-size:12px;"><?php echo $this->_tpl_vars['itemvar']["serviceRemark"];?></textarea>

                                                    </div>
                                                </div>
                                            </td>
                                            <td align="right">

                                                 <?php if($this->_tpl_vars['itemvar']["order_item_status"] == '19'):?>
                                            		<div class="bghui confirm_receipt">Confirmed</div>
                                                 <?php endif;?>
                                            </td>
                                        </tr>


                                         <tr height="50px">
                                        	<td></td>
                                            <td></td>
                                            <td colspan="3">
                                            	<table width="800px">
                                                	<tr>
                                                    	<td width="100px"><img src="/skin/images/car.png" /></td>

                                                        <td width="300px">
                                                	<?php if($orderStatus > 6 && $orderStatus < 11):?>

                                                       <input type="text" class="bghui2" style="height:20px;width:260px;" name="expressNum" disabled="disabled" value="<?php echo $this->_tpl_vars['itemvar']["expressNum"];?>" />

                                                    <?php elseif($this->_tpl_vars['itemvar']["expressNum"]):?>

                                                    	<?php echo $this->_tpl_vars['itemvar']["expressNum"];?>

                                                    <?php endif;?>

                                                        </td>
                                                        <td width="100px">
                                                        	url:
                                                        </td>
                                                        <td>
                                                    <?php if($orderStatus > 6 && $orderStatus < 11):?>

                                                       <input name="expressUrl" disabled="disabled"  class="bghui2" style="height:20px;width:260px;" value="<?php if($this->_tpl_vars['itemvar']["expressUrl"]){echo $this->_tpl_vars['itemvar']["expressUrl"];}else{echo "http://";};?>" />
                                                    <?php elseif($this->_tpl_vars['itemvar']["expressUrl"]):?>
                                                      	<?php echo $this->_tpl_vars['itemvar']["expressUrl"];?>
                                                    <?php endif;?>

                                                        </td>
                                                    </tr>

                                                </table>

                                            </td>
                                            <td align="right">
                                                 <?php if($this->_tpl_vars['itemvar']["order_item_status"] == '12' || ($this->_tpl_vars['itemvar']["returnInstructions"] && $this->_tpl_vars['itemvar']["returnPhoto"])):?>
                                            		<a target="_blank" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderReturnDetail&cartID='.$this->_tpl_vars['itemvar']['cartID'].'&orderID='.$order['orderID']));?>" class="nan">查看换货申请</a>


                                                 <?php elseif($this->_tpl_vars['itemvar']["order_item_status"] == '14' || ($this->_tpl_vars['itemvar']["returnInstructions"] && $this->_tpl_vars['itemvar']["returnPhoto"])):?>

                                                 	<a target="_blank" href="/cms/index.php<?php echo runFunc('encrypt_url',array('action=cms&method=orderReturnDetail&cartID='.$this->_tpl_vars['itemvar']['cartID'].'&orderID='.$order['orderID']));?>" class="nan">查看退货申请</a>
                                                 <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td><td class="sellerFreight">Refund reason:</td>
                                            <td class="sellerFreightPrice" colspan="2" align="right">

                                               <?php if($orderStatus > 4 && $orderStatus < 19 && $order_return != 2 && $orderStatus != 17):?>
                                                    <select class="bghui2" name="pay_back_message" disabled="disabled" style="width:140px;">
                                                    	<option value="0">Selected Reason</option>
                                                    	<option value="1" <?php if($this->_tpl_vars['itemvar']["pay_back_message"] == "1"):?> selected="selected"<?php endif;?>><?php echo $_GLOBAL['refund_reason_1'];?></option>
                                                        <option value="2" <?php if($this->_tpl_vars['itemvar']["pay_back_message"] == "2"):?> selected="selected"<?php endif;?>><?php echo $_GLOBAL['refund_reason_2'];?></option>
                                                        <option value="3" <?php if($this->_tpl_vars['itemvar']["pay_back_message"] == "3"):?> selected="selected"<?php endif;?>><?php echo $_GLOBAL['refund_reason_3'];?></option>
                                                    </select>
                                                <?php elseif($this->_tpl_vars['itemvar']["pay_back_message"]):?>

                                                   	<span style="color:#5E97ED"><?php echo $_GLOBAL['refund_reason_'.$this->_tpl_vars['itemvar']['pay_back_message']];?></span>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td><td class="sellerFreight">Refund:</td>
                                            <td class="sellerFreightPrice" colspan="2" align="right">

                                               <?php if($orderStatus > 4 && $orderStatus < 19 && $order_return != 2 && $orderStatus != 17):?>
                                                    <input type="text" class="bghui2" style="height:20px;width:139px;" name="refundPrice" value="<?php echo $this->_tpl_vars['itemvar']["pay_back_money"];?>" />

                                                <?php elseif($this->_tpl_vars['itemvar']["pay_back_money"]):?>

                                                   ¥ <span><?php echo $this->_tpl_vars['itemvar']["pay_back_money"];?></span>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr class="itemLineBg270" height="2px"><td colspan="6"></td></tr>
                                        <tr>
                                            <td colspan="4"></td><td class="sellerFreight">Purchase Total:</td>
                                            <td class="sellerFreightPrice"  colspan="2">

                                                <?php if($orderStatus == 6):?>
                                                    <input type="text" class="bghui2" style="height:20px;width:100px;" name="purchaseTotal" value="<?php echo $this->_tpl_vars['itemvar']["purchaseTotal"];?>" />
                                                <?php elseif($this->_tpl_vars['itemvar']["purchaseTotal"]):?>
                                                   ¥ <span><?php echo $this->_tpl_vars['itemvar']["purchaseTotal"];?></span>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                       <tr class="itemLineBg270" height="2px"><td colspan="6"></td></tr>
                                       <tr height="40px">
                                            <td colspan="5"></td>
                                            <td align="right">
                                               <span class="save_modify_item" isOpen = "0" cartid="<?php echo $this->_tpl_vars['itemvar']["cartID"];?>" orderid="<?php echo $order["orderID"];?>"></span>
                                            </td>
                                        </tr>
                                        <tr class="itemLineBg980"><td colspan="6" height="10px"></td>
                                        </tr>
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
</div>



<?php
$inc_tpl_file=includeFunc(<<<LNMV
footer.tpl
LNMV
);
include($inc_tpl_file);
?>