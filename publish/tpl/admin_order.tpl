<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<!--<script type="text/javascript">
		function checkSubmit()
		{
			if(!$("#passwordEmail").val())
			{
				$("#requestpasswordH3Info").html("E-mail Address can not be empty");
				$("#requestpasswordH3Info").css("display","");
				return false;
			}else
			{
				reg = new RegExp('^[a-zA-Z0-9]+.[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-z][a-z.]{1,8}$');
				if(reg.test($("#passwordEmail").val()))
				{
					$("#requestpasswordH3Info").css("display","none");
					return true;
				}else
				{
					$("#requestpasswordH3Info").html("E-mail Address format is not correct");
					$("#requestpasswordH3Info").css("display","");
					return false;
				}
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
			<pp:if expr="$userInfo.0.groupName!='administrator'">
				<script>location.href='index.php[@encrypt_url('action=website&method=login')]'</script>	
			</pp:if>
			
			<!--content info-->
			<div class="content">
			
			<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_order WHERE orderStatus ='3' ORDER BY orderTime DESC" />
			
			<div class="orderlistPay">			
				
				<table>
					<tr>
						<th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
					</tr>
					
					<loop name="orderList.data" var="var" key="key">
						<tr>
							<pp:var name="orderDate" value="date('Y-m-d H:i:s',$var.orderTime)"/>
							<pp:var name="orderStatus" value="@getOrderStatus($var.orderStatus)"/>
							<td>No:[$var.OrderNo]</td><td align="center">[$orderDate]</td><td align="center">[$orderStatus]</td>
							<td class="orderlistPayBtn"><a href="index.php[@encrypt_url('action=admin&method=orderDetail&orderID=' . $var.orderID)]">View details</a><br />
							
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