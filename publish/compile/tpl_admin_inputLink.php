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
  
	</head>
	<body>
<script>

function addressadd()
{
        document.formAddress.submit(); 
}

</script>
	    
		<div class="box">
		    
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

			
			
			<div class="content clb">
				<h2 class="timeTitle">Time to shopping and share </h2>
				<h3 class="timeTitleSmail">HOW TO:</h3>
				<ul class="linkQ">
				    <li><span>submit order</span></li>
				    <li><span>service confirm</span></li>
				    <li><span>pay</span></li>
				    <li><span>purchase</span></li>
				    <li id="noBj"><span>delivery</span></li>
				</ul>
				<span class="moreQa clb"><a href="index.php<?php echo runFunc('encrypt_url',array('action=help&method=main'));?>">More Q &amp; A</a></span>
				<div class="httpLink">
				    <h2>I have a link from www.Taobao.com</h2>
				    <form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post"  >
					<input type="hidden" name="action" value="admin">
					<input type="hidden" name="method" value="addGoods">

				        <input type="text" value="http://" class="httpLinkText fl" name="GoodsURL" onfocus="this.value=''" onblur="javascript:if(this.value==''){this.value='http://'}"/>

				        <span class="buyLink fl">
					<a href="javascript:addressadd();" name="savesubmit" id="savesubmit">Buy</a>
					</span>
				    </form>
				    <span class="linkHere"></span>
				    <div style="padding:50px 0 0 19px" class="clb">
                        If you don't have any link, please visit <a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=taobaoLink'));?>" style="color:#9E2021">LINKS FROM TAOBAO</a></span>
                    </div>
				
				</div>
				
				<div class="membership clb">
				    Membership make your shopping more easier <a href="###" class="join fr">Join</a>
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
		
		<?php if ($this->_tpl_vars["IN"]["grapRst"]=='alert'){?>
			<script>alert("<?php echo $this->_tpl_vars["IN"]["alertContent"];?>");</script>
		<?php } ?>
		
	</body>
</html>