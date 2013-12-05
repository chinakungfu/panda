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
			
			<!--content info-->
			<pp:var name="orderNodeId" value="@getGlobalModelVar('orderNode')"/>
			<pp:var name="orderNode" value="@getNodeInfoById($orderNodeId)"/>
			<cms action="content" return="orderDetail" nodeid="{$orderNode.0.nodeGuid}" contentid="{$IN.orderID}"/>

			<cms action="sql" return="orderList" query="SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.cartID in ({$orderDetail.cartIDstr}) Order By a.cartid DESC" />
					<pp:var name="goodsNum" value="sizeof($orderList.data)"/>
			<pp:if expr="$goodsListNum==''">
					<pp:var name="goodsListNum" value="5"/>
			</pp:if>
			<pp:var name="SubTotalPrice" value="0"/>
			<pp:if expr="$orderDetail.serviceName=='1'">
				<pp:var name="serviceStr" value="'WOW Express'"/>
			<pp:elseif expr="$orderDetail.serviceName=='2'">
				<pp:var name="serviceStr" value="'WOW Collect&go'"/>
			<pp:elseif expr="$orderDetail.serviceName=='3'">
				<pp:var name="serviceStr" value="'WOW Premium Service'"/>
			</pp:if>

    			<div class="contentCentSubmit" style="margin-bottom:49px; padding-right:5px">
    			    
    			    <div class="subMitBelow">
    			        <h2>PAYMENT
    			            <span>Orderlist<em>No:201202121001</em></span>
    			        </h2>
    			    </div>
    			    
    			    <!-- pageContentSubmit -->
    			    <div class="pageContentSubmit fl" style="border-right:0 none">
    			        <div style="border-right:1px solid #454544; padding-right:5px">
        			    <h2 align="center">You are choosing<em style="color:#B6D97E; font-size:12px; font-weight:bold">[$serviceStr]</em></h2>
        			    <div class="orderPay" id="orderPay">
        			        <table>
        			            <tr>
        			                <td colspan="2"><label>CARD TYPE *</label>
        			                    <select class="cardText">
        			                        <option value="choose">choose</option>
        			                    </select>
        			                </td>
        			            </tr>
        			            <tr>
                                    <td><label>CARD NUMBER *</label><input type="text" class="cardText"/></td>
                                    <td><label>SECURITY CODE *</label><span style="background-color:#FFFF9F; padding:2px 20px; margin-top:5px"><img src="" /></span>?</td>
                                </tr>
                                <tr>
                                    <td><label style="margin-top:0">EXPIRATION<br />MONTH*</label><input type="text" class="cardTexts"/></td>
                                    <td><label style="margin-left:-151px">YEAR *</label><input type="text" class="cardTexts" style="margin-left:-113px"/></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-left:106px; padding-top:11px; padding-bottom:112px;">
                                        <img src="../skin/images/mcard1.png" alt="mcard1" />
                                        <img src="../skin/images/mcard2.png" alt="mcard2" />
                                        <img src="../skin/images/mcard3.png" alt="mcard3" />
                                        <img src="../skin/images/mcard4.png" alt="mcard4" />
                                        <img src="../skin/images/mcard5.jpg" alt="mcard5" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span class="orderPayPay">
                                            Submitting your order begins payment authorization
                                            <input type="button" value="PAY" class="contInueChose" style="margin-left:120px">
                                        </span>
                                    </td>
                                </tr>
        			        </table>
        			    </div>
        			    </div>
				    

        			    <div class="pageContent">
	        			    <h3><a href="#">View all</a> / <pp:if expr="$goodsNum>=$goodsListNum">[$goodsListNum]<pp:else/>[$goodsNum]</pp:if>  item page</h3>
	        			    <table>
	        			        <thead>
	        			            <tr>
	        			             <td width="264px"><pp:if expr="$goodsNum>=$goodsListNum">[$goodsListNum]<pp:else/>[$goodsNum]</pp:if>  item in your bag</td><td width="50px">QTY</td><td width="91px" style="text-indent:30px; text-align:center">PRICE</td><td style="text-align:right">FREIGHT</td><td>&nbsp;</td>
	        			            </tr>
	        			        </thead>
	        			        <tbody>

						<loop name="orderList.data" var="var" key="key">
				
	            			        <tr>
	                                    <td class="bagItem">
	                                        <dl>
	                                            <dt><img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="bagImg" /></dt>
	                                            <dd><strong>[$var.goodsTitleCN]<br />[$var.goodsTitleEn]</strong></dd>
	                                            <dd>Item: BGS12_T4CTF</dd>
	                                            <dd>Size: 33A<span class="pageContentColor">Color:<em class="colorSize"></em></span></dd>
	                                            <dd class="wowService">WOW FINDING SERVICE</dd>
	                                        </dl>
	                                    </td>
					    <pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
	                                    <td><input type="text" value="1" class="numtextBag"></td>
	                                    <td class="yuanRmb">￥ [$SinglePrice]</td>
	                                    <td class="yuanRmb"><pp:if expr="$var.goodsFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.goodsFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
	                                    <td class="bagEdit">
	                                        
	                                    </td>
	                                </tr>
	                                
	                                </loop>
	                                
	                                
	                               
	                                
	                            </tbody>
	                            
	                            <tfoot>
	                                <tr>
	                                   <td colspan="2" align="right" style="font-weight:bold">Subtotal (5 items ):</td><td align="center">￥5,012.00</td><td colspan="2" style="font-size:9px; font-weight:bold; text-align:center">( service fee are not included here )</td> 
	                                </tr>
	                            </tfoot>
	        			    </table>
        			    </div>
    			    </div>
    			    
    			    <div class="subMitRight fr">
                        <table class="subMitNameInfo">
                            <tr>
                                <td width="55">Name:</td><td>HAPPY</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">Address:</td><td style="padding-bottom:5px; vertical-align:top">Xingming St <br />
                                    dushi huayuan<br />
                                    suzhou, jiangsu 215010<br />
                                    China<br />
                                    Phone: 18962177512
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:45px;">Email: </td><td valign="top">ivisionservice@gmail.com</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  style="padding-bottom:45px;" width="133">Subtotal (5 items ):</td><td  valign="top" width="133" align="right">￥5,012.00</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  width="133">WOW Delivery </td><td  width="133" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                                <td  style="padding-bottom:36px;">WOW D2D Service :</td><td  width="133" align="right" valign="top">￥50.00</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  width="133">Service Fee:</td><td  width="133" align="right">￥500.00</td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:23px;" colspan="2"  class="subMitNameInfoText">WOW D2D Service :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom:12px;" class="subMitNameInfoText">GIFT CODE : 6855844987</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal" style="border-bottom:0 none">
                            <tr>
                                <td  width="133"  style="padding-bottom:23px;">TOTAL</td><td  width="133" align="right" valign="top">￥5,562.00</td>
                            </tr>
                        </table>
                        <div style="margin-bottom:8px;">
                            <input type="button" value="BACK" class="contInueChose" style="margin-left:73px; margin-right:6px;"/><input type="button" value="SUBMIT" class="contInueChose"/>
                        </div>
                    </div>
                    
			 </div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>