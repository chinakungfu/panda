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
    <div class="navHelp">
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Account & Members
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Recharge Account</h3>
        <div>
        	<h4>WOW ACCOUNT</h4>
            <div class="conList">    
            	<ol>
                	<li>For convenient, fast and easy payments, we highly recommend you to use our Wow account. Your wow account 

can be charged by PayPal and online methods (see: <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=paymentWalkthrough'));?>">Payment walkthrough</a> ) or by calling at our office with cash 

deposits.( SUZHOU only )</li>
                 	<li>To recharge your WOW ACCOUNT, please visit our "<a class="nan" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>">Recharge Account</a>" page.</li>
                    
                	<li>The minimum re-chargeable amount is 500rmb but you may increase this amount using the white box.</li> 
                    
                    <li><img src="../../skin/images/help/rechargeAccount001.jpg" /></li> 
                    
                    <li>You will now be taken through the payment process as above depending on which method you choose.</li>                       
                </ol>
            
            
            </div>

        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=paymentWalkthrough'));?>">Payment walkthrough</a></div>
    </div>
    

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
help/main/right.tpl
LNMV
);
//include($inc_tpl_file);
?>    
    
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