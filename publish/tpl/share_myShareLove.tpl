<!DOCTYPE HTML>
<html>
	<head>
		<pp:include file="common/header/common_header.tpl" type="tpl"/>
		<style>                                                                                            
		#stage{ margin-top:6px; overflow:hidden; margin-bottom:40px }                                      
		#stage li{ float:left; width:250px;}                                                               
		#stage li div{ font-size:12px; padding:0px; color:#999999; text-align:left; }                      
		</style>
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
							//alert('Upload image size can not be greater than 200k');
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
		                                                                                           
		<script language=JavaScript type="" >                                                              
		var getAjaxGoodsIndex = 1;                                                                         
		var getAjaxGoodsSize = 10;                                                                         
		$(document).ready(function(){                                                                      
			loadMore("website","getAjaxMyShareLove","json",getAjaxGoodsIndex,getAjaxGoodsSize);          
		});	                                                                                           
														   
		$(window).scroll(function(){                                                                       
			// 当滚动到最底部以上100像素时， 加载新内容                                                
			if ($(document).height() - $(this).scrollTop() - $(this).height()<100){                    
				getAjaxGoodsIndex++;                                                               
				loadMore("website","getAjaxMyShareLove","json",getAjaxGoodsIndex,getAjaxGoodsSize);  
			}                                                                                          
		});                                                                                                
		</script>                                                                                          


	</head>
	<body>
	    <!--最外框-->
		<div class="box">
		    <!--头部-->			
		    <pp:include file="common/header/shop_header.tpl" type="tpl"/>
		<pp:include file="common/myShare_left.tpl" type="tpl"/>
               
              
               	<div class="imglistMySharePage">
                   
			<ul id="stage">
				<li></li>
				<li></li>
				<li></li>				
			</ul>
               </div>
            </div>
			<!--foot-->
			<pp:include file="common/footer/shop_footer.tpl" type="tpl"/>
			
		</div>
	</body>
</html>