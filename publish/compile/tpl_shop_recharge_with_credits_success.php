<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
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
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>


	<?php //$this->_tpl_vars["result"]=runFunc('getStaffInfoByNo',array($this->_tpl_vars["IN"]["staffId"])); ?>
    <div class="content">
        <div class="notic_content">
            <div class="notic_header">
                <h1>Recharge succsessfully</h1>
                <h2 style="color:#b2b3b0;">Enjoy your shopping on wow!</h2>
            </div>
            <div class="notic_body">
                <p style="text-align:center;"><span style="color:#b2b3b0;font:normal 14px Arial, Helvetica, sans-serif;margin-right:50px;">YOUR BALANCE</span> <span style="color:#333;font:bold 30px Arial, Helvetica, sans-serif;">¥ <?php echo $this->_tpl_vars["IN"]["balance"];?></span></p> 
                <p style="text-align:center;"><span style="color:#b2b3b0;font:normal 14px Arial, Helvetica, sans-serif;margin-right:50px;">YOUR POINTS</span> <span style="color:#333;font:bold 30px Arial, Helvetica, sans-serif;"><?php echo $this->_tpl_vars["IN"]["credits"];?></span></p> 
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