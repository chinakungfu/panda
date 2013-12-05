<?php import('core.util.RunFunc'); ?><?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "shareItem",
	'query' => "SELECT * FROM cms_publish_goods where goodsid='{$this->_tpl_vars["IN"]["goodsID"]}' limit 1",
 ); 

$this->_tpl_vars['shareItem'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?> 
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "goodsImgList",
	'query' => "select * from cms_resource_resource r,cms_publish_goods_img gi where r.resourceId=gi.resourceId and goodsId='{$this->_tpl_vars["goodsID"]}'",
 ); 

$this->_tpl_vars['goodsImgList'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php $this->_tpl_vars["goodsImgListCount"]=count($this->_tpl_vars["goodsImgList"]["data"]); ?>
<?php $this->_tpl_vars["SinglePrice"]=number_format($this->_tpl_vars["shareItem"]["data"]["0"]["goodsUnitPrice"], 2, '.', ','); ?>
<?php $this->_tpl_vars["FreightPrice"]=number_format($this->_tpl_vars["shareItem"]["data"]["0"]["goodsFreight"], 2, '.', ','); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/common_header.tpl
LNMV
);
include($inc_tpl_file);
?>

		<script type="text/javascript" >
		var uploadGoodsImgMaxCount = '<?php echo $this->_tpl_vars["app"]["uploadGoodsImgMaxCount"];?>';
		$(document).ready(function(){
			var btnUpload=$('#goodsUploadImg');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:'<?php echo $this->_tpl_vars["IN"]["goodsID"];?>',
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
					goodsId:'<?php echo $this->_tpl_vars["IN"]["goodsID"];?>',
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
	    
		<div class="box">
		    
			<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

             <div class="subMitMyShare">
               <h2>SUBMIT SHARE</h2>
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
                   <h3><?php echo $this->_tpl_vars["shareItem"]["data"]["0"]["goodsTitleCN"];?></h3>
                   <table class="subMitMyShareRightTable">
                       <tr>
                           <td width="110px">The link from</td><td style="color:#777; font-size:10px">http://www.taobao.com/</td>
                       </tr>
                       <tr>
                           <td>Price (single)</td><td><input type="text" value="<?php echo $this->_tpl_vars["SinglePrice"];?>" class="subMitMyShareText"/>RMB</td>
                       </tr>
                       <tr>
                           <td>Freight</td><td><input type="text" value="<?php echo $this->_tpl_vars["FreightPrice"];?>" class="subMitMyShareText"/>RMB</td>
                       </tr>
                       
                   </table>
                   <table class="subMitMyShareRightTable01">
		   
                       <tr>
		       <form action="/publish/index.php" method="post">
				<input type="hidden" name="action" value="share">
				<input type="hidden" name="method" value="addShare">
				<input type="hidden" name="goodsID" value="<?php echo $this->_tpl_vars["IN"]["goodsID"];?>">
                           <td colspan="2">
                               <textarea class="textAreaMyShare" name="sharePara[shareComment]">Write your comment  here</textarea>
                               <input type="submit" value="Submit" class="subMitMyShareBtn fr"/><span class="fr" style="margin-top:2px; margin-right:4px;">0/1000</span>
                           </td>
			  </form>
                       </tr>
                   </table>
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