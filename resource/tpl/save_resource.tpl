<pp:include file="isLogin" type="tpl"/>
<pp:if expr="$method=='saveResource'">
	<pp:memfunc funcname="addResource($IN.para,$fileFolder)"/>
	<pp:include file="frameListResource.tpl" type="tpl"/>
<pp:elseif expr="$method=='selectResource'">
	<pp:var name="url" value="<pp:memfunc funcname="selectResource($resourceId)"/>"/>
		<pp:if expr="$isText==''">
			<pp:memfunc funcname="modifyUrl($resourceId)"/>
			<script >window.top.close();</script>
		<pp:else/>
			<script >window.top.opener.document.getElementById('headImageUrl').value = '[$url]';window.top.opener.document.getElementById('resourceId').value = '[$resourceId]';window.top.close();</script>
		</pp:if>
<pp:else/>
	<pp:memfunc funcname="delResource({$resourceId})"/>
	<pp:include file="frame_list_resource.tpl" type="tpl"/>
</pp:if>