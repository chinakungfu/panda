<div class="surpriseLeft fl">
	<h2>FIND<span>GIFTS FOR ...</span></h2>
	<ul>
		<cms action="sql" return="surpriseSite" query="select * from cms_cms_site  where parentId = 'specialDHKg'"/>
		<loop name="surpriseSite.data" var="var" key="key">
			<pp:var name="urlArray" value="explode('?',$var.dynamicIndexUrl)"/>
			<li><a href="[$urlArray.0][@encrypt_url($urlArray[1] .'&nodeId=' . $var.nodeGuid )]">[$var.nodeName]</a></li>
		</loop> 
	</ul>
	<!--<ul style="margin-top:48px">
		<li><a href="#">GIFT CARDS</a></li>
		<li><a href="#">GIFT BOOKS</a></li>
		<li><a href="index.php[@encrypt_url('action=website&method=sendmail')]">Mail Send Test</a></li>
	</ul>-->
</div>