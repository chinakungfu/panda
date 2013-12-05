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

		<style>
		#stage{ margin-top:6px; overflow:hidden; margin-bottom:40px }
		#stage li{ float:left; width:250px;}
		#stage li div{ font-size:12px; padding:0px; color:#999999; text-align:left; }
		</style>
		<script language=JavaScript type="" >
		var getAjaxGoodsIndex = 1;
		var getAjaxGoodsSize = 10;
		$(document).ready(function(){
			loadMore("website","getAjaxShopShare","json",getAjaxGoodsIndex,getAjaxGoodsSize);
		});	
		
		$(window).scroll(function(){
			// 当滚动到最底部以上100像素时， 加载新内容
			if ($(document).height() - $(this).scrollTop() - $(this).height()<100){
				getAjaxGoodsIndex++;
				loadMore("website","getAjaxShopShare","json",getAjaxGoodsIndex,getAjaxGoodsSize);
			}
		});
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

			<div class="imglistSharemain">
			<ul id="stage">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
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