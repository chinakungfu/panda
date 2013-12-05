<script language=JavaScript type="" >
var t4;
$(document).ready(function() {
		t4 =  new PopupLayer({trigger:"#headApp",popupBlk:"#dataStr",closeBtn:"#close",useFx:true,offsets:{
				x:-266,
				y:10
			}});
		t4.doEffects = function(way){
			way == "open"?this.popupLayer.slideDown("slow"):this.popupLayer.slideUp("slow");
		};
	});
	var timer1;
	var timer2;
	var timer3;
	var timer4;
	function addShoppingBag(addFlag)
	{
		var args = $('#goodsInfo').serialize();
		call_tpl('shop','addCart','backData2(\'headApp\')','return',args,addFlag,'');
	}
	function backData2(response){
		if(response>=0)
		{
			//alert("Add TO SHOPING BAG SUCCESS");
			$('#headerNewCartCount').html(response);
			$.ajax({
				url		: 'index.php',
				type	: 'POST',
				dataType: 'html',
				data	: {
					action	: 'shop',
					method	: 'shopCartListDiv',
					userName	: $("#headUserId").val()
				},
				success	: function(data){
					$("#dataStr").html(trim(data));
				}
			});
		}
	}
	function loadCart()
	{
		window.clearTimeout(timer1);
		window.clearTimeout(timer2);
		window.clearTimeout(timer3);
		window.clearTimeout(timer4);
		document.getElementById('loadStr1').style.display='';
		document.getElementById('dataStr1').style.display='none';
		timer1 = setTimeout("document.getElementById('loadStr1').style.display='none';document.getElementById('dataStr1').style.display=''",3000);
		timer4 =  setTimeout("closeDiv();",8000);
	}
	function loadCart1()
	{
		window.clearTimeout(timer1);
		window.clearTimeout(timer2);
		window.clearTimeout(timer3);
		window.clearTimeout(timer4);
		document.getElementById('loadStr1').style.display='';
		document.getElementById('dataStr1').style.display='none';
		t4.setPosition(t4.trigger.offset().left + t4.options.offsets.x, t4.trigger.offset().top + t4.trigger.get(0).offsetHeight + t4.options.offsets.y);
		t4.popupLayer.show();
		timer2 = setTimeout("document.getElementById('loadStr1').style.display='none';document.getElementById('dataStr1').style.display=''",3000);
		timer4 =  setTimeout("closeDiv();",8000);
	}
	function addWish(value)
	{
		if(value=='0')
		{				
			document.goodsInfo.submit();
		}else if(value=='1')
		{				
			document.goodsInfo.submit();
		}
	}
	function updateCart(value)
	{
		if(value=='0')
		{				
			document.goodsInfo.submit();
		}else if(value=='1')
		{				
			document.goodsInfo.submit();
		}
	}
	function closeDiv()
	{
		t4.options.useOverlay?t4.overlay.hide():null;
		t4.options.useFx?t4.doEffects("close"):t4.popupLayer.hide();
	}
	 $(function(){  
        var popupLayerObj = $(".popupLayer");  
        $("#dataStr").mouseover(function() {
        	window.clearTimeout(timer3);
        	window.clearTimeout(timer4);
            popupLayerObj.show();
            //timer4 =  setTimeout("closeDiv();",8000);
        });  
//关键的一句，绑定Div对象的mouseleave事件  
        popupLayerObj.bind("mouseleave", function() {  
            timer3 = setTimeout("closeDiv();",5000);
        });  
    }); 
</script>
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
<pp:var name="CookieUser" value="@readCookie()"/>	
	<pp:if expr="$CookieUser">
		<pp:var name="tmpUser" value="$CookieUser"/>
	<pp:else/>
		<pp:var name="tmpUser" value="@getSessionID()"/>
		{@writeCookie($tmpUser)}
	</pp:if>
<pp:else/>
	<pp:var name="tmpUser" value="$name"/>
</pp:if>

<cms action="sql" return="headCartList" query="SELECT count(*) as countRows FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC" />

<div class="head">

<!--attention-->
	<div class="attention">
		<ul class="fr">
			<pp:if expr="$action=='shop' and $method=='goodsDetail'">
				<pp:if expr="$headCartList.data.0.countRows>1">
					<li id="item"><a href="###"><span id="headerNewCartCount">[$headCartList.data.0.countRows]</span> Items</a></li>
				<pp:elseif expr="$headCartList.data.0.countRows>=0">
					<li id="item"><a href="###"><span id="headerNewCartCount">[$headCartList.data.0.countRows]</span> Item</a></li>				
				</pp:if>
			<pp:else/>
				<pp:if expr="$headCartList.data.0.countRows>1">
					<li id="item"><a href="###"><span id="headerNewCartCount">[$headCartList.data.0.countRows]</span> Items</a></li>
				<pp:elseif expr="$headCartList.data.0.countRows>0">
					<li id="item"><a href="###"><span id="headerNewCartCount">[$headCartList.data.0.countRows]</span> Item</a></li>
				<pp:elseif expr="$headCartList.data.0.countRows=0">
					<li id="item"><a href="###"><span id="headerNewCartCount">[$headCartList.data.0.countRows]</span> Item</a></li>
				</pp:if>
			</pp:if>
                        <li class="app"><a href="#" id="headApp" onclick="loadCart();">app</a></li>
                        <li class="facebook"><a href="#">facebook</a></li>
                        <li class="sns"><a href="#">sns</a></li>
                        <li class="google"><a href="#">G+</a></li>
		</ul> 
	</div>

	<!--logo-->
	<div class="logoLogin clb">
		<pp:if expr="$action=='shop'">
			<h1 class="logo fl"><a href="../index.php"><img src="/skin/images/logo.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>		
		<pp:elseif expr="$action=='surprise'">
			<h1 class="logo fl"><a href="../index.php"><img src="/skin/images/surpriseLogo.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
		<pp:elseif expr="$action=='website'">
			<pp:if expr="$method=='shopindex'">
				<h1 class="logo fl"><a href="../index.php"><img src="/skin/images/logo.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
			<pp:elseif expr="$method=='surpriseindex'">
				<h1 class="logo fl"><a href="../index.php"><img src="../skin/images/surpriseLogo.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
			<pp:elseif expr="$method=='shareindex'">
				<h1 class="logo fl"><a href="../index.php"><img src="/skin/images/logo01.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
			<pp:else/>
				<h1 class="logo fl"><a href="../index.php"><img src="/skin/images/logo01.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
			</pp:if>
		<pp:elseif expr="$action=='account' or $action=='share' or $action=='help'  or $action=='admin'">
			<h1 class="logo fl"><a href="../index.php"><img src="../skin/images/logo01.jpg" alt="WOWO FIND ONLINESHOP IN CHINA"/></a></h1>
		</pp:if>

		<!--login-->
		<pp:if expr="$name==''">
			<div class="login fr">
				<pp:if expr="$action=='website'">
					<pp:if expr="$method=='surpriseindex' or $method=='shopindex' or $method=='shareindex'">
						<form  name="logoutForm" action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="headerLogin">
							<input type="hidden" name="backUrl" value="[@url2str($IN)]">
							<ul>
								<li><label>EMAIL</label><input type="text"  name="staffNo"  value="" class="text"/></li>
								<li class="password"><label>PASSWORD</label><input  type="password" name="password" value="" class="text"/></li>
								<li id="loginBtn"><input type="submit" value="Login"/></li>
								<li id="check"><input type="checkbox">&nbsp;Keep me logged  in<span><a href="/publish/index.php[@encrypt_url('action=website&method=forgetPassword')]">Forget your password?</a></span></li>
								<li id="sign"><a href="/publish/index.php[@encrypt_url('action=website&method=registerUser')]">SIGN ME UP</a></li>
							</ul>
						</form>				
					</pp:if>
				<pp:else/>
					<form  name="logoutForm" action="/publish/index.php" method="post">
						<input type="hidden" name="action" value="website">
						<input type="hidden" name="method" value="headerLogin">
						<input type="hidden" name="backUrl" value="[@url2str($IN)]">
    						<ul>
    							<li><label>EMAIL</label><input type="text"  name="staffNo"  value="" class="text"/></li>
    							<li class="password"><label>PASSWORD</label><input  type="password" name="password" value="" class="text"/></li>
    							<li id="loginBtn"><input type="submit" value="Login"/></li>
    							<li id="check"><input type="checkbox">&nbsp;Keep me logged  in<span><a href="/publish/index.php[@encrypt_url('action=website&method=forgetPassword')]">Forget your password?</a></span></li>
							<li id="sign"><a href="/publish/index.php[@encrypt_url('action=website&method=registerUser')]">SIGN ME UP</a></li>
    						</ul>
    					</form>

				</pp:if>
    				</div>
		<pp:else/>
			<pp:var name="userInfo" value="@getStaffInfoById($tmpUser)"/>
			<div class="logout fr">		   
				<dl class="welcome fr">
				       <dt>
					   <span>Welcome !<br></span>
					   <a href="###">[$userInfo.0.staffName]</a>
				      </dt>
					<dd class="loginBtn">
					      <form  name="logoutForm" action="/publish/index.php" method="post">
							<input type="hidden" name="action" value="website">
							<input type="hidden" name="method" value="logout">
							<input type="hidden" name="backUrl" value="[@url2str($IN)]">
							<input type="submit" value="Log out" />
							<!--<a href="/publish/index.php[@encrypt_url('action=website&method=logout')]">LOG OUT</a>-->
						</form>
				       </dd>
				</dl>
			</div>
		</pp:if>
	</div>

	<!--menu button-->
	<pp:if expr="$action=='admin'">
	<div class="menu clb">
		<ul>
		<li><a href="../index.php">HOME</a></li>
		<li><a href="/publish/index.php[@encrypt_url('action=admin&method=order')]">ORDER</a></li>
		<li><a href="/publish/index.php[@encrypt_url('action=admin&method=goodsDetail')]">ADD GOODS</a></li>
		<li><a href="/publish/index.php[@encrypt_url('action=admin&method=taobaoLink')]">TAOBAO LINK</a></li>
	 </ul>
	</div>
	<pp:else/>
	<div class="menu clb">
		<ul>
			    <li><a href="../index.php">HOME</a></li>
			<pp:if expr="$action=='shop' or $method=='shopindex'">
			    <li id="shoppingHover">
			<pp:else/>
				<li>
			</pp:if><a href="/publish/index.php[@encrypt_url('action=website&method=shopindex')]">SHOPPING</a></li>
			<pp:if expr="$action=='share' or $method=='shareindex'">
			    <li id="sharetalkHover">
			    <pp:else/>
			    <li>
			    </pp:if><a href="/publish/index.php[@encrypt_url('action=website&method=shareindex')]">SHARETALK</a></li>
			<pp:if expr="$action=='surprise' or $method=='surpriseindex'">
			    <li id="surpriseHover" class="borderNone">
			    <pp:else/>
			    <li class="borderNone">
			    </pp:if>
			    <a href="/publish/index.php[@encrypt_url('action=website&method=surpriseindex')]">SURPRISE</a></li>
	    </ul>
	</div>
	</pp:if>

</div>
<pp:if expr="$action=='share'">
	<div class="sharemain clb">
		<pp:if expr="$name!=''">
		       <ul class="shareNav">
			 <li><a href="index.php[@encrypt_url('action=share&method=myShare')]">MY SHARE</a></li>
			 <li><a href="#">YOURFRIENDS</a></li>
			 <li><!--<a href="index.php[@encrypt_url('action=share&method=wishList')]">FRESH WISHS</a>--></li>
			 <li><!--<a href="index.php[@encrypt_url('action=share&method=links')]">LINKS ON TAOBAO</a></li>-->
			 <li>
			 <form name='orderButton' action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="share">
				<input type="hidden" name="method" value="order">			
				<input type="submit" value="SHARE WHAT YOU BOUGHT" class="shareBtn"/></li>
			</form>
		       </ul>
		</pp:if>
<pp:elseif expr="$action=='website' and $method=='shareindex'">
	<div class="sharemain clb">
		<pp:if expr="$name!=''">
		       <ul class="shareNav">
			 <li><a href="index.php[@encrypt_url('action=share&method=myShare')]">MY SHARE</a></li>
			 <li><a href="#">YOURFRIENDS</a></li>
			 <!--<li><a href="index.php[@encrypt_url('action=share&method=wishList')]">FRESH WISHS</a></li>
			 <li><a href="index.php[@encrypt_url('action=shop&method=taobaoLink')]">LINKS ON TAOBAO</a></li>
			 <li>
			 <form name='orderButton' action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="share">
				<input type="hidden" name="method" value="order">			
				<input type="submit" value="SHARE WHAT YOU BOUGHT" class="shareBtn"/></li>
			</form>-->
			<li><a href="index.php[@encrypt_url('action=share&method=order')]"  class="shareBtn">SHARE WHAT YOU BOUGHT</a></li>
		       </ul>
		</pp:if>	
</pp:if>
<cms action="sql" return="cartInfo" query="SELECT sum(a.ItemQTY) as ItemQTY,sum(a.ItemQTY*b.goodsUnitPrice+b.goodsFreight) as totalPrice  FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC" />

<cms action="sql" return="cartList" query="SELECT * FROM a0222211743.cms_publish_cart a,a0222211743.cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'New' Order By a.cartid DESC" />	

<pp:var name="SubTotalPrice" value="0"/>			
<pp:var name="cartListNum" value="5"/>
<pp:var name="SubTotalPrice" value="number_format($cartInfo.data.0.totalPrice, 2, '.', ',')"/>

<pp:var name="cartIDstr_tmp" value="''"/>
<pp:var name="cartNum" value="sizeof($cartList.data)"/>

<loop name="cartList.data" var="var" key="key">
	<pp:if expr="$cartIDstr_tmp">
		<pp:var name="cartIDstr_tmp" value="$cartIDstr_tmp . ',' . $var.cartID"/>
	<pp:else/>
		<pp:var name="cartIDstr_tmp" value="$var.cartID"/>
	</pp:if>
</loop>	

<!--弹出框1-->

<div id="dataStr" style="display:none">
	<div class="viewShoppingBag">
		<h2 class="viewShoppingBagHead">
			View shopping bag
			<a href="#" class="close fr textHide mr12" id="close">close</a>
			<span>Subtotal: [$SubTotalPrice]</span>
		</h2>
		<div class="viewShoppingBagCont" id="loadStr1">
			<span class="loading"><img src="/skin/images/loading.gif" alt="loading"></span>
			<span class="viewShoppingBagContp">LOADING SHOPPING BAG</span>
		</div>

		<div class="viewShoppingBagCont" id="dataStr1" style="display:none">
			<p>Note: Items and promotional pricing not reserved until checkout is completed</p>
			<span>[$cartInfo.data.0.ItemQTY] items in your bag</span>
			<loop name="cartList.data" var="var" key="key">   
				<pp:if expr="$cartIDstr_tmp">
					<pp:var name="cartIDstr_tmp" value="$cartIDstr_tmp . ',' . $var.cartID"/>
				<pp:else/>
					<pp:var name="cartIDstr_tmp" value="$var.cartID"/>
				</pp:if>

				<pp:if expr="$key<$cartListNum">
					<dl>
						<dt class="fl">
						<pp:if expr="$var.goodsType=='inside'">		    
		    <img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="小图1" style="width:75px;height:93px" border="0">
		<pp:elseif expr="$var.goodsType=='outside'">
		    <img src="[$var.goodsImgURL]" alt="小图1" style="width:75px;height:93px" border="0">
		</pp:if>
						</dt>
						<pp:if expr="$var.goodsTitleCN">
						<dd><strong>[$var.goodsTitleCN]</strong></dd>
						</pp:if>
						<pp:if expr="$var.goodsTitleEn">
						<dd><strong>[$var.goodsTitleEn] </strong></dd>
						</pp:if>
					       <!--<dd>Item: BGS12_B1LLD</dd>-->
					       <pp:var name="SinglePrice" value="number_format($var.goodsUnitPrice, 2, '.', ',')"/>
					       <dd>Price:￥ [$SinglePrice]</dd>
					       <dd>Qty: [$var.ItemQTY]</dd>
					       <dd><pp:if expr="$var.itemSize">Size: [$var.itemSize]</pp:if>
					       <pp:if expr="$var.itemColor"><span class="pageContentColor">Color:[$var.itemColor]</span></pp:if></dd>
						<pp:if expr="$var.goodsType=='inside'"><dd class="wowService">WOW SURPRISE SERVICE</dd></pp:if>
						<dd>Seller Freit : <pp:if expr="$var.goodsFreight<=0">NO<pp:else/><pp:var name="Freight" value="number_format($var.goodsFreight, 2, '.', ',')"/>[$Freight]</pp:if></dd>
					</dl>
					<br>
				</pp:if>
			</loop>
			</div>
			<form action="/publish/index.php" method="post" id="actionForm">
				<input type="hidden" name="action" value="shop">
				<input type="hidden" name="method" value="releaseOrder">
				<input type="hidden" name="para[cartIDstr]" value="[$cartIDstr_tmp]">
				<input type="hidden" name="para[orderUser]" value="[$userName]">
				<div class="viewShoppingBagfoot">
					<a href="index.php[@encrypt_url('action=website&method=shopindex')]" class="btn fl buyMore">Buy More</a>
					<!--<a href="javascript:javascript:void(0)" onclick="$('#actionForm').submit();" class="btn fl checkout">Checkout</a>-->
					<a href="index.php[@encrypt_url('action=shop&method=myCart')]" class="btn fl checkout">Checkout</a>
				</div>
			</form>
		</div>
	</div>
</div>	