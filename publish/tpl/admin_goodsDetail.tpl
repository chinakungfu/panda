<pp:var name="cartNodeId" value="@getGlobalModelVar('cartNode')"/>
<pp:var name="cartNode" value="@getNodeInfoById($cartNodeId)"/>
<cms action="content" return="listCart" nodeid="{$cartNode.0.nodeGuid}" contentid="{$IN.cartID}"/>

<cms action="sql" return="goodsItem" query="SELECT * FROM `cms_publish_goods` WHERE goodsid='{$IN.goodsID}' limit 1"  />
<pp:var name="listGoods" value="$goodsItem.data.0"/>

<!DOCTYPE HTML>
<html>
<head>	
	<pp:include file="common/header/common_header.tpl" type="tpl"/>
	<script type="text/javascript" >

		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
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
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
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
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
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
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
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
	<!--最外框-->
	<div class="box">
		<!--头部-->
		<pp:include file="common/header/shop_header.tpl" type="tpl"/>	
		<!--content info-->
		<div class="content clb">
			
			<!--shopRight-->
			<div class="shopRight fl">
				<!--smailNav-->
				
				<!--clothesInfo-->
				<form name="goodsInfo" id="goodsInfo" action="/publish/index.php" method="post">
					<input type="hidden" name="action" value="admin">
					<pp:if expr="$method=='goodsDetail'">
						<input type="hidden" name="method" value="addGoods">
					<pp:elseif expr="$method=='editCartItem'">
						<input type="hidden" name="method" value="updateCart">
						<input type="hidden" name="cartID" value="[$IN.cartID]">					
					</pp:if>		
								
					<input type="hidden" name="para[goodsAddUser]" id="goodsAddUser" value="[$tmpUser]">

					<ul class="clothesInfo clb">
						<li>
							<label>The link you input</label>
							<input name="para[goodsURL]" type="text" class="text1" value="[$listGoods.goodsURL]"/>							
						</li>
						<li>
							<label> Title (English)</label>
							<!--<input  name="para[goodsTitleCn]" type="text" class="text2" value="[$listGoods.goodsTitleCN]"/><br />-->		
							<input  name="para[goodsTitleEn]" type="text" class="text2" value="[$listGoods.goodsTitleEn]"/>	
						</li>
						<li class="pb5">
							<label>Price (single)</label>							
							<input  name="para[goodsUnitPrice]" type="text" class="text3" value="[$SinglePrice]"/>
							<span class="rmb">RMB</span>
						</li>
						<li class="mb12">
							<input type="hidden" name="para[goodsFreight]" value="15"/>
						</li>
						<li>
							<label>Description</label>							
								<textarea name="para[goodsDesc]" ></textarea> 	
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
							<!--<input type="submit" value="EDIT" />-->
							<!--<div id="upload" ><span>upload your photo here<span></div><span id="status" ></span>-->
							<span id="status" ></span>
							</dd>
						</dl>
						<dl class="youraccountUserBtn fr">
							
							<a href="javascript:uploadPic(0);" id="upload">ADD PIC</a>
							
						    <!--<dd class="youraccountLogoutBtn"><a href="#">LOGOUT</a></dd>-->
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
							
						    <!--<dd class="youraccountLogoutBtn"><a href="#">LOGOUT</a></dd>-->
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
							
						    <!--<dd class="youraccountLogoutBtn"><a href="#">LOGOUT</a></dd>-->
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
							
						    <!--<dd class="youraccountLogoutBtn"><a href="#">LOGOUT</a></dd>-->
						</dl>
					</div>					


					<!--addtowishlist-->
					<pp:if expr="$method=='goodsDetail'">
						<ul>							
							<li class="addtoshoppingbag fr"><input type="submit" value="ADD INTO STORE"/></li>
						</ul>
					<pp:elseif expr="$method=='editCartItem'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<pp:elseif expr="$method=='editOrderItem'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					<pp:elseif expr="$method=='editOrderDetail'">
						<ul>
							<li class="fr"><a href="javascript:updateCart(0);"><img src="../skin/images/updateMyBag.jpg" /></a></li>
						</ul>
					</pp:if>
					
				</form>
			</div>
		</div>

		<!--foot-->
		<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>

	</div>
</body>
</html>