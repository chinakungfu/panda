<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
 if ($this->_tpl_vars["name"]){?>
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
<?php if ($this->_tpl_vars["IN"]["grapRst"]=='alert'){?>
<script>
	if(confirm("<?php echo $this->_tpl_vars["IN"]["alertContent"];?>Now go to shopping guide page, or not!" ))
	{

    }else{
         history.go(-1);
    }
    </script>
<?php } ?>
</head>
<body>

	<div class="box">
	<?php $inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>


	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>
	</div>
	<div class="content clb">


		<form id="help_message_form" action="/publish/index.php" method="post">

			<input type="hidden" name="action" value="shop">
			<input type="hidden" name="method" value="control">
			<input type="hidden" name="signUpType" value="message_unregist">


			<div class="shop_message_box" style="margin-top:50px;">
           		<div style="font-size:16px;">
                    <span>Dear</span><span style="color: #c3dc93;"> <?php echo $this->_tpl_vars["userInfo"]["0"]["staffName"];?></span>
                    
                    <div style="margin:40px 0px;">
                        Please send us details of your request. We will respond as quickly as possible.
                    </div>
                </div>
				<textarea class="message_input required" name="para[content]"></textarea>
				<ul class="message_selected">
					<li><input type="checkbox" value="1" checked="checked" name="para[send_mail]" /><span>Please
							send me a copy of this e-mail</span></li>
					<li><input value="1" type="checkbox" checked="checked" name="para[send_wow]" /><span>I
							would like to receive e-mail updates from WOWSHOPPING</span></li>
				</ul>
				<div class="message_submit  clb">
                    <button class="submit_btn" type="submit" name="submit_btn">Send</button>
				</div>
				<!--
				<span class="red fl clb" style="margin-top: 20px;">Please note:</span>
				<span class="red fl clb" style="margin-top: 10px;">WOWshopping respects your privacy, we will not sell or share your personal details.</span>
				-->
			</div>
		</form>
	</div>
	<?php $inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	?>



<script type="text/javascript">
	$(function(){

		$("#help_message_form").validate({
			errorPlacement: function(error, element) {

        	}
			});


	});
</script>
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
