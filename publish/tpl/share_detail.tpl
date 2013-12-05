<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
	</head>
	<script>
	function commentAdd()
	{
		document.formComment.submit(); 
	}
	var speed = 500;
	var dd = "";
	function showReplyDiv(e,commentId)
	{
		$("#replayCommitId").val(commentId);
		dd = e;
		e.css("background-color","#C8CCCF");
		var top =e.offset().top;
		var left = e.offset().left;
		$("#replyDiv").css("left",left-345);
		$("#replyDiv").css("top",top+e.outerHeight());
		
		$("#replyDiv").show(speed);
	}
	function hideReplyDiv()
	{
		dd.removeAttr("style");
		dd.css("margin","3px 15px 3px 0");
		dd.css("float","right");
		$("#replyDiv").hide(speed);
	}
	function limitWordCount(contentId,counter,countId)
	{
		counter = parseInt(counter);
		contentId = "#"+contentId;
		countId = "#"+countId;
		var curLength=$(contentId).val().length;
		if(curLength>=counter){
			var num=$(contentId).val().substr(0,counter-1);
			$(contentId).val(num);
			alert("The number of words more than "+counter+" restrictions, the more the word will be truncated!" );
		}
		else{
			$(countId).text(counter-$(contentId).val().length)
		}
	}
	</script>
	<body>
		<!--最外框-->
		<div class="box">
			<!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>

			<cms action="sql" return="shareItem" query="SELECT a.shareId,a.userId,b.goodsType,b.goodsURL,b.goodsImgURL,b.goodsTitleCN,b.goodsTitleEn,a.shareComment, c.staffName,c.headImageUrl,a.shareTime,b.goodsUnitPrice,b.goodsFreight,b.goodsID FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareId='{$IN.shareID}' and a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId order by a.shareId LIMIT 1" />

			<cms action="sql" return="shareComment" query="SELECT a.commentId,a.commentDate,a.commentContent,a.commentType,a.replyInfo,b.staffName,b.staffId,b.headImageUrl FROM cms_publish_sharecomment a,cms_member_staff b where a.shareId='{$IN.shareID}' and a.userId=b.staffId order by a.commentId desc" />

			<pp:var name="commRow" value="sizeof($shareComment.data)+1"/>

			<cms action="sql" return="favoriteCount" query="SELECT COUNT(favoriteId) as favoriteCount FROM cms_publish_favorite where shareId='{$IN.shareID}'" />
			<pp:var name="favoriteRow" value="$favoriteCount.data.0.favoriteCount"/>

			<div class="subMitMyShare">               
				<div class="fl">
					<!--<img src="[$shareItem.data.0.goodsImgURL]" alt="submitShare" />-->
					<div class="subMitMyShareLeft">

					   <pp:if expr="$shareItem.data.0.goodsType=='inside'">
					    <img src="../web-inf/lib/coreconfig/[$shareItem.data.0.goodsImgURL]" alt="bagImg" />
					    <pp:elseif expr="$shareItem.data.0.goodsType=='outside'">
					    <img src="[$shareItem.data.0.goodsImgURL]" alt="bagImg" />
					    </pp:if>
					    </div>

				</div>
				<div class="subMitMyShareRight fr">
					<h3><pp:if expr="$shareItem.data.0.goodsTitleEn">[$shareItem.data.0.goodsTitleEn]<pp:else/>[$shareItem.data.0.goodsTitleCN]</pp:if></h3>
					<table class="subMitMyShareRightTable">
						<tr>
							<td width="110px">The link from</td><td style="color:#777; font-size:10px">http://www.taobao.com/<a href="[$shareItem.data.0.goodsURL]" style="padding-left:38px; color:#5e97ed" target='_blank'>More details</a></td>
						</tr>
						<tr>
							<pp:var name="SinglePrice" value="number_format($shareItem.data.0.goodsUnitPrice, 2, '.', ',')"/>
							<pp:var name="FreightPrice" value="number_format($shareItem.data.0.goodsFreight, 2, '.', ',')"/>
							<td>Price (single)</td><td><input  readonly type="text" value="[$SinglePrice]" class="subMitMyShareText"/>RMB</td>
						</tr>
						<tr>
							<td>Freight</td><td><input readonly type="text" value="[$FreightPrice]" class="subMitMyShareText"/>RMB</td>
						</tr>
						<tr>
							<td style="padding-top:12px; padding-bottom:6px; border-bottom:1px solid #76746F">
								<pp:if expr="$shareItem.data.0.headImageUrl">
									<img src="../web-inf/lib/coreconfig/[$shareItem.data.0.headImageUrl]" width="39px" height="40px"/> 
								<pp:else/>
									<dt><img src="../skin/images/pic.jpg" alt="userInfo"/></dt>
								</pp:if>
								<pp:if expr="$name==''">
									<a href="index.php[@encrypt_url('action=share&method=addFriend&shareID=' . $IN.shareID . '&userId=' . $shareItem.data.0.userId )]" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
								<pp:else/>
									<cms action="sql" return="friendNo1" query="select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$name}' and friendUserId='{$shareItem.data.0.userId}'" />
									<pp:var name="showAdd" value="0"/>
									<pp:if expr="$friendNo1.data.0.friendNo==0 and $name!=$shareItem.data.0.userId">
										<pp:var name="showAdd" value="1"/>
										
									</pp:if>

									<pp:if expr="$showAdd==1">
										<a href="index.php[@encrypt_url('action=share&method=addFriend&shareID=' . $IN.shareID . '&userId=' . $shareItem.data.0.userId )]" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
									</pp:if>
								</pp:if>								
							</td>

							<pp:var name="shareDate" value="date('Y-m-d H:i:s',$shareItem.data.0.shareTime)"/>
							<td style="font-size:10px; vertical-align: top; padding-top:12px; padding-bottom:6px; border-bottom:1px solid #76746F">
								Shared by <span style="color:#5e97ed">[$shareItem.data.0.staffName]</span><br />at [$shareDate]<br />
								<span class="comments">Comments ([$commRow])</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-top:15px; line-height:12px; vertical-align:top; width:313px; height:148px;">
							[$shareItem.data.0.shareComment]
							</td>
						</tr>
						<tr>
							<td><span class="loveIt">([$favoriteRow]) <a href="index.php[@encrypt_url('action=share&method=addFavorite&shareID=' . $IN.shareID)]">Love it</a></span></td>
							<td><span class="addIcon"><a href="index.php[@encrypt_url('action=share&method=addWish&goodsID=' . $shareItem.data.0.goodsID . '&shareID=' . $IN.shareID . '&itemPrice=' . $shareItem.data.0.goodsUnitPrice . '&itemFreight=' . $shareItem.data.0.goodsFreight)]">Add to Wish List</a></span></td>
						</tr>
						<tr>
							<td colspan="2"><a href="index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $shareItem.data.0.goodsID)]"><img src="/skin/images/buyNow.jpg" alt="buyNow" class="fr"/></a></td>
						</tr>
					</table>
				</div>
				<div class="moreShares clb">
					<h3>More shares by<span>&nbsp;[$shareItem.data.0.staffName]</span></h3>
					<ul>
						<cms action="sql" return="userShare" query="SELECT a.shareId,a.userId,b.goodsURL,b.goodsImgURL,b.goodsType,b.goodsTitleCN,a.shareComment, a.shareTime,b.goodsUnitPrice,b.goodsFreight FROM cms_publish_share a, cms_publish_goods b  WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId='{$shareItem.data.0.userId}' and a.shareId!='{$IN.shareID}' order by a.shareId desc LIMIT 0,5" />

						<loop name="userShare.data" var="var" key="key"> 
						<pp:if expr="$var.goodsType=='inside'">
							
							<li><a href="/publish/index.php[@encrypt_url('action=share&method=detail&shareID=' . $var.shareId )]"><img src="../web-inf/lib/coreconfig/[$var.goodsImgURL]" alt="[$var.goodsTitleCN]"/></a></li>
						<pp:elseif expr="$var.goodsType=='outside'">
							<li><a href="/publish/index.php[@encrypt_url('action=share&method=detail&shareID=' . $var.shareId )]"><img src="[$var.goodsImgURL]" alt="[$var.goodsTitleCN]"/></a></li>
						</pp:if>
							
						</loop>
					</ul>
				</div>

				<div class="commentsList clb">
					<h3>Comments ([$commRow])</h3>
					<div class="commentsCont">
						<div class="commentsContUser">
							<h4><span>[$shareItem.data.0.staffName]</span>at [$shareDate]</h4>
							<dl>
								<dt>
								<pp:if expr="$shareItem.data.0.headImageUrl">
									<img src="../web-inf/lib/coreconfig/[$shareItem.data.0.headImageUrl]"/> 
								<pp:else/>
									<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
								</pp:if>
								
								<span>
									<pp:if expr="$showAdd==1">
										<a href="index.php[@encrypt_url('action=share&method=addFriend&shareID=' . $IN.shareID . '&userId=' . $shareItem.data.0.userId )]" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
									</pp:if>
								</span>
								</dt>
								<dd class="commentsContUserBj">
									<p class="commentsContUserBjTop">
										[$shareItem.data.0.shareComment]
									</p>
									<span class="commentsContUserBjBottom01"></span>
								</dd>
							</dl>
						</div>
						<pp:if expr="$name!=''">
							<form action="/publish/index.php" method="post" name="formComment" id="formComment" >
								<input type="hidden" name="action" value="share">
								<input type="hidden" name="method" value="addShareComments">
								<input type="hidden" name="shareID" value="[$IN.shareID]">
								<div class="commentsContUser01">
									<h4></h4>
									<dl>
										<dd class="commentsContUserBj01">
											<p class="commentsContUserBj01Top">
												<textarea  name="shareCommentPara[commentContent]" id="commentContent" style="min-width:99%; max-width:99%; min-height:40px; max-height:40px; border:0 none;" onkeydown="limitWordCount(this.id,250,'commentWordCount')" ></textarea>
											</p>
											<span class="commentsContUserBj01Bottom"><span id="commentWordCount">250</span> characters remaining</span>
										</dd>
										<dd class="commentsContUser01Dd fr"><span class="fl">Forward to</span>
											<ul class="commentsContUser01Ul">
												<li class="facebook01"><a href="#">facebook</a></li>
												<li class="sns01"><a href="#">sns</a></li>
												<li class="google01"><a href="#">G+</a></li>
											</ul>
											<a href="javascript:commentAdd();" name="savesubmit" id="savesubmit"><img src="/skin/images/SHARE002Btn.png" alt="SHARE002Btn" /></a>
										</dd>
									</dl>
								</div>
							</form>
						</if>
						<div class="commentsContUser02 clb">
							<h4></h4>

							<loop name="shareComment.data" var="var" key="key"> 
								<pp:var name="commDate" value="date('Y-m-d H:i:s',$var.commentDate)"/>
								<dl>
									<dt>
									<pp:if expr="$var.headImageUrl">
										<img src="../web-inf/lib/coreconfig/[$var.headImageUrl]"/> 
									<pp:else/>
										<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
									</pp:if>
									
									<span>
										<pp:if expr="$name==''">
											<a href="index.php[@encrypt_url('action=share&method=addFriend&shareID=' . $IN.shareID . '&userId=' . $var.staffId )]" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
										<pp:else/>
											<cms action="sql" return="friendNo2" query="select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$name}' and friendUserId='{$var.staffId}'" />
											
											<pp:if expr="$friendNo2.data.0.friendNo==0 and $name!=$var.staffId">
												<a href="index.php[@encrypt_url('action=share&method=addFriend&shareID=' . $IN.shareID . '&userId=' . $var.staffId )]" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
											</pp:if>
										</pp:if>
									</span>
									</dt>
									<dd class="commentsContUserBj">									
										
											<p class="commentsContUserBjTop">
												<pp:if expr="$var.commentType==3 and $var.replyInfo!=''">
												<pp:var name="replyStr" value="explode('||',$var.replyInfo)"/>
												<pp:var name="replyDate" value="date('Y-m-d H:i:s',$replyStr.1)"/>
												<span>@<em>[$replyStr.0]</em> at [$replyDate] : [$replyStr.2]</span><br></pp:if>
												[$var.commentContent]
											</p>
										
										<span class="commentsContUserBjBottom">Posted by <em>[$var.staffName]</em>at [$commDate]
										<pp:if expr="$name!=''"><a href="javascript:void(0);" style="margin:3px 15px 3px 0; float:right" onclick="showReplyDiv($(this),'[$var.commentId]')">reply</a></pp:if></span>
										<span></span>
									</dd>
								</dl>
							</loop>
						</div>
						<!--JS下滑回复窗口-->
						<div class="showDivCont" style="display:none" id="replyDiv"><a href="javascript:void(0);" title="Close" onclick="hideReplyDiv()" style="float:right;top:0px">x</a><br>
							<form method="POST" action="#" id="replayForm">
								<input type="hidden" name="action" value="share">
								<input type="hidden" name="method" value="replyShareComments">
								<dl>
									<dd class="showDivContBj">
										<p class="showDivContBjTop">
											<input type="hidden" name="replayCommitId" id="replayCommitId">
											<textarea name="shareCommentPara[commentContent]" style="min-width:99%; max-width:99%; min-height:50px; max-height:50px; border:0 none;" id="replyContent" onkeydown="limitWordCount(this.id,250,'replyWordCount')"></textarea>
										</p>
											<span class="showDivContBjBottom"><span id="replyWordCount">250</span> characters remaining</span>
									</dd>
									<a href="javascript:void(0);" style="margin:3px 3px 0 0; float:right" onclick="$('#replayForm').submit();hideReplyDiv();"><img src="/skin/images/reply.gif" alt="reply"/></a>
								</dl>
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>