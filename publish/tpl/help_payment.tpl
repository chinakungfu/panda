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
			<div class="contentHelp clb">
				<div class="navHelp fl">
					
					<pp:include file="common/help_links.tpl" type="tpl"/>
				</div>
				<div class="contentHelpCont fr">
					<h2>Payment details</h2>
					<div class="contentHelpContLeft fl">
						
						<p>1.Total fees = item price + domestic delivery + service fee</p>						
						<br>
						<p>2.Service fee = 10% item price. (item price below 200RMB will be charge at least 20RMB service fee. 
						Delivery rate depends on distance and package weight. Different delivery service brands charge different. Delivery rate is determined by the taobao seller.</p>						
						<br>
						<p>3.Refund/exchange service charge: 5% item price (domestic delivery fee excluded). </p>						
						<br>

						<p>4.After opening your package, you notice any problem (such as damaged goods) please contact us within 3 days, if we don’t hear anything from you within 3 days, we consider the transaction as successful.</p> 
						<br>
						<p>For example, you buy 3 items (total price 50RMB) from one seller, in that case the total fee will be: </p>
						<br>
						<p>Item price: 50RMB + 23RMB delivery fee = 73RMB</p>
						<p>Service fee: 10RMB (item price below 100RMB)</p>
						<p>Total fee: 73RMB + 10RMB = 83RMB</p>
						<br>
						<p>In case of 2 items (total price 500RMB) from different sellers, the total fee will be:</p> 
						<br>
						<p>Item price: 500RMB + 18RMB delivery fee seller 1 + 15 RMB delivery fee seller 2 = 533RMB</p>
						<p>Service fee: 10% * 533RMB = 53.3RMB</p>
						<p>Total fee: 533RMB + 53.3RMB = 586.3RMB</p>



					</div>

					<!--<div class="contentHelpContRight fr">
						<img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/>
					</div>
					
					<p class="clb yourPassword">
						<strong>Change Your Password </strong><br />
						Under Account Information, click Password. You will be prompted to enter a new password.
					</p>-->
				</div>
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>