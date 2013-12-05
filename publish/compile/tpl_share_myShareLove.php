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
				action: "/publish/index.php<?php echo runFunc('encrypt_url',array('action=account&method=uploadHeaderImage'));?>",
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
	    
		<div class="box">
		    			
		    <?php
$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
);
include($inc_tpl_file);
?>

		<?php
$inc_tpl_file=includeFunc(<<<LNMV
common/myShare_left.tpl
LNMV
);
include($inc_tpl_file);
?>

               
              
               	<div class="imglistMySharePage">
                   
			<ul id="stage">
				<li></li>
				<li></li>
				<li></li>				
			</ul>
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