<pp:if expr="$method=='addGoods'">	
	
	<pp:appfunc app="publish" file="./appfunc/taobao_interface" return="result" funcname="GetGoodsInfo($IN.GoodsURL)"/>
	<!--<pp:var name="result" value="<pp:memfunc funcname="GetGoodsInfo($IN.GoodsURL)"/>"/>-->
	<pp:var name="backUrl" value="'action=shop&method=linkTest&grapRst=alert'"/>
	
	<pp:if expr="$result=='-1'">			
		
		<script>location.href="index.php[@encrypt_url($backUrl . '&alertContent=Please check the link you input!')]"</script>
	<pp:elseif expr="!is_array($result)">
		<script>location.href="index.php[@encrypt_url($backUrl . '&alertContent=Please Input the right Link at first!')]"</script>		
	<pp:else/>
		<pp:if expr="!is_array($result.img)">
			<script>location.href="index.php[@encrypt_url($backUrl . '&alertContent=Can not get the image!')]"</script>
		<pp:else/>
			

			<pp:if expr="$result.title<0">
				<pp:var name="titleCN" value="'0'"/>
			<pp:else/>
				<pp:var name="titleCN" value="$result.title"/>
			</pp:if>
			<pp:if expr="$result.price<0">
				<pp:var name="price" value="'0'"/>
			<pp:else/>
				<pp:var name="price" value="$result.price"/>
			</pp:if>
			<pp:if expr="$result.postage<15">
				<pp:var name="postage" value="'15'"/>
			<pp:else/>
				<pp:var name="postage" value="$result.postage"/>
			</pp:if>
			
			<!--<loop name="result.img" var="var" key="key">
			<pp:if expr="$key==0">
			<pp:var name="para.goodsImgURL" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
			<pp:elseif expr="$key==1">
			<pp:var name="para.goodsImgURL1" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
			<pp:elseif expr="$key==2">
			<pp:var name="para.goodsImgURL2" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
			<pp:elseif expr="$key==3">
			<pp:var name="para.goodsImgURL3" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
			</pp:if>
			</loop>	-->

			

			<loop name="result.img" var="var" key="key">
				<pp:if expr="$key==0">
					<pp:if expr="$key<$IN.imgQty">
						<pp:var name="para.goodsImgURL" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
					<pp:else/>
						<pp:var name="para.goodsImgURL" value="$var['url']"/>
					</pp:if>
				<pp:elseif expr="$key==1">
					<pp:if expr="$key<$IN.imgQty">
						<pp:var name="para.goodsImgURL1" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
					<pp:else/>
						<pp:var name="para.goodsImgURL1" value="$var['url']"/>
					</pp:if>
				<pp:elseif expr="$key==2">
					<pp:if expr="$key<$IN.imgQty">
						<pp:var name="para.goodsImgURL2" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
					<pp:else/>
						<pp:var name="para.goodsImgURL2" value="$var['url']"/>
					</pp:if>
				<pp:elseif expr="$key==3">
					<pp:if expr="$key<$IN.imgQty">
						<pp:var name="para.goodsImgURL3" value="@addImageToResource($var['url'] . '_310x310.jpg','taobao')"/>
					<pp:else/>
						<pp:var name="para.goodsImgURL3" value="$var['url']"/>
					</pp:if>
				</pp:if>
			</loop>

			<pp:var name="nodeId" value="@getGlobalModelVar('outsideGoodsNode')"/>
			<pp:var name="node" value="@getNodeInfoById($nodeId)"/>

			<pp:var name="contentModel" value="$node.0.appTableName"/>
			<pp:var name="para.nodeId" value="$node.0.nodeGuid"/>
			
			<pp:var name="para.goodsStatus" value="'Open'"/>
			<pp:var name="para.goodsType" value="'outside'"/>

			<pp:var name="para.goodsUnitPrice" value="$price"/>
			<pp:var name="para.goodsFreight" value="$postage"/>
			<pp:var name="para.goodsTitleCn" value="$titleCN"/>	
			<pp:var name="para.goodsURL" value="$IN.GoodsURL"/>				

			<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
			<pp:if expr="$name">
				<pp:var name="para.goodsAddUser" value="$name"/>
			<pp:else/>	
				<pp:var name="para.goodsAddUser" value="@readCookie()"/>	
				
			</pp:if>				
			
			<pp:var name="addGoodsTable" value="@addData($nodeId,$contentModel,$para)"/>	
			<pp:if expr="$addGoodsTable">
				
					<script>
					alert("Succeed to grab the page you want to buy, please fill the form bellow!");			
					location.href='index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $addGoodsTable .'&imgQTY=' . $IN.imgQty)]'
					</script>				
			<pp:else/>
				<script>alert("An error has occurred, the items you choosed is possibly sold out .");location.href='index.php[@encrypt_url($backUrl)]'</script>
			</pp:if>
			
		</pp:if>
		
	</pp:if>
</pp:if>