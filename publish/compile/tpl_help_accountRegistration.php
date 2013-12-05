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
<body>
<div class="box">	
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>
<div class="contentHelp clb">
    <div class="navHelp">
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Account & Members
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>Account Registration</h3>
        <div>
            <div class="conList">    
            	<ol>
                	<li>Shopping on WOWshopping is faster and more convenient when you have an account. Your account consists
 
of a unique WOW ID and password. When you're logged in, you can easily save items and shopping bags, 

take advantage of express checkout ordering, check the status of an order, and more.</li>                      
                </ol>            
            </div>
        	<h4>Benefits of an WOW ID</h4>
            <div class="conList">    
            	<ol>
                	<li>To create a WOW ID (typically your email address)，<a class="reg" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=registerUser'));?>">click here.</a> By using your WOW ID, you can personalize 

your wowshopping experience. You can save items you’re interested in purchasing, save a bag if you’re almost 

ready to place an order, use express checkout ordering, check the status of or change your order, check WOW 

Account balances, and much more.</li> 

                	<li>If you've forgotten your WOW ID, try your current email address. If that doesn't work, please contact Customer 

Service at +86-512-62519973. We'll do all we can to help.</li>                        
                </ol>            
            </div>
            
        	<h4>Find or Reset Password</h4>
            <div class="conList">    
            	<ol>
                	<li>If you forgot your password, you can easily recover or reset it using <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=website&method=forgetPassword'));?>">FIND YOUR PASSWORD</a>. For security 

reasons, We cannot reset your password for you without security question. Please contact Customer Service 

at +86-512-62519973. We'll do all we can to help.</li>
                	<li>To protect yourself against unauthorized purchases to your credit card, do not give out your password to anyone.

It's easy to change your WOW ID password, or default shipping and payment information. <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=editProfile'));?>">Click here</a> to view and 

edit your account information.
</li>                       
                </ol>            
            </div>
                           
        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=rechargeAccount'));?>">Recharge Account</a></div>
    </div>
    

			<?php
$inc_tpl_file=includeFunc(<<<LNMV
help/main/right.tpl
LNMV
);
//include($inc_tpl_file);
?>    
    
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