<pp:var name="shareCommentNodeId" value="@getGlobalModelVar('shareCommentNode')"/>
<pp:var name="shareCommentNode" value="@getNodeInfoById($shareCommentNodeId)"/>
<pp:var name="shareCommentContentModel" value="$shareCommentNode.0.appTableName"/>
<pp:var name="name" value="<pp:session funcname="readSession()"/>"/>
<pp:if expr="$name==''">
	<script>alert("Sorry, you are not login!");location.href="index.php[@encrypt_url('action=website&method=shareCommentindex')]"</script>

<pp:else/>
	<pp:if expr="empty($shareCommentPara.commentContent)">
		<script>alert("Sorry, you need input 1 character at least.");location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>

	<pp:else/>
		<pp:if expr="$method=='addShareComments'">
			<pp:var name="shareCommentPara.shareId" value="$IN.shareID"/>
			<pp:var name="shareCommentPara.nodeId" value="$shareCommentNode.0.nodeGuid"/>
			<pp:var name="shareCommentPara.userId" value="$name"/>
			<pp:var name="shareCommentPara.commentType" value="2"/>	
			
			<?php date_default_timezone_set("prc");?>
			<pp:var name="shareCommentPara.commentDate" value="strtotime(date('Y-m-d H:i:s',time()))"/>
			
			<pp:var name="addshareCommentTable" value="@addData($shareCommentNodeId,$shareCommentContentModel,$shareCommentPara)"/>		
			<pp:if expr="addshareCommentTable">
			
				<pp:var name="publishshareCommentTable" value="@publish($shareCommentNodeId,$shareCommentContentModel,$shareCommentNode.0.appTableKeyName,$addshareCommentTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
				<pp:if expr="publishshareCommentTable">
					<script>location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>
				</pp:if>
			</pp:if>
		<pp:elseif expr="$method=='replyShareComments'">
			<pp:var name="shareCommentPara.shareId" value="$IN.shareID"/>
			<pp:var name="shareCommentPara.nodeId" value="$shareCommentNode.0.nodeGuid"/>
			<pp:var name="shareCommentPara.userId" value="$name"/>
			<pp:var name="shareCommentPara.commentType" value="3"/>	
			
			<cms action="sql" return="shareComment" query="SELECT a.commentDate,a.commentContent,b.staffName FROM cms_publish_sharecomment a,cms_member_staff b where a.commentId='{$IN.replayCommitId}' and a.userId=b.staffId LIMIT 1" />

			<pp:var name="shareCommentPara.replyInfo" value="$shareComment.data.0.staffName . '||' . $shareComment.data.0.commentDate . '||' . $shareComment.data.0.commentContent"/>
			
			<?php date_default_timezone_set("prc");?>
			<pp:var name="shareCommentPara.commentDate" value="strtotime(date('Y-m-d H:i:s',time()))"/>
			
			<pp:var name="addshareCommentTable" value="@addData($shareCommentNodeId,$shareCommentContentModel,$shareCommentPara)"/>		
			<pp:if expr="addshareCommentTable">
			
				<pp:var name="publishshareCommentTable" value="@publish($shareCommentNodeId,$shareCommentContentModel,$shareCommentNode.0.appTableKeyName,$addshareCommentTable,$selectConId,$frameListAction,$frameListMethod,$extraPublishId,$type)"/>	
				<pp:if expr="publishshareCommentTable">
					<script>location.href="index.php[@encrypt_url('action=share&method=detail&shareID=' . $IN.shareID)]"</script>
				</pp:if>
			</pp:if>
		</pp:if>
	</pp:if>
</pp:if>
