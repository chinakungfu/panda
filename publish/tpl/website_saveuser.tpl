<pp:if expr="$method=='addUser'">
	<pp:var name="checkData" value="<pp:memfunc funcname="checkSignupData($IN.para)"/>"/>
	
	<pp:if expr="$checkData==1">
		<pp:var name="signPara.staffNo" value="$IN.para.staffNo"/>
		<pp:var name="signPara.password" value="$IN.para.password"/>
		<pp:var name="signPara.safetyQuestion" value="$IN.para.safetyQuestion"/>
		<pp:var name="signPara.questionResult" value="$IN.para.questionResult"/>
		
		
		<pp:var name="result1" value="<pp:memfunc funcname="addStaff($signPara)"/>"/>
		<pp:if expr="$result1">
			<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
			<pp:if expr="$IN.signUpType=='order'">
				<pp:var name="mailArr.verifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateUser&staffId=' . $result1 . '&signUpType=' . $IN.signUpType . '&orderID=' . $IN.orderId)" />
			<pp:elseif expr="$IN.signUpType=='signUp'">
				<pp:var name="mailArr.verifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateUser&staffId=' . $result1)" />
			</pp:if>
			<pp:var name="mailArr.userId" value="$result1" />
			<pp:var name="result" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>
			<pp:if expr="$result">
					<script>location.href="index.php[@encrypt_url('action=website&method=registerOk&email=' . $IN.para.staffNo)]"</script>
			<pp:else/>
				<script>alert('Mail Fail');location.href="index.php[@encrypt_url('action=website&method=index')]"</script>
			</pp:if>
			
		</pp:if>
		
	<pp:else/>	
		<!--<?php print_r($this->_tpl_vars["checkData"]);?>
		<br>
		<br>
		-->
		<pp:var name="backData" value="<pp:memfunc funcname="backSignupData($IN.para,$checkData)"/>"/>
		
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>
	</pp:if>
	
<pp:elseif expr="$method=='validateUser'">
	<pp:var name="result" value="<pp:memfunc funcname="validateStaff($IN.staffId)"/>"/>
	
	<pp:if expr="$IN.signUpType=='Order'">		
		<cms action="sql" return="orderList" query="select * from cms_publish_order  WHERE orderID= '{$IN.orderID}' limit 1"/>

		<cms action="sql" return="updateOrderUser" query="update cms_publish_order SET orderUser= '{$IN.staffId}' WHERE orderID= '{$IN.orderID}'"/>
		<cms action="sql" return="updateAddressUser" query="update cms_publish_address SET userId= '{$IN.staffId}' WHERE addressId= '{$orderList.data.0.orderAddress}'"/>
		<cms action="sql" return="updateCartUser" query="update cms_publish_cart SET UserName= '{$IN.staffId}' WHERE cartID in ('{$orderList.data.0.cartIDstr}')"/>
	</pp:if>	
	<pp:if expr="$result">
		<pp:session funcname="writeSession($IN.staffId)"/>
		<script>location.href="index.php[@encrypt_url('action=website&method=verificationOk&staffId=' . $IN.staffId)]"</script>
	</pp:if>
<pp:elseif expr="$method=='validateChangeUser'">
	<pp:var name="result" value="<pp:memfunc funcname="validateStaff($IN.staffId)"/>"/>
	
	<pp:if expr="$IN.signUpType=='Order'">		
		<cms action="sql" return="orderList" query="select * from cms_publish_order  WHERE orderID= '{$IN.orderID}' limit 1"/>

		<cms action="sql" return="updateOrderUser" query="update cms_publish_order SET orderUser= '{$IN.staffId}' WHERE orderID= '{$IN.orderID}'"/>
		<cms action="sql" return="updateAddressUser" query="update cms_publish_address SET userId= '{$IN.staffId}' WHERE addressId= '{$orderList.data.0.orderAddress}'"/>
		<cms action="sql" return="updateCartUser" query="update cms_publish_cart SET UserName= '{$IN.staffId}' WHERE cartID in ('{$orderList.data.0.cartIDstr}')"/>
	</pp:if>	
	<pp:if expr="$result">
		<pp:session funcname="writeSession($IN.staffId)"/>
		<script>location.href="index.php[@encrypt_url('action=website&method=verificationOk&staffId=' . $IN.staffId)]"</script>
	</pp:if>
<pp:elseif expr="$method=='delData'">
	<pp:memfunc funcname="delStaff($selectConId)"/>
<pp:elseif expr="$method=='resetPassword'">
	<pp:if expr="$IN.answer==''">
		<script>location.href="index.php[@encrypt_url($IN.backUrl . '&alertStr=2' )]"</script>
	<pp:else/>
		<pp:var name="checkData" value="<pp:memfunc funcname="verifySafty($IN.userId,$IN.safetyQuestion,$IN.answer)"/>"/>
		<pp:if expr="$checkData">
			<pp:var name="randomPassword" value="<pp:memfunc funcname="generate_rand('8')"/>"/>
			<pp:var name="changePara.password" value="$randomPassword"/>
			<pp:var name="result" value="<pp:memfunc funcname="editStaff($IN.userId,$changePara)"/>"/>

			<pp:if expr="$result=='1'">
			
				<pp:var name="mailArr.userId" value="$IN.userId" />
				<pp:var name="mailArr.newPwd" value="$randomPassword" />
				<pp:var name="resultMail" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>
				
				<pp:if expr="resultMail">
					<script>alert("Edit Successfully!");location.href="index.php[@encrypt_url('action=website&method=resetPwdOk&staffId=' . $IN.userId)]"</script>
				<pp:else/>
					<script>alert('Mail Fail');location.href="index.php[@encrypt_url($IN.backUrl)]"</script>
				</pp:if>
				
			<pp:else/>
				<script>alert("Edit failed!");location.href='index.php[@encrypt_url($IN.backUrl)]'</script>
			</pp:if>
		<pp:else/>
			<script>location.href="index.php[@encrypt_url($IN.backUrl . '&alertStr=1' )]"</script>
		</pp:if>
	</pp:if>
</pp:if> 