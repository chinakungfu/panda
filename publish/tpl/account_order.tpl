<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name">
<!DOCTYPE HTML>
<html>
<head>
	<pp:include file="common/header/common_header.tpl" type="tpl"/>
</head>
<body onload="window.location.hash = 'here'">
	<!--最外框-->
	<div class="box">
		<!--头部-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>

		<!--content info-->
		<div class="content">
			
				<pp:include file="common/account_body.tpl" type="tpl"/>
			
			<div class="orderlistPay">
			<a name="here"></a>
				<h2 style="color:#700000">YOUR ORDER HISTORY</h2>
				<table>
					<tr>
						<th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
					</tr>
					
					<loop name="orderList.data" var="var" key="key">
						<tr>
							<pp:var name="orderDate" value="date('Y-m-d H:i:s',$var.orderTime)"/>
							<pp:var name="orderStatus" value="@getOrderStatus($var.orderStatus)"/>
							<td>No:[$var.OrderNo]</td><td align="center">[$orderDate]</td><td align="center">[$orderStatus]</td>
							<td class="orderlistPayBtn"><a href="index.php[@encrypt_url('action=shop&method=orderDetail&orderID=' . $var.orderID)]">View details</a><br />
							<pp:if expr="$var.orderStatus=='4'">
								<a href="/publish/index.php[@encrypt_url('action=shop&method=payment&orderID=' . $var.orderID)]" class="orderlistPayBtnLink">Pay</a>
							</pp:if></td> 
						</tr>
					</loop>
				</table>

			</div>
		</div>
		<!--foot-->
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
	</div>
</body>
</html>
<pp:else/>
<pp:include file="common/account_passPara.tpl" type="tpl"/>
</pp:if>