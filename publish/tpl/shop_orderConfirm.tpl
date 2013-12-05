<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>    
	<script type="text/javascript">
	function changeItemQTY(value,cartId,userId,cartType,cartIdStr)
	{
		call_tpl('shop','changeItemQTY','backDataItemQTY()','return',cartId,value,userId,cartType,cartIdStr,'');
	}
	function backDataItemQTY(response)
	{
		var responseArr = response.split("-");
		var subTotalPriceObj = document.getElementById("subTotalPrice");
		var subTotalPrice1Obj = document.getElementById("subTotalPrice1");
		var totalItemsObj = document.getElementById("totalItems");

		var wowDeliveryObj = document.getElementById("wowDelivery");
		var serviceFreeObj = document.getElementById("serviceFree");
		var totalPriceObj = document.getElementById("totalPrice");

		//totalItemsObj.innerHTML =responseArr[0];
		subTotalPriceObj.innerHTML = setCurrency(responseArr[1]);
		subTotalPrice1Obj.innerHTML = setCurrency(responseArr[1]);
		var serviceFree = parseInt(responseArr[1])*0.1;
		if(serviceFree<20)
		{
			serviceFree = 20;
		}
		serviceFreeObj.innerHTML = setCurrency(serviceFree);
		if(wowDeliveryObj==null)
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(serviceFree));
		}else
		{
			totalPriceObj.innerHTML = setCurrency(parseFloat(responseArr[1])+parseFloat(wowDeliveryObj.innerHTML)+parseFloat(serviceFree));
		}
	}
	//四舍五入保留两位小数
	function changeTwoDecimal(x)
	{
		var f_x = parseFloat(x);
		if (isNaN(f_x))
		{
			alert('function:changeTwoDecimal->parameter error');
			return false;
		}
		var f_x = Math.round(x*100)/100;
		return f_x;
	}
	function setCurrency(s){
		s = String(s);
		if(s.indexOf('-')==0){
			//计算负数
			s= s.substring(1,s.lenght);
			alert("ddddd"+s);
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return '-'+s.replace(/^\./,"0.")
		}else{
			//计算正数
			if(/[^0-9\.\-]/.test(s)) return "invalid value";
			s=s.replace(/^(\d*)$/,"$1.");

			s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");//取小数点后两位
			s=s.replace(".",",");
			var re=/(\d)(\d{3},)/;
			while(re.test(s))
			s=s.replace(re,"$1,$2");
			s=s.replace(/,(\d\d)$/,".$1");//取小数点后两位

			return s.replace(/^\./,"0.")
		}
	}
	</script>
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<!--<pp:var name="orderNodeId" value="@getGlobalModelVar('orderNode')"/>
			<pp:var name="orderNode" value="@getNodeInfoById($orderNodeId)"/>
			<cms action="content" return="orderDetail" nodeid="{$orderNode.0.nodeGuid}" contentid="{$IN.orderID}"/>-->
			<cms action="sql" return="orderInfo" query="SELECT * FROM cms_publish_order WHERE  orderID='{$IN.orderID}' limit 1" />
			<pp:var name="orderDetail" value="$orderInfo.data.0"/>
			 <pp:if expr="$orderDetail=='-1'">

			 </pp:if>
    			<div class="contentCentSubmit">
    			    <div class="subMitBelow">
    			        <h2>Please confirm the order list below:
    			            <span>Orderlist<em>No:[$orderDetail.OrderNo]</em></span>
    			        </h2>
    			    </div>
					<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.cartID in ({$orderDetail.cartIDstr}) Order By a.cartid DESC" />
					<pp:var name="goodsNum" value="sizeof($orderList.data)"/>
					
    			    <div class="pageContentSubmit fl">
			<!--<pp:if expr="$IN.goodsListNum==''">
				<pp:var name="goodsListNum" value="5"/>
			<pp:else/>
				<pp:var name="goodsListNum" value="$IN.goodsListNum"/>
			</pp:if>-->

			<pp:var name="SubTotalPrice" value="0"/>
			<pp:if expr="$orderDetail.serviceName=='1'">
				<pp:var name="serviceStr" value="'WOW Express'"/>
			<pp:elseif expr="$orderDetail.serviceName=='2'">
				<pp:var name="serviceStr" value="'WOW Collect&go'"/>
			<pp:elseif expr="$orderDetail.serviceName=='3'">
				<pp:var name="serviceStr" value="'WOW Premium Service'"/>
			</pp:if>
        			    <h2>YOUR SHOPPING BAG<span>You are choosing <em>[$serviceStr]</em></span></h2>
        			    <h3><!--<a href="index.php[@encrypt_url('action=shop&method=orderConfirm&goodsListNum=' . $goodsNum . '&orderID=' . $IN.orderID)]">View all</a> / <pp:if expr="$goodsNum>=$goodsListNum">[$goodsListNum]<pp:else/>[$goodsNum]</pp:if> -->[$goodsNum] <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> </h3>
        			    <table>
        			        <thead>
        			            <tr>
        			             <td> [$goodsNum] <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> in your bag</td><td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRICE</td><td style="text-align:center" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
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
                                            <pp:if expr="$var.goodsTitleCN">
					<dd><strong>[$var.goodsTitleCN]</strong></dd>
					</pp:if>
					<pp:if expr="$var.goodsTitleEn">
					<dd><strong>[$var.goodsTitleEn]</strong></dd>
					</pp:if>
					<!--
                                            <dd>Item:  [$goodsListNum]</dd>-->
                                            <dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if>
					    <pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
					    <pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd></pp:if>
					    

                                        </dl>
                                    </td>
                                    <td><input type="text" value="[$var.ItemQTY]" class="numtextBag" id="itemQTY[$key]" onblur="changeItemQTY(this.value,'[$var.cartID]','[$tmpUser]','Order','[$orderDetail.cartIDstr]');"></td>
				   <pp:var name="subItemPrice" value="number_format($var.itemPrice, 2, '.', ',')"/>
                                    <td align="center">￥ [$subItemPrice]</td>
                                    <td align="center"><pp:if expr="$var.itemFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.itemFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
                                    <td class="bagEdit">
                                        <dl>
                                            <dd><a href="index.php[@encrypt_url('action=shop&method=editOrderItem&goodsID=' . $var.ItemGoodsID . '&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Edit Item</a></dd>
                                            <dd>
					    <pp:if expr="$goodsNum>'1'">
					    <a href="index.php[@encrypt_url('action=shop&method=delOrder&cartID=' . $var.cartID . '&orderID=' . $IN.orderID . '&cartIDString=' . $orderDetail.cartIDstr)]">Delete</a>
					    <pp:elseif expr="$goodsNum=='1'">
					     <a href="index.php[@encrypt_url('action=shop&method=cancelOrder&cancelType=del&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Delete</a>
					    </pp:if>
					    </dd>
                                            <dd>
					    <pp:if expr="$goodsNum>'1'">
					    <a href="index.php[@encrypt_url('action=shop&method=OrderToWish&cartID=' . $var.cartID . '&orderID=' . $IN.orderID . '&cartIDString=' . $orderDetail.cartIDstr)]">Move to Wish</a>
					    <pp:elseif expr="$goodsNum=='1'">
					     <a href="index.php[@encrypt_url('action=shop&method=cancelOrder&cancelType=move&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Move to Wish</a>
					    </pp:if>					    
                                        </dl>
                                    </td>
                                </tr>
				
                                <pp:var name="SubTotalPrice" value="$SubTotalPrice+$var.ItemQTY*$var.itemPrice+$var.itemFreight"/>
				
				
                                </loop>
                                <pp:var name="tempSubTotalPrice" value="$SubTotalPrice"/>
                                <pp:var name="SubTotalPriceF" value="number_format($SubTotalPrice, 2, '.', ',')"/>
                            </tbody>
                            
                            <tfoot>
                                <tr>
                                   <td colspan="2" align="right" style="font-weight:bold">Subtotal (<span id="totalItems">[$goodsNum]</span> <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> ):</td><td align="center">￥<span id="subTotalPrice">[$SubTotalPriceF]</span></td><td colspan="2" style="font-size:9px; font-weight:bold; text-align:center">( service fee are not included here )</td> 
                                </tr>
                            </tfoot>
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
                                <td style="padding-bottom:45px;">Email: </td>
				<td valign="top">
				<pp:if expr="$name">
					[$userInfo.0.staffNo]
				<pp:else/>
					[$addressDetail.email]
				</if>
				
				</td>
                            </tr>
                        </table>
                        
                        <table class="subMitNameSubTotal">
                            <tr>
                                <td  style="padding-bottom:45px;" width="133">Subtotal ([$goodsNum]  <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> ):</td><td  valign="top" width="133" align="right">￥<span id="subTotalPrice1">[$SubTotalPriceF]</span></td>
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
			
			<pp:if expr="$SubTotalPrice*0.1<20">
				<pp:var name="serviceFee" value="20"/>
			<pp:else/>
				<pp:var name="serviceFee" value="$SubTotalPrice*0.1"/>
			</pp:if>
			<pp:var name="serviceFee" value="number_format($serviceFee, 2, '.', ',')"/>
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
                        
			<pp:var name="totalCharge" value="1111111"/>
                        
                        <table class="subMitNameSubTotal" style="border-bottom:0 none">
                            <tr>
                                <td  width="133"  style="padding-bottom:23px;">TOTAL</td><td  width="133" align="right" valign="top">￥<span id="totalPrice">[$totalCharge]</span></td>
                            </tr>
                        </table>
			<form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="shop">
				<input type="hidden" name="method" value="submitOrder">
				<input type="hidden" name="orderID" value="[$IN.orderID]">
                        <div style="height:22px">
                            <!--<input type="button" value="BACK" class="contInueChose" style="margin-left:73px; margin-right:6px;"/>--><input type="submit" value="SUBMIT" class="contInueChose fr" style="margin-top: -10px; margin-right: 12px;"/>
                        </div>
			</form>
                    </div>
		    
                    
                    <div class="subMitNote clb">
                        <dl>
                            <!--<dt class="fl">NOTE: <dt>
                            <dd>1.One seller only charge freight once per order usually, sometimes customer service will contact you when freight needs to be modified according to some special 
                                issues like package overweight etc.</dd>
                             <dd>2.D2D delivery charge: starting fee 20CNY, packages heavier than 10kg/bigger than 53*29*37 cm/2*1*1.5 feet shall be calculated according to the circumstance. </dd>
                             <dd class="subMitNoteSpan"><a href="index.php[@encrypt_url('action=help&method=main')]">More Q &amp; A</a></dd> -->
                        </dl>
                    </div>
		   
			 </div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
<script type="text/javascript">
var subTotalPrice = '[$tempSubTotalPrice]';
var wowDeliveryObj = document.getElementById("wowDelivery");
var serviceFreeObj = document.getElementById("serviceFree");
var totalPriceObj = document.getElementById("totalPrice");
var totlaPrice = 0.00;
if(wowDeliveryObj==null)
{
	totlaPrice= parseFloat(subTotalPrice)+parseFloat(serviceFreeObj.innerHTML);
}else
{
	totlaPrice= parseFloat(subTotalPrice)+parseFloat(wowDeliveryObj.innerHTML)+parseFloat(serviceFreeObj.innerHTML);
}
totalPriceObj.innerHTML = setCurrency(totlaPrice);
</script>
</html>