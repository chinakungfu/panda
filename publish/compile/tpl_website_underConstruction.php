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

		<meta HTTP-EQUIV=REFRESH CONTENT="5;URL='/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=account'));?>'">
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
			    <div class="requestpassword">
			        <h2>Time to shopping and share</h2>
			        <table class="passwordemailed" width="10%">
			        	<tr>
			               <td height="20" style="background-color:#454544; color:#fff; padding-left:6px"></td>    
			            </tr>
			            <tr>
			                <td height="115" valign="middle">
								<p style="font-size:12px">Under construction</p>
							</td>
			            </tr>
			        </table>
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

	</body>
</html>