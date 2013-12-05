<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php 
	if(!$this->_tpl_vars["name"]){
		header("Location: ".runFunc('encrypt_url',array('action=website&method=index')));
		exit;
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
?>		

			<div class="content">   
			       <?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_body.tpl
LNMV
);
include($inc_tpl_file);
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