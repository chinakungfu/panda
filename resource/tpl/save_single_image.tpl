<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:if expr="$method=='saveSingleImage'">
	<pp:if expr="$resourceId==''">
		<pp:var name="resourceId" value="<pp:memfunc funcname="addResource($IN.para,$fileFolder)"/>"/>
		<pp:if expr="$resourceId=='disableFile'">
			<script >alert('不能传php类型文件！');window.history.back();</script>
		<pp:elseif epxr="">
			<script >alert('上传失败！');window.history.back();</script>
		<pp:else/>
			<pp:var name="url" value="<pp:memfunc funcname="selectResource($resourceId)"/>"/>
			<script >window.opener.document.getElementById('[$resourceUrl]').value = '[$url]';window.top.close();</script>		
		</pp:if>
	</pp:if>
</pp:if>
