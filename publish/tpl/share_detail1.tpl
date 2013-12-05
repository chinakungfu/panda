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
	</script>
	<body>
		<!--最外框-->
		<div class="box">
			<!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>

			<cms action="sql" return="shareItem" query="SELECT a.shareId,a.userId,b.goodsURL,b.goodsImgURL,b.goodsTitleCN,a.shareComment, c.staffName,a.shareTime,b.goodsUnitPrice,b.goodsFreight,b.goodsID FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareId='{$IN.shareID}' and a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId order by a.shareId LIMIT 1" />

			<cms action="sql" return="shareComment" query="SELECT a.commentId,a.commentDate,a.commentContent,b.staffName,b.staffId FROM cms_publish_sharecomment a,cms_member_staff b where a.shareId='{$IN.shareID}' and a.userId=b.staffId order by a.commentId desc" />

			<pp:var name="commRow" value="sizeof($shareComment.data)+1"/>

			<div class="subMitMyShare">               
				<div class="subMitMyShareLeft fl">
					<img src="[$shareItem.data.0.goodsImgURL]" alt="submitShare" />
				</div>
				<div class="subMitMyShareRight fr">
					<h3>[$shareItem.data.0.goodsTitleCN]</h3>
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
								<img src="/skin/images/user011.jpg" width="39px" height="40px"/> 
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
							<td><span class="loveIt">(15) Love it</span></td><td><span class="addIcon"><a href="index.php[@encrypt_url('action=share&method=addWish&goodsID=' . $shareItem.data.0.goodsID . '&shareID=' . $IN.shareID . '&itemPrice=' . $SinglePrice . '&itemFreight=' . $FreightPrice)]">Add to Wish List</a></span></td>
						</tr>
						<tr>
							<td colspan="2"><a href="index.php[@encrypt_url('action=shop&method=goodsDetail&goodsID=' . $shareItem.data.0.goodsID)]"><img src="/skin/images/buyNow.jpg" alt="buyNow" class="fr"/></a></td>
						</tr>
					</table>
				</div>
				<div class="moreShares clb">
					<h3>More shares by<span>&nbsp;[$shareItem.data.0.staffName]</span></h3>
					<ul>
						<cms action="sql" return="userShare" query="SELECT a.shareId,a.userId,b.goodsURL,b.goodsImgURL,b.goodsTitleCN,a.shareComment, a.shareTime,b.goodsUnitPrice,b.goodsFreight FROM cms_publish_share a, cms_publish_goods b  WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId='{$shareItem.data.0.userId}' and a.shareId!='{$IN.shareID}' order by a.shareId desc LIMIT 0,5" />

						<loop name="userShare.data" var="var" key="key"> 
							<li><a href="/publish/index.php[@encrypt_url('action=share&method=detail&shareID=' . $var.shareId )]"><img src="[$var.goodsImgURL]" alt="[$var.goodsImgURL]"/></a></li>
						</loop>
					</ul>
				</div>

				<div class="commentsList clb">
					<h3>Comments ([$commRow])</h3>
					<div class="commentsCont">
						<div class="commentsContUser">
							<h4><span>[$shareItem.data.0.staffName]</span>at [$shareDate]</h4>
							<dl>
								<dt><img src="/skin/images/user011.jpg" alt="user011" />
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
												<textarea  name="shareCommentPara[commentContent]" style="min-width:99%; max-width:99%; min-height:40px; max-height:40px; border:0 none;" > </textarea>
											</p>
											<span class="commentsContUserBj01Bottom">250 characters remaining</span>
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
									<dt><img src="/skin/images/user011.jpg" alt="user011" />
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
											<span>@<em>triplyksis</em> at 10:35 am 20/03/12 : </span>
											[$var.commentContent]
										</p>
										<span class="commentsContUserBjBottom">Posted by <em>[$var.staffName]</em>at [$commDate]
										<pp:if expr="$name!=''"><a href="#" style="margin:3px 15px 3px 0; float:right">reply</a></pp:if></span>
										<span></span>
									</dd>
								</dl>
							</loop>
						</div>
						<!--JS下滑回复窗口
						<div class="showDivCont">
						<dl>
						<dd class="showDivContBj">
						<p class="showDivContBjTop">
						<textarea style="min-width:99%; max-width:99%; min-height:50px; max-height:50px; border:0 none;">fdsafdsafdasfdsafdsafafdas</textarea>
						</p>
						<span class="showDivContBjBottom"></span>
						</dd>
						<a href="#" style="margin:3px 3px 0 0; float:right"><img src="/skin/images/reply.gif" alt="reply"/></a>
						</dl>
						</div>-->
						
					</div>
				</div>
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>