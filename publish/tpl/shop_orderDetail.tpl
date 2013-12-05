<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<cms action="sql" return="orderInfo" query="SELECT * FROM cms_publish_order WHERE  orderID='{$IN.orderID}' limit 1" />
<pp:var name="orderDetail" value="$orderInfo.data.0"/>
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>   
		<!--
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
		totalPriceObj.innerHTML = setCurrency(parseInt(responseArr[1])+parseInt(wowDeliveryObj.innerHTML)+parseInt(serviceFreeObj.innerHTML));
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
	-->
	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
    			<div class="contentCentSubmit">
    			    <div class="subMitBelow">
    			        <h2>Your Order
    			            <span>Orderlist<em>No:[$orderDetail.OrderNo]</em></span>
    			        </h2>
    			    </div>
			 
    			    
			    <!--<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.cartID in ({$orderDetail.cartIDstr}) Order By a.cartid DESC" />-->
			
			<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.cartID in ({$orderDetail.cartIDstr}) Order By a.cartid DESC" />		
			

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
        			             <td>[$goodsNum] <pp:if expr="$goodsNum==1">item <pp:elseif expr="$goodsNum>1"> items </pp:if> in your bag</td><td width="75px" align="center">QTY</td><td width="75px"  style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRICE</td><td style="text-align:center" width="75px">FREIGHT</td><td width="100px">&nbsp;</td>
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
                                    <td><input type="text" disabled value="[$var.ItemQTY]" class="numtextBag"></td>
				    <pp:var name="subItemPrice" value="number_format($var.itemPrice, 2, '.', ',')"/>
                                    <td align="center">￥ [$subItemPrice]</td>

                                    <td align="center"><pp:if expr="$var.itemFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.itemFreight, 2, '.', ',')"/>[$Freight]</pp:if></td>
                                    <td class="bagEdit">
                                        <!--
					<dl>
                                            <dd><a href="index.php[@encrypt_url('action=shop&method=editOrderDetail&goodsID=' . $var.ItemGoodsID . '&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Edit Item</a></dd>
                                            <dd>
					    <pp:if expr="$goodsNum>'1'">
					    <a href="index.php[@encrypt_url('action=shop&method=delOrderDetail&cartID=' . $var.cartID . '&orderID=' . $IN.orderID . '&cartIDString=' . $orderDetail.cartIDstr)]">Delete</a>
					    <pp:elseif expr="$goodsNum=='1'">
					     <a href="index.php[@encrypt_url('action=shop&method=cancelOrderDetail&cancelType=del&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Delete</a>
					    </pp:if>
					    </dd>
                                            <dd>
					    <pp:if expr="$goodsNum>'1'">
					    <a href="index.php[@encrypt_url('action=shop&method=OrderDetailToWish&cartID=' . $var.cartID . '&orderID=' . $IN.orderID . '&cartIDString=' . $orderDetail.cartIDstr)]">Move to Wish</a>
					    <pp:elseif expr="$goodsNum=='1'">
					     <a href="index.php[@encrypt_url('action=shop&method=cancelOrderDetail&cancelType=move&cartID=' . $var.cartID . '&orderID=' . $IN.orderID)]">Move to Wish</a>
					    </pp:if>				
                                        </dl>
					-->
                                    </td>
                                </tr>
				<pp:var name="SubTotalPrice" value="$SubTotalPrice+$var.ItemQTY*$var.itemPrice+$var.itemFreight"/>
                                </loop>
                                <pp:var name="tempSubTotalPrice" value="$SubTotalPrice"/>
                                <pp:var name="SubTotalPriceF" value="number_format($SubTotalPrice, 2, '.', ',')"/>
                                
                                
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
			     <pp:if expr="$orderDetail.orderStatus=='4'">
			     <form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="shop">
				<input type="hidden" name="method" value="payment">
				<input type="hidden" name="orderID" value="[$IN.orderID]">
			     <input type="submit" value="PAY" class="contInueChose fr" style="margin-top: -10px; margin-right: 12px;"/>
			     </form>
			      <pp:elseif expr="$orderDetail.orderStatus=='3'">
				<span>You will pay this order after confirming.</span>
				 </pp:if>
                        </div>
			  
                    </div>
		  
                    
			 </div>
			 <div class="orderlistPay">
                <h2>YOUR ORDER HISTORY<span><!--View All / 5 item page--></span></h2>
		
		<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_order WHERE orderUser ={$name} AND orderStatus >=3 and orderID!='{$IN.orderID}' ORDER BY orderTime DESC" />
                   <table>
                      <tr>
                         <th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
                      </tr>
		      <loop name="orderList.data" var="var" key="key">
                      <tr>
		      <pp:var name="orderDate" value="date('Y-m-d H:i:s',$var.orderTime)"/>
			      <pp:var name="orderStatus" value="@getOrderStatus($var.orderStatus)"/>
                         <td>No:[$var.OrderNo]</td><td align="center">[$orderDate]</td><td align="center">[$orderStatus]</td><td class="orderlistPayBtn"><a href="index.php[@encrypt_url('action=shop&method=orderDetail&orderID=' . $var.orderID)]">View details</a><br />			 
			 <pp:if expr="$var.orderStatus=='4'"><a href="/publish/index.php[@encrypt_url('action=shop&method=payment&orderID=' . $var.orderID)]" class="orderlistPayBtnLink">Pay</a>
				
				 </pp:if>
				 </td>
                      </tr>
                      </loop>
                   </table>
              </div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>
<pp:else/>	
	<script>location.href='index.php[@encrypt_url('action=website&method=login&backaction=website&backmethod=login&paraStr=' . $paraStr )]'</script>
</pp:if>