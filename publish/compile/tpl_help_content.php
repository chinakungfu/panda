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
					<h2>Customer Service</h2>
					<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/help_links.tpl
LNMV
);
include($inc_tpl_file);
?>

				</div>
				<div class="contentHelpCont fr">
					<h2>My Account Help</h2>
					<div class="contentHelpContLeft fl">
						
						<ul>
							<li>Account Service</li>
							<li>Account Management</li>
							<li>Shopping from Taobao</li>
							<li>Surprise—Wow Shop</li>
							<li>Delivery</li>
							<li>Package check</li>
							<li>Refunds and Returns</li>							
							
						</ul>
						<br>

						<h3>Account Service</h3>
						<p>Welcome Wowtaobao, We are glad to help you buying any item you want from Taobao.</p>
						<p>How to buy from Taobao, please follow the examples below.</p>
						<br>
						<p><strong>Sign in Wowtaobao Web Site www.wowtaobao.net</strong></p>

						<ul>
							<li>① Enter<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>
							<li>②Sign me up.<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>
							<li>③Fill in the information.<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>
							<li>④Receiving registration mail from Wowtaobao.<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>
							
						</ul>
						<br>
						<p><strong>Registration complete</strong></p>
						<p>As registered customer:</p>						
						<ul>
							<li>①	Please input the username and password directly.<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>
							<li>After login you can go shopping.<br><img src="../skin/images/helpcontentImg.jpg" alt="helpcontentImg"/></li>							
						</ul>
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