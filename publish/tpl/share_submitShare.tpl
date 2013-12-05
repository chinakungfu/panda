<cms action="sql" return="shareItem" query="SELECT * FROM cms_publish_goods where goodsid='{$IN.goodsID}' limit 1"/> 
<cms action="sql" return="goodsImgList" query="select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$goodsID}'"/>
<pp:var name="goodsImgListCount" value="count($goodsImgList.data)"/>
<pp:var name="SinglePrice" value="number_format($shareItem.data.0.goodsUnitPrice, 2, '.', ',')"/>
<pp:var name="FreightPrice" value="number_format($shareItem.data.0.goodsFreight, 2, '.', ',')"/>
<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<script type="text/javascript" >
		var uploadGoodsImgMaxCount = '[$app.uploadGoodsImgMaxCount]';
		$(document).ready(function(){
			var btnUpload=$('#goodsUploadImg');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:'[$IN.goodsID]',
					maxFileSize:204800,//允许上传文件大小设置
					para:{'serverName':'member'},
					operaterType:1
				},
				onChange:function(file, ext)
				{
					if($("#uploadCount").val()>=uploadGoodsImgMaxCount)
					{
						alert("The maximum number of upload pictures of "+uploadGoodsImgMaxCount);
						return false;
					}
				},
				onSubmit: function(file, ext){
					
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						// extension is not allowed
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					btnUpload.val('Uploading...');
				},
				onComplete: function(file, response){
					//alert(response);
					//On completion clear the status
					btnUpload.val('Upload Pic');
					//Add uploaded file to list
					if(response)
					{
						if(response=='tooMax')
						{
							alert('Upload image size can not be greater than 200k');
						}else
						{
							var displayStr = "";
							var fileCount = 1;
							var dataObj=eval("("+response+")");//转换为json对象
							var returnDataCount = dataObj.data.length;
							$("#uploadCount").val(returnDataCount);
							if(returnDataCount>=uploadGoodsImgMaxCount)
							{
								$("#goodsUploadImg").attr("disabled",true);
							}else
							{
								$("#goodsUploadImg").attr("disabled",false);
							}
							
	//						if(returnDataCount>=uploadGoodsImgMaxCount)
	//						{
	//							displayStr = displayStr + "<input type=\"button\" value=\"Upload Pic\" id=\"goodsUploadImg\" class=\"subMitMyShareBtn\" disabled/>";
	//						}else
	//						{
	//							displayStr = displayStr + "<input type=\"button\" value=\"Upload Pic\" id=\"goodsUploadImg\" class=\"subMitMyShareBtn\"/>";
	//						}
							$.each(dataObj.data, function(i, item) {
								fileCount = fileCount+i;
								displayStr = displayStr + "<span class=\"fileDel\">file"+fileCount+"<em>"+item.fileName+"</em><a href=\"#\" onclick=\"delUploadGoodsImg('"+item.Id+"','"+item.resourceId+"')\"></a></span>";
							});
							$("#uploadImgList").html(displayStr);
						}
					}
				}
			});

		});
		function delUploadGoodsImg(goodsImgId,resourceId)
		{
			$.ajax({
				url		: 'index.php',
				type	: 'POST',
				data	: {
					action	: 'account',
					method	: 'uploadHeaderImage',
					goodsId:'[$IN.goodsID]',
					goodsImgId	: goodsImgId,
					resourceId:resourceId,
					operaterType:0
				},
				success	: function(data){
					data = trim(data);
					var displayStr = "";
					var fileCount = 1;
					var dataObj=eval("("+data+")");//转换为json对象
					var returnDataCount = dataObj.data.length;
					$("#uploadCount").val(returnDataCount);
					if(returnDataCount>=uploadGoodsImgMaxCount)
					{
						$("#goodsUploadImg").attr("disabled",true);
					}else
					{
						$("#goodsUploadImg").attr("disabled",false);
					}
//					if(returnDataCount>=uploadGoodsImgMaxCount)
//					{
//						displayStr = displayStr + "<input type=\"button\" value=\"Upload Pic\" id=\"goodsUploadImg\" class=\"subMitMyShareBtn\" disabled/>";
//					}else
//					{
//						displayStr = displayStr + "<input type=\"button\" value=\"Upload Pic\" id=\"goodsUploadImg\" class=\"subMitMyShareBtn\"/>";
//					}
					$.each(dataObj.data, function(i, item) {
						fileCount = fileCount+i;
						displayStr = displayStr + "<span class=\"fileDel\">file"+fileCount+"<em>"+item.fileName+"</em><a href=\"#\" onclick=\"delUploadGoodsImg('"+item.Id+"','"+item.resourceId+"')\"></a></span>";
					});
					$("#uploadImgList").html(displayStr);
				}
			});
		}
		</script>
	</head>
	<body>
	    <!--�����-->
		<div class="box">
		    <!--ͷ��-->
			<pp:include file="common/header/shop_header.tpl" type="tpl"/>
             <div class="subMitMyShare">
               <h2>SUBMIT SHARE</h2>
               <div class="fl">
                   <div class="subMitMyShareLeft">

		   <pp:if expr="$shareItem.data.0.goodsType=='inside'">
		    <img src="../web-inf/lib/coreconfig/[$shareItem.data.0.goodsImgURL]" alt="bagImg" />
		    <pp:elseif expr="$shareItem.data.0.goodsType=='outside'">
		    <img src="[$shareItem.data.0.goodsImgURL]" alt="bagImg" />
		    </pp:if>
		    </div>
               </div>
               <div class="subMitMyShareRight fr">
                   <h3>[$shareItem.data.0.goodsTitleCN]</h3>
                   <table class="subMitMyShareRightTable">
                       <tr>
                           <td width="110px">The link from</td><td style="color:#777; font-size:10px">http://www.taobao.com/</td>
                       </tr>
                       <tr>
                           <td>Price (single)</td><td><input type="text" value="[$SinglePrice]" class="subMitMyShareText"/>RMB</td>
                       </tr>
                       <tr>
                           <td>Freight</td><td><input type="text" value="[$FreightPrice]" class="subMitMyShareText"/>RMB</td>
                       </tr>
                       <!--
		       <tr>
                           <td colspan="2" style="color:#777; font-size:10px; font-weight:bold">purchase time<span>2012-03-13</span></td>
                       </tr>
                       <tr>
                           <td colspan="2">
                           <input type="hidden" name="uploadCount" id="uploadCount" value="[$goodsImgListCount]" >
                           <pp:if expr="$goodsImgListCount>=$app.uploadGoodsImgMaxCount">
                           <input type="button" value="Upload Pic" id="goodsUploadImg" class="subMitMyShareBtn" disabled/>
                           <pp:else/>
                           <input type="button" value="Upload Pic" id="goodsUploadImg" class="subMitMyShareBtn"/>
                           </pp:if>
                           <div id="uploadImgList">
                           <loop name="goodsImgList.data" var="var" key="key">
                           <pp:var name="fileCount" value="$key+1"/>
                           <pp:if expr="$fileCount<=$app.uploadGoodsImgMaxCount">
                           <span class="fileDel">
                           file[$fileCount]<em>[$var.fileName]</em>
                           <a href="#" onclick="delUploadGoodsImg('[$var.Id]','[$var.resourceId]')"></a>
                           </span>
                           </pp:if>
                           </loop>
                           </div>
                           </td>
                       </tr>
                       <tr>
                           <td colspan="2" style="color:#5e97ed; font-size:11px">you can upload 2 pictures about this item </td>
                       </tr>
		      -->
                   </table>
                   <table class="subMitMyShareRightTable01">
		   <!--
                       <tr>
                           <td>Tag your share!</td><td align="center">Choose tags</td>
                       </tr>
                       <tr>
                           <td align="center" style="color:#5e97ed">You can put 10 tags on one item.</td><td align="center" style="color:#ad1233">Style</td>
                       </tr>
                       <tr>
                           <td>
                               <div class="springLeft">
                                   <a href="#">Spring 2012 new collection</a><a href="#">Purple</a>
                                   <a href="#">flowery</a><a href="#">ruralism</a><a href="#">Flower print</a>
                                   <a href="#">Cocktail dress</a><a href="#">Cocktail dress</a>
                                   <a href="#">Cocktail dress</a><a href="#">Cocktail dress</a>
                               </div>
                           </td>
                           <td>
                               <a href="#" class="fr arrowSubMit"><img src="../skin/images/backArrowRight.png" alt="backArrowRight" /></a>
                               <a href="#" class="fl arrowSubMit"><img src="../skin/images/backArrowLeft.gif" alt="backArrowLeft" /></a>
                               <div class="springRight">
                                   <a href="#">Spring 2012 new collection</a><a href="#">Purple</a>
                                   <a href="#">flowery</a><a href="#">ruralism</a><a href="#">Flower print</a>
                                   <a href="#">Cocktail dress</a><a href="#">Cocktail dress</a>
                                   <a href="#">Cocktail dress</a><a href="#">Cocktail dress</a>
                               </div>
                           </td>
                       </tr>
                       <tr>
                           <td>&nbsp;</td><td style="color:#444" align="center">No match tags for your share? </td>
                       </tr>
                       <tr>
                           <td style="color:#5e97ed; line-height:12px;">Why tag share items?<br />
                               tagged items will be easier to search
                           </td>
                           <td>
                               <input type="text" value="write your unique tag" class="unique"/><input type="submit" value="tag it" class="uniqueSubmit"/>
                           </td>
                       </tr>
		       -->
                       <tr>
		       <form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="share">
				<input type="hidden" name="method" value="addShare">
				<input type="hidden" name="goodsID" value="[$IN.goodsID]">
                           <td colspan="2">
                               <textarea class="textAreaMyShare" name="sharePara[shareComment]">Write your comment  here</textarea>
                               <input type="submit" value="Submit" class="subMitMyShareBtn fr"/><span class="fr" style="margin-top:2px; margin-right:4px;">0/1000</span>
                           </td>
			  </form>
                       </tr>
                   </table>
               </div>
             </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>