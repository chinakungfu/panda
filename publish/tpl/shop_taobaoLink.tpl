<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
	</head>
		<script type="text/javascript">
		jQuery(function(){
			jQuery(".mySareListBaoLink").click(function()
			{
				if(!jQuery(this).hasClass("active_mySareListBaoLinkH3"))
				{
					jQuery(".mySareListBaoLink").removeClass("active_mySareListBaoLinkH3");
					jQuery(this).addClass("active_mySareListBaoLinkH3");
					jQuery(".mySareListBaoLinkH3").css("margin-top","30px");
					jQuery(".mySareListBaoLinkH3").css("border-bottom","0");
					jQuery(this).children(".mySareListBaoLinkH3").animate({'margin-top':"5px"},300,function(){
							jQuery(this).next(".mySareListBaoLinkInfo01").show();
							jQuery(this).next(".mySareListBaoLinkInfo02").show();
						});
					jQuery(this).children(".mySareListBaoLinkH3").css("border-bottom","1px solid #ccc");
					jQuery(".mySareListBaoLinkInfo01").hide();
					jQuery(".mySareListBaoLinkInfo02").hide();
				}
			});
			jQuery(".mySareListBaoLink").hover(function(){
				jQuery(this).addClass("hover_mySareListBaoLinkH3");
			},function(){
				jQuery(this).removeClass("hover_mySareListBaoLinkH3");
			});
		});
		</script>
	<body>
	<!--最外框-->
		<div class="box">
			<!--头部-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>

			<!--content info-->
			<div class="sharemain clb">
				<!--<ul class="shareNav">
					<li><a href="#">MY SHARE</a></li>
					<li><a href="#">YOURFRIENDS</a></li>
					<li><a href="#">FRESH WISHS</a></li>
					<li><a href="#">LINKS ON TAOBAO</a></li>
					<li><a href="#"  class="shareBtn">SHARE WHAT YOU BOUGHT</a></li>
				</ul>-->
				<div class="mySareListBao">
					<h2>LINKS ON <span>TAOBAO</span></h2>
					<div class="mySareListBaoBox">
						<cms action="sql" return="linkList" query="SELECT * FROM cms_publish_link order by linkSequence " />
						<loop name="linkList.data" var="var" key="key">
							
							<pp:if expr="$var.parentId==-1">
								<div class="mySareListBlock" style= "overflow:hidden" >
								<!--<h5><span>[$var.linkName]</span></h5>-->
								<h5>[$var.linkName]</h5>
								<loop name="linkList.data" var="var1" key="key1">
									<pp:var name="linkCount" value="0"/>
									<pp:if expr="$var1.parentId==$var.linkId">
									<div class="mySareListBaoLink">
									<h3 class="mySareListBaoLinkH3">[$var1.linkName]</h3>
									<div class="mySareListBaoLinkInfo02">
									<table width="290px" id="mySareListBaoTable">
										<tr>
										<loop name="linkList.data" var="var2" key="key2">
											<pp:if expr="$var2.parentId==$var1.linkId and $linkCount<6">
												<pp:if expr="$linkCount==0">
													<td width="140px" ><a href="[$var2.linkUrl]" class="mySareListBaoLinkInfo02Link" target="_blank">[$var2.linkName]</a></td><td width="1px">|</td>
												<pp:elseif expr="$linkCount%2==0">				
													</tr>
													<tr>
													<td width="140px"><a href="[$var2.linkUrl]" class="mySareListBaoLinkInfo02Link" target="_blank">[$var2.linkName]</a></td><td width="1px">|</td>
												<pp:else/>
													
													<td width="140px"><a href="[$var2.linkUrl]" class="mySareListBaoLinkInfo02Link" target="_blank">[$var2.linkName]</a></td>
												</if>
												<pp:var name="linkCount" value="$linkCount+1"/>
											</if>
										</loop>
										</tr>										
										</table>		
									</div>
								</div>
									</pp:if>
								</loop>
								</div>
							</pp:if>
							
						</loop>                    
					</div>
				</div>
			</div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
		</div>
	</body>
</html>