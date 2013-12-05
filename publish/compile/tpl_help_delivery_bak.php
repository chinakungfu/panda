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
	<body>
		
		<div class="box">
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>


			
			<div class="contentHelp clb">
				<div class="navHelp fl">
					
					<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/help_links.tpl
LNMV
);
include($inc_tpl_file);
?>

				</div>
				<div class="contentHelpCont fr">
					<h2>Delivery</h2>
					<div class="contentHelpContLeft fl">						
					
						<p>In average, domestic delivery takes 2-7 days to arrive to our warehouse or your expected place. International delivery delivery time does not depend on WOWTaobao and we cannot provide any guarantee as for duration of shipping.</p>
						<br>
						<p>Below is the average delivery time for international shipping:<br>
						Air Mail (China Post Air Mail): 14 – 40 days.<br>
						EMS (China Post): 7 – 28 days<br>
						DHL: 5-14 days</p>
						<br>
						<p>Delivery time depends on the destination country, in particular on the speed of the local customs clearance and local postal services. However, the time for arrival does not depend on us and we are not liable to any delay in delivery. We always try our best to ask for information and give you the feedback in time. We can inquire additional information about your parcel only if online tracking did not appear within 10 days of shipping date or if delivery time exceeds the above estimated time.</p>
						<br>
						<p>The risk of loss or damage to your order shall pass to delivery company upon international shipping.</p>
						<br>
						<p>About delivery rate(freight) depends on distance and package weight. Different delivery service brands charge different. Delivery rate is determined by the taobao seller，So we should revise the item freight case by case by our Custom Service. When the freight is revised, it will sent you “Freight Modified” email automatically for your confirmation.</p>
						<br>



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