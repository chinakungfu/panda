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
  <?php if ($this->_tpl_vars["IN"]["grapRst"]=='alert'){?>
		<script>
			if(confirm("<?php echo $this->_tpl_vars["IN"]["alertContent"];?> Now go to shopping guide page, or not!" ))
			{
				  
		    }else{
		         history.go(-1);
		    }
		</script>
		<?php } ?>
		
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
	</div>

	<div class="content clb">
		<form action="/publish/index.php" method="post">
			<input
				type="hidden" name="action" value="website"> <input type="hidden"
				name="method" value="addUser"> <input type="hidden" name="backUrl"
				value="<?php echo runFunc('url2str',array($this->_tpl_vars["IN"]));?>">
			<input type="hidden" name="signUpType" value="message_request"> 
			<div class="shop_message_box">
				<span class="message_title">Please fill the form bellow ,let us know
					what you need; Our customer service will response within 24 hours</span>
				<ul class="message_content">
					<li><span>Your Name*</span><input name="para[staffName]" type="text" />
					</li>
					<li><span>Your E-mail*</span><input name="para[staffNo]"
						type="text" /></li>
					<li><span>Comfirm E-mail*</span><input name="para[reStaffNo]"
						type="text" /></li>
					<li><span>Your phone*</span><input name="para[phone]" type="text" /></li>
					<li><span>Password*</span><input name="para[password]" type="text" />
					</li>
					<li><span>Retype Password*</span><input name="para[rePassword]"
						type="text" />
					</li>
					<li><span>Security Question*</span><select id="select1" size="1"
						class="accoutInfoTextA" name="para[safetyQuestion]">
						<?php
						$inc_tpl_file=includeFunc(<<<LNMV
common/saftyQuestion.tpl
LNMV
						);
						include($inc_tpl_file);
						?>

					</select>
					</li>
					<li><span>Security Answer*</span><input type="text"
						name="para[questionResult]"
						value="<?php echo $this->_tpl_vars["IN"]["questionResult"];?>" />
					</li>
				</ul>
				<?php if ($this->_tpl_vars["IN"]["alertStr"]){?>
				<span class="passwordE" id="registerMessage"><?php echo $this->_tpl_vars["IN"]["alertStr"];?>
				
				</span>
				<?php } ?>
				<span class="message_input_notice">Message (optional) Maximum 500
					characters</span>
				<textarea class="message_input" name="para[content]" ></textarea>
				<ul class="message_selected">
					<li><input type="checkbox" checked="checked" name="para[send_mail]" /><span>Please
							send me a copy of this e-mail</span></li>
					<li><input type="checkbox" checked="checked" name="para[send_wow]" /><span>I
							would like to receive e-mail updates from WOW GROUP</span></li>
				</ul>
				<div class="message_submit  clb">
					<input type="submit" value="" />
				</div>
				<span class="red fl clb" style="margin-top: 20px;">Please note:</span>
				<span class="red fl clb" style="margin-top: 10px;">WOW GROUP will
					not sell or share e-mail addresses you provide.</span>
			</div>
		</form>
	</div>
	<?php $inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
	);
	include($inc_tpl_file);
	
	?>
		</div>
		
		
</body>
</html>
