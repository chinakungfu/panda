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
 <script type="text/javascript">
	 var intervalid;  
	 intervalid = setInterval("notice_page_redirect()", 50000);
	 function notice_page_redirect() {  
			window.location.href = "/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=shopindex'));?>";  
			clearInterval(intervalid); 
	 }
 </script>
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
			
			<div class="content">
			    <div class="register">
	                <div class="regtitle">
                    	<h1>WELCOME TO WOWshopping</h1>
                        <h2>ACCOUNT REGISTRATION</h2>
                    </div>
                    <div class="regokInfo">
                        <p>Please go to <font color="#880808"><?php echo $this->_tpl_vars["IN"]["email"];?></font> to finish your registration process</p>
                        <p>
                            If you didn't receive the account activation email from WOWshopping Service, perhaps it was treated as spam, please check the trash box. 
                        </p>
                        <p style="margin-left:400px;">Thank You !</p>             
                    	<p style="margin-left:400px;">WOWshopping Team</p>  

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