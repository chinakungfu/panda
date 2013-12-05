<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>  
	</head>
	<script>
	function checkRadio(name)
	{
		
		var serviceName = $(':radio[name="'+name+'"]:checked').val();
		if(typeof(serviceName) == "undefined")
		{
			alert("Please select the order address and try");
			return false;
		}
	}
	</script>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="content">
                <div class="shipping02">
                    <h2>SHIPPING[$IN.orderID]</h2>
                    <p>You are choosing<span>WOW Collect &amp; go</span></p>
                    <p>You pick up the goods at WOW ship to point.</p>
                </div>
                <form action="/publish/index.php" method="post"  onsubmit="return checkRadio('para[orderAddress]')">
		<input type="hidden" name="action" value="shop">
		<input type="hidden" name="method" value="updateAddress">
		<input type="hidden" name="para[orderID]" value="[$IN.orderID]">
			
			<table class="chooseTable">
			   <thead>
			       <tr>
				  <th colspan="3" class="chooseTableTitle">Choose the place near you</th>
			       </tr>
			   </thead>
			   <tbody>
			   <cms action="sql" return="addressList" query="SELECT * FROM a0222211743.cms_publish_address WHERE userId='0' and status='1' Order By addressId DESC" />
			   <pp:var name="addressStr" value="''"/>
			    <loop name="addressList.data" var="var" key="key">
				<pp:if expr="$var.address1">
					<pp:var name="addressStr" value="$var.address1"/>
				</pp:if>				
				<pp:if expr="$var.address2">
					<pp:if expr="$addressStr">
						<pp:var name="addressStr" value="$addressStr . ',' . $var.address2"/>					
					<pp:else/>
						<pp:var name="addressStr" value="$var.address2"/>
					</pp:if>
				</pp:if>
				
				<pp:if expr="$var.city">
					<pp:var name="addressStr" value="$addressStr . ',' . $var.city"/>
				</pp:if>
				<pp:if expr="$var.province">
					<pp:var name="addressStr" value="$addressStr . ',' . $var.province"/>
				</pp:if>
				<pp:if expr="$var.country">
					<pp:var name="addressStr" value="$addressStr . ',' . $var.country"/>
				</pp:if>
				<pp:if expr="$var.zipcode">
					<pp:var name="addressStr" value="$addressStr . '&nbsp; ' . $var.zipcode"/>
				</pp:if>

				
			       <tr>
				  <td width="339" class="shippingTableAdd">[$addressStr]<br /><pp:if expr="$var.telephone">Tel:[$var.telephone]<br /></pp:if><pp:if expr="$var.cellphone">Cellphone:[$var.cellphone]</pp:if></td>
				  <td width="40" class="map">MAP</td>
				  <td align="center"><input type="radio" name="para[orderAddress]" value='[$var.addressId]'/></td>
			       </tr>			      
			   </loop>
			   </tbody>
			   <tfoot>
			       <tr>
				   <td colspan="3" class="weWil">we will open more office soon</td>
			       </tr>
			       <tr class="chooseTableTfoot">
				   <td colspan="3" class="chooseTableBtn"><input type="submit" value="BACK" class="contInueChose mr12 fl"/><input type="submit" value="CONTINUE" class="contInueChose fl"/></td>
			       </tr>
			   </tfoot>
			</table>
			</form>
		</form>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>