<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
<!DOCTYPE HTML>
<html>
<head>
<?php
$inc_tpl_file=includeFunc("common/header/common_header.tpl");
include($inc_tpl_file);
?>
</head>
<body>
<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>

	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);
	?>

	<div class="content">
		<div class = "itemoutofstock">
			<h2>Oops! This item page on TAOBAO seems currently unavailable.</h2>
			<div class="submitBtn">
				<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=myCart'));?>">View Shopping Bag</a> or <a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>">Continue Shopping</a>
			</div>
		</div>
    </div>
	<?php
	$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
	include($inc_tpl_file);
	?>
</div>
</body>
</html>

