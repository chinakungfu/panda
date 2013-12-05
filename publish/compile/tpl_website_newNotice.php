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

<script type="text/javascript">

/*var intervalid;  
 intervalid = setInterval("notice_page_redirect()", 4000);  

	 function notice_page_redirect() {  

			window.location.href = "/publish/index.php<?php echo runFunc('encrypt_url',array('action='.$this->_tpl_vars["IN"]["link_action"].'&method='.$this->_tpl_vars["IN"]["link_method"]));?>";  
         clearInterval(intervalid);  

	 }*/
</script>
 
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
	<?php $inc_tpl_file=includeFunc("shop/common_header.tpl");
	include($inc_tpl_file);?>


	<?php //$this->_tpl_vars["result"]=runFunc('getStaffInfoByNo',array($this->_tpl_vars["IN"]["staffId"])); ?>
    <div class="content">
        <div class="notic_content">
            <div class="notic_header">
                <h1><?php echo $this->_tpl_vars["IN"]["title_h1"];?></h1>
                <h2><?php echo $this->_tpl_vars["IN"]["title_h2"];?></h2>
            </div>
            <div class="notic_body">
                <p><?php echo $this->_tpl_vars["IN"]["alert_content"];?></p> 
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

			
		</div>
	</body>
</html>