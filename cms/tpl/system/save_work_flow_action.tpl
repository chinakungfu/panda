<pp:if expr="$method=='saveAddWorkFlowAction'">
	<pp:memfunc funcname="addWorkFlowAction($IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowAction'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditWorkFlowAction'">
	<pp:memfunc funcname="editWorkFlowAction($flowActionId,$IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowAction'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delWorkFlowAction'">
	<pp:memfunc funcname="delWorkFlowAction($flowActionId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowAction'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>