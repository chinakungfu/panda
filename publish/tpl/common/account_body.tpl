<script type="text/javascript" >
		$(function(){
			var btnUpload=$('#upload');
			var status=$('#status');
			new AjaxUpload(btnUpload, {
				action: "/publish/index.php[@encrypt_url('action=account&method=uploadHeaderImage')]",
				name: 'uploadfile',
				data:{
					fileFolder:'headerImg',
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
							
							status.text('Upload image size can not be greater than 200k');
						}else
						{
							response = '../web-inf/lib/coreconfig/'+trim(response);
							$("#userHeaderImg").attr('src',response);
						}
					}
				}
			});

		});
		</script>
<div class="youraccount">
	<h2>Time to shopping and share</h2>
		<div class="youraccountUserInfo">
			<dl class="userImg fl">
				<pp:if expr="$userInfo.0.headImageUrl">
					<dt><img src="../web-inf/lib/coreconfig/[$userInfo.0.headImageUrl]" alt="userInfo"   id="userHeaderImg"/></dt>
				<pp:else/>
					<dt><img src="../skin/images/pic.jpg" alt="userInfo"  id="userHeaderImg"/></dt>
				</pp:if>
				<dd>Welcome !  [$userInfo.0.staffName] </dd>
				
				<!--<input type="submit" value="EDIT" />-->
				<!--<div id="upload" ><span>upload your photo here<span></div><span id="status" ></span>-->
				<dd class="youraccountEdit" id="upload">EDIT</dd><span id="status" ></span>
				
			</dl>
			<dl class="youraccountUserBtn fr">
				<dd class="goShoppingBtn"><a href="/publish/index.php[@encrypt_url('action=website&method=surpriseindex')]">GO SHOPPING</a></dd>
                            <!--<dd class="youraccountLogoutBtn"><a href="#">LOGOUT</a></dd>-->
			</dl>
		</div>
	<h3>YOUR ONLINE ACCOUNT</h3>
	<div class="contactUs fl">
		<h4 style="color:#842622; font-size:12px; margin-bottom:5px">Contact US</h4>
		<p style="color:#5e97ed; font-size:12px">CALL US ANYTIME </p>
		<p style="color:#444; font-size:18px">4008 823 823</p>
		<p style="color:#444; font-size:10px">24 hours/7 days a week</p>
		<ul>
			<li>Online Chat</li>
			<li>Email</li>
		</ul>
	</div>
	<table class="contactTable fl">     
		<tr>
			<td>
				
				<cms action="sql" return="orderList" query="SELECT * FROM cms_publish_order WHERE orderUser ={$name} AND orderStatus >=3 ORDER BY orderTime DESC" />
				<pp:var name="orderPayNum" value="0"/>
				<loop name="orderList.data" var="var" key="key">
					<pp:if expr="$var.orderStatus==3">
						<pp:var name="orderConfirmNum" value="$orderConfirmNum+1"/>					
					</pp:if>
					<pp:if expr="$var.orderStatus==4">
						<pp:var name="orderPayNum" value="$orderPayNum+1"/>					
					</pp:if>
				</loop>	
				<dl>
                                    <dt>Orders<a href="/publish/index.php[@encrypt_url('action=account&method=order')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
                                        Please contact us for orders not listed.<br />
					<pp:if expr="$orderConfirmNum==0">
						No Order waiting to WOW service confirm.
					<pp:elseif expr="$orderConfirmNum==1">
						Your have <span style="color:#D13D3D">[$orderConfirmNum]</span> order waiting to WOW service confirm.
					<pp:elseif expr="$orderConfirmNum>1">
						Your have <span style="color:#D13D3D">[$orderConfirmNum]</span> orders waiting to WOW service confirm.
					</pp:if>

                                    </dd>
                                </dl>
			</td>
			<td>
				
				<dl>
                                    <dt>Payment Information<a href="/publish/index.php[@encrypt_url('action=account&method=payment')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
                                        
					<pp:if expr="$orderPayNum==0">
						No Payment Information.
					<pp:elseif expr="$orderPayNum==1">
						Your have <span style="color:#D13D3D">[$orderPayNum]</span> order waiting to pay.
					<pp:elseif expr="$orderPayNum>1">
						Your have <span style="color:#D13D3D">[$orderPayNum]</span> orders waiting to pay.
					</pp:if>
                                    </dd>
                                </dl>
			</td>
			<td>
				
				<dl>
                                    <dt>Shipping Status<a href="/publish/index.php[@encrypt_url('action=website&method=underConstruction')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
                                        <!--Your have <span style="color:#D13D3D">1</span> pagage-->
                                    </dd>
                                </dl>
			</td>
		</tr>
		<tr>
			<td>				
				<dl>
                                    <dt>Account Information<a href="/publish/index.php[@encrypt_url('action=account&method=information')]" class="youraccountViewBtn fr">EDIT</a></dt>
                                    <dd>
                                        Nick Name:<br />
					[$userInfo.0.staffName]<br />
                                        E-mail Address: <br />
                                        [$userInfo.0.staffNo]<br />
                                        
                                    </dd>
                                </dl>
			</td>
			<td>				
				<dl>
                                    <dt>Membership Infomation<a href="/publish/index.php[@encrypt_url('action=website&method=underConstruction')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
				    <!--
                                        Membercard 0987654321<br />
                                        Blance<span style="color:#D13D3D; float:right">4,000.00</span>
				-->
                                    </dd>
                                </dl>
			</td>
			<td>	
			<cms action="sql" return="addressInfo" query="SELECT * FROM cms_publish_address WHERE userId='{$userInfo.0.staffId}' and status=1 order by addressId" />
			<pp:var name="AddressNum" value="sizeof($addressInfo.data)"/>
				<dl>
                                    <dt>Address<a href="/publish/index.php[@encrypt_url('action=account&method=address')]" class="youraccountViewBtn fr">EDIT</a></dt>
                                    <dd>
				    <pp:if expr="$AddressNum==0">
				    Please input your address.
				    <pp:else/>
                                        [$addressInfo.data.0.fullName]<br />
                                        [$addressInfo.data.0.address1] <br />
                                        [$addressInfo.data.0.address2]<br />
                                        [$addressInfo.data.0.city], [$addressInfo.data.0.province]&nbsp;[$addressInfo.data.0.zipcode]<br />
                                        [$addressInfo.data.0.country]<br />
                                        Phone: [$addressInfo.data.0.cellphone]<br />
				</pp:if>
                                    </dd>
                                </dl>
			</td>
		</tr>
		
		<tr>
			<td>
				<cms action="sql" return="WishList" query="SELECT * FROM cms_publish_cart a,cms_publish_goods b WHERE  a.ItemGoodsID=b.goodsid and a.UserName='{$tmpUser}' and a.ItemStatus = 'Wish'"/>
				<pp:var name="wishNum" value="sizeof($WishList.data)"/>
				<dl>
                                    <dt>Wish List<a href="/publish/index.php[@encrypt_url('action=account&method=wishlist')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
                                        <!--You have <span style="color:#D13D3D;">20</span> wishes -->
					<pp:if expr="$wishNum==0">
						No Wish List Information.
					<pp:elseif expr="$wishNum==1">
						Your have <span style="color:#D13D3D">[$wishNum]</span> wish.
					<pp:elseif expr="$wishNum>1">
						Your have <span style="color:#D13D3D">[$wishNum]</span> wishes.
					</pp:if>
                                    </dd>
                                </dl>
			</td>
			<td>
				
				<dl>
                                    <dt>Your Friends<a href="/publish/index.php[@encrypt_url('action=website&method=underConstruction')]" class="youraccountViewBtn fr">VIEW</a></dt>
                                    <dd>
                                       <!-- You have <span style="color:#D13D3D;">2</span> new friends-->
                                    </dd>
                                </dl>
			</td>
		</tr>
		
	</table>
	
</div>