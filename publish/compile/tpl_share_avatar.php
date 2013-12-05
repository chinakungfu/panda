<?php import('core.util.RunFunc'); ?><?php $this->_tpl_vars["name"]=runFunc('readSession',array());?>
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

	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
common/header/shop_header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	<?php
	$inc_tpl_file=includeFunc(<<<LNMV
account/common/header.tpl
LNMV
	);
	include($inc_tpl_file);
	?>
	
	
<?php
$uid =runFunc('readSession',array());
	if($this->_tpl_vars["IN"]["avatar_type"] == "upload"){
	
		$w_width = 300;
		$aExtraInfo = getimagesize($_FILES['img']['tmp_name']);
		$o_width = $aExtraInfo["0"];
		$o_height = $aExtraInfo["1"];
	   
		$c_height = ($w_width/$o_width) * $o_height;
		$file_type = runFunc('screen_shot',array($_FILES['img']['name'],$_FILES['img']['tmp_name'],0,0,0,0,$w_width,$c_height,"avatar/".$uid."_catch",1));
		
	}
	if($this->_tpl_vars["IN"]["avatar_type"] == "resize"){
	
	//$ctype = screen_shot($_POST["cache"],$_POST["cache"],$_POST["x1"],$_POST["x2"],$_POST["y1"],$_POST["y2"],$_POST["width"],$_POST["height"],"thumb_".$_POST["cache"]);
	$cfile = runFunc('screen_shot',array($_POST["cache"],$_POST["cache"],$_POST["x1"],$_POST["x2"],$_POST["y1"],$_POST["y2"],$_POST["width"],$_POST["height"],"avatar/".$uid."_thumb"));
	runFunc('screen_shot',array($_POST["cache"],$_POST["cache"],$_POST["x1"],$_POST["x2"],$_POST["y1"],$_POST["y2"],$_POST["width"],$_POST["height"],"avatar/".$uid."_thumb"));
	runFunc('screen_shot',array("avatar/".$uid."_thumb.".$cfile,"avatar/".$uid."_thumb.".$cfile,0,0,0,0,100,100,"avatar/".$uid."_thumb.".$cfile."_100",1));
	runFunc('screen_shot',array("avatar/".$uid."_thumb.".$cfile,"avatar/".$uid."_thumb.".$cfile,0,0,0,0,40,40,"avatar/".$uid."_thumb.".$cfile."_40",1));
	runFunc('screen_shot',array("avatar/".$uid."_thumb.".$cfile,"avatar/".$uid."_thumb.".$cfile,0,0,0,0,20,20,"avatar".$uid."_thumb.".$cfile."_20",1));
	runFunc('avatarSave',array($cfile,$uid));
	
	header('Location: /publish/index.php'.runFunc('encrypt_url',array('action=share&method=editProfile')));
	
	}
?>
</head>
<body>
<div class="box">
<div class="avatar_box">
<div class="avatar_box_bar">
<div class="avatar_bar_title">
	EDIT YOUR PHOTO
</div>
<div class="gray_line_box">
<form action="index.php" method="post" enctype="multipart/form-data">
	<table class="avatar_edit_table">
		<tr>
			<td style="text-align:left;">
			<?php if(file_exists($avatar) and $this->_tpl_vars["IN"]["avatar_type"] == ""){?>
			<img src="<?php echo $avatar."_100.".$this->_tpl_vars["userInfo"]["0"]["headImageUrl"];?>" alt="userInfo" id="userHeaderImg" />
				<?php }elseif($this->_tpl_vars["IN"]["avatar_type"] == ""){ ?>
				<img src="../skin/images/pic.jpg" alt="userInfo" id="userHeaderImg" />
			<?php } ?>
				<?php if($this->_tpl_vars["IN"]["avatar_type"] == "upload"){?>
			<img id="photo" src="<?php echo "avatar/".$uid."_catch".".".$file_type?>" alt=""/>
			<?php }?>
			</td>
			<td style="text-align: center;">
				
					<div style="color:black;margin-top:15px;margin-bottom: 20px;">Select an image file on your computer(4MB max)</div>
					
					<input type="hidden" name="method" value="uploadAvatar"/>
					<input type="hidden" name="action" value="share"/>
					<?php if($this->_tpl_vars["IN"]["avatar_type"] == "upload"){?>
					<input type="hidden" name="avatar_type" value="resize"/>
					<input type="hidden" id="x1" name="x1" value="0"/>
					<input type="hidden" id="x2" name="x2" value="0" />
					<input type="hidden" id="y1" name="y1" value="0" />
					<input type="hidden" id="y2" name="y2" value="100" />
					<input type="hidden" id="width" name="width" value="100"/>
					<input type="hidden" id="height" name="height" value="100"/>
					<input type="hidden" name="cache" value="<?php echo "avatar/".$uid."_catch".".".$file_type?>"/>
					<?php }else{?>
					<input type="file" name="img"/>
					<input type="hidden" name="avatar_type" value="upload"/>
					<?php }?>
				<div class="sep_gray">
					<div class="gray_line fl"></div>
					<div style="margin:0 15px;" class="fl">Preview</div>
					<div class="gray_line fl"></div>
				</div>
				<div class="avatar_thumb"><img src="<?php echo "avatar/".$uid."_catch".".".$file_type?>" alt="" /></div>
				<div class="ts">
					By uploading a file you certify that you have the right to distribute this picture and that it does note violate the Terms of Service 
				</div>
			</td>
		</tr>
	</table>
	<div class="bottom_bar">
		<?php if($this->_tpl_vars["IN"]["avatar_type"] == "upload"){?>
		<input class="ubotton" type="submit" value="Save" style="float: right; width: 110px; height: 30px; border: medium none; cursor: pointer;margin-bottom:10px; margin-right: 10px;">
		<?php }else{?>
		<input class="ubotton" type="submit" value="Upload" style="float: right; width:110px; height: 30px; border: medium none; cursor: pointer;margin-bottom:10px; margin-right: 10px;">
		<?php }?>
	</div>
</form>
</div>
</div>
</div>	
	
</div>
	<?php
		$inc_tpl_file=includeFunc(<<<LNMV
common/footer/shop_footer.tpl
LNMV
		);
		include($inc_tpl_file);
		?>
<script type="text/javascript">


function preview(img, selection) {
    var scaleX = 66 / (selection.width || 1);
    var scaleY = 66 / (selection.height || 1);
	var width = img.width;
	var height = img.height;
	
	$('.avatar_thumb img').css({
        width: Math.round(scaleX * width) + 'px',
        height: Math.round(scaleY * height) + 'px',
        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
}


$(document).ready(function () {
		var twidth = $("#photo").width();
		var theight =$("#photo").height();

		 var tscaleX = 66 / (100 || 1);
  		 var tscaleY = 66 / (100 || 1);
	$('.avatar_thumb img').css({
        width: Math.round(tscaleX * twidth) + 'px',
        height: Math.round(tscaleY * theight) + 'px'
	});



		$('img#photo').imgAreaSelect({

				aspectRatio: '1:1',
				handles: true,
				minHeight: 100,
				minWidth: 100,
				x1: 0, y1: 0, x2: 100, y2: 100,
				persistent: true,
				onSelectChange: preview ,
				onSelectEnd: function (img, selection) {
					$("#x1").val(selection.x1);	 
					$("#x2").val(selection.x2);	 
					$("#y1").val(selection.y1);	 
					$("#y2").val(selection.y2);	 
					$("#width").val(selection.width);	 
					$("#height").val(selection.height);	
			}   		
		});
});
</script>
</body>
</html>