<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["cartNodeId"]=runFunc('getGlobalModelVar',array('cartNode')); ?>
<?php $this->_tpl_vars["cartNode"]=runFunc('getNodeInfoById',array($this->_tpl_vars["cartNodeId"])); ?>
<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "content",
	'return' => "listCart",
	'nodeid' => "{$this->_tpl_vars["cartNode"]["0"]["nodeGuid"]}",
	'contentid' => "{$this->_tpl_vars["IN"]["cartID"]}",
 ); 

$this->_tpl_vars['listCart'] = CMS::CMS_content($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>

<?php
 import('core.apprun.cmsware.CmswareNode'); 
 import('core.apprun.cmsware.CmswareRun'); global $PageInfo,$params; 
 $params = array ( 
	'action' => "sql",
	'return' => "goodsItem",
	'query' => "SELECT * FROM `cms_publish_goods` WHERE goodsid='{$this->_tpl_vars["IN"]["goodsID"]}' limit 1",
 ); 

$this->_tpl_vars['goodsItem'] = CMS::CMS_sql($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
<?php $this->_tpl_vars["listGoods"]=$this->_tpl_vars["goodsItem"]["data"]["0"]; ?>

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

		$(function(){
		
			
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:-1,
					operaterType:1,
					maxFileSize:204800,//允许上传文件大小设置
					para:{'serverName':'member'}
				},
				onSubmit: function(file, ext){
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						// extension is not allowed
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
					//Add uploaded file to list
					response = trim(response);
					if(response){
						if(response=='tooMax')
						{
							//alert('Upload image size can not be greater than 200k');
							status.text('Upload image size can not be greater than 200k');
						}else
						{
							displayStr ="<input type=\"hidden\" value="+response+" name=\"para[goodsImgURL]\" />";
							response = '../web-inf/lib/coreconfig/'+trim(response);
							$("#userHeaderImg").attr('src',response);							
							$("#inputDispaly").html(displayStr);
						}
					}
				}
			});

		});
		$(function(){
			var btnUpload=$('#upload1');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:-1,
					operaterType:1,
					maxFileSize:204800,//允许上传文件大小设置
					para:{'serverName':'member'}
				},
				onSubmit: function(file, ext){
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						// extension is not allowed
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
					//Add uploaded file to list
					response = trim(response);
					if(response){
						if(response=='tooMax')
						{
							//alert('Upload image size can not be greater than 200k');
							status.text('Upload image size can not be greater than 200k');
						}else
						{
							displayStr ="<input type=\"hidden\" value="+response+" name=\"para[goodsImgURL1]\" />";
							response = '../web-inf/lib/coreconfig/'+trim(response);
							$("#userHeaderImg1").attr('src',response);							
							$("#inputDispaly1").html(displayStr);
						}
					}
				}
			});

		});
		$(function(){
			var btnUpload=$('#upload2');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:-1,
					operaterType:1,
					maxFileSize:204800,//允许上传文件大小设置
					para:{'serverName':'member'}
				},
				onSubmit: function(file, ext){
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						// extension is not allowed
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
					//Add uploaded file to list
					response = trim(response);
					if(response){
						if(response=='tooMax')
						{
							//alert('Upload image size can not be greater than 200k');
							status.text('Upload image size can not be greater than 200k');
						}else
						{
							displayStr ="<input type=\"hidden\" value="+response+" name=\"para[goodsImgURL2]\" />";
							response = '../web-inf/lib/coreconfig/'+trim(response);
							$("#userHeaderImg2").attr('src',response);							
							$("#inputDispaly2").html(displayStr);
						}
					}
				}
			});

		});
		$(function(){
			var btnUpload=$('#upload3');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
				name: 'uploadfile',
				data:{
					fileFolder:'goodsImg',
					goodsId:-1,
					operaterType:1,
					maxFileSize:204800,//允许上传文件大小设置
					para:{'serverName':'member'}
				},
				onSubmit: function(file, ext){
					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						// extension is not allowed
						status.text('Only JPG, PNG or GIF files are allowed');
						return false;
					}
					status.text('Uploading...');
				},
				onComplete: function(file, response){
					//On completion clear the status
					status.text('');
					//Add uploaded file to list
					response = trim(response);
					if(response){
						if(response=='tooMax')
						{
							//alert('Upload image size can not be greater than 200k');
							status.text('Upload image size can not be greater than 200k');
						}else
						{
							displayStr ="<input type=\"hidden\" value="+response+" name=\"para[goodsImgURL3]\" />";
							response = '../web-inf/lib/coreconfig/'+trim(response);
							$("#userHeaderImg3").attr('src',response);							
							$("#inputDispaly3").html(displayStr);
						}
					}
				}
			});

		});
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
	
		
		<div class="content clb">
			
			
			<div class="shopRight fl">
				
				
				
				<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<?php if ($this->_tpl_vars["method"]=='goodsDetail'){?>
						<input type="hidden" name="method" value="addGoods">
					<?php } elseif ($this->_tpl_vars["method"]=='editCartItem'){ ?>
						<input type="hidden" name="method" value="updateCart">
						<input type="hidden" name="cartID" value="<?php echo $this->_tpl_vars["IN"]["cartID"];?>">					
					<?php } ?>		
								
					<input type="hidden" name="para[goodsAddUser]" id="goodsAddUser" value="<?php echo $this->_tpl_vars["tmpUser"];?>">

					<ul class="clothesInfo clb">
						<li>
							<label>The link you input</label>
							<input name="para[goodsURL]" type="text" class="text1" value="<?php echo $this->_tpl_vars["listGoods"]["goodsURL"];?>"/>							
						</li>
						<li>
							<label> Title (English)</label>
									
							<input  name="para[goodsTitleEn]" type="text" class="text2" value="<?php echo $this->_tpl_vars["listGoods"]["goodsTitleEn"];?>"/>	
						</li>
						<li class="pb5">
							<label>Price (single)</label>							
							<input  name="para[goodsUnitPrice]" type="text" class="text3" value="<?php echo $this->_tpl_vars["SinglePrice"];?>"/>
							<span class="rmb">RMB</span>
						</li>
						<li class="mb12">
							<input type="hidden" name="para[goodsFreight]" value="15"/>
						</li>
						<li>
							<label>Description</label>							
								<textarea name="para[goodsDesc]" ></textarea></li> 	
						</li>
						
						<li class="mb12">
							<label>SIZE</label>							
							<input  name="para[goodsSize]" type="text" class="text2"/>	
						</li>
						<li class="mb12">
							<label>COLOR</label>							
							<input  name="para[goodsColor]" type="text" class="text2"/>
						</li>
						<li class="mb12">
							<label>CATEGROY</label>
							
							<select name="para[nodeId]" size="1" id="select1" class="selectinput"> 
								<option value="84">Gifts for Her</option>
								<option value="85">Gifts for Him</option>
								<option value="87">Gifts for Children</option>
								<option value="88">Gifts for Family & Friends</option>
							</select>
							
							
						</li>
					</ul>
					<div class="youraccountUserInfo">
						
					</div>
					<div class="youraccountUserInfo">
						<dl class="userImg fl">
							<dt><img src="../skin/images/pic.jpg" alt="userInfo"   id="userHeaderImg"/></dt>
								<span id="inputDispaly" ></span>									
							<dd class="youraccountEdit">
							
							
							<span id="status" ></span>
							</dd>
						</dl>
						<dl class="youraccountUserBtn fr">
							
							<a href="javascript:uploadPic(0);" id="upload">ADD PIC</a>
							
						    
						</dl>
					</div>

					<div class="youraccountUserInfo">
						<dl class="userImg fl">
							
								<dt><img src="../skin/images/pic.jpg" alt="userInfo"   id="userHeaderImg1"/></dt>
								<span id="inputDispaly1" ></span>
																
							<dd class="youraccountEdit">
							
							<span id="status1" ></span>
							</dd>
						</dl>
						<dl class="youraccountUserBtn fr">
							
							<a href="javascript:uploadPic(1);" id="upload1">ADD PIC</a>
							
						    
						</dl>
					</div>
					<div class="youraccountUserInfo">
						<dl class="userImg fl">
							
								<dt><img src="../skin/images/pic.jpg" alt="userInfo"   id="userHeaderImg2"/></dt>
								<span id="inputDispaly2" ></span>
																
							<dd class="youraccountEdit">
							
							<span id="status2" ></span>
							</dd>
						</dl>
						<dl class="youraccountUserBtn fr">
							
							<a href="javascript:uploadPic(2);" id="upload2">ADD PIC</a>
							
						    
						</dl>
					</div>
					<div class="youraccountUserInfo">
						<dl class="userImg fl">
							
								<dt><img src="../skin/images/pic.jpg" alt="userInfo"   id="userHeaderImg3"/></dt>
								<span id="inputDispaly3" ></span>
																
							<dd class="youraccountEdit">
							
							<span id="status3" ></span>
							</dd>
						</dl>
						<dl class="youraccountUserBtn fr">
							
							<a href="javascript:uploadPic(3);" id="upload3">ADD PIC</a>
							
						    
						</dl>
					</div>					


					
					<?php if ($this->_tpl_vars["method"]=='goodsDetail'){?>
						<ul>							
							<li class="addtoshoppingbag fr"><input type="submit" value="ADD INTO STORE"/></li>
						</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editCartItem'){ ?>
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editOrderItem'){ ?>
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<?php } elseif ($this->_tpl_vars["method"]=='editOrderDetail'){ ?>
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<?php } ?>
					
				</form>
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