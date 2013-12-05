<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<pp:if expr="$method=='saveMultFiles'">
	<pp:if expr="$resourceId==''">
		<pp:var name="resourceIdArray" value="<pp:memfunc funcname="addMultFiles($IN.para,$fileFolder)"/>"/>
		<pp:if expr="$resourceId=='disableFile'">
			<script >alert('不能传php类型文件！');window.history.back();</script>
		<pp:elseif epxr="">
			<script >alert('上传失败！');window.history.back();</script>
		<pp:else/>
			<!--<pp:var name="url" value="<pp:memfunc funcname="selectResource($resourceIdArray)"/>"/>-->
			<pp:var name="resourceIdStr" value="''"/>
			<loop name="resourceIdArray"  var="var" key="key">
				<pp:var name="resourceIdStr" value="$var . ',' . $resourceIdStr"/>
			</loop>
			<pp:var name="resourceIdStr" value="substr($resourceIdStr,0,-1)"/>
			<script >window.opener.document.getElementById('[$resourceUrl]').value = '[$resourceIdStr]';window.top.close();</script>		
		</pp:if>
	</pp:if>
</pp:if>
