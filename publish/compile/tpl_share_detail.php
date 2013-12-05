<?php import('core.util.RunFunc'); ?><!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

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
		
		<div class="box">
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>


			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareItem",
	'query' => "SELECT a.shareId,a.userId,b.goodsType,b.goodsURL,b.goodsImgURL,b.goodsTitleCN,b.goodsTitleEn,a.shareComment, c.staffName,c.headImageUrl,a.shareTime,b.goodsUnitPrice,b.goodsFreight,b.goodsID FROM cms_publish_share a, cms_publish_goods b, cms_member_staff c WHERE a.shareId='{$this->_tpl_vars["IN"]["shareID"]}' and a.shareStatus=1 and a.goodsId=b.goodsId and a.userId=c.staffId order by a.shareId LIMIT 1",
 ); 

$this->_tpl_vars['shareItem'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareComment",
	'query' => "SELECT a.commentId,a.commentDate,a.commentContent,a.commentType,a.replyInfo,b.staffName,b.staffId,b.headImageUrl FROM cms_publish_sharecomment a,cms_member_staff b where a.shareId='{$this->_tpl_vars["IN"]["shareID"]}' and a.userId=b.staffId order by a.commentId desc",
 ); 

$this->_tpl_vars['shareComment'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

			<?php $this->_tpl_vars["commRow"]=sizeof($this->_tpl_vars["shareComment"]["data"])+1; ?>

			<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "favoriteCount",
	'query' => "SELECT COUNT(favoriteId) as favoriteCount FROM cms_publish_favorite where shareId='{$this->_tpl_vars["IN"]["shareID"]}'",
 ); 

$this->_tpl_vars['favoriteCount'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
			<?php $this->_tpl_vars["favoriteRow"]=$this->_tpl_vars["favoriteCount"]["data"]["0"]["favoriteCount"]; ?>

			<div class="subMitMyShare">               
				<div class="fl">
					
					<div class="subMitMyShareLeft">

					   <?php if ($this->_tpl_vars["shareItem"]["data"]["0"]["goodsType"]=='inside'){?>
					    <img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsImgURL"];?>" alt="bagImg" />
					    <?php } elseif ($this->_tpl_vars["shareItem"]["data"]["0"]["goodsType"]=='outside'){ ?>
					    <img src="<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsImgURL"];?>" alt="bagImg" />
					    <?php } ?>
					    </div>

				</div>
				<div class="subMitMyShareRight fr">
					<h3><?php if ($this->_tpl_vars["shareItem"]["data"]["0"]["goodsTitleEn"]){?><?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsTitleEn"];?><?php }else{ ?><?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsTitleCN"];?><?php } ?></h3>
					<table class="subMitMyShareRightTable">
						<tr>
							<td width="110px">The link from</td><td style="color:#777; font-size:10px">http://www.taobao.com/<a href="<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsURL"];?>" style="padding-left:38px; color:#5e97ed" target='_blank'>More details</a></td>
						</tr>
						<tr>
							<?php $this->_tpl_vars["SinglePrice"]=number_format($this->_tpl_vars["shareItem"]["data"]["0"]["goodsUnitPrice"], 2, '.', ','); ?>
							<?php $this->_tpl_vars["FreightPrice"]=number_format($this->_tpl_vars["shareItem"]["data"]["0"]["goodsFreight"], 2, '.', ','); ?>
							<td>Price (single)</td><td><input  readonly type="text" value="<?php echo $this->_tpl_vars["SinglePrice"];?>" class="subMitMyShareText"/>RMB</td>
						</tr>
						<tr>
							<td>Freight</td><td><input readonly type="text" value="<?php echo $this->_tpl_vars["FreightPrice"];?>" class="subMitMyShareText"/>RMB</td>
						</tr>
						<tr>
							<td style="padding-top:12px; padding-bottom:6px; border-bottom:1px solid #76746F">
								<?php if ($this->_tpl_vars["shareItem"]["data"]["0"]["headImageUrl"]){?>
									<img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["headImageUrl"];?>" width="39px" height="40px"/> 
								<?php }else{ ?>
									<dt><img src="../skin/images/pic.jpg" alt="userInfo"/></dt>
								<?php } ?>
								<?php if ($this->_tpl_vars["name"]==''){?>
									<a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFriend&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&userId=' . $this->_tpl_vars["shareItem"]["data"]["0"]["userId"] ));?>" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
								<?php }else{ ?>
									<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "friendNo1",
	'query' => "select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$this->_tpl_vars["name"]}' and friendUserId='{$this->_tpl_vars["shareItem"]["data"]["0"]["userId"]}'",
 ); 

$this->_tpl_vars['friendNo1'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
									<?php $this->_tpl_vars["showAdd"]=0; ?>
									<?php if ($this->_tpl_vars["friendNo1"]["data"]["0"]["friendNo"]==0 and $this->_tpl_vars["name"]!=$this->_tpl_vars["shareItem"]["data"]["0"]["userId"]){?>
										<?php $this->_tpl_vars["showAdd"]=1; ?>
										
									<?php } ?>

									<?php if ($this->_tpl_vars["showAdd"]==1){?>
										<a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFriend&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&userId=' . $this->_tpl_vars["shareItem"]["data"]["0"]["userId"] ));?>" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
									<?php } ?>
								<?php } ?>								
							</td>

							<?php $this->_tpl_vars["shareDate"]=date('Y-m-d H:i:s',$this->_tpl_vars["shareItem"]["data"]["0"]["shareTime"]); ?>
							<td style="font-size:10px; vertical-align: top; padding-top:12px; padding-bottom:6px; border-bottom:1px solid #76746F">
								Shared by <span style="color:#5e97ed"><?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["staffName"];?></span><br />at <?php echo $this->_tpl_vars["shareDate"];?><br />
								<span class="comments">Comments (<?php echo $this->_tpl_vars["commRow"];?>)</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-top:15px; line-height:12px; vertical-align:top; width:313px; height:148px;">
							<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["shareComment"];?>
							</td>
						</tr>
						<tr>
							<td><span class="loveIt">(<?php echo $this->_tpl_vars["favoriteRow"];?>) <a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFavorite&shareID=' . $this->_tpl_vars["IN"]["shareID"]));?>">Love it</a></span></td>
							<td><span class="addIcon"><a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addWish&goodsID=' . $this->_tpl_vars["shareItem"]["data"]["0"]["goodsID"] . '&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&itemPrice=' . $this->_tpl_vars["shareItem"]["data"]["0"]["goodsUnitPrice"] . '&itemFreight=' . $this->_tpl_vars["shareItem"]["data"]["0"]["goodsFreight"]));?>">Add to Wish List</a></span></td>
						</tr>
						<tr>
							<td colspan="2"><a href="index.php<?php echo runFunc('encrypt_url',array('action=shop&method=goodsDetail&goodsID=' . $this->_tpl_vars["shareItem"]["data"]["0"]["goodsID"]));?>"><img src="/skin/images/buyNow.jpg" alt="buyNow" class="fr"/></a></td>
						</tr>
					</table>
				</div>
				<div class="moreShares clb">
					<h3>More shares by<span>&nbsp;<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["staffName"];?></span></h3>
					<ul>
						<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "userShare",
	'query' => "SELECT a.shareId,a.userId,b.goodsURL,b.goodsImgURL,b.goodsType,b.goodsTitleCN,a.shareComment, a.shareTime,b.goodsUnitPrice,b.goodsFreight FROM cms_publish_share a, cms_publish_goods b  WHERE a.shareStatus=1 and a.goodsId=b.goodsId and a.userId='{$this->_tpl_vars["shareItem"]["data"]["0"]["userId"]}' and a.shareId!='{$this->_tpl_vars["IN"]["shareID"]}' order by a.shareId desc LIMIT 0,5",
 ); 

$this->_tpl_vars['userShare'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

						<?php if(!empty($this->_tpl_vars["userShare"]["data"])){ 
 foreach ($this->_tpl_vars["userShare"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?> 
						<?php if ($this->_tpl_vars["var"]["goodsType"]=='inside'){?>
							
							<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["var"]["shareId"] ));?>"><img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="<?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?>"/></a></li>
						<?php } elseif ($this->_tpl_vars["var"]["goodsType"]=='outside'){ ?>
							<li><a href="/publish/index.php<?php echo runFunc('encrypt_url',array('action=share&method=detail&shareID=' . $this->_tpl_vars["var"]["shareId"] ));?>"><img src="<?php echo $this->_tpl_vars["var"]["goodsImgURL"];?>" alt="<?php echo $this->_tpl_vars["var"]["goodsTitleCN"];?>"/></a></li>
						<?php } ?>
							
						<?php  }
} ?>
					</ul>
				</div>

				<div class="commentsList clb">
					<h3>Comments (<?php echo $this->_tpl_vars["commRow"];?>)</h3>
					<div class="commentsCont">
						<div class="commentsContUser">
							<h4><span><?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["staffName"];?></span>at <?php echo $this->_tpl_vars["shareDate"];?></h4>
							<dl>
								<dt>
								<?php if ($this->_tpl_vars["shareItem"]["data"]["0"]["headImageUrl"]){?>
									<img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["headImageUrl"];?>"/> 
								<?php }else{ ?>
									<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
								<?php } ?>
								
								<span>
									<?php if ($this->_tpl_vars["showAdd"]==1){?>
										<a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFriend&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&userId=' . $this->_tpl_vars["shareItem"]["data"]["0"]["userId"] ));?>" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
									<?php } ?>
								</span>
								</dt>
								<dd class="commentsContUserBj">
									<p class="commentsContUserBjTop">
										<?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["shareComment"];?>
									</p>
									<span class="commentsContUserBjBottom01"></span>
								</dd>
							</dl>
						</div>
						<?php if ($this->_tpl_vars["name"]!=''){?>
							<form action="/publish/index.php" method="post" name="formComment" id="formComment" >
								<input type="hidden" name="action" value="share">
								<input type="hidden" name="method" value="addShareComments">
								<input type="hidden" name="shareID" value="<?php echo $this->_tpl_vars["IN"]["shareID"];?>">
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
						<?php } ?>
						<div class="commentsContUser02 clb">
							<h4></h4>

							<?php if(!empty($this->_tpl_vars["shareComment"]["data"])){ 
 foreach ($this->_tpl_vars["shareComment"]["data"] as $this->_tpl_vars['key']=>$this->_tpl_vars['var']){ ?> 
								<?php $this->_tpl_vars["commDate"]=date('Y-m-d H:i:s',$this->_tpl_vars["var"]["commentDate"]); ?>
								<dl>
									<dt>
									<?php if ($this->_tpl_vars["var"]["headImageUrl"]){?>
										<img src="../web-inf/lib/coreconfig/<?php echo $this->_tpl_vars["var"]["headImageUrl"];?>"/> 
									<?php }else{ ?>
										<dt><img src="../skin/images/pic.jpg" alt="userInfo""/></dt>
									<?php } ?>
									
									<span>
										<?php if ($this->_tpl_vars["name"]==''){?>
											<a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFriend&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&userId=' . $this->_tpl_vars["var"]["staffId"] ));?>" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
										<?php }else{ ?>
											<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "friendNo2",
	'query' => "select count(friendId) as friendNo  from cms_publish_friend WHERE userId='{$this->_tpl_vars["name"]}' and friendUserId='{$this->_tpl_vars["var"]["staffId"]}'",
 ); 

$this->_tpl_vars['friendNo2'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
											
											<?php if ($this->_tpl_vars["friendNo2"]["data"]["0"]["friendNo"]==0 and $this->_tpl_vars["name"]!=$this->_tpl_vars["var"]["staffId"]){?>
												<a href="index.php<?php echo runFunc('encrypt_url',array('action=share&method=addFriend&shareID=' . $this->_tpl_vars["IN"]["shareID"] . '&userId=' . $this->_tpl_vars["var"]["staffId"] ));?>" style="color:#5e97ed; padding-left:8px;">+ Friend</a>
											<?php } ?>
										<?php } ?>
									</span>
									</dt>
									<dd class="commentsContUserBj">									
										
											<p class="commentsContUserBjTop">
												<?php if ($this->_tpl_vars["var"]["commentType"]==3 and $this->_tpl_vars["var"]["replyInfo"]!=''){?>
												<?php $this->_tpl_vars["replyStr"]=explode('||',$this->_tpl_vars["var"]["replyInfo"]); ?>
												<?php $this->_tpl_vars["replyDate"]=date('Y-m-d H:i:s',$this->_tpl_vars["replyStr"]["1"]); ?>
												<span>@<em><?php echo $this->_tpl_vars["replyStr"]["0"];?></em> at <?php echo $this->_tpl_vars["replyDate"];?> : <?php echo $this->_tpl_vars["replyStr"]["2"];?></span><br><?php } ?>
												<?php echo $this->_tpl_vars["var"]["commentContent"];?>
											</p>
										
										<span class="commentsContUserBjBottom">Posted by <em><?php echo $this->_tpl_vars["var"]["staffName"];?></em>at <?php echo $this->_tpl_vars["commDate"];?>
										<?php if ($this->_tpl_vars["name"]!=''){?><a href="javascript:void(0);" style="margin:3px 15px 3px 0; float:right" onclick="showReplyDiv($(this),'<?php echo $this->_tpl_vars["var"]["commentId"];?>')">reply</a><?php } ?></span>
										<span></span>
									</dd>
								</dl>
							<?php  }
} ?>
						</div>
						
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
			
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
);
include($inc_tpl_file);
?>

		</div>
	</body>
</html>