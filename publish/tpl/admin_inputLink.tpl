<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>  
	</head>
	<body>
<script>

function addressadd()
{
        document.formAddress.submit(); 
}

</script>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
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
				<span class="moreQa clb"><a href="index.php[@encrypt_url('action=help&method=main')]">More Q &amp; A</a></span>
				<div class="httpLink">
				    <h2>I have a link from www.Taobao.com<!--<span>hot chinese sites</span>--></h2>
				    <form name="formAddress" id="formAddress" class="ov search_box" action="/publish/index.php" method="post"  >
					<input type="hidden" name="action" value="admin">
					<input type="hidden" name="method" value="addGoods">

				        <input type="text" value="http://" class="httpLinkText fl" name="GoodsURL" onfocus="this.value=''" onblur="javascript:if(this.value==''){this.value='http://'}"/>

				        <span class="buyLink fl">
					<a href="javascript:addressadd();" name="savesubmit" id="savesubmit">Buy</a>
					<!--<input type="submit" value="Buy"/>--></span>
				    </form>
				    <span class="linkHere"></span>
				    <div style="padding:50px 0 0 19px" class="clb">
                        If you don't have any link, please visit <a href="index.php[@encrypt_url('action=shop&method=taobaoLink')]" style="color:#9E2021">LINKS FROM TAOBAO</a></span>
                    </div>
				
				</div>
				
				<div class="membership clb">
				    Membership make your shopping more easier <a href="###" class="join fr">Join</a>
				</div>
			</div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
		
		<pp:if expr="$IN.grapRst=='alert'">
			<script>alert("[$IN.alertContent]");</script>
		</pp:if>
		
	</body>
</html>