<div class="foot clb">
			    
    <!--footNav-->
	<div class="footNav">
	    <a href="index.php[@encrypt_url('action=help&method=aboutUs')]">About</a> · 
	    Data Use Policy · Terms · <a href="index.php[@encrypt_url('action=help&method=main')]">Help</a>
	</div>
	
	<!--copyRight-->
	<div class="copyRight">
	    <span class="fr" style="margin-right:14px">WOWTAOBAO © 2012</span>
	    <ul>
		<!--<li><a href="#">THE STORE</a></li>-->
		<li id="aHover"><a href="index.php[@encrypt_url('action=website&method=account')]">YOUR ACCOUNT</a></li>
		<li><a href="index.php[@encrypt_url('action=shop&method=myCart')]">SHOPPING BAG</a></li>
		<pp:if expr="$userInfo.0.groupName=='administrator'">
			<li><a href="index.php[@encrypt_url('action=account&method=wishlist')]">WISHLIST</a></li>
			<li class="borderNone"><a href="index.php[@encrypt_url('action=admin&method=order')]">ADMINISTRATOR</a></li>
		<pp:else/>
			<li class="borderNone"><a href="index.php[@encrypt_url('action=account&method=wishlist')]">WISHLIST</a></li>
		</pp:if>
	    </ul>
	</div>
	
</div>