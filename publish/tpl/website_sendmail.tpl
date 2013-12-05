<!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name!=''">
	<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
	<pp:var name="VerifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateUser&staffId=' . $name)" />
	<pp:var name="result" value="<pp:memfunc funcname="sendVerifyMail($name,$VerifyLink)"/>"/>	

	<pp:if expr="$result">
		<script>alert('Successfully！');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
		<pp:else/>
		<script>alert('Fail！');location.href="index.php[@encrypt_url('action=website&method=surpriseindex')]"</script>
	</pp:if>
</pp:if>-->
<cms action="node" return="node" nodeid="{$IN.nodeId}"/>
<!DOCTYPE HTML>
<html>
<head>
<pp:include file="common/header/common_header.tpl" type="tpl"/>
</head>
<body>
<!--最外框-->
<div class="box">
	<!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
			
			<!--content info-->
			<div class="surprise clb">
				<pp:include file="common/surprise_category.tpl" type="tpl"/>
				<div class="surpriseContent fl">
					<pp:var name="titleLeft" value="substr($node.nodeName, 0,9)" />
					<pp:var name="titleRight" value="substr($node.nodeName,10)" />
				    <h2>[$titleLeft] <span>[$titleRight]</span></h2>
				
				    <div class="surpriseContInfo clb">	
				        <dl>	
					    <dd><a href="/publish/index.php[@encrypt_url('action=mailtest&method=signup')]">Sign up mail</a></dd>					    
					</dl>
					<dl>					    
					    <dd><a href="/publish/index.php[@encrypt_url('action=mailtest&method=changeMail&goodsID=' . $var.goodsid )]">change mail account</a></dd>					    
					</dl>
					<dl>	
					    <dd><a href="/publish/index.php[@encrypt_url('action=mailtest&method=orderSubmit&orderID=1')]">Order Information</a></dd>    
					</dl>
					<dl>	
					    <dd><a href="/publish/index.php[@encrypt_url('action=mailtest&method=resetPassword')]">Reset Password</a></dd>    
					</dl>
                        
				    </div>
				</div>
			</div>
			
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>