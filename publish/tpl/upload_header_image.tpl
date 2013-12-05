<pp:if expr="$operaterType==0">
	<cms action="sql" return="delGoodsImgInfo" query="delete from cms_publish_goods_img where Id='{$goodsImgId}'" />
	<cms action="sql" return="delResourceInfo" query="delete from cms_resource_resource where resourceId='{$resourceId}'" />
	<cms action="sql" return="goodsImgList" query="select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$goodsId}'"/>
	<pp:var name="json_str" value="json_encode($goodsImgList)"/>
	[$json_str]
<pp:else/>
	<pp:var name="resourceId" value="<pp:memfunc funcname="addResource($para,$fileFolder,1,$maxFileSize)"/>"/>
	<pp:if expr="$resourceId=='tooMax'">
		[$resourceId]
	<pp:else/>
		<pp:if expr="$resourceId">
			<pp:var name="url" value="<pp:memfunc funcname="selectResource($resourceId)"/>"/>
			<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
			<pp:if expr="$goodsId!=''">
				<pp:if expr="$goodsId!=-1">
					<pp:var name="dateTime" value="time()"/>
					<cms action="sql" return="insertGoodsInfo" query="insert into cms_publish_goods_img (resourceId,goodsId,imgUrl,createUserId,createDateTime) values ('{$resourceId}','{$goodsId}','{$url}','{$name}','{$dateTime}')" />
					<cms action="sql" return="goodsImgList" query="select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$goodsId}'"/>
					<pp:var name="json_str" value="json_encode($goodsImgList)"/>
					[$json_str]
				<pp:else/>
					[$url]					
				</pp:if>
			<pp:else/>
				[$url]
				<cms action="sql" return="upUserInfo" query="update cms_member_staff set headImageUrl='{$url}' where staffId='{$name}'" />
			</pp:if>
		<pp:else/>
		
		</pp:if>
	</pp:if>
		
</pp:if>