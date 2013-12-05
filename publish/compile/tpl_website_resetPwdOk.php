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

			<?php $this->_tpl_vars["result"]=runFunc('getStaffInfoByNo',array($this->_tpl_vars["IN"]["staffId"])); ?>
			
			<div class="content">
                 <div class="resetpwd">
                    <div class="resetpwdtitle">
                        <h1>WELCOME TO WOWshopping</h1>
                        <h2>FIND YOUR PASSWORD SUCCESSFULLY</h2>                 
                    </div>
                </div>              
			    <div class="requestpassword">
			        <h2 style="text-align:center;">Passwords mailed. Please go to your mailbox to get your new password.</h2>
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