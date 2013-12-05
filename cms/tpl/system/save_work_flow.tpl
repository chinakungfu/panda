<pp:if expr="$method=='saveAddWorkFlow'">
	<pp:memfunc funcname="addWorkFlow($IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowListFrame'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditWorkFlow'">
	<pp:memfunc funcname="editWorkFlow($flowId,$IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowListFrame'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delWorkFlow'">
	<pp:memfunc funcname="delWorkFlow($flowId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowListFrame'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>