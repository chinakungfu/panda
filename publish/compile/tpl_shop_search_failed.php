<?php import('core.util.RunFunc'); ?>
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
	<?php $inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	</div>
	<div class="content clb">
			
			<div class="search_message_box" style="text-align:center;">
				<h2 style="font-size:24px;color:#BAD584;">Sorry, your search failed</h2>
				<div style="margin-top:30px">
				Maybe the url you input is wrong,please check again and <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>">continue search</a>. 
				<br />
				Or the item can not be searched,please <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=messages_help'));?>">click here</a>,we will help you.
				</div>
			</div>
			
	</div>
	<?php $inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>




</body>
</html>
