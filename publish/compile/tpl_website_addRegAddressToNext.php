<?php import('core.util.RunFunc');
$this->_tpl_vars["user_id"]=runFunc('readSession',array());
if($this->_tpl_vars["user_id"]==""){
	header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
}
?>
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
	$countries = runFunc("getShippingCountries");
	?>
    <div class="content">
        <div class="address">
            <div class="addresstitle">
                <h1>WELCOME TO WOWshopping</h1>
                <h2>Congratulations, address set successfully</h2>
            </div>
            <div class="addresscont">
                <div class="addresstab">
                	<p class="addressNextInfo">You can visit your account homepage to edit or add new address later</p>.
                    <div class="addressNext"><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=editProfile'));?>">Next</a></div>
                </div>
              
            </div>
    </div>
</form>

		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

	</div>
</body>
</html>>