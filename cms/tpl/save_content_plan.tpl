<pp:if expr="$method=='saveAddContentPlan'">
<pp:var name="contentPlanId" value="<pp:memfunc funcname="addContentPlanInfo($IN.para)"/>"/>
<pp:var name="tempUrl" value="'action=cms&method=listContentPlan'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='saveEditContentPlan'">
<pp:memfunc funcname="editContentPlanInfo($contentPlanId,$IN.para)"/>
<pp:var name="tempUrl" value="'action=cms&method=listContentPlan'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
<pp:elseif expr="$method=='delContentPlan'">
<pp:memfunc funcname="delContentPlanInfo($contentPlanId)"/>
<pp:var name="tempUrl" value="'action=cms&method=listContentPlan'"/>
<script>location.href='index.php[@encrypt_url($tempUrl)]'</script>
</pp:if>