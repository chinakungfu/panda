<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>SIGN UP</title>
	<link rel="stylesheet" href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/css/style.css"/>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){
				$(document).pngFix();
			});
		function register_check(){
				$(".require").each(function(){
					if($(this).children("input").val()==""){
						$(this).next().css("background","url(images/error.gif) no-repeat center right")
					}
				});
				return false;
			}
	</script>
</head>
<body>
	<div id="inner-header">
		<div id="inner-header-contain">
			<a href="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>index.php">
			<img id="inner-logo" class="left" src="<?php echo runFunc('getGlobalModelVar',array('Site_Domain'));?>skin/images/logo.png" alt=""/>
			</a>
		</div>
	</div>
	<div id="inner-body">
		<div id="inner-body-contain">
			<h1 class="page-line">Time to shopping and share</h1>
			<div class="inner-input-box right">
				<h2 class="page-title"><span class="title-span left">Sign Up</span></h2>
				<form action="" onsubmit="return register_check()">
					<table class="inner-input-table right">
						<tr>
							<th>Your Email</th>
							<td class="require"><input type="text" id="email" ></td>
							<td class="check"></td>
						</tr>
						<tr>
							<th>Re Enter Your Email</th>
							<td class="require"><input type="text" id="remail" name="para[staffNo]"/></td>
							<td class="check"></td>
						</tr>
						<tr>
							<th>New Password</th>
							<td class="require"><input type="password" id="password" name="para[password]" ></td>
							<td class="check"></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td><input type="text" id="phone"/></td>
							<td class="check"></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="inner-submit" type="submit" value="Sign up"></td>
						</tr>
					</table>
				</form>
			</div>
			<div id="message-below" class="right">
				By clicking Sign Up, you agree to our Terms and that you have read and understand
our Data Use Policy.
			</div>
		</div>
	</div>
	<div id="inner-footer">
		<div class="inner-footer-menu-box">
			<ul id="inner-footer-menu" class="right">
				<li><a href="">About</a></li>
				<li>&bull; </li>
				<li><a href="">Data Use Policy</a></li>
				<li>&bull; </li>
				<li><a href="">Terms</a></li>
				<li>&bull; </li>
				<li><a href="">Help</a></li>
			</ul>
		</div>
		<div class="red-line"></div>
			<p class="inner-copy">WOWTAOBAO &copy; 2012 </p>
	</div>
</body>
</html>