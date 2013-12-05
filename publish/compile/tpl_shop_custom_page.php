<?php import('core.util.RunFunc'); ?>
<!DOCTYPE HTML>
<html>
<head>
<?php
echo $this->_tpl_vars["IN"]["search_Content"];
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
		<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	
	include($inc_tpl_file);

	$item = runFunc("getCustomPageFromAdminById",array($this->_tpl_vars["IN"]["id"]));
	
	?>
	
	<div class="content">
		<h2 class="shop_page_title">
			<?php echo $item[0]["title"]?>
		</h2>
		<div class="custom_page_content">
			<?php echo $item[0]["content"]?>
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

