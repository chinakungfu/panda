
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Cart</title>
	<link rel="stylesheet" href="[@getGlobalModelVar('Site_Domain')]skin/css/style.css"/>
	<script type="text/javascript" src="[@getGlobalModelVar('Site_Domain')]skin/js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="[@getGlobalModelVar('Site_Domain')]skin/js/jquery.pngFix.js"></script>
	<script type="text/javascript">
		 $(document).ready(function(){ 
				$(document).pngFix(); 
			}); 
	</script>
</head>
<body>
	<pp:include file="common/header/red_header.tpl" type="tpl"/>
	<div class="wow-body">
		<div class="wow-body-contain">
			<pp:include file="common/header/top_guide.tpl" type="tpl"/>>
			<pp:include file="common/wow_left.tpl" type="tpl"/>
				
			<div class="line2-full left">				
				
				<h3 id="wl-title" class="wow-module-title sec-title">
					WISH LIST
				</h3>
				<table class="itable" cellpadding=0 cellspacing=0>
					<tr>
						<th width="50%" align="left">Item to buy</th>
						<th width="16%"></th>
						<th width="16%" align="center"></th>
						<th width="16%" align="center"></th>
					</tr>
					<cms action="list" return="cartList" nodeid="{$nodeId}" where="c.UserName ='{$name}' and c.ItemStatus='Wish'" OrderBy="i.publishDate DESC" num="3"/>
					<loop name="cartList.data" var="var" key="key">
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
					<tr>
						<td>
							<img class="left item-view-s" src="[$var.IMGURL]" alt=""/>
							<span class="left item-name">[$var.ItemName]</span>
						</td>
						<td>
							<a class="ce" href="">delete</a> <a class="ce" href="[@getGlobalModelVar('Site_Domain')]publish/index.php[@encrypt_url('action=wow&method=WishToCart&nodeId=71&cartID=' .$var.cartID)]" >move to cart</a>
						</td>
						<td align="center">RMB [$var.ItemUnitPrice]</td>
						<td align="center">
							
						</td>
					</tr>
					</loop>
					<tr>
						<td class="dashed-td" colspan="4">
							<div class="dashed-line"></div>
						</td>
					</tr>
				</table>
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