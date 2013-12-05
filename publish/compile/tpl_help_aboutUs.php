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
        <a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">Help Center</a> > Company
    </div>    
    <div class="contentHelpContLeft fl">
        <h3>About Us</h3>
        <div>
        	<p style="font:normal 14px Arial, Helvetica, sans-serif;margin:20px 10px 20px 0;line-height:26px;color:#333; text-indent:20px;">WowShopping is an English speaking online shopping service based in Suzhou, China. We aim to provide expert guidance through the process of shopping…from buying to delivery of products from Taobao (China’s leading online 

marketplace) Our fabulous customer services team will be on hand to assist you at any time in the process.We are 

dedicated to providing a fun and stress free shopping experience; we have beautiful collections to browse for inspiration.</p>
        	<h4>We assist you in these ways:</h4>
            <div class="conList">    
            	<ol style="list-style:decimal">
                	<li>Language:</br>

         English search function. Taobao currently has only a Chinese language service. WowShopping offers an English </br>

         auto translate search, to enable you to find the products you are interested in.
</li>
                 	<li>Shopping:</br>

         While buying online by yourself in China can be quite difficult, we make online shopping feasible and aim to make 

         it a fun experience for all. When we buy on your behalf, we will keep close contact with you, to ensure you receive 

         the item as ordered. If there are any changes in circumstance (for example shipping fee and delivery time changes)

         we will always notify you in advance.</li>
                	<li>Collections</br>

         We have many collections available on our website for you to view; you can browse by subject (if you are looking 

         for something in particular) or simply look through the available pages for inspiration.

         If you see items you would like to check out later, add them to your wishlist for viewing at your convenience.

         We also encourage you to share your favourite products through our collections pages. You can add your wishlist

         items, maybe let your friends see your collection in time for your birthday or wedding. Your friends can even vote 

         for their favourite item using our Polls function.
 </li>          
         
 				<li>Live Events</br>Wow Shopping offers free advertising on the Live Events pages, see what’s happening, take advantage of 

         promotions and even advertise your event for free.
</li>          
                      
                </ol>
            
            
            </div>

        </div>

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