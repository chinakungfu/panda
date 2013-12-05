<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array()); ?>
<?php if ($this->_tpl_vars["name"]){?>
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
	<body onload="window.location.hash = 'here'">
	    
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

			    
			    <div class="orderlistPay">
			    <a name="here"></a>
                        <h2 style="color:#700000">YOUR SHIPPING HISTORY</h2>
                           <table>
                              <tr>
                                 <th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td>
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details<br /></td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details<br /></td> 
                              </tr>
                              <tr>
                                 <td>No:201202121001</td><td align="center">2012.2.20&nbsp;&nbsp;18:39</td><td align="center">Process</td><td class="orderlistPayBtn">View details</td> 
                              </tr>
                           </table>
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
<?php }else{ ?>
	<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
);
include($inc_tpl_file);
?>

<?php } ?>