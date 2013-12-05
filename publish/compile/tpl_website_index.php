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
<body style="background:url(../../skin/images/holloween.jpg) repeat 0 0;">

	<?php $inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);?>

	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>
    
    <div class="homeImgs">
    	<?php echo runFunc("getSiteAdv",array("INDEX TOP IMG"));?>
    </div>
    
    <div class="homeBanners">
	<?php echo runFunc("getSiteAdv",array("Quick Order Top"));?> 
	</div>
    <div class="homeFee clb">
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/index/fee.tpl
LNMV
		);
		include($inc_tpl_file);
		?>  

    </div>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/index/recommend.tpl
LNMV
		);
		include($inc_tpl_file);
		?>        
        
        
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

	<?php if ($this->_tpl_vars["IN"]["grapRst"]=='alert'){?>
	<script>alert("<?php echo $this->_tpl_vars["IN"]["alertContent"];?>");</script>
	<?php } ?>

</body>
</html>
