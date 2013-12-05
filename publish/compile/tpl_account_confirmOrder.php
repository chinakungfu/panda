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
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>



			<div class="content">

			       <?php
$inc_tpl_file=includeFunc(<<<LNMV
common/account_body.tpl
LNMV
);
include($inc_tpl_file);

$orders = runFunc("getMyOrderByStatus",array($this->_tpl_vars["name"],7.1));
?>


			    <div class="orderlistPay">
			    <a name="here"></a>
                        <h2 style="color:#700000">YOUR CONFIRM INFORMATION</h2>
                        <?php if(count($orders)>0):?>
                           <table>
                              <tr>
                                 <th width="140px">&nbsp;</th><th width="260px" align="center">Submit time</th><th width="180">Status</th><th>&nbsp;</th>
                              </tr>
			<?php  foreach ($orders as $order){ ?>
				      <tr>
					 <td>No:<?php echo $order["orderTime"];?></td>
					 <td align="center"><?php echo date('Y-m-d H:i:s',$order["orderTime"]);?></td>
					 <td align="center"><?php echo runFunc("getOrderStatus",array($order["orderStatus"]));?></td>
					 <td class="orderlistPayBtn">
					<a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=orderDetail&orderID=' .$order["orderID"]));?>">View details</a>
					<br />
					 <a onClick="javascript:return confirm('Are you sure you get what you need?')" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=order_final_confirm&orderID=' .$order["orderID"]));?>" class="orderlistPayBtnLink">Confirm</a>
					</td>
				      </tr>
 			<?php } ?>
					</table>

				<?php else:?>
				<p style="padding: 10px; text-indent: 52px;">There are no orders waiting to confirm.</p>
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