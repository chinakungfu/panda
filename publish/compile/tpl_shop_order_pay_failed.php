<?php import('core.util.RunFunc'); 

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

<script type="text/javascript">
	$(function(){
		$(".order_view").click(function(){
			$(".pageContentSubmit").toggle();
			
			});
				});
</script>
</head>
<body>

<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
shop/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	
	$order = runFunc("getOrderInfoById",array($this->_tpl_vars["IN"]["orderID"]));
	
	
$loginUser = runFunc('readSession',array());
$user_info = runFunc("getStaffInfoById",array($loginUser));

	if($loginUser == ""){
	
	$current_user_id =  $tmpUser;
}else{
	$current_user_id =  $loginUser;
}



	?>
<div class="content" style="width: 916px;">
<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">Payment failed <a style="color:#BAD584;font-size:11px" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=order'));?>">Back to your order history</a></h2>
<div class="subMitConfirm  fl">
			<div class="order_address fl success_order_address" width="100%">
				<h2>SHIPPING ADDRESS</h2>
				<table>
					<tr>
						<td width=12%>Name:</td>
						<td width="40%"><?php echo $order["fullName"];?></td>
						<td width=12%>Email:</td>
						<td><?php echo $order["email"];?></td>
					</tr>
					<tr>
						<td>Address1:</td>
						<td colspan=3><?php echo $order["address1"];?></td>
					</tr>
					<tr>
						<td>Address2:</td>
						<td colspan=3><?php echo $order["address2"];?></td>
					</tr>
					<tr>
						<td>City:</td>
						<td><?php echo $order["city"];?></td>
						<td>Province:</td>
						<td><?php echo $order["province"];?></td>
					</tr>	
					<tr>
						<td>Country:</td>
						<td><?php echo $order["country"];?></td>
						<td>Zip:</td>
						<td><?php echo $order["zipcode"];?></td>
					</tr>
					<tr>
						<td>Phone1:</td>
						<td><?php echo $order["cellphone"];?></td>
						<td>Phone2:</td>
						<td><?php echo $order["telephone"];?></td>
					</tr>
				</table>
			</div>
			
			<div class="order_imf">
				<span class="imf_title">SORRY, YOUR ORDER PAYMENT IS FAILED</span>
				<p>
				Please check if your payment information is correct or you can choose other payment methods.
				</p>
			</div>
</div>
	<div class="fr" style="width:300px;position:relative;">
		<div class="submitOrderNo">
		Order <span>(No:<?php echo $order["OrderNo"];?>)</span>
		</div>
		<?php
		// ******************order Review**************************

		$inc_tpl_file=includeFunc(<<<LNMV
shop/paymentInfo.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
		</div>
		<style type="text/css">
			.subMitRight{
				height: 465px;
			}
			.order_view {
				margin-top: 3px;
			}
			
				.order_imf {
				    height: 286px;
				}
		</style>
		
			<div class="fl">
			<?php
			// ******************order Review**************************
			$inc_tpl_file=includeFunc(<<<LNMV
shop/orderReview.tpl
LNMV
			);
			include($inc_tpl_file);?>
	</div>

</div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
<script type="text/javascript">
	$(function(){

			$(".select_payment_button").click(function(){

					$(".payment_box").hide();
					var id = $(this).attr("id");
					var box = id + "_box";

					
					$("."+box).show();
				});

			
			
		})

</script>
</body>
</html>