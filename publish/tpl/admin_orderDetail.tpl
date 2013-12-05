<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<pp:var name="orderNodeId" value="@getGlobalModelVar('orderNode')"/>
<pp:var name="orderNode" value="@getNodeInfoById($orderNodeId)"/>
<cms action="content" return="orderDetail" nodeid="{$orderNode.0.nodeGuid}" contentid="{$IN.orderID}"/>
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>   
	
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			<pp:if expr="$userInfo.0.groupName!='administrator'">
				<script>location.href='index.php[@encrypt_url('action=website&method=login')]'</script>	
			</pp:if>
			<!--content info-->
    			<div class="contentCentSubmit">
    			    <div class="subMitBelow">
    			        <h2>Order Information
    			            <span>Orderlist<em>No:[$orderDetail.OrderNo]</em></span>
    			        </h2>
    			    </div>
			 
    			    
			
			<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid  and a.cartID in ({$orderDetail.cartIDstr}) Order By a.cartid DESC" />
			

			<pp:var name="goodsNum" value="sizeof($orderList.data)"/>				
    			    
			
			    

			<pp:var name="SubTotalPrice" value="0"/>
			<pp:if expr="$orderDetail.serviceName=='1'">
				<pp:var name="serviceStr" value="'WOW Express'"/>
			<pp:elseif expr="$orderDetail.serviceName=='2'">
				<pp:var name="serviceStr" value="'WOW Collect&go'"/>
			<pp:elseif expr="$orderDetail.serviceName=='3'">
				<pp:var name="serviceStr" value="'WOW Premium Service'"/>
			</pp:if>
			    <div class="pageContentSubmit fl">
        			    <h2><span>You are choosing <em>[$serviceStr]</em></span></h2>
        			    <h3>[$goodsNum] <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> </h3>
        			    <table>
        			        <thead>
        			            <tr>
        			             <td>[$goodsNum] <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> in your bag</td><td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;UNIT&nbsp;PRICE</td><td style="text-align:center" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
        			            </tr>
        			        </thead>
        			        <tbody>
					<loop name="orderList.data" var="var" key="key">
            			        <tr>
                                    <td class="bagItem">
                                        <dl>
                                            <dt>
					    <pp:if expr="$var.goodsType=='inside'">
						    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" />
						<pp:elseif expr="$var.goodsType=='outside'">
						    <img src="[$var.goodsImgURL]" alt="bagImg" />
						</pp:if>
						</dt>
                                            <dd><strong>[$var.goodsTitleCN]<br />[$var.goodsTitleEn] </strong></dd>
                                            <pp:if expr="$var.goodsType=='inside'">
						<dd><a href="/publish/index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $var.goodsid )]" target=_blank>Taobao Link</a></dd>
					    <pp:elseif expr="$var.goodsType=='outside'">
						<dd><a href="[$var.goodsURL]" target=_blank>Taobao Link</a></dd>
					    </pp:if>
					    <!--
                                            <dd>Size: 33A<span class="pageContentColor">Color:<em class="colorSize"></em></span></dd>
					    
                                            <dd class="wowService">WOW FINDING SERVICE</dd>-->
                                        </dl>
                                    </td>
				    <form action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<input type="hidden" name="method" value="updateOrder">	
					<input type="hidden" name="cartID" value="[$var.cartID]">
					<input type="hidden" name="orderID" value="[$IN.orderID]">
					<input type="hidden" name="goodsid" value="[$var.goodsid]">

					    <td><input type="text"  name="para[ItemQTY]" value="[$var.ItemQTY]" class="numtextBag"></td>
					    <pp:var name="subItemPrice" value="number_format($var.itemPrice, 2, '.', ',')"/>
					    <td align="center"><input name="para[goodsUnitPrice]" type="text" class="text3" value="[$subItemPrice]"/></td>

					    <td align="center"><pp:if expr="$var.itemFreight<=0"><input name="para[Freight]" type="text" class="text3" value="[$Freight]"/><pp:else/><pp:var name="Freight" value="number_format($var.itemFreight, 2, '.', ',')"/><input  name="para[Freight]" type="text" class="text3" value="[$Freight]"/></pp:if></td>
					    <td class="bagEdit">
						
						<dl>
						    <!--<dd><a href="index.php[@encrypt_url('action=shop&method=editOrderDetail&goodsID=' . $var.ItemGoodsID . '&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Edit Item</a></dd>
						    <dd>
						    <pp:if expr="$goodsNum>'1'">
						    <a href="index.php[@encrypt_url('action=shop&method=delOrderDetail&cartID=' . $var.cartID . '&orderID=' . $IN.orderID . '&cartIDString=' . $orderDetail.cartIDstr)]">Delete</a>
						    <pp:elseif expr="$goodsNum=='1'">
						     <a href="index.php[@encrypt_url('action=shop&method=cancelOrderDetail&cancelType=del&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Delete</a>
						    </pp:if>
						    </dd>
						    -->
						    <dd>
							<input type="submit" value="Update"/>						

								
							
						</dd>				
						</dl>
						
					    </td>
				    </form>
                                </tr>
				<pp:var name="SubTotalPrice" value="$SubTotalPrice+$var.ItemQTY*$var.itemPrice+$var.itemFreight"/>
                                </loop>
                                <pp:var name="tempSubTotalPrice" value="$SubTotalPrice"/>
                                <pp:var name="SubTotalPriceF" value="number_format($SubTotalPrice, 2, '.', ',')"/>
                                
                                <tr>
                                   
				    <td >
                                       Notes:&nbsp;&nbsp;[$var.itemNotes]
						
					    </td>
				    
                                </tr>
                            </tbody>
        			    </table>
    			    </div>
    			    
    			    <div class="subMitRight fr">
			    <pp:var name="AddressNodeId" value="@getGlobalModelVar('AddressNode')"/>
			<pp:var name="AddressNode" value="@getNodeInfoById($AddressNodeId)"/>
			<cms action="content" return="addressDetail" nodeid="{$AddressNode.0.nodeGuid}" contentid="{$orderDetail.orderAddress}"/>
                        <table class="subMitNameInfo">
                            <tr>
                                <td width="55">Name:</td><td>[$addressDetail.fullName]</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">Address:</td><td style="padding-bottom:5px; vertical-align:top">[$addressDetail.address1] <br>
                                    [$addressDetail.address2]<br />
                                    [$addressDetail.city], [$addressDetail.province]&nbsp;&nbsp;[$addressDetail.zipcode]<br>
                                    [$addressDetail.country]<br />
                                    Phone: [$addressDetail.cellphone]
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:45px;">Email: </td><td valign="top">[$addressDetail.email]</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  style="padding-bottom:45px;" width="133">Subtotal ([$goodsNum] items ):</td><td  valign="top" width="133" align="right">￥<span id="subTotalPrice1">[$SubTotalPriceF]</span></td>
                            </tr>
                        </table>
                        <!--
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  width="133">WOW Delivery </td><td  width="133" align="right">￥<span id="wowDelivery">50.00</span></td>
                            </tr>
                            <tr>
                                <td  style="padding-bottom:36px;">WOW D2D Service :</td><td  width="133" align="right" valign="top">￥<span id="wowDelivery">50.00</span></td>
                            </tr>
                        </table>
			-->
                        
                        <table class="subMitNameSubTotal">
			<pp:var name="serviceFee" value="number_format($SubTotalPrice*0.1, 2, '.', ',')"/>
                            <tr>
                                <td  width="133">Service Fee:</td><td  width="133" align="right">￥<span id="serviceFree">[$serviceFee]</span></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:23px;" colspan="2"  class="subMitNameInfoText"><!--WOW D2D Service :--></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom:12px;" class="subMitNameInfoText"><!--GIFT CODE : 6855844987--></td>
                            </tr>
                        </table>
                        <pp:var name="totalCharge" value="number_format($SubTotalPrice+$serviceFee, 2, '.', ',')"/>
                        <table class="subMitNameSubTotal" style="border-bottom:0 none">
                            <tr>
                                <td  width="133"  style="padding-bottom:23px;">TOTAL</td><td  width="133" align="right" valign="top">￥<span id="totalPrice">[$totalCharge]</span></td>
                            </tr>
                        </table>
			   
                        <div style="height:23px;">
                            <!--<input type="button" value="BACK" class="contInueChose" />-->
			     
			     <form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="admin">
				<input type="hidden" name="method" value="confirmOrder">
				<input type="hidden" name="orderID" value="[$IN.orderID]">
			     <input type="submit" value="Confirm and Mail" class="contInueChose fr" style="margin-top: -10px; margin-right: 12px;"/>
			     </form>
			      
                        </div>
			  </form>
                    </div>
		  
                    
			 </div>
			
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>	
	<script>location.href='index.php[@encrypt_url('action=website&method=login&backaction=website&backmethod=login&paraStr=' . $paraStr )]'</script>
</pp:if>