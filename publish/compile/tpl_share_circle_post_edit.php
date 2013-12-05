<?php import('core.util.RunFunc'); ?>
<?php $this->_tpl_vars["name"]=runFunc('readSession',array());
 if ($this->_tpl_vars["name"]){?>
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
</head>
<body onload="window.location.hash = 'here'">
	<div class="box">
	<?php
	$inc_tpl_file=includeFunc("common/header/shop_header.tpl");
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc("share/header/nav.tpl");
	include($inc_tpl_file);
	
	$post = runFunc("getCirclePost",array($this->_tpl_vars["IN"]["id"]));
	$imgs = runFunc("getCirclePostImg",array($this->_tpl_vars["IN"]["id"]));
	?>
	<div class="content">
	<h2 class="cp_title">Discovery Circles</h2>
	<h3 class="circle_create_box_title">Edit Your  Post</h3>
	<div class="circle_create_main oh">
	<div class="circle_create_box fl gray_line_box">
	<form id="post_create_form" action="index.php" method="post">
		<input type="hidden" name="circle_id" value="<?php echo $this->_tpl_vars["circle_id"];?>"/>
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars["IN"]["id"];?>"/>
		<table class="circle_create_detail_table">
			<tr>
				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="post_name">Post Title: *</label></th>
				<td>
				<input id="post_name" class="circle_editor_input big_input required" type="text" value="<?php echo $post["title"];?>" name="post_name" maxlength="50">
				<br>
				<font style="font-style:italic">Maximum of 50 characters</font>	
				</td>
			</tr>
			<tr>
				<th>Photos: <br /><font style="font-style:italic;font-size:11px;">(optional)</font></th>
				<td style="vertical-align: top">
				<div class="post_photo_box">
				<?php foreach ($imgs as $img):?>
						<div class="post_img_box oh">
							<input type="hidden" name="img_src[]" value="<?php echo $img["img"]?>">
							<img class="post_img_now fl" src="../circle_post_img/<?php echo $post["user_id"];?>/<?php echo $img["img"];?>">
							<input class="post_img_title_input fl" name="img_title[]" value="<?php echo $img["title"];?>">
							<div class="delete_post_img fl">X</div>
						</div>
					
				<?php endforeach;?>
				</div>
					<div style="color:#fd8f8f;font-style:italic;font-size:11px;line-height:20px;">Note: You can only upload each photo maximum 1M</div>
				</td>
			</tr>
			<tr>
				<th>
				Upload Photos:
				</th>
				<td>
					<input type="hidden" name="method" value="circlePostSave"/>
					<input type="hidden" name="action" value="share"/>
					<div id="file-uploader" class="post_img_uploader">
					<noscript>
					    <p>Please enable JavaScript to use file uploader.</p>
					    <!-- or put a simple form for upload here -->
					</noscript>
					</div>
					<script type="text/javascript">
					var ias ="";
					var uploader = new qq.FileUploader({
					    // pass the dom node (ex. $(selector)[0] for jQuery users)
					    element: document.getElementById('file-uploader'),
					    // path to server-side upload script
					    action: '/circle_post_img_upload.php',
					    debug: false,
					    params: {
								id : <?php echo $this->_tpl_vars["name"];?>
						    },
						sizeLimit : 1024000,
						showMessage : function(messages ){
							$(".upload_error").remove();
							$(".upload_success").remove();
							 var error = $(document.createElement("span")).addClass("upload_error fl").text(messages);
							 $("#file-uploader").append(error);
							},
					    onSubmit: function(){
					    	$(".upload_error").remove();
							$(".upload_success").remove();
					    	var loading_icon = $(document.createElement("img")).attr("src","../skin/images/loading_sm.gif").addClass("loading_sm");
					    	$("#file-uploader").append(loading_icon);
						    },
					    onComplete: function(id,fileName,json){
							$(".loading_sm").remove();
				
							 var error = $(document.createElement("span")).addClass("upload_error fl").text(json.reason);
						   	 var success = $(document.createElement("span")).addClass("upload_success fl").text("Upload success!");
					    	if(json.success == false){
								$("#file-uploader").append(error);
								
							}else{

								var img_box =  $(document.createElement("div")).addClass("post_img_box oh");
								var img =  $(document.createElement("img")).attr("src","../circle_post_img/<?php echo $this->_tpl_vars["name"];?>/thumb_"+json.file_name+"."+json.ext).addClass("post_img_now fl"); 
								var img_title = $(document.createElement("input")).addClass("post_img_title_input fl").attr("name","img_title[]");
								var img_delete = $(document.createElement("div")).addClass("delete_post_img fl").text("X");
								var img_input_hidden = $(document.createElement("input")).attr("name","img_src[]").attr("type","hidden").val(json.file_name+"."+json.ext);
								$(img_box).append(img_input_hidden);
								$(img_box).append(img);
								$(img_box).append(img_title);
								$(img_box).append(img_delete);
								$(img_delete).click(function(){
										$(this).parent().remove();
									});
								$(".post_photo_box").prepend(img_box);

							}
					    }
					});
										
					
					</script>
					
					
				</td>
			</tr>
			<tr>
				<th><label class="fr" for="introduction">Body Text:*</label></th>
				<td>
					<textarea class="circle_text required" name="comment" id="comment" style="height: 300px;" cols="30" rows="10"><?php echo str_replace("<br />","",$post["comment"]);?></textarea>
					<font class="introduction_limit" style="font-style:italic">Maximum of 2000 characters</font>	
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
				<a href="<?php echo runFunc('encrypt_url',array('action=share&method=circlePage&id='.$this->_tpl_vars["circle_id"]))?>" class="cancel_button fr" href="">Cancel</a>
				<input id="submit_share_list" class="blue_button_large fr" type="submit" value="Save">
				</td>
			</tr>
		</table>	
	</form>
	</div>
	<div class="circle_msg_box gray_line_box fr" style="height: 468px;">
		<p>Although the administrators of wowshopping.com.cn will 

attempt to keep all objectionable messages off this site, it is 

impossible for us to review all messages. All messages 

express the views of the author, and the owners of 

wowshoppoing.com.cn will be held responsible for the 

content of any message.
</p>
	
	<p>By agreeing to these rules, you warrant that you will not post

any messages that are obscene, vulgar, sexually-oriented, 

hateful, threatening, or otherwise violative of any laws.

The owners of wowshopping.com.cn reserve the right to 

remove, edit, move or close any content item for any reason.</p>
	</div>
	</div>
	
	</div>
</div>
<script type="text/javascript">


	$(function(){

		$(".delete_post_img").click(function(){
			$(this).parent().remove();
			});
		
		$("#comment").keyup(function(){
				var limit = 2000 - $(this).val().length;
				var limit_word = "Maximum of "+ limit +" characters";
	
				if($(this).val().length >=2000){
					$(this).val($(this).val().substring(0, 2000));
					limit_word = "Maximum of 0 characters";
				}
				$(".introduction_limit").text(limit_word);
			});


		

			$(".circle_create_tags").click(function(){

					var tag_id = $(this).attr("id");
					$("#circle_tags_box").removeClass("error_content_div");
					if($("#circle_tags_box #"+tag_id).length>0){
							alert("You have already added this tag!");
							return false;
						}
									
					var tags_hidden_input = '<input type="hidden" name="tags[]" value="'+ tag_id +'" />';
				
					$(this).clone().appendTo("#circle_tags_box").click(function(){
						$(this).remove();
					}).append(tags_hidden_input);

				});

			$("#post_create_form").validate({

					errorPlacement: function(error, element) {
			         // console.info(element.parent().prev("th").append(error));
			        }		

			});
			
		});
</script>

<?php
		$inc_tpl_file=includeFunc("common/footer/shop_footer.tpl");
		include($inc_tpl_file);
		?>
</body>
</html>

<?php }else{ ?>
		<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/account_passPara.tpl
LNMV
		);
		include($inc_tpl_file);
		?>

<?php } ?>