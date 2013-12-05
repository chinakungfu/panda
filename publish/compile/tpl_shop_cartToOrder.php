<?php import('core.util.RunFunc');
$signin = runFunc('readSession',array());
?>
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

</head>
<script type="text/javascript" src="/publish/skin/jsfiles/shoppingcartToOrder.js"></script>
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
	$cartIdStr =  $this->_tpl_vars["IN"]["cartIdStr"];
	$userid = $this->_tpl_vars["tmpUser"];
	if(!$cartIdStr || !$userid){
		header("Location: ".runFunc('encrypt_url',array('action=shop&method=myCart')));
	}
	$settings =  runFunc("getGlobalSetting");
	//购物车中全部商品
	import('core.apprun.cmsware.CmswareNode');
	import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params,$PageInfo2,$params2;
	$params = array (
	'action' => "sql",
	'return' => "cartTotal",
	'query' => "SELECT SUM(ItemQTY) as cartTotal,SUM(itemTotal) as sellerSubTotalPrice FROM cms_publish_cart WHERE UserName = '{$this->_tpl_vars["tmpUser"]}' and ItemStatus = 'New' and cartID in ({$cartIdStr})",
	);

	$this->_tpl_vars['cartTotal'] = CMS::CMS_sql($params);
	$this->_tpl_vars['PageInfo'] = &$PageInfo;
		

	$params2 = array (
	'action' => "sql",
	'return' => "shopList",
	'query' => "SELECT b.goodsShopId,b.goodsShopName,SUM(a.ItemQTY) as shopTotal,SUM(a.itemTotal) as sellerTotalPrice FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$userid}' and a.ItemStatus = 'New' and cart_type = 1 and a.cartID in ({$cartIdStr}) Group By b.goodsShopId Order By a.cartID DESC",
	);

	$this->_tpl_vars['shopList'] = CMS::CMS_sql($params2);
	$this->_tpl_vars['PageInfo'] = &$PageInfo2;

	$shopNum =  count($this->_tpl_vars["shopList"]["data"]);//商店数目
	$sellerSubFreightPrice =  number_format($shopNum*$settings[0]["freight"], 2, '.', ',');//总运费	
	$sellerSubTotalPrice = number_format($this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品总价
	$serviceFeePrice = number_format($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'], 2, '.', ',');//所有商品服务费

	$sellerAllTotalPriceYuan = ($shopNum*$settings[0]["freight"]) + $this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice'] + ($settings[0]["service_fee"]*$this->_tpl_vars["cartTotal"]["data"][0]['sellerSubTotalPrice']); //不带,号的价格,可以与换算
	$sellerAllTotalPrice = number_format($sellerAllTotalPriceYuan, 2, '.', ',');//总价钱
	?>
    
    <!--第一步-->
    <div class="cartOne">
	<div class="cartOneTitle"><span>1. Items you ordered</span> <a href="<?php echo "/publish/index.php".runFunc('encrypt_url',array('action=shop&method=myCart'));?>">Edit</a></div>
	<?php if($this->_tpl_vars["cartTotal"]["data"][0]['cartTotal'] > 0){?>
        <div class="bagContent">
       
            <table width="976px">
                <tr class="bagTh">
                    <td width="60px"></td>
                    <td width="80px"></td>
                    <td width="440px"></td>
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
                <tr id="all_<?php echo $goodsShopId;?>"><td colspan="6">
                    <table width="976px">       	
                    <tr class="bagShopName">
                    	<td width="580px" colspan="3"><span>Store :</span> <a href="<?php echo $this->_tpl_vars["var"]["goodsShopUrl"];?>" target="_blank"><?php echo $goodsshopName;?></a></td>
                    	<td width="150px"></td>
                    	<td width="150px"></td>                        
                        <td></td>
                    </tr>
                    <tr class="itemLineBg980" height="2px"><td colspan="6"></td></tr>
                    <tr style="margin-top:10px;" id="<?php echo $goodsShopId;?>">
                        <td colspan="6">
                           <?php 
						   		$shopItemList = runFunc("getShopItemList",array($userid,$goodsShopId)); 							                      			$isModify = false;
								$isRequest = false;
                             foreach ($shopItemList as $this->_tpl_vars['itemkey'] => $this->_tpl_vars['itemvar']){
							 
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
								if($this->_tpl_vars['itemvar']['modifyPriceStatus']){
									$isModify = true;
								}
								if(trim($this->_tpl_vars['itemvar']["itemNotes"])){
									$isRequest = true;
								}
							?>                       
                                    <table style="margin:10px auto;width:976px;table-layout:fixed;word-wrap:break-word;" id="<?php echo $cartID;?>">
                                        <tr>
                                            <td rowspan="2" width="60px" align="left" valign="top">
                                            <div class="itemGoodsIdStyle">ID:<?php echo $goodsid;?> </div>
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
                                                <div>
												<?php if($isModify){?>
                                                	<span class="itemModifyPriceYes" style="cursor:inherit;">Price Modify Requested</span>
												<?php }?>

                                                </div>
                                            </td>
                                            <td width="150px" align="center" valign="top">
                                            	<?php echo $itemQTY;?>
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
                                        
                                        
                                        
                                        
                                     </table>                         
                            <?php } ?>
							
						 <script language="javascript">
                            $(function(){
								<?php if($isModify){?>
                                	$("#pending").val("1");
								<?php }?>
								<?php if($isRequest){?>
                                	$("#isRequest").val("1");
								<?php }?>								
                            });
                        </script> 
                        
                                                                   
                    </td></tr>
                 </table>
                 </td></tr>
                <?php }?>        
                <tr height="50px" style="border-top: 2px solid #ADAEAB;">
                    <td colspan="3"></td>
                    <td colspan="3" align="right">
                        <a class="cart_submit" id="cartToAddress" href="#cartTwoTitleAll">Continue</a>
                    </td>
                </tr>
            </table>
	</div>
	<?php }else{
		header("Location: ".runFunc('encrypt_url',array('action=shop&method=myCart')));
	 }?>
 	</div>
    <div class="itemLineBg980 h30 w975"></div>
    
<script src="/skin/js/formValidator/formValidator-4.1.3.js"></script>
<script src="/skin/js/formValidator/formValidatorRegex.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$.formValidator.initConfig({formID:"addressForm",theme:"address",submitOnce:false,
		onError:function(msg,obj,errorlist){
			$("#errorlist").empty();
			$.map(errorlist,function(msg){
				$("#errorlist").append("<li>" + msg + "</li>")
			});
			//alert(msg);
		},
		ajaxPrompt : '有数据正在异步验证，请稍等...'
	});
	$("#firstName").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#lastName").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#address1").formValidator({onShowText:"Apartment, suite, unit, building,floor, etc."}).inputValidator({min:3,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	

	$("#address2").formValidator({onShowText:"Street address, P.O.box, company name, c/o"}).inputValidator({min:3,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	

	$("#province").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#city").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#country").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	$("#phone1").inputValidator({min:2,onError:""}).regexValidator({regExp:["ascii"],dataType:"enum",onError:""});	
	
	//$("#phone1").regexValidator({regExp:["tel","mobile"],dataType:"enum",onError:"你输入的手机或电话格式不正确"});	

	var tax = <?php echo $sellerAllTotalPriceYuan * $settings[0]["tax_rate"];?>;
	var amount = <?php echo $sellerAllTotalPriceYuan;?>;
	$(".order_invoice").click(function(){
		if($(this).val() == 1){
			$("#tax_view").text("¥ "+setCurrency(tax));
			$("#order_amount").text("¥ "+setCurrency(amount + tax));
		}else{
			$("#tax_view").text("¥ 0.00");
			$("#order_amount").text("¥ "+setCurrency(amount));
		}
	});	

	$(".inputBlur").focus(function(){
		if($(this).val() == $(this).attr("defaultValue")){
			$(this).val("");
			$(this).css("color","#333");
		}
	});

	$(".inputBlur").blur(function(){
		if($(this).val() == ""){
			var defaultValue = $(this).attr("defaultValue");
			$(this).val(defaultValue);
		}
	});	
	
});

</script>    
    
     <!--第二步-->
     <?php
	 	$countries = runFunc("getShippingCountries");
		//获取用户的所有地址
		$list_addresses = runFunc("getUserAddressByUserId",array($userid));
	?>
	<div class="cartTwo">
    	
            <div class="cartTwoTitle">2. Shipping Address
            	<div id="cartTwoTitleAll" style="display:none;float:right;"><span class="newAddress" id="newAddress" style="<?php if(!$list_addresses):?>display:none<?php endif;?>">Add new address</span><span class="newAddress" style="display:none;" id="addressBackEdit">Edit</span>
           	    </div>
        </div>
        <div id="cartTwoContentAll" style="display:none;">
	<?php
	// ******************Address form**************************

			$inc_tpl_file=includeFunc('shop/shipping/address_list.tpl');
			include($inc_tpl_file);
			
			$inc_tpl_file=includeFunc('shop/shipping/address_create.tpl');
			include($inc_tpl_file);				

	?>    
    	</div>

          
    </div>
	<div style="height:30px;"></div>
	<div class="cartThree">
    	<div class="cartThreeTitle"> 3. Confirm order infomation and submit</div>
        <div class="cartThreeContent" id="cartThreeContent">
        <form id="confirmCart" action="/publish/index.php" method="post">
        <input type="hidden" name="action" value="shop">
        <input type="hidden" name="method" value="submitOrder">
        <input type="hidden" name="cartIdStr" id="cartIdStr" value="<?php echo $cartIdStr;?>">
        <input type="hidden" name="cartThreeAddressId" id="cartThreeAddressId" value="<?php if($defaultAddressId){echo $defaultAddressId;}?>">    
        <input type="hidden" name="check_type" value="normal" />
        <input type="hidden" name="pending" id="pending" value="0" />
        <input type="hidden" name="isRequest" id="isRequest" value="0" />
		<table width="976px">
        	<tr class="cartTreeTh">
            	<td width="220">Shipping Address</td>
                <td width="450" align="center"></td>
                <td width="170">Payment Info</td>
                <td align="right"></td>
            </tr>
        	<tr style="font-size:12px;font-weight:normal;">
            	<td>Receiving Name</td>
                <td align="center" class="cartThreeCN"><span id="cartThreeFirstName"></span></td>
                <td>Merchandise Sub-Total: </td>
                <td align="right" class="cartThreeRmb">¥ <?php echo $sellerSubTotalPrice;?> </td>
            </tr>
         	<tr style="font-size:12px;font-weight:normal;">
            	<td>Email</td>
                <td align="center"><span id="cartThreeEmail"></span></td>
                <td>Service Fee: </td>
                <td align="right" class="cartThreeRmb">¥ <?php echo $serviceFeePrice;?></td>
            </tr>       
         	<tr style="font-size:12px;font-weight:normal;">
            	<td>Phone</td>
                <td align="center"><span id="cartThreeTelephone"></span></td>
                <td>Freight Fee: </td>
                <td align="right" class="cartThreeRmb">¥ <?php echo $sellerSubFreightPrice;?></td>
            </tr>
         	<tr style="font-size:12px;font-weight:normal;">
            	<td>Shipping Address </td>
                <td align="center"><span id="cartThreeAddress1"></span></td>
                <td class="hide">Additinal Payment:</td>
                <td align="right"></td>
            </tr>
         	<tr style="font-size:12px;font-weight:normal;">
            	<td></td>
                <td align="center"><span id="cartThreeAddress2"></span></td>
                <td class="hide">International Shipping:</td>
                <td align="right"></td>
            </tr>
         	<tr style="font-size:12px;font-weight:normal;">
            	<td></td>
                <td align="center"><span id="cartThreeCity"></span></td>
                <td class="hide"></td>
                <td align="right"></td>
            </tr>            
 			<tr id="addressCN" style="display:none;font-size:12px;font-weight:normal;">
            	<td colspan="4">
                <table>          
                    <tr>
                        <td width="220">Address in Chinese </td>
                        <td width="450" align="center" class="cartThreeCN"><span id="cartThreeCNCity"></span></td>
                        <td width="170"></td>
                        <td align="right"></td>
                    </tr> 
                    <tr>
                        <td><a href="#" class="cartThreeTaxi hide">Order a box of customized taxi card</a></td>
                        <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress1"></span></td>
                        <td></td>
                        <td align="right"></td>
                    </tr> 
                    <tr>
                        <td></td>
                        <td align="center" class="cartThreeCN"><span id="cartThreeCNAddress2"></span></td>
                        <td></td>
                        <td align="right"></td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr class="itemLineBg980" style="height:2px"><td colspan="6"></td></tr>
          	<tr class="cartThreeInvoice" >
            	<td colspan="2">Invoice &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" class="order_invoice" value="1" name="isInvoice" />&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" checked name="isInvoice" class="order_invoice" value="0" />&nbsp;&nbsp;No, thank you</td>
                <td>Estimated Tax:</td> 
                <td align="right" class="cartThreeRmb"><span id="tax_view">¥ 0.00</span></td>
            </tr>  
          	<tr class="invoiceinput hide">
            	<td colspan="2" class="cartThreeInvoiceTitle"  style="font-size:12px;font-weight:normal;font-weight:normal;"><span>Title:</span><input type="text" class="inputBlur" name="invoiceTitle" defaultValue = "Input Invoice Title (Required)" value="Input Invoice Title (Required)" /></td>
                <td></td>
                <td align="right"></td>
            </tr> 
           	<tr class="invoiceinput hide">
            	<td colspan="2" class="cartThreeInvoiceTitle"  style="font-size:12px;font-weight:normal;font-weight:normal;"><span>Tax Number: </span><input type="text" class="inputBlur" name="invoiceNum" defaultValue = "Input Tax Number (Required)" value="Input Tax Number (Required)" />
                </td>
                <td></td>
                <td align="right"></td>
            </tr> 
            <tr>
            	<td colspan="4" style="color:#adaeab;font-size:11px;">Request an invoice,you need pay 10% estimated tax .An invoice can not be cancle once you requested</td>
            </tr>
              
            <tr style="font-size:18px;border-top:2px solid #aaa;">
            	<td colspan="2"></td>
                <td>Total:</td>
                <td align="right" class="cartThreeRmb"><span id="order_amount">¥ <?php echo $sellerAllTotalPrice;?></span></td>
            </tr>
            <tr style="height:50px;border-bottom:2px solid #aaa;">
            	<td colspan="2"></td>
                <td></td>
                <td align="right" class="cartThreeRmb"></td>
            </tr>
            <tr>
            	<td colspan="4"><button class="cartThreeContinue" type="button" name="cartThreeContinue" id="cartThree_submit">Continue</button></td>
            </tr>                      
           </table>
        </form>
      </div>
    </div>

	<div style="height:80px;"></div>
	<div class="itemRequest cartRequest">
		<div class="itemRequestTop cartRequestTop">
    	<div class="questCont">
        	<h1>Questions</h1>
            <h2>When will I get my items?</h2>
        	<p>"Delivery" Time is the estimated time of your items being delivered to your shipping address. This takes into account the our processing time 
and the Taobao seller’ s delivery time. On average, domestic shipping takes around 4-7 days to arrive at your destination.
For international shipping,Usually, delivery time depends on the destination country, the speed of the courier service and customs clearance
timings. Unfortunately we cannot accept responsibility for these services and therefore cannot be liable for any delays due to them.</p>            
            <h2>Delivery time</h2>
        	<p>Monday to Sunday 8:30 am to 5:30 pm (No deliveries take place during public holidays).</p>

            <h2>How do I track my shipment?</h2>
        	<p>As each item ships from the Taobao seller, we’ll give you a tracking number and link to the courier page within your order form. Please visit the order list in your Account Home. Click the link and input the tracking number to view the status of your package on the couriers website. If you are in China, you need use google translate to change the page into English.</p>
			<p style="float:right;margin-top:50px;"><a style="color:#5e97ed" target="_blank" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=orderingWalkthrough'));?>">Ordering Walkthrough</a></p>
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
