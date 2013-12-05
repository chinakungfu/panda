<?php import('core.util.RunFunc'); 
import('core.addfunction.facebook.src.facebook'); 
$this->_tpl_vars["CookieUser"]=runFunc('readCookie',array()); 
?>

<?php 

$facebook = new Facebook(array(
  'appId'  => '278948165550978',
  'secret' => '7e4af236c3155bdf466474a60f3e55a5',
));

$user = $facebook->getUser();

if ($user){
//  $user_profile = $facebook->api('/me');

    // Proceed knowing you have a logged in user who's authenticated.
//	header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
$check_facebook = runFunc("checkFaceBookUser",array($user));
if($check_facebook!=""){
	runFunc('writeSession',array($check_facebook));
		
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateCart",
	'query' => "update cms_publish_cart SET UserName= '{$check_facebook}' WHERE `UserName`= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateCart'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  

 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "updateOrder",
	'query' => "update cms_publish_order SET orderUser= '{$check_facebook}' WHERE orderUser= '{$this->_tpl_vars["CookieUser"]}'",
 ); 

$this->_tpl_vars['updateOrder'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  


		header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
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
	<div class="facebook_login_box">
		<div class="fb_logos">
			<img class="site_logo_large" src="../skin/images/logo_large.png" alt="" />
			<br />
			<img class="fb_login_mark" src="../skin/images/fb_login_mark.png" alt="" />
		</div>
		<div >
			<form id="fb_login_form" action="index.php" method="post">
				<table class="fb_login_table">
					<tr>
						<td colspan="2">
							<input id="mail_for_fb" name="user_email" class="large_input_bar email required" type="text" value="Enter your email for shopping"/>		
						</td>
					</tr>	
					<tr>
						<td><input type="submit" class="fb_login_button" value=""/></td>
						<td style="font-size:12px;">Not a member yet? <a style="color:#b63937" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerUser'));?>">Join now!</a></td>
					</tr>
					
					<tr>
						<td style="text-align:center;" colspan="2">
							By clicking Login, you agree to our <a style="color:#5E97ED" href="index.php<?php echo runFunc('encrypt_url',array('action=help&method=terms'));?>">Terms</a> and that you have read our <a style="color:#5E97ED" href="index.php<?php echo runFunc('encrypt_url',array('action=help&method=datausepolicy'));?>">Data Use Policy</a>. 
						</td>
					</tr>
				</table>
				<input name="action" type="hidden" value="website" />
				<input name="method" type="hidden" value="facebook_user_save" />
			</form>
		</div>
		<div class="fb_login_ft">
			 <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=aboutUs'));?>">About</a> · 
	    	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=datausepolicy'));?>">Data Use Policy</a> · 
	   		  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=terms'));?>">Terms</a> · 
	     	<a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help</a>
		   <br />
	          WOWSHOPPING &copy; 2012
	      
	      </div>
	</div>
	<script type="text/javascript">
	$(function(){
		$("#mail_for_fb").focus(function(){
			if($(this).val() == "Enter your email for shopping"){
					$(this).val("");
				}
		});

		$("#mail_for_fb").blur(function(){
			if($(this).val() == ""){
					$(this).val("Enter your email for shopping");
				}
		});


		$("#fb_login_form").validate({

			errorPlacement: function(error, element) {
	         // console.info(element.parent().prev("th").append(error));
	        }		

		});
		
	});
	
	</script>
</body>
</html>
<?php }else{
	
	header("Location:".runFunc('encrypt_url',array('action=shop&method=shopindex')));
}?>
