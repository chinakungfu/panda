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
$order_list = runFunc('getOrderList',array($this->_tpl_vars["name"],1,18));
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
	?>
	<div class="content">
	<h2 class="cp_title">Open Your Shops</h2>
	<h3 class="circle_create_box_title">Application</h3>
	<div class="circle_create_main oh">
	<div class="circle_create_box fl gray_line_box">
	<form id="circle_create_form" action="index.php" method="post">
		<table class="circle_create_detail_table">
			<tr>
				<th style="line-height: 25px;vertical-align: top;"><label class="fr" for="list_name">Shop Name: *</label></th>
				<td>
				<input id="list_name" class="circle_editor_input big_input required" type="text" name="circles_name" maxlength="50">
				<br>
				<font style="font-style:italic">Maximum of 50 characters</font>	
				</td>
			</tr>
			<tr>
				<th>Photo of Shop:*</th>
				<td>
					<div class="photo_box">
						<div id="photo_empty_msg" style="margin-top: 76px; text-align: center;">A beautiful photo will increase the attractiveness of your shop</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>
				Upload Photos:
				</th>
				<td>
					<input type="hidden" id="x1" name="x1" value="0"/>
					<input type="hidden" id="x2" name="x2" value="0" />
					<input type="hidden" id="y1" name="y1" value="0" />
					<input type="hidden" id="y2" name="y2" value="100" />
					<input type="hidden" id="width" name="width" value="100"/>
					<input type="hidden" id="height" name="height" value="100"/>
					<input type="hidden" id="file_name" name="file_name" value=""  />
					<input type="hidden" id="ext" name="ext" value=""  />
					<input type="hidden" name="method" value="circleSave"/>
					<input type="hidden" name="action" value="share"/>
					<div id="file-uploader">
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
					    action: '/circle_img_upload.php',
					    debug: false,
					    params: {
								id : <?php echo $this->_tpl_vars["name"];?>
						    },
					    onComplete: function(id,fileName,json){
						    $("#photo_empty_msg").remove();
					    	$(".photo_box").removeClass("error_content_div");
					    	$(".upload_error").remove();
							$(".upload_success").remove();
						    var error = $(document.createElement("span")).addClass("upload_error").text(json.reason);
						    var success = $(document.createElement("span")).addClass("upload_success").text("Upload success!");
								if(json.success == false){
										$("#file-uploader").append(error);
										
									}else{
										var img =  $(document.createElement("img")).attr("src","../circles_img/<?php echo $this->_tpl_vars["name"];?>/"+json.file_name+"."+json.ext); 
										$("#file_name").val(json.file_name);
										$("#ext").val(json.ext);
										if(ias!=""){
										ias.remove();
										}
										$(".photo_box").children().remove();
										$(".photo_box").append(img);
											
										ias  =img.imgAreaSelect({
											aspectRatio: '1:1',
											handles: true,
											minHeight: 100,
											minWidth: 100,
											instance: true,
											x1: 0, y1: 0, x2: 100, y2: 100,
											persistent: true,
									//		onSelectChange: preview ,
											onSelectEnd: function (img, selection) {
												$("#x1").val(selection.x1);	 
												$("#x2").val(selection.x2);	 
												$("#y1").val(selection.y1);	 
												$("#y2").val(selection.y2);	 
												$("#width").val(selection.width);	 
												$("#height").val(selection.height);	
											}   		
										});
										} 
						    }
					});
										
					
					</script>
					
					
				</td>
			</tr>
			<tr>
				<th><label class="fr" for="introduction">Introduction:*</label></th>
				<td>
					<textarea class="circle_text required" name="introduction" id="introduction" cols="30" rows="10"></textarea>
					<font class="introduction_limit" style="font-style:italic">Maximum of 500 characters</font>	
				</td>
			</tr>
			<tr>
				<th>About:*</th>
				<td>
				<?php $tags =  runFunc("getCircleTags");?>
				<select name="circle_about" class="required">
				<option value="">Select your shop about</option>
				<?php foreach($tags as $tag):?>
						
						<option value="<?php echo $tag["id"];?>"><?php echo $tag["title"];?></option>
					
				<?php endforeach;?>
				</select>
				</td>
			</tr>

			<tr>
				<th><label class="fr" for="circles_phone">Phone:*</label></th>
				<td><input id="list_phone" class="circle_editor_input big_input required" type="text" id="circles_phone" name="circles_phone" maxlength="50"></td>
			</tr>
			<tr>
				<th><label class="fr" for="circles_email">Email:*</label></th>
				<td>
				<input id="list_phone" class="circle_editor_input big_input required email" type="text" id="circles_email" name="circles_email" maxlength="50">
				<br />
				<font style="font-style:italic">This will allow us and the potential customers to be more motivated to communicate with you. We respect the personal privacy.</font>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><br /></td>
			</tr>
			<tr>
				<th><input id="agree_terms" type="checkbox" checked="checked" class=""/></th>
				<td><label for="agree_terms" style="font-style:italic">I have read and agree to the wowshopping.com.cn service agreement</label></td>
			</tr>
			<tr>
				<th></th>
				<td>
				<a class="cancel_button fr" href="<?php echo runFunc('encrypt_url',array('action=share&method=myCircle'));?>">Cancel</a>
				<input id="submit_share_list" class="blue_button_large fr" type="submit" value="Save">
				</td>
			</tr>
		</table>	
	</form>
	</div>
	<div class="circle_msg_box gray_line_box fr" style="height: 822px;">
		<p>Taking into account the requirements of Chinese laws and
 
regulations and related policies, we do not welcome 

pornography, radical topic of discussion of the ideological, 

and reserves the right to the dissolution of such topics circles.</p>
	
	</div>
	</div>
	
	</div>
</div>
<script type="text/javascript">


	$(function(){

		$("#introduction").keyup(function(){
				var limit = 500 - $(this).val().length;
				var limit_word = "Maximum of "+ limit +" characters";
	
				if($(this).val().length >=500){
					$(this).val($(this).val().substring(0, 500));
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

			$("#circle_create_form").validate({
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