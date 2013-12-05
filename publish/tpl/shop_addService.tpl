<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">			
		<pp:var name="tmpUser" value="@readCookie()"/>		
<pp:else/>
	<pp:var name="tmpUser" value="$name"/>
</pp:if>

<cms action="sql" return="listOrder" query="SELECT * FROM a0222211743.cms_publish_order WHERE orderID='{$IN.orderID}' limit 1" />

<pp:if expr="$method=='addService' and $listOrder.data.0.orderUser==$tmpUser">
	<pp:var name="serviceName" value="1"/>
	<!--
	<cms action="sql" return="updateOrderService" query="UPDATE a0222211743.cms_publish_order SET serviceName = '{$IN.para.serviceName}',orderStatus='1' WHERE orderID = '{$IN.para.orderID}' " />-->
	<cms action="sql" return="updateOrderService" query="UPDATE a0222211743.cms_publish_order SET serviceName = '{$serviceName}',orderStatus='1' WHERE orderID = '{$IN.orderID}' " />
	<pp:if expr="$updateOrderService">
		
		<!--<pp:if expr="$IN.para.serviceName=='2'">
			<pp:var name="tempUrl" value="'action=shop&method=WOWcollect&orderID=' . $IN.para.orderID"/>		
		<pp:elseif expr="$IN.para.serviceName=='1'">
			<pp:var name="tempUrl" value="'action=shop&method=WOWd2d&orderID=' . $IN.para.orderID"/>
		<pp:elseif expr="$IN.para.serviceName=='3'">
			<pp:var name="tempUrl" value="'action=shop&method=WOWd2d&orderID=' . $IN.para.orderID"/>
		</pp:if>-->
		<pp:var name="tempUrl" value="'action=shop&method=WOWd2d&orderID=' . $IN.orderID"/>
		<script>location.href='index.php[@encrypt_url($tempUrl)] '</script>
	</pp:if>
<pp:else/>
	<script>alert("Failed to release order due to pass due temporary account!");location.href='index.php[@encrypt_url('action=shop&method=myCart')]'</script>
</pp:if>