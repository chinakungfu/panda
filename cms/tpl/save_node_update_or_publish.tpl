<pp:if expr="$method=='saveNodeUpdate'">
	<pp:memfunc funcname="saveNodeUpdate($nodeId,'0',$counter,$subNode,$IN.para)"/>
	<script>window.close();</script>
<pp:elseif expr="$method=='saveNodePublish'">
	<pp:memfunc funcname="saveNodePublish($nodeId,'0',$counter,$subNode,$IN.para,$isMandatory)"/>
	<script>window.close();</script>
</pp:if>