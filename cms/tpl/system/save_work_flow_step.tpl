<pp:if expr="$method=='saveAddWorkFlowStep'">
	<pp:memfunc funcname="addWorkFlowStep($IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowStep'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditWorkFlowStep'">
	<pp:memfunc funcname="editWorkFlowStep($flowStepId,$IN.para)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowStep'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delWorkFlowStep'">
	<pp:memfunc funcname="delWorkFlowStep($flowStepId)"/>
	<pp:var name="tempUrl" value="'action=cms&method=workFlowStep'"/>
	<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>