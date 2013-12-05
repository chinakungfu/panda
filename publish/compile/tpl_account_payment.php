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
	<body onLoad="window.location.hash = 'here'">
	    
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
			    
			       <?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_body.tpl
LNMV
);
include($inc_tpl_file);

$orders = runFunc("getMyOrderByStatus",array($this->_tpl_vars["name"],4));
?>

			   
			    <div class="orderlistPay">
			    <a name="here"></a>
                        <h2 style="color:#700000">YOUR PAYMENT INFORMATION</h2>
                        <?php if(count($orders)>0):?>
                           <table>
                              <tr>
                                 <th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th> 
                              </tr>
			<?php  foreach ($orders as $order){ ?>
				      <tr>
					 <td>No:<?php echo $order["OrderNo"];?></td>
					 <td align="center"><?php echo date('Y-m-d H:i:s',$order["orderTime"]);?></td>
					 <td align="center"><?php echo runFunc("getOrderStatus",array($order["orderStatus"]));?> <?php if($order["group_buy"]==1)echo "<br />Group Buy"?></td>
					 <td class="orderlistPayBtn">
						<?php if($order["orderStatus"]<=4):?>
						<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_modify&orderID=' . $order["orderID"]));?>">Modify</a>
						<?php else:?>
						<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID=' . $order["orderID"]));?>">View details</a>
						<?php endif;?><br />
					<?php if($order["totalAmount"]>0):?>
					 <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=payment&orderID=' . $order["orderID"]));?>" class="orderlistPayBtnLink">Pay</a>
					<?php endif;?>
					</td> 
				      </tr>
 			<?php } ?>
					</table>
					
				<?php else:?>
				<p style="padding: 10px; text-indent: 52px;">There are no orders waiting to pay.</p>
			   <?php endif;?>
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