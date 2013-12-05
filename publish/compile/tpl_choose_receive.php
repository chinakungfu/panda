<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>CHOOSE RECEIVE</title>
	<link rel="stylesheet" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/css/style.css"/>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){ 
				$(document).pngFix(); 
			}); 
	</script>
</head>
	
<body>
	
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/red_header.tpl
LNMV
);
include($inc_tpl_file);
?>

	<div id="inner-body">
		<div id="inner-body-contain">
	
			<h1 class="page-line">Please choose a receiving way</h1>
			
			<div class="choose-box right">
					
			<span class="c-title">
						Choose a warehouse
					</span>
					 
			( I can go to WOW's warehouse to pick it up. )
				
			<form action="">
					
			<div class="address-detial">
						
			<div class="address-content left">
							
			<p>Shop 2, Block 76, Orchard Manors, Xingming Street, SIP</p>
							
			<p>Tel:0512-6s9176632</p>
							
			<p>Cellphone:+86 13962177512</p>
						
			</div>
						
			<a href="#" class="map-link left">MAP</a>
					
			</div>
					
			<div class="ov">
						
			<input type="submit" class="right button-link" id="odn" value="Order now">
					
			</div>
				
			</form>
			
			</div>
			
			<div class="dashed-line order-line right"></div>
			
			<div class="choose-box right">
					
			<span class="c-title left">
						
			Door to door delivery
					</span>
	
			<a href="#" id="yus" class="button-link left">Why Us</a>
					
			<div class="de-content right">
						
			D2D delivery charge: starting fee 50CNY, packages heavier than 10kg/bigger than 53*29*37 cm/2*1*1.5 feet shall be calculated according to the circumstance. 
					
			</div>
					
			<div class="ov">
						
			<a class="right button-link" id="ad-book" href="">Address Book</a>
					
			</div>
			
			</div>
		</div>
	</div>
	
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/red_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

	</body>
</html>