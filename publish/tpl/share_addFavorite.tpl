<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
	<pp:var name="paraArr.backAction" value="share"/>
	<pp:var name="paraArr.backMethod" value="addFavorite"/>
	<pp:var name="paraArr.shareID" value="$IN.shareID"/>	

	<pp:var name="paraStr" value="serialize($paraArr)"/>

	<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=addFriend&paraStr=' . $paraStr )]'</script>
<pp:else/>

	<cms action="sql" return="FavoriteNo" query="select count(favoriteId) as FavoriteNo  from cms_publish_favorite WHERE userId='{$name}' and shareId='{$IN.shareID}'" />
	<pp:if expr="$FavoriteNo.data.0.FavoriteNo>0">
		<script>alert('Already added.');location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>
		
	
	<pp:else/>
		<pp:var name="FavoriteNodeId" value="93"/>
		<pp:var name="FavoriteNode" value="@getNodeInfoById($FavoriteNodeId)"/>
		<pp:var name="FavoriteContentModel" value="$FavoriteNode.0.appTableName"/>

		<pp:if expr="$method=='addFavorite'">
			
			<pp:var name="FavoritePara.nodeId" value="$FavoriteNode.0.nodeGuid"/>
			<pp:var name="FavoritePara.userId" value="$name"/>	
			<pp:var name="FavoritePara.shareID" value="$IN.shareID"/>
			
			<?php date_default_timezone_set("prc");?>
			<pp:var name="FavoritePara.addTime" value="strtotime(date('Y-m-d H:i:s',time()))"/>
			
			<pp:var name="addFavoriteTable" value="@addData($FavoriteNodeId,$FavoriteContentModel,$FavoritePara)"/>		
			<pp:if expr="addFavoriteTable">
				<script>alert('Add Favorite successfully.');location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>
				
			</pp:if>
		</pp:if>
	</pp:if>
</pp:if>