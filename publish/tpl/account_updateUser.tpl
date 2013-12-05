<pp:if expr="$method=='updateUser'">	
	<pp:var name="checkData" value="<pp:memfunc funcname="checkChangeData($IN.para,'username')"/>"/>
	<pp:if expr="$checkData==1">
		<pp:var name="changePara.staffNo" value="$IN.para.staffNo"/>
		<pp:var name="changePara.groupName" value="'NoValidation'"/>
		<pp:var name="changePara.email" value="$IN.para.staffNo"/>

		<pp:var name="result" value="<pp:memfunc funcname="editStaff($IN.para.staffId,$changePara)"/>"/>
		<pp:if expr="$result=='1'">
			<pp:var name="siteNmae" value=" @getGlobalModelVar('Site_Domain')" />
			<pp:var name="mailArr.verifyLink" value=" $siteNmae . '/publish/index.php' . @encrypt_url('action=website&method=validateChangeUser&staffId=' . $IN.para.staffId)" />
			<pp:var name="mailArr.userId" value="$IN.para.staffId" />
			<pp:var name="mailArr.reStaffNo" value="$IN.para.staffNo" />
			<pp:var name="Mailresult" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>

			<pp:if expr="$Mailresult">
				<script>alert("Edit Successfully!");location.href='index.php[@encrypt_url($backUrl)]'</script>
			<pp:else/>
				<script>alert('Mail Fail');location.href="index.php[@encrypt_url($backUrl)]"</script>
			</pp:if>
		</pp:if>
		
	<pp:else/>
		<!--<?php print_r($this->_tpl_vars["checkData"]);?>
		<br>
		<br>
		-->
		<pp:var name="backData" value="<pp:memfunc funcname="backChangeData($IN.para,$checkData,'username')"/>"/>
		
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>
		
	</pp:if>
<pp:elseif expr="$method=='updatePassword'">
	<pp:var name="checkData" value="<pp:memfunc funcname="checkChangeData($IN.para,'password')"/>"/>
	<pp:if expr="$checkData==1">
		<pp:var name="changePara.password" value="$IN.para.newPassword"/>
			
		<pp:var name="result" value="<pp:memfunc funcname="editStaff($IN.para.staffId,$changePara)"/>"/>
		
		<pp:if expr="$result=='1'">
			<pp:var name="mailArr.userId" value="$IN.para.staffId" />
			<pp:var name="mailArr.newPwd" value="$IN.para.newPassword" />
			<pp:var name="resultMail" value="<pp:memfunc funcname="sendMail($mailArr,$method)"/>"/>
			
			<pp:if expr="resultMail">
				<script>alert("Edit Successfully!");location.href='index.php[@encrypt_url($backUrl)]'</script>
			<pp:else/>
				<script>alert('Mail Fail');location.href="index.php[@encrypt_url('action=website&method=index')]"</script>
			</pp:if>
			
		<pp:else/>
			<script>alert("Edit failed!");location.href='index.php[@encrypt_url($backUrl)]'</script>
		</pp:if>
		
	<pp:else/>
		<!--
		<?php print_r($this->_tpl_vars["checkData"]);?>
		<br>
		<br>
		-->
		<pp:var name="backData" value="<pp:memfunc funcname="backChangeData($IN.para,$checkData,'password')"/>"/>
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>
		
		
	</pp:if>
<pp:elseif expr="$method=='updateNickname'">
	<pp:var name="checkData" value="<pp:memfunc funcname="checkChangeData($IN.para,'nickname')"/>"/>
	<pp:if expr="$checkData==1">
		<pp:var name="changePara.staffName" value="$IN.para.staffName"/>
			
		<pp:var name="result" value="<pp:memfunc funcname="editStaff($IN.para.staffId,$changePara)"/>"/>
		
		<pp:if expr="$result=='1'">
			<script>alert("Edit Successfully!");location.href='index.php[@encrypt_url($backUrl)]'</script>
		<pp:else/>
			<script>alert("Edit failed!");location.href='index.php[@encrypt_url($backUrl)]'</script>
		</pp:if>
		
	<pp:else/>
		<!--
		<br>
		<?php print_r($this->_tpl_vars["checkData"]);?>
		<br>
		<br>
		-->
		<pp:var name="backData" value="<pp:memfunc funcname="backChangeData($IN.para,$checkData,'nickname')"/>"/>
		<!--
		<?php print_r($this->_tpl_vars["backData"]);?>
		<br>
		<br>
		-->
		<script>location.href="index.php[@encrypt_url($IN.backUrl . $backData )]"</script>
		
	</pp:if>
</pp:if>