<?php import('core.util.RunFunc'); ?>

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
		function checkSSIS(a){
			var chekValue = $(a).val();
			if(chekValue == 1){
				$(a).val(0);
			}else{
				$(a).val(1);
			}
		}
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

	if(!$order or $order["orderStatus"]!=4){

		$link = "index.php".runFunc('encrypt_url',array('action=shop&method=myCart'));
		 header("Location: ".$link);
	}
	?>
	<div class="content" style="width: 916px;">
		<h2 width="100%" style="color: #777777; height: 60px; font-size: 24px; font-weight: bold;">Congratulations!</h2>
		<div class="subMitConfirm fl">
			<div class="order_address fl success_order_address" width="100%">
				<h2>SHIPPING ADDRESS hu</h2>
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

			<div class="order_imf" style="height: 320px;">
				<span class="imf_title" style="margin-top: 12px;margin-bottom:10px;">PAYMENT NOTIFICATION</span>
				<p style="float:none;">
				Order <font style="color:#7c0000;">(<?php echo $order["OrderNo"];?>)</font> has been successfully submitted. Please save your information below in order to finish your payment process.
			</p>


				<?php if ($this->_tpl_vars["name"]==''){?>
		<form action="/publish/index.php" method="post" id="order_regist_form">
			<input type="hidden" name="action" value="website"> <input
				type="hidden" name="method" value="addOrderUser"> <input type="hidden"
				name="signUpType" value="order"> <input type="hidden" name="backUrl"
				value="<?php echo runFunc('url2str',array($this->_tpl_vars["IN"]));?>">
			<input type="hidden" name="orderID"
				value="<?php echo $this->_tpl_vars["IN"]["orderID"];?>">
			<input type="hidden" name="fullName" value="<?php echo $order["fullName"];?>" >
				<?php if ($this->_tpl_vars["IN"]["alertStr"]){?>
				<?php } ?>
				<?php
				import('core.apprun.cmsware.CmswareNode');
				import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params;
				$params = array (
				'action' => "sql",
				'return' => "addressInfo",
				'query' => "SELECT * FROM cms_publish_address WHERE addressID='{$this->_tpl_vars["orderInfo"]["data"]["0"]["orderAddress"]}' limit 1",
				);

				$this->_tpl_vars['addressInfo'] = CMS::CMS_sql($params);
				$this->_tpl_vars['PageInfo'] = &$PageInfo;
				?>
				<?php if(isset($this->_tpl_vars["IN"]["alertStr"])):?>
				<script type="text/javascript">
				$(function(){
					$(window).scrollTop(1000);
				});

				</script>
					<span style="width: 300px;margin:auto;margin-bottom:10px;" class="passwordE" id="registerMessage"><?php echo $this->_tpl_vars["IN"]["alertStr"];?></span>
				<?php endif;?>
					<h2 style="margin-top: 14px;">SAVE YOUR INFORMATION</h2>
					<table class="order_regist_table">
						<tr>
							<td width="22%">USER NAME</td>
							<td width="38%"><input readonly type="text" value="<?php echo $order["email"];?>" name="para[staffNo]" /></td>
							<td><input type="hidden" name="para[reStaffNo]" value="<?php echo $order["email"];?>"></td>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>PASSWORD</td>
							<td><input id="password" type="password" name="para[password]" /></td>
						</tr>
						<tr>
							<td>RETYPE PASSWORD</td>
							<td><input id="repassword" type="password" name="para[rePassword]" /></td>
						</tr>
						<tr>
							<td>SECURITY QUESTION</td>
							<td>
								<select class="required" size="1" name="para[safetyQuestion]">
								<?php
								$inc_tpl_file=includeFunc(<<<LNMV
common/saftyQuestion.tpl
LNMV
								);
								include($inc_tpl_file);
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>SECURITY ANSWER</td>
							<td><input class="required" type="text" name="para[questionResult]" value="<?php echo $this->_tpl_vars["IN"]["questionResult"];?>" /></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="checkbox"  name="para[SSIS]" value="0" onClick="checkSSIS(this);" />&nbsp&nbsp&nbsp&nbsp&nbsp<font color="#7c0000">If you are from SSIS please check</font></td>
						</tr>
					</table>

		</form>

		<?php
		} ?>
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
				height: 479px;
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

	</div>

	</div>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>

<style type="text/css">
.order_view {
    cursor: pointer;
    margin-top: 3px;
    width: 602px;
}
</style>

<script type="text/javascript">
$(function(){

	$("#order_regist_form").validate({

		errorPlacement: function(error, element) {
			if($(error).text()!="This field is required."){
			if($(element).attr("id") == "email"){
				error.insertAfter(element);
				}
			}

    	},rules: {
			"para[password]":{
					required: true,
					minlength: 6
				},
           	"para[rePassword]":{
					required: true,
					equalTo: "#password",
        		}
    	},messages: {
    	    email: { remote: "Already subscribed",required:" ",email:" "}
    	  }

		});


});
</script>
</body>
</html>
