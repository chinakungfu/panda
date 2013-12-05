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
			alert("Please select a service and try again.");
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
                <div class="shippingHead">
                    <h2>SHIPPING[$IN.orderID]<span>Please choose a receiving way from below</span></h2>
		    <form action="/publish/index.php" method="post" onsubmit="return checkRadio('para[serviceName]')">
			<input type="hidden" name="action" value="shop">
			<input type="hidden" name="method" value="addService">
			<input type="hidden" name="para[orderID]" value="[$IN.orderID]">
			    <ul>
				<li><label>WOW Express</label><input type="radio" name="para[serviceName]" value='1'/></li>
				<li><label>WOW Collect&amp;go</label><input type="radio" name="para[serviceName]" value='2'/></li>
				<li><label>WOW Premium Service</label><input type="radio" name="para[serviceName]" value='3'/><br /></li>
			    </ul>
			    <input type="submit" value="CONTINUE" class="contInue clb"/>
		    </form>
                </div>
                
                <table class="shippingTable">
                    <thead>
                        <tr>
                            <td colspan="4">Delivery method and after sales service.</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th width="114" style="border-left:1px solid #76746F">&nbsp;</th><th width="234">WOW Express<br />Directly to your door</th><th width="267">WOW Collect&amp;go</th><th width="320" style="border-right:1px solid #76746F">WOW Premium Service<br />To your door *plus</th>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Transport</td>
                            <td class="shippingTable01">Shop seller arranges transport to your door directly. Fast service. You need to provide your address in Chinese.</td>
                            <td class="shippingTable02">Shop seller arranges transport to Wow ship to point. Wow will check the goods. You pick up the goods at WOW ship to point.</td>
                            <td class="shippingTable03">WOW arranges transport. Taobao seller will deliver to WOW ship to point. Wow will check the goods and arrange further transport to your door.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Quality Check</td>
                            <td class="shippingTable01">Quality check done by you. In case of Quality complaints, WOW can help you to negotiate with Shop Seller, but WOW will not be liable.</td>
                            <td class="shippingTable02">Quality check done by WOW. In case of Quality complaints, WOW will guarantee you a replacement or refund.</td>
                            <td class="shippingTable03">Quality check done by WOW. In case of Quality complaints, WOW will guarantee you a replacement or refund.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Guarantee</td>
                            <td class="shippingTable01">No guarantee refund by WOW. Depends on the conditions of the Shop seller.</td>
                            <td class="shippingTable02">If the goods are damaged during transport: full refund</td>
                            <td class="shippingTable03">If the goods are damaged during transport: full refund</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">After sales service</td>
                            <td class="shippingTable01">&nbsp;</td>
                            <td class="shippingTable02">WOW will take care of the problems and contact the Taobao seller. WOW guarantees you a refund or replacement without extra costs.</td>
                            <td class="shippingTable03">WOW will take care of the problems and contact the Taobao seller. WOW guarantees you a refund or replacement without extra costs.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Costs/service level</td>
                            <td class="shippingTable01" align="center">Low</td>
                            <td class="shippingTable02" align="center">Medium</td>
                            <td class="shippingTable03" align="center">High</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Handling cost</td>
                            <td class="shippingTable01">10% of the value you buy with a minimum of 10 RMB.</td>
                            <td class="shippingTable02">10% of the value you buy with a minimum of 10 RMB.</td>
                            <td class="shippingTable03">15% of the value you buy with a minimum of 30 RMB.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Transport cost</td>
                            <td class="shippingTable01" align="center">Seller Freight</td>
                            <td class="shippingTable02" align="center">Seller Freight</td>
                            <td class="shippingTable03" align="center">Seller Freight</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Extra transport cost</td>
                            <td class="shippingTable01">&nbsp;</td>
                            <td class="shippingTable02">&nbsp;</td>
                            <td class="shippingTable03">extra charge depends on weight/distance.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Advantages</td>
                            <td class="shippingTable01">Fast and cheap. Good for cheap goods with low Quality risk.</td>
                            <td class="shippingTable02">Middle way solution.</td>
                            <td class="shippingTable03">High service level. Good for expensive products and or goods with high risk of damage.</td>
                        </tr>
                        <tr>
                            <td class="shippingTableTitle">Disadvantages</td>
                            <td class="shippingTable01">Less service (guarantee, after sales service)</td>
                            <td class="shippingTable02">&nbsp;</td>
                            <td class="shippingTable03">Slower, more expensive</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">One seller only charge freight once per order usually, sometimes customer service will contact you when <br />freight needs to be modified according to some special issues like package overweight etc.</td>
                        </tr>
                    </tfoot>
                </table>
			</div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>