<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
	<pp:var name="paraArr.backAction" value="share"/>
	<pp:var name="paraArr.backMethod" value="addFriend"/>
	<pp:var name="paraArr.shareID" value="$IN.shareID"/>
	<pp:var name="paraArr.userId" value="$IN.userId"/>

	<pp:var name="paraStr" value="serialize($paraArr)"/>

	<script>location.href='index.php[@encrypt_url('action=website&method=login&loginType=addFriend&paraStr=' . $paraStr )]'</script>
<pp:else/>

	<cms action="sql" return="friendNo" query="select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$name}' and friendUserId='{$IN.userId}'" />
	<pp:if expr="$friendNo.data.0.friendNo>0">
		<script>alert('Already added.');location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>	
	<pp:else/>
		<pp:var name="friendNodeId" value="92"/>
		<pp:var name="friendNode" value="@getNodeInfoById($friendNodeId)"/>
		<pp:var name="friendContentModel" value="$friendNode.0.appTableName"/>

		<pp:if expr="$method=='addFriend'">

			<pp:var name="friendPara.friendUserId" value="$IN.userId"/>
			<pp:var name="friendPara.nodeId" value="$friendNode.0.nodeGuid"/>
			<pp:var name="friendPara.userId" value="$name"/>
			<!--<pp:var name="friendPara.friendStatus" value="'1'"/>-->
			
			<?php date_default_timezone_set("prc");?>
			<pp:var name="friendPara.addTime" value="strtotime(date('Y-m-d H:i:s',time()))"/>
			
			<pp:var name="addfriendTable" value="@addData($friendNodeId,$friendContentModel,$friendPara)"/>		
			<pp:if expr="$addfriendTable">
			
				<!--<pp:var name="publishfriendTable" value="@publish($friendNodeId,$friendContentModel,$friendNode.0.appTableKeyName,$addfriendTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
				<pp:if expr="publishfriendTable">-->
					<script>alert('Add friend successfully.');location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>
				<!--</pp:if>-->
			</pp:if>
		</pp:if>
	</pp:if>
</pp:if>
