<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
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
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			<div class="imglistSharemain">
			<ul id="stage">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>