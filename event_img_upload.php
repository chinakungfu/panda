<?php





$pathinfo = pathinfo(getName());
$user_id = $_GET['id'];
$filename = time();
$ext = @$pathinfo['extension'];

if(!is_dir("circle_event_img/".$user_id)){
	mkdir("circle_event_img/".$user_id);
}

$uploadDirectory = "circle_event_img/".$user_id."/";

if($ext=="jpeg" or $ext=="jpg" or $ext=="gif" or $ext=="png" or $pathinfo['basename'] == "temp.php"){
if (save($uploadDirectory . $filename . '.' . $ext)){

	make_thumb($uploadDirectory . $filename . '.' . $ext,$uploadDirectory.$filename,407);

	$return =  array('success'=>true,'file_name'=>$filename,"ext"=>$ext);

	echo json_encode($return);
}
}else{

	$return =  array('success'=>false,'reason'=>"Error file type");
	echo json_encode($return);
}






function getName() {
	return $_GET['qqfile'];
}

function getSize() {
	if (isset($_SERVER["CONTENT_LENGTH"])){
		return (int)$_SERVER["CONTENT_LENGTH"];
	} else {
		throw new Exception('Getting content length is not supported.');
	}
}

function save($path) {
	$input = fopen("php://input", "r");
	$temp = tmpfile();
	$realSize = stream_copy_to_stream($input, $temp);
	fclose($input);

	if ($realSize != getSize()){
		return false;
	}

	$target = fopen($path, "w");
	fseek($temp, 0, SEEK_SET);
	stream_copy_to_stream($temp, $target);
	fclose($target);

	return true;
}

function make_thumb($filename,$thumb_name,$c_width){

	$img_info = getimagesize($filename);
	list($width, $height) = getimagesize($filename);
	$newwidth = $c_width;
	$newheight = $height * ($c_width/$width);



	// Load
	switch($img_info["mime"]){

	case "image/jpeg":
			$source = imagecreatefromjpeg($filename); //jpeg file
			$ext = "jpg";
		break;
	case "image/gif":
			$source = imagecreatefromgif($filename); //gif file
			$ext = "gif";
		break;
	case "image/png":
			$source = imagecreatefrompng($filename); //png file
			$ext = "png";
		break;

	}

	$thumb = imagecreatetruecolor($newwidth, $newheight);
	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	// Output
	switch($img_info["mime"]){

	case "image/jpeg":
			$source = imagecreatefromjpeg($filename); //jpeg file
			$ext = "jpg";
			imagejpeg($thumb,$thumb_name.".".$ext,100);
		break;
	case "image/gif":
			$source = imagecreatefromgif($filename); //gif file
			$ext = "gif";
			imagegif($thumb,$thumb_name.".".$ext);
		break;
	case "image/png":
			$source = imagecreatefrompng($filename); //png file
			$ext = "png";
			imagepng($thumb,$thumb_name.".".$ext,100);
		break;

	}

	imagedestroy($thumb);
}

?>