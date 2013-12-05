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
        <h3>Points and E-Coupons</h3>
        <div>
        	<h4>How do I get WowShopping credit?</h4>
            <div class="conList">    
            	<ol style="list-style:decimal">
                	<li>Receive one point for every Chinese Yuan you spend on items and domestic delivery fee.</li>
                 	<li>Participate in events: We will hold point events where you can gain points by participation.</li>                      
                </ol>            
            </div>
        	<h4>When will I receive points?</h4>
            <div class="conList">    
            	<ol>
                	<li>We will automatically send the points to your account after your payment is confirmed. You can check your 

points balance on your <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_page'));?>">Wow Account</a> page </li>                      
                </ol>            
            </div>
            
        	<h4>How do I use my points?</h4>
            <div class="conList">    
            	<ol>
                	<li>The points can be used as total cost of the product you buy on WowShopping. You may exchange your points

within your <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=shop&method=recharge_with_credits'));?>">Points Exchange</a> page. Please note: Every 200 points entitles you to 1 RMB.</li>                      
                </ol>            
            </div>
            
        	<h4>What is WowShopping’s points usage policy?</h4>
            <div class="conList">    
            	<ol>
                	<li>WowShopping points cannot be transferred but can be used as part payment while shopping on this website.</li>       
                </ol>            
            </div>

        	<h4>What are the points validity dates?</h4>
            <div class="conList">    
            	<ol>
                	<li>In principle, the member points have no validity dates applied.</li>                      
                </ol>            
            </div>

        	<h4>About E-Coupons</h4>
            <div class="conList">    
            	<ol>
                	<li>There are four kinds of e-coupon available. Face values are: 5rmb, 10rmb, 20rmb and 50rmb. </br>

Every e-coupon has a unique serial number which must be entered in the code box before payment. </br>

The e-coupon can be used as total cost payment of a product.</br>

Only one e-coupon may be used per transaction.
</li>                      
                </ol>            
            </div>                                                
        </div>
  		<div class="conListBottom"><a style="color:#de8908;" href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Back</a>  <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=orderingWalkthrough'));?>">Ordering Walkthrough</a></div>
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